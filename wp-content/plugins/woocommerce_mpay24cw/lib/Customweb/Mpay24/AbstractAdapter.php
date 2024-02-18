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

require_once 'Customweb/Mpay24/Constants/ReturnCode.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPaymentResponse.php';
require_once 'Customweb/Xml/Binding/Encoder.php';
require_once 'Customweb/Xml/Binding/Decoder.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatus.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfilesResponse.php';
require_once 'Customweb/Mpay24/Service.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatusResponse.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPaymentResponse.php';
require_once 'Customweb/Mpay24/Configuration.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentTokenResponse.php';
require_once 'Customweb/Mpay24/Constants/Error.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfiles.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';

abstract class Customweb_Mpay24_AbstractAdapter {
	
	/**
	 * mPAY24 Soapclient
	 *
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ETP
	 */
	private $soapClient = null;
	
	/**
	 * Configuration object.
	 *
	 * @var Customweb_Mpay24_Configuration
	 */
	private $configuration;
	
	/**
	 *
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	/**
	 *
	 * @var Customweb_Mpay24_Method_Factory
	 */
	private $methodFactory = null;
	
	/**
	 *
	 * @var Customweb_Xml_Binding_Encoder
	 */
	private $encoder;
	
	/**
	 *
	 * @var Customweb_Xml_Binding_Decoder
	 */
	private $decoder;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = $container;
		$configurationAdapter = $container->getBean('Customweb_Payment_IConfigurationAdapter');
		$this->configuration = new Customweb_Mpay24_Configuration($configurationAdapter);
		$this->methodFactory = $container->getBean('Customweb_Mpay24_Method_Factory');
		$this->encoder = new Customweb_Xml_Binding_Encoder();
		$this->decoder = new Customweb_Xml_Binding_Decoder();
	}

	/**
	 *
	 * @return Customweb_Mpay24_Configuration
	 */
	final public function getConfiguration(){
		return $this->configuration;
	}

	/**
	 * Matches the values of the given node with the properties of the specified class
	 * and returns the corresponding object.
	 *
	 * @param DOMNode $node node to encode
	 * @param string $responseType The class name of the response object
	 * @return mixed The response object
	 */
	final public function decode(DOMNode $node, $responseType){
		return $this->decoder->decode($node, $responseType);
	}

	/**
	 * Creates a DOMElement from a given object.
	 *
	 * @param mixed $object The object to encode
	 * @param DOMDocument $doc The parent document to which the resulting node will be appended
	 * @return DOMElement The encoded node
	 */
	final public function encode($object, DOMDocument $doc = null){
		return $this->encoder->encodeToDom($object, $doc);
	}

	/**
	 *
	 * @return Customweb_Mpay24_Service
	 */
	final public function getSoapService(){
		if (!$this->soapClient) {
			$this->soapClient = new Customweb_Mpay24_Service($this->configuration->getUserName(), $this->configuration->getPassword());
			if ($this->configuration->isTestMode()) {
				$this->soapClient->overrideLocation($this->getConfiguration()->getLiveUrl(), $this->getConfiguration()->getTestUrl());
			}
		}
		return $this->soapClient;
	}

	/**
	 *
	 * @return Customweb_DependencyInjection_IContainer
	 */
	public function getContainer(){
		return $this->container;
	}

	/**
	 *
	 * @return Customweb_Mpay24_Method_Factory
	 */
	public function getMethodFactory(){
		return $this->methodFactory;
	}

	/**
	 * Reassesses the transaction.
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param array $parameters
	 * @return boolean
	 */
	final public function ensureTransaction(Customweb_Mpay24_Authorization_Transaction $transaction, array $parameters){
		$frontendMessage = Customweb_I18n_Translation::__('Unfortunately the transaction could not be verified');

		if ($transaction->getTid() != $parameters['TID']) {
			$backendMessage = Customweb_I18n_Translation::__('The transaction id (TID) did not match');
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
		
		$amount = $transaction->getAuthorizationAmount();
		$amountPaid = $parameters['PRICE'] / pow(10, Customweb_Util_Currency::getDecimalPlaces($transaction->getCurrencyCode()));
		if (Customweb_Util_Currency::compareAmount($amountPaid, $amount, $transaction->getCurrencyCode()) < 0) {
			$backendMessage = Customweb_I18n_Translation::__('The paid amount was smaller than the price');
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
		
		if (strtolower($transaction->getCurrencyCode()) != strtolower($parameters['CURRENCY'])) {
			$backendMessage = Customweb_I18n_Translation::__('The currency did not match');
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
	}

	/**
	 * SOAP call.
	 * Checks the transaction status at mPAY24 and returns an
	 * array with the parameters 'returnCode' and 'status'
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @throws Customweb_Core_Exception_CastException
	 * @return array
	 */
	final public function checkTransactionStateSoap(Customweb_Mpay24_Authorization_Transaction $transaction){
		$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus();
		$param->setMerchantID($this->getConfiguration()->getMerchantId());
		$param->setMpayTID($transaction->getMpayTid());
		$param->setTid($transaction->getTid());
		try {
			$response = $this->getSoapService()->TransactionStatus($param);
			$returnCode = $response->getReturnCode();
		}
		catch (Exception $e) {
			$returnCode = $e->getCode();
		}
		if (!($response instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatusResponse)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatusResponse');
		}
		$status = '';
		if ($response->getStatus() != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
			$returnCode = 'CONNECTION_ERROR';
		}
		if ($returnCode == 'OK') {
			foreach ($response->getParameter() as $param) {
				/* @var $param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter */
				if ($param->getName() == 'STATUS') {
					$status = $param->getValue();
					break;
				}
			}
		}
		return array(
			'returnCode' => $returnCode,
			'status' => $status 
		);
	}

	/**
	 * SOAP call.
	 * Lists all profiles stored at mPAY24 for the given customer ID.
	 *
	 * @param string $custId
	 * @throws Customweb_Core_Exception_CastException
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	final protected function listMpayProfiles($custId){
		$listRequest = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles();
		$listRequest->setMerchantID($this->getConfiguration()->getMerchantId());
		$listRequest->setCustomerID($custId);
		
		$listResponse = self::getSoapService()->ListProfiles($listRequest);
		if (!($listResponse instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse)) {
			throw new Customweb_Core_Exception_CastException("Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse");
		}
		if (!($listResponse->getStatus() == Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK())) {
			$returnCode = $listResponse->getReturnCode();
			$frontendMessage = Customweb_Mpay24_Constants_Error::getFrontendMessage();
			$backendMessage = Customweb_I18n_Translation::__("Could not find profile! Return code: @returnCode", 
					array(
						'@returnCode' => $returnCode 
					));
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
		return $listResponse;
	}

	/**
	 * Soap call.
	 * Returns the profile ID of the last profile in the list
	 * stored at mPAY24 for the given customer ID.
	 * $profileCount is set to the number of existing profiles (passed by reference)
	 *
	 * @param string $custId
	 * @param int $profileCount
	 * @return string
	 */
	final protected function getLastProfileId($custId, &$profileCount = 0){
		$response = $this->listMpayProfiles($custId);
		$profiles = $response->getProfile();
		if (!isset($profiles[0])) {
			return null;
		}
		$payments = $profiles[0]->getPayment();
		$profileId = '';
		foreach ($payments as $pay) {
			$profileCount += 1;
			$profileId = $pay->getProfileId();
		}
		return $profileId;
	}

	/**
	 * Combines the backend message from the response
	 * error number and error text and adds it to
	 * the thrown exception.
	 *
	 * @param mixed $response
	 * @param Customweb_I18n_LocalizableString $errMsg
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 */
	public function translateErrorMessage($response){
		$this->translateErrorMessageInner($response, Customweb_Mpay24_Constants_Error::getFrontendMessage());
	}

	/**
	 * Combines the backend message from the response
	 * error number and error text and adds it to
	 * the thrown exception
	 *
	 * @param mixed $response
	 * @param Customweb_I18n_LocalizableString $frontendMessage
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 */
	protected function translateErrorMessageInner($response, $frontendMessage){
		if (!($response instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse) &&
				 !($response instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse) &&
				 !($response instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentTokenResponse)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse');
		}
		
		$code = Customweb_Mpay24_Constants_ReturnCode::get($response->getReturnCode()->get());
		$error = '';
		$desc = '';
		if ($response->getErrNo() !== NULL) {
			$errNo = $response->getErrNo();
			$error = Customweb_I18n_Translation::__("#Error: @errNo", array(
				'@errNo' => $errNo 
			));
		}
		if ($response->getErrText() !== NULL) {
			$errDesc = $response->getErrText();
			$desc = Customweb_I18n_Translation::__("Description: @errDesc", array(
				'@errDesc' => $errDesc 
			));
		}
		$backendMessage = Customweb_I18n_Translation::__("@errMsg @error @desc", 
				array(
					'@errMsg' => $code->getMessage(),
					'@error' => $error,
					'@desc' => $desc 
				));
		throw new Customweb_Payment_Exception_PaymentErrorException(
				new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
	}

	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		return false;
	}
	
	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){}
	
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){}
}