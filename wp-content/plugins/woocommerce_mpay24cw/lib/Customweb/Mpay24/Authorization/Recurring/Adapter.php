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

require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Payment/Util.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPayment.php';
require_once 'Customweb/Mpay24/AbstractAdapter.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Constants/Error.php';
require_once 'Customweb/Payment/Authorization/Recurring/ITransactionContext.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Payment/Exception/RecurringPaymentErrorException.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 */
final class Customweb_Mpay24_Authorization_Recurring_Adapter extends Customweb_Mpay24_AbstractAdapter implements 
		Customweb_Payment_Authorization_Recurring_IAdapter {

	/**
	 * Overridden
	 */
	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	/**
	 * Overridden
	 */
	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$paymentMethod = $this->getMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), $this->getAuthorizationMethodName());
		return $paymentMethod->isAuthorizationMethodSupported($this->getAuthorizationMethodName());
	}

	/**
	 * Overridden
	 */
	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod){
		$methodWrapper = $this->getMethodFactory()->getPaymentMethod($paymentMethod, $this->getAuthorizationMethodName());
		return $methodWrapper->isRecurringPaymentSupported();
	}

	/**
	 * Overridden
	 */
	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext){
		$transaction = new Customweb_Mpay24_Authorization_Transaction($transactionContext, $this->getAuthorizationMethodName());
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		
		$tid = $transaction->getExternalTransactionId();
		$tid = Customweb_Payment_Util::applyOrderSchemaImproved($this->getConfiguration()->getTransactionNumberSchema(), $tid, 32);
		$transaction->setTid($tid);
		
		return $transaction;
	}
	
	/**
	 * Overridden
	 */
	public function getAdapterPriority(){
		return 500;
	}

	/**
	 * Overridden
	 */
	public function process(Customweb_Payment_Authorization_ITransaction $transaction){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException("Customweb_Mpay24_Authorization_Transaction");
		}
		$profileId = $this->getLastProfileId($this->getInitialTransaction($transaction)->getRecurringId());
		if ($profileId === null) {
			throw new Exception(Customweb_I18n_Translation::__('No profile found for charging!'));
		}
		try {
			$response = $this->acceptPaymentCall($profileId, $transaction);
			$transaction->setPaymentId($response->getMpayTID());
			$this->updateTransactionState($transaction);
		}
		catch (Exception $e) {
			throw new Customweb_Payment_Exception_RecurringPaymentErrorException($e);
		}
	}

	private function updateTransactionState(Customweb_Mpay24_Authorization_Transaction $transaction){
		$status = '';
		$result = $this->checkTransactionStateSoap($transaction);
		$returnCode = $result['returnCode'];
		if ($returnCode != 'OK') {
			$frontendMessage = Customweb_Mpay24_Constants_Error::getFrontendMessage();
			$backendMessage = Customweb_I18n_Translation::__('Transaction status could not be verified. Return code: @return', 
					array(
						'@return' => $returnCode 
					));
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
		else {
			$status = $result['status'];
		}
		switch ($status) {
			case "RESERVED":
				$transaction->authorize();
				break;
			case "BILLED":
				$transaction->authorize();
				$transaction->capture();
				break;
			case 'SUSPENDED':
				$transaction->authorize();
				$transaction->setAuthorizationUncertain("Transaction remains in a suspended state.");
				$this->getConfiguration()->callUpdateService($transaction);
				break;
			case 'FAILED':
			case "ERROR":
			default:
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
		}
	}

	private function acceptPaymentCall($profileId, Customweb_Mpay24_Authorization_Transaction $transaction){
		$request = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment();
		$request->setMerchantID($this->getConfiguration()->getMerchantId());
		$request->setTid($transaction->getTid());
		$request->setPType(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType::PROFILE());
		$request->setCustomerID($this->getInitialTransaction($transaction)->getRecurringId());
		
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment();
		$payment->setProfileID($profileId);
		$payment->setUseProfile(true);
		
		$currency = $transaction->getCurrencyCode();
		$payment->setCurrency($currency);
		
		$amount = Customweb_Util_Currency::formatAmount($transaction->getAuthorizationAmount(), $currency, '', '');
		$payment->setAmount($amount);
		$request->setPayment($payment);
		$response = self::getSoapService()->AcceptPayment($request);
		$this->checkAcceptPaymentCall($response);
		return $response;
	}

	private function checkAcceptPaymentCall(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse $response){
		if (!($response->getStatus() == Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK() &&
				 (string) $response->getReturnCode() == 'PROFILE_USED')) {
			$this->translateErrorMessage($response);
		}
	}

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Mpay24_Authorization_Transaction
	 */
	private function getInitialTransaction(Customweb_Mpay24_Authorization_Transaction $transaction){
		$initial = $this->getTransactionContext($transaction)->getInitialTransaction();
		if (!($initial instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		return $initial;
	}

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Payment_Authorization_Recurring_ITransactionContext
	 */
	private function getTransactionContext(Customweb_Mpay24_Authorization_Transaction $transaction){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		
		$transactionContext = $transaction->getTransactionContext();
		if (!($transactionContext instanceof Customweb_Payment_Authorization_Recurring_ITransactionContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_Authorization_Recurring_ITransactionContext');
		}
		return $transactionContext;
	}
}