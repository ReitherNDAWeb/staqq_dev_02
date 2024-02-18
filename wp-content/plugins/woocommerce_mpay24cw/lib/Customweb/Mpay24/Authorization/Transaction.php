<?php

/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2016 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

require_once 'Customweb/Util/String.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/Mpay24/Authorization/TransactionCapture.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
final class Customweb_Mpay24_Authorization_Transaction extends Customweb_Payment_Authorization_DefaultTransaction {
	
	/**
	 *
	 * @var Customweb_Mpay24_Authorization_IPaymentInformationProvider[]
	 */
	private $paymentInformationProviders = array();
	
	/**
	 *
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	private $tStatus;
	/**
	 *
	 * @var string
	 */
	private $tid;
	
	/**
	 * var boolean
	 */
	private $createProfile = false;
	
	/**
	 * Until we get back the profile id (undefined),
	 * every recurring profile has a new customer ID
	 * (therefore just one profile per listProfiles-call)
	 *
	 * @var string
	 */
	private $recurringId;
	/**
	 *
	 * @var boolean
	 */
	private $transactionFailedDuringUpdate = false;
	/**
	 *
	 * @var int
	 */
	private $updateCounter = 0;
	/**
	 *
	 * @var string
	 */
	private $aliasId;
	private $lastError;
	private $firstErrorTime;
	const MAX_ERROR_TIME = 60;
	
	/**
	 * Token used for widget authorization.
	 */
	private $widgetToken;

	public function __construct(Customweb_Payment_Authorization_ITransactionContext $transactionContext, $authorizationMethodName){
		parent::__construct($transactionContext);
		$this->setAuthorizationMethod($authorizationMethodName);
		$this->recurringId = Customweb_Util_String::substrUtf8(
				$this->getTransactionContext()->getOrderContext()->getCustomerId() . mt_rand(1000000, mt_getrandmax()), 0, 11);
	}

	/**
	 *
	 * @param int $mpayTID
	 */
	public function setMpayTid($mpayTID){
		return $this->setPaymentId($mpayTID);
	}

	/**
	 *
	 * @return int $mpayTID
	 */
	public function getMpayTid(){
		return $this->getPaymentId();
	}

	/**
	 *
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus $tStatus or primitive type for native value
	 * @return $this
	 */
	public function setTStatus($tStatus){
		$this->tStatus = $tStatus;
		return $this;
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus $tStatus
	 */
	public function getTStatus(){
		return tStatus;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getCreateProfile(){
		return $this->createProfile;
	}

	public function setCreateProfile($createProfile){
		$this->createProfile = $createProfile;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getRecurringId(){
		return $this->recurringId;
	}

	/**
	 *
	 * @return string
	 */
	public function getTid(){
		return $this->tid;
	}

	public function setTid($tid){
		$this->tid = $tid;
		return $this;
	}

	public function isCaptureClosable(){
		return false;
	}

	public function isRefundClosable(){
		return false;
	}

	public function isTransactionFailedDuringUpdate(){
		return $this->transactionFailedDuringUpdate;
	}

	public function setTransactionFailedDuringUpdate($transactionFailedDuringUpdate){
		$this->transactionFailedDuringUpdate = $transactionFailedDuringUpdate;
		return $this;
	}

	public function getUpdateCounter(){
		return $this->updateCounter;
	}

	public function incrementUpdateCounter(){
		return $this->updateCounter += 1;
	}

	public function getAliasId(){
		return $this->aliasId;
	}

	public function setAliasId($alias){
		$this->aliasId = $alias;
		return $this;
	}

	public function getLastError(){
		return $this->lastError;
	}

	public function setLastError($lastError){
		if ($this->lastError == null) {
			$this->firstErrorTime = time();
			$this->setUpdateExecutionDate(Customweb_Core_DateTime::_()->addMinutes(self::MAX_ERROR_TIME));
		}
		$this->lastError = $lastError;
		return $this;
	}

	public function getFirstErrorTime(){
		return $this->firstErrorTime;
	}

	/**
	 * Sets the token used for widget authorization.
	 *
	 * @param string $token
	 */
	public function setWidgetToken($token){
		$this->widgetToken = $token;
	}

	/**
	 * Returns the token used for widget authorization.
	 */
	public function getWidgetToken(){
		return $this->widgetToken;
	}

	/**
	 * Overridden
	 */
	protected function getCustomOrderStatusSettingKey($statusKey){
		if ($this->isTransactionFailedDuringUpdate() && $this->getPaymentMethod()->existsPaymentMethodConfigurationValue('failed_status')) {
			$status = $this->getPaymentMethod()->getPaymentMethodConfigurationValue('failed_status');
			if ($status != 'no_status_change') {
				return 'failed_status';
			}
		}
		
		return $statusKey;
	}

	/**
	 * Overridden
	 */
	protected function buildNewCaptureObject($captureId, $amount, $status = NULL){
		return new Customweb_Mpay24_Authorization_TransactionCapture($captureId, $amount, $status);
	}
	
	public function registerPaymentInformationProvider(Customweb_Mpay24_Authorization_IPaymentInformationProvider $provider){
		$this->paymentInformationProviders[] = $provider;
		return $this;
	}
	
	/**
	 * Overridden
	 * @see Customweb_Payment_Authorization_DefaultTransaction::getPaymentInformation()
	 */
	public function getPaymentInformation(){
		$output = '';
		foreach ($this->paymentInformationProviders as $provider) {
			$output .= $provider->getPaymentInformation($this);
		}
		if (empty($output)) {
			return null;
		}
		return $output;
	}
}