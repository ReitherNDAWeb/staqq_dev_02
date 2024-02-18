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
require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Core/Http/Response.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Controller("process")
 *
 */
class Customweb_Mpay24_Endpoint_Process extends Customweb_Payment_Endpoint_Controller_Abstract {
	private static $OPTIMISTIC_LOCKING_TRIES = 5;

	/**
	 * @Action("index")
	 */
	public function processManually(Customweb_Core_Http_IRequest $request){
		for ($i = 0; $i < self::$OPTIMISTIC_LOCKING_TRIES; ++$i) {
			try {
				$this->getTransactionHandler()->beginTransaction();
				$transaction = $this->loadTransactionFromRequest($request);
				$parameters = $request->getParameters();
				
				if ($transaction->isAuthorized() || $transaction->isAuthorizationFailed()) {
					$adapter->handleTwoStepDirectCapture($transaction, $parameters);
					$this->saveTransaction($transaction);
					$this->getTransactionHandler()->commitTransaction();
					return Customweb_Core_Http_Response::_("OK");
				}
				
				$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
				$response = $adapter->processAuthorization($transaction, $parameters);
				$transaction->setAuthorizationParameters($parameters);
				$this->saveTransaction($transaction);
				$this->getTransactionHandler()->commitTransaction();
				return $response;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $exp) {
				$this->getTransactionHandler()->rollbackTransaction();
			}
		}
		return Customweb_Core_Http_Response::_('ERROR')->setStatusCode(500)->setStatusMessage('Could not update transaction state');
	}

	/**
	 * @Action("cancelled")
	 */
	public function cancelled(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_Core_Http_IRequest $request){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		$parameters = $request->getParameters();
		
		$transaction->checkSecuritySignature("process/cancelled", $parameters["signature"]);
		
		if (!$transaction->isAuthorizationFailed() && !$transaction->isAuthorized()) {
			$reason = Customweb_I18n_Translation::__("The payment has been cancelled.");
			if (isset($parameters['ERRTEXT']) && !empty($parameters['ERRTEXT'])) {
				$reason = $parameters['ERRTEXT'];
			}
			$transaction->setAuthorizationFailed($reason);
		}
		if ($transaction->getAuthorizationMethod() == Customweb_Payment_Authorization_Iframe_IAdapter::AUTHORIZATION_METHOD_NAME) {
			$iframeBreakoutUrl = Customweb_Util_Url::appendParameters($transaction->getTransactionContext()->getIframeBreakOutUrl(), 
					$transaction->getTransactionContext()->getCustomParameters());
			return Customweb_Core_Http_Response::redirect($iframeBreakoutUrl);
		}
		else {
			return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
		}
	}

	/**
	 * @Action("failed")
	 */
	public function failed(Customweb_Core_Http_IRequest $request){
		
		// handle optimistic locking
		for ($i = 0; $i < self::$OPTIMISTIC_LOCKING_TRIES; ++$i) {
			try {
				// manually load transaction to handle optimistic locking
				$this->getTransactionHandler()->beginTransaction();
				$transaction = $this->loadTransactionFromRequest($request);
				if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
					throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
				}
				if ($transaction->isAuthorizationFailed()) {
					$this->getTransactionHandler()->commitTransaction();
					break;
				}
				
				$parameters = $request->getParameters();
				$reason = $transaction->getLastError();
				
				if (isset($parameters['ERRTEXT']) && !empty($parameters['ERRTEXT'])) {
					$reason = new Customweb_Payment_Authorization_ErrorMessage($parameters['ERRTEXT'], $parameters['ERRTXT']);
				}
				if (isset($parameters['reason_code'])) {
					$reason = new Customweb_Payment_Authorization_ErrorMessage($parameters['reason_msg'], 
							$parameters['reason_code'] . ': ' . $parameters['reason_msg']);
				}
				if (empty($reason)) {
					$reason = Customweb_I18n_Translation::__("The transaction failed for an unknown reason.");
				}
				
				$transaction->setAuthorizationFailed($reason);
				$this->saveTransaction($transaction);
				$this->getTransactionHandler()->commitTransaction();
				break;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $exp) {
				$this->getTransactionHandler()->rollbackTransaction();
			}
		}
		
		if ($transaction->getAuthorizationMethod() == Customweb_Payment_Authorization_Iframe_IAdapter::AUTHORIZATION_METHOD_NAME) {
			$iframeBreakoutUrl = Customweb_Util_Url::appendParameters($transaction->getTransactionContext()->getIframeBreakOutUrl(), 
					$transaction->getTransactionContext()->getCustomParameters());
			return Customweb_Core_Http_Response::redirect($iframeBreakoutUrl);
		}
		else {
			return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
		}
	}

	private function loadTransactionFromRequest(Customweb_Core_Http_IRequest $request){
		$txid = $this->getTransactionId($request);
		$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($txid['id'], false);
		if (!$transaction instanceof Customweb_Mpay24_Authorization_Transaction) {
			throw new Exception("Transaction must be of type Customweb_Mpay24_Authorization_Transaction.");
		}
		return $transaction;
	}

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @throws Customweb_Payment_Exception_OptimisticLockingException
	 */
	private function saveTransaction(Customweb_Mpay24_Authorization_Transaction $transaction){
		$this->getTransactionHandler()->persistTransactionObject($transaction);
	}
}
