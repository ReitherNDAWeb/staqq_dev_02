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

require_once 'Customweb/Payment/Endpoint/Controller/Abstract.php';
require_once 'Customweb/Mpay24/Constants/ReturnCode.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Authorization/Widget/Adapter.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentTOKEN.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Mpay24/Authorization/AbstractTokenAdapter.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPayment.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Controller("widgetp")
 *
 */
class Customweb_Mpay24_Endpoint_WidgetProcess extends Customweb_Payment_Endpoint_Controller_Abstract {

	/**
	 * @Action("process")
	 */
	public function index(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_Core_Http_IRequest $request){
		$widgetAdapter = $this->getContainer()->getBean('Customweb_Mpay24_Authorization_Widget_Adapter');
		if (!($widgetAdapter instanceof Customweb_Mpay24_Authorization_Widget_Adapter)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Widget_Adapter');
		}
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		
		$response = $this->acceptPaymentCall($transaction, $widgetAdapter, $request->getParameters());
		if ($response->getStatus() == Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
			if ($response->getLocation() != null) {
				$location = $response->getLocation()->get();
				if (!empty($location)) {
					return Customweb_Core_Http_Response::redirect($response->getLocation()->get());
				}
			}
			return Customweb_Core_Http_Response::redirect($transaction->getSuccessUrl());
		}
		
		$code = Customweb_Mpay24_Constants_ReturnCode::get($response->getReturnCode()->get());
		return Customweb_Core_Http_Response::redirect(
				$this->getUrl('process', 'failed', 
						array(
							'cw_transaction_id' => $transaction->getExternalTransactionId(),
							'reason_code' => $code->getCode(),
							'reason_msg' => $code->getMessage() 
						)));
	}

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse
	 */
	private function acceptPaymentCall(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_Mpay24_Authorization_Widget_Adapter $adapter, array $queryParams){
		$request = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment();
		$request->setMerchantID($adapter->getConfiguration()->getMerchantId());
		$request->setTid($transaction->getTid());
		$request->setPType(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType::TOKEN());
		$request->setOrder($adapter->getOrder($transaction));
		$useProfile = $this->setCustomerId($transaction, $request);
		
		$request->setConfirmationURL(
				$this->getUrl('process', 'index', array(
					'cw_transaction_id' => $transaction->getExternalTransactionId() 
				)));
		$request->setSuccessURL($transaction->getSuccessUrl());
		$request->setErrorURL($this->getUrl('process', 'failed', array(
			'cw_transaction_id' => $transaction->getExternalTransactionId() 
		)));
		
		$currency = $transaction->getCurrencyCode();
		$amount = Customweb_Util_Currency::formatAmount($transaction->getAuthorizationAmount(), $currency, '', '');
		
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentTOKEN();
		$payment->setToken($transaction->getWidgetToken())->setCurrency($currency)->setAmount($amount);
		$payment->setUseProfile($useProfile);
		
		if($useProfile && isset($queryParams[Customweb_Mpay24_Authorization_AbstractTokenAdapter::$ALIAS_FORM_FIELD])) {
			$aliasForDisplay = $queryParams[Customweb_Mpay24_Authorization_AbstractTokenAdapter::$ALIAS_FORM_FIELD];
			$payment->setProfileID($transaction->getAliasId());
			$transaction->setAliasForDisplay($aliasForDisplay);
		}

		$request->setPayment($payment);
		return $adapter->getSoapService()->AcceptPayment($request);
	}
	
	/**
	 * Sets the customer id of the request and returns whether a profile should be used or not.
	 * 
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment $request
	 * @return boolean True if a profile should be used
	 */
	private function setCustomerId(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment $request) {
		$useProfile = true;
		if ($transaction->getCreateProfile()) {
			$request->setCustomerID($transaction->getRecurringId());
		}
		else {
			$cid = $transaction->getTransactionContext()->getOrderContext()->getCustomerId();
			$request->setCustomerID(empty($cid) ? 'null' : $cid);
			if ($transaction->getTransactionContext()->getAlias() === null) {
				$useProfile = false;
			}
		}
		return $useProfile;
	}
}
