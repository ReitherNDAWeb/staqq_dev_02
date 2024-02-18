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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/DeleteProfile.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Util/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPayment.php';
require_once 'Customweb/Mpay24/Authorization/PaymentPage/ParameterBuilder.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Authorization/IAdapter.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Payment/Util.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPayment.php';
require_once 'Customweb/Mpay24/AbstractAdapter.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Mpay24/BackendOperation/Capture/ParameterBuilder.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Constants/Error.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Mpay24/Method/Seamless/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 */
abstract class Customweb_Mpay24_Authorization_AbstractRedirectAdapter extends Customweb_Mpay24_AbstractAdapter implements 
		Customweb_Payment_Authorization_IAdapter {
	public static $REDIRECTION_URL = '';

	/**
	 * Returns a parameter builder to create the request to init the payment page.
	 *
	 * @return Customweb_Mpay24_Authorization_AbstractParameterBuilder
	 */
	abstract protected function getParameterBuilder(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData);

	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext){
		$pMethod = $this->getPaymentMethod($orderContext->getPaymentMethod());
		return $pMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $this->getAuthorizationMethodName(), false,
				$paymentCustomerContext);
	}
	
	final public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext){
		return $this->getPaymentMethod($orderContext->getPaymentMethod())->isAuthorizationMethodSupported($this->getAuthorizationMethodName());
	}

	final public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException("Customweb_Mpay24_Authorization_Transaction");
		}
		try {
			$transaction->setPaymentId($parameters['MPAYTID']);
			$this->ensureTransaction($transaction, $parameters);
			$this->handleRecurring($transaction, $parameters['PROFILE_STATUS']);
			$alias = $transaction->getTransactionContext()->getAlias();
			$this->processAlias($transaction, $alias);
			
			//handle response
			switch ($parameters['STATUS']) {
				case "RESERVED":
					$transaction->authorize();
					return Customweb_Core_Http_Response::_("OK");
				case "BILLED":
					$transaction->authorize();
					$transaction->capture();
					return Customweb_Core_Http_Response::_("OK");
				case 'SUSPENDED':
					$transaction->authorize();
					$transaction->setAuthorizationUncertain("Transaction remains in a suspended state.");
					$this->getConfiguration()->callUpdateService($transaction);
					return Customweb_Core_Http_Response::_("OK");
				case 'FAILED':
				case "ERROR":
				default:
					$frontendMessage = Customweb_Mpay24_Constants_Error::getFrontendMessage();
					$backendMessage = Customweb_I18n_Translation::__('Failed transaction. State: @state', 
							array(
								'@state' => $parameters['STATUS'] 
							));
					throw new Customweb_Payment_Exception_PaymentErrorException(
							new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
			}
		}
		catch (Customweb_Payment_Exception_PaymentErrorException $e) {
			$transaction->setLastError($e->getErrorMessage());
			return Customweb_Core_Http_Response::_("ERROR")->setStatusCode(500)->setStatusMessage($e->getMessage());
		}
		catch (Exception $e) {
			$msg = $e->getMessage();
			$transaction->setAuthorizationFailed($msg);
			return Customweb_Core_Http_Response::_("ERROR")->setStatusCode(500)->setStatusMessage($msg);
		}
	}
	
	/**
	 * Depending on the acquirer, it is possible that MPay24 processes direct clearing with two requests (reserved > billed) instead of just one (billed).
	 */
	final public function handleTwoStepDirectCapture(Customweb_Mpay24_Authorization_Transaction $transaction, array $parameters) {
		if($transaction->isCapturePossible() && $parameters['STATUS'] == 'BILLED') {
			$transaction->capture();
			try{
				$shopCaptureAdapter = $this->getContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Shop_ICapture');
				$shopCaptureAdapter->capture($transaction);
			} catch(Exception $e){
				$transaction->addErrorMessage($message);
			}			
		}
	}

	public final function selectPaymentCall(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPayment();
		$param->setMerchantID($this->getConfiguration()->getMerchantId());
		
		$doc = new DOMDocument();
		$builder = $this->getParameterBuilder($transaction, $formData);
		$orderNode = $this->encode($builder->getOrder(), $doc);
		$mdxiStr = $doc->saveXML($orderNode);
		$param->setMdxi($mdxiStr);
		
		return self::getSoapService()->SelectPayment($param);
	}

	public final function checkSelectPaymentResponse(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse $response){
		if ($response->getStatus() != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
			$this->translateErrorMessage($response);
		}
	}

	/**
	 * Performs an AcceptPayment call for seamless integrations.
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param array $formData
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse
	 */
	public final function seamlessAcceptPaymentCall(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$pMethod = $this->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
		if (!($pMethod instanceof Customweb_Mpay24_Method_Seamless_DefaultMethod)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Method_Seamless_DefaultMethod');
		}
		
		$parameters = $pMethod->getPaymentMethodParameters();
		
		$request = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment();
		$request->setMerchantID($this->getConfiguration()->getMerchantId());
		$request->setTid($transaction->getTid());
		$request->setPType(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType::_()->set($parameters['type']));
		
		$currency = $transaction->getCurrencyCode();
		$amount = Customweb_Util_Currency::formatAmount($transaction->getAuthorizationAmount(), $currency, '', '');
		$payment = $pMethod->getPaymentElement($formData);
		$payment->setCurrency($currency);
		$payment->setAmount($amount);
		$request->setPayment($payment);
		
		$etpBuilder = new Customweb_Mpay24_BackendOperation_Capture_ParameterBuilder($transaction, $this->getContainer());
		$request->setOrder($etpBuilder->getOrder());
		
		$ppBuilder = new Customweb_Mpay24_Authorization_PaymentPage_ParameterBuilder($transaction, $this->getContainer(), $formData);
		$url = $ppBuilder->getUrl();
		$request->setSuccessURL($url->getSuccess());
		$request->setErrorURL($url->getError());
		$request->setConfirmationURL($url->getConfirmation());
		
		$request->setLanguage($ppBuilder->getLanguageType()->get());
		
		$response = self::getSoapService()->AcceptPayment($request);
		if ($response->getStatus() != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK() &&
				 strcasecmp($response->getReturnCode()->get(), 'REDIRECT') !== 0) {
			$this->translateErrorMessage($response);
		}
		return $response;
	}

	protected final function createTransactionInner(Customweb_Payment_Authorization_ITransactionContext $transactionContext, $failedTransaction){
		$transaction = new Customweb_Mpay24_Authorization_Transaction($transactionContext, $this->getAuthorizationMethodName(), 
				$this->getContainer());
		$transaction->setLiveTransaction(!$this->getConfiguration()->isTestMode());
		
		$this->handleAlias($transaction);
		$this->setTid($transaction);
		$this->registerPaymentInformationProvider($transaction);
		
		return $transaction;
	}

	protected final function getPaymentPageUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		try {
			if (self::$REDIRECTION_URL !== '') {
				return self::$REDIRECTION_URL;
			}
			if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
				throw new Customweb_Core_Exception_CastException("Customweb_Mpay24_Authorization_Transaction");
			}
			$this->storeDefaultFormValues($transaction, $formData);
			$pMethod = $this->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
			self::$REDIRECTION_URL = $pMethod->getRedirectionUrl($this, $transaction, $formData);
			return self::$REDIRECTION_URL;
		}
		catch (Customweb_Payment_Exception_PaymentErrorException $e) {
			$transaction->setAuthorizationFailed($e->getErrorMessage());
			return $transaction->getFailedUrl();
		}
		catch (Exception $e) {
			$transaction->setAuthorizationFailed($e->getMessage());
			return $transaction->getFailedUrl();
		}
	}

	protected function handleAlias(Customweb_Mpay24_Authorization_Transaction $transaction){
		if ($transaction->getTransactionContext()->createRecurringAlias()) {
			$transaction->setCreateProfile(true);
		}
		else {
			$this->handleAliasInner($transaction);
		}
	}

	protected function handleAliasInner(Customweb_Mpay24_Authorization_Transaction $transaction){
		$transactionContext = $transaction->getTransactionContext();
		$alias = $transactionContext->getAlias();
		if ($alias == 'new') {
			$transaction->setAliasId(
					Customweb_Util_String::substrUtf8($transactionContext->getOrderContext()->getCustomerId() . mt_rand(1000000, mt_getrandmax()), 0, 
							11));
		}
		elseif ($alias instanceof Customweb_Mpay24_Authorization_Transaction) {
			$transaction->setAliasId($alias->getAliasId());
		}
		else {
			$transaction->setAliasId(null);
		}
	}

	protected function setTid(Customweb_Mpay24_Authorization_Transaction $transaction){
		$tid = $transaction->getExternalTransactionId();
		$tid = Customweb_Payment_Util::applyOrderSchemaImproved($this->getConfiguration()->getTransactionNumberSchema(), $tid, 32);
		$transaction->setTid($tid);
	}

	protected function registerPaymentInformationProvider(Customweb_Mpay24_Authorization_Transaction $transaction){
		$provider = $this->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod())->getPaymentInformationProvider();
		if ($provider !== null) {
			$transaction->registerPaymentInformationProvider($provider);
		}
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @return Customweb_Mpay24_Method_DefaultMethod
	 */
	private function getPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $method){
		return $this->getMethodFactory()->getPaymentMethod($method, $this->getAuthorizationMethodName());
	}
	
	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param string|Customweb_Mpay24_Authorization_Transaction|NULL $alias
	 */
	private function processAlias(Customweb_Mpay24_Authorization_Transaction $transaction, $alias){
		$profileId = '';
		$pCount = 0;
		$aliasId = $transaction->getAliasId();
		$profileId = $this->getLastProfileId($aliasId, $pCount);
		$formerAlias = $transaction->getAliasForDisplay();
		if ($alias == 'new' && $profileId !== null && empty($formerAlias)) {
			$transaction->setAliasForDisplay($profileId);
		}
		elseif (($alias instanceof Customweb_Payment_Authorization_ITransaction) && ($pCount > 1)) {
			$custId = $transaction->getAliasId();
			$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_DeleteProfile();
			$param->setMerchantID($this->getConfiguration()->getMerchantId());
			$param->setCustomerID($custId);
			$param->setProfileID($profileId);
			$this->getSoapService()->DeleteProfile($param);
			$transaction->setAliasForDisplay($alias->getAliasForDisplay());
		}
	}
	
	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param string $profileStatus
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 */
	private function handleRecurring(Customweb_Mpay24_Authorization_Transaction $transaction, $profileStatus){
		if ($transaction->getCreateProfile()) {
			if (!($profileStatus == 'CREATED')) {
				$transaction->setAuthorizationUncertain();
				$frontendMessage = Customweb_I18n_Translation::__(
						"Unfortunately your data could not be stored and therefore are no recurring transactions possible. Please try again later.");
				$backendMessage = Customweb_I18n_Translation::__("Recurring profile could not be created");
				$transaction->addErrorMessage(new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $backendMessage));
			}
		}
	}
	
	private function storeDefaultFormValues(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$pMethod = $this->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod());
		$pMethod->storeFormData($transaction->getTransactionContext()->getPaymentCustomerContext(), $formData);
	}
}