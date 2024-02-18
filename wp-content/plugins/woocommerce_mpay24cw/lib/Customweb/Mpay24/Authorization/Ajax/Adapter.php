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
require_once 'Customweb/Storage/IBackend.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Core/Url.php';
require_once 'Customweb/Payment/Endpoint/IAdapter.php';
require_once 'Customweb/Form/WideElement.php';
require_once 'Customweb/Form/Control/HiddenInput.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Validator/IFrameValidator.php';
require_once 'Customweb/Payment/Authorization/Ajax/IAdapter.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Mpay24/Authorization/AbstractTokenAdapter.php';
require_once 'Customweb/Form/HiddenElement.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 */
class Customweb_Mpay24_Authorization_Ajax_Adapter extends Customweb_Mpay24_Authorization_AbstractTokenAdapter implements 
		Customweb_Payment_Authorization_Ajax_IAdapter {
	private static $STORAGE_SPACE_KEY = 'Mpay24StorageSpace';
	private static $CALLBACK_FORM_FIELD_VALUES = 'formFieldValues';
	private static $FRAME_FORM_FIELD = 'mpayFrame';
	private static $VALIDATOR_FORM_FIELD = 'mpayValidator';

	/**
	 * Overridden
	 */
	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	/**
	 * Overridden
	 */
	public function getAdapterPriority(){
		return 100;
	}

	/**
	 * Overridden
	 */
	public function createTransaction(Customweb_Payment_Authorization_Ajax_ITransactionContext $transactionContext, $failedTransaction){
		return $this->createTransactionInner($transactionContext, $failedTransaction);
	}

	/**
	 * Overridden
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $customerPaymentContext){
		try {
			$aliasId = ($aliasTransaction instanceof Customweb_Mpay24_Authorization_Transaction ? $aliasTransaction->getAliasId() : null);
			$storage = $this->getContainer()->getBean('Customweb_Storage_IBackend');
			if (!($storage instanceof Customweb_Storage_IBackend)) {
				throw new Customweb_Core_Exception_CastException('Customweb_Storage_IBackend');
			}
			
			$tokenWrapper = $storage->read(self::$STORAGE_SPACE_KEY, $this->getTokenCacheKey($orderContext, $aliasId));
			if ($tokenWrapper == null || !is_array($tokenWrapper) || $this->isTimedOut($tokenWrapper)) {
				// cache token per checkout and payment method
				$response = $this->createPaymentToken($orderContext, $aliasId);
				if ($response->getStatus() != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
					$this->translateErrorMessage($response);
				}
				$tokenWrapper = array(
					'token' => $response->getToken()->get(),
					'location' => $response->getLocation(),
					'time' => time() 
				);
				$storage->write(self::$STORAGE_SPACE_KEY, $this->getTokenCacheKey($orderContext, $aliasId), $tokenWrapper);
			}
			
			$paymentMethod = $this->getMethodFactory()->getPaymentMethod($orderContext->getPaymentMethod(), self::AUTHORIZATION_METHOD_NAME);
			$validatorConditionName = 'mpay24' . $orderContext->getPaymentMethod()->getPaymentMethodName() . 'Validated';
			$brand = $this->getPaymentMethodBrand($paymentMethod);
			$html = '<iframe src=\'' . $tokenWrapper['location'] . '\' style=\'border:none; width:100%; height:' .
					 $paymentMethod->getPaymentMethodConfigurationValue('widget_frame_height') . '\'></iframe>';
			$eventListenerFunctionName = 'checkValid' . $brand;
			$script = 'window.addEventListener("message", ' . $eventListenerFunctionName . ', false);
						' . $validatorConditionName . ' = false;
				
						// receive form data from mPAY24 and check
						function ' . $eventListenerFunctionName . '(form) {
							var data = JSON.parse(form.data);
							if (data.valid === "true"' . (empty($brand) ? '' : ' && data.response.brand == "' . $brand . '"') . '){
								' . $validatorConditionName . ' = true;
							} else {
								' . $validatorConditionName . ' = false;
							}
						}';
			
			$frameControl = new Customweb_Form_Control_Html(self::$FRAME_FORM_FIELD, $html);
			$frameElement = new Customweb_Form_WideElement($frameControl);

			$frameElement->appendJavaScript($script);
			$frameElement->setRequired(false);
			
			$controlVal = new Customweb_Form_Control_HiddenInput(self::$VALIDATOR_FORM_FIELD, 'false');
			$validator = new Customweb_Mpay24_Validator_IFrameValidator($controlVal, 
					Customweb_I18n_Translation::__('Please validate your input.'), $orderContext->getPaymentMethod()->getPaymentMethodName());
			$controlVal->addValidator($validator);
			$elementVal = new Customweb_Form_HiddenElement($controlVal);
			
			$formFields = array(
				$frameElement,
				$elementVal 
			);
			/*
			 * > $aliasTransaction > new || aliasTransaction || null
			 * > form with profile id: If name is entered, data will be stored at mPay
			 * > getJavaScriptCallbackFunction > formFieldValues['profile_id_field'] as parameter for endpoint
			 * > endpoint: Set profile id in accept payment call
			 */
			if ($aliasTransaction == 'new') {
				$formFields[] = $this->createAliasFormField($aliasTransaction);
			}
			
			return $formFields;
		}
		catch (Exception $e) {
			$frameControl = new Customweb_Form_Control_Html(self::$FRAME_FORM_FIELD, $e->getMessage());
			$frameControl->setCssClass('error danger');
			$frameElement = new Customweb_Form_WideElement($frameControl);
			$frameElement->setRequired(false);
			return array(
				$frameElement 
			);
		}
	}

	/**
	 * Overridden
	 */
	public function getAjaxFileUrl(Customweb_Payment_Authorization_ITransaction $transaction){
		$assetResolver = $this->getContainer()->getBean('Customweb_Asset_IResolver');
		return (string) $assetResolver->resolveAssetUrl('ajax/dummy.js');
	}

	/**
	 * Overridden
	 */
	public function getJavaScriptCallbackFunction(Customweb_Payment_Authorization_ITransaction $transaction){
		$storage = $this->getContainer()->getBean('Customweb_Storage_IBackend');
		$endpointAdapter = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');
		
		if (!($endpointAdapter instanceof Customweb_Payment_Endpoint_IAdapter)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_Endpoint_IAdapter');
		}
		if (!($storage instanceof Customweb_Storage_IBackend)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Storage_IBackend');
		}
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		
		try {
			$aliasTransaction = $transaction->getTransactionContext()->getAlias();
			$aliasId = ($aliasTransaction instanceof Customweb_Mpay24_Authorization_Transaction ? $aliasTransaction->getAliasId() : null);
			$orderContext = $transaction->getTransactionContext()->getOrderContext();
			$tokenWrapper = $storage->read(self::$STORAGE_SPACE_KEY, $this->getTokenCacheKey($orderContext, $aliasId));
			$transaction->setWidgetToken($tokenWrapper['token']);
			try {
				$storage->remove(self::$STORAGE_SPACE_KEY, $this->getTokenCacheKey($orderContext, $aliasId));
			}
			catch (Exception $exc) {
				// ignore
			}
			$urlObj = new Customweb_Core_Url(
					$endpointAdapter->getUrl('widgetp', 'process', 
							array(
								'cw_transaction_id' => $transaction->getExternalTransactionId() 
							)));
			$url = $urlObj->getUrlAsString();
		}
		catch (Exception $e) {
			$transaction->setAuthorizationFailed($e->getMessage());
			$url = $transaction->getFailedUrl();
		}
		
		$callback = 'function (' . self::$CALLBACK_FORM_FIELD_VALUES . ') {var url = "' . $url . '";';
		if ($transaction->getTransactionContext()->getAlias() == 'new') {
			$callback .= 'url = url.concat("&", "' . self::$ALIAS_FORM_FIELD . '", "=", ' . self::$CALLBACK_FORM_FIELD_VALUES . '[\'' .
					 self::$ALIAS_FORM_FIELD . '\']);';
		}
		$callback .= 'window.location.replace(url); }';
		return $callback;
	}

	private function getTokenCacheKey(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasId){
		return hash("sha256", $orderContext->getCheckoutId() . $orderContext->getPaymentMethod()->getPaymentMethodName() . $aliasId);
	}

	private function getPaymentMethodBrand(Customweb_Mpay24_Method_DefaultMethod $paymentMethod){
		$params = $paymentMethod->getPaymentMethodParameters();
		if (($type = $params['type']) != 'CC') {
			return $type; // MAESTRO
		}
		return $params['brand'];
	}

	private function isTimedOut(array $tokenwrapper){
		// The payment form times out after approx. 15min
		return isset($tokenwrapper['time']) ? time() - $tokenwrapper['time'] > 15 * 60 - 1 : true;
	}
}
