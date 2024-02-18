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

require_once 'Customweb/Payment/BackendOperation/Adapter/Shop/ICapture.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/Update/IAdapter.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Mpay24/AbstractAdapter.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 *
 */
final class Customweb_Mpay24_Update_Adapter extends Customweb_Mpay24_AbstractAdapter implements 
		Customweb_Payment_Update_IAdapter {
	const TRANSACTION_TIMEOUT = 3;

	/**
	 * Overridden
	 */
	public function updateTransaction(Customweb_Payment_Authorization_ITransaction $transaction){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		$firstError = $transaction->getFirstErrorTime();
		if ($firstError != null && $firstError + Customweb_Mpay24_Authorization_Transaction::MAX_ERROR_TIME * 60 <= time()) {
			if (!$transaction->isAuthorized() && !$transaction->isAuthorizationFailed()) {
				$transaction->setAuthorizationFailed($transaction->getLastError());
				return;
			}
		}
		
		$status = '';
		$result = $this->checkTransactionStateSoap($transaction);
		$returnCode = $result['returnCode'];
		if ($returnCode != 'OK') {
			$this->handleUpdateError($transaction, $returnCode);
			if ($transaction->getUpdateCounter() === self::TRANSACTION_TIMEOUT) {
				$status = 'ERROR';
			}
			else {
				return;
			}
		}
		if ($status != 'ERROR') {
			$status = $result['status'];
		}
		
		switch ($status) {
			
			case 'BILLED':
				$transaction->setAuthorizationUncertain(false);
				if ($this->getContainer()->hasBean('Customweb_Payment_BackendOperation_Adapter_Shop_ICapture')) {
					$transaction->capture();
					$captureAdapter = $this->getContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Shop_ICapture');
					if (!($captureAdapter instanceof Customweb_Payment_BackendOperation_Adapter_Shop_ICapture)) {
						throw new Customweb_Core_Exception_CastException('Customweb_Payment_BackendOperation_Adapter_Shop_ICapture');
					}
					$captureAdapter->capture($transaction);
				}
				break;
			
			case 'RESERVED':
				$transaction->setAuthorizationUncertain(false);
				break;
			
			case 'FAILED':
			case 'ERROR':
				$this->failTransaction($transaction);
				break;
			
			case 'SUSPENDED':
			default:
				$this->handleUpdateError($transaction, $returnCode);
				if ($transaction->getUpdateCounter() === self::TRANSACTION_TIMEOUT) {
					$this->failTransaction($transaction);
				}
				$this->getConfiguration()->callUpdateService($transaction);
				break;
		}
	}

	private function handleUpdateError(Customweb_Mpay24_Authorization_Transaction $transaction, $returnCode){
		$transaction->incrementUpdateCounter();
		$times = ($transaction->getUpdateCounter() > 1 ? 'times' : 'time');
		$transaction->addErrorMessage(
				new Customweb_Payment_Authorization_ErrorMessage(
						Customweb_I18n_Translation::__('Transaction failed the update @number @times. Return code: @return', 
								array(
									'@number' => $transaction->getUpdateCounter(),
									'@return' => $returnCode,
									'@times' => $times 
								))));
	}

	private function failTransaction(Customweb_Mpay24_Authorization_Transaction $transaction){
		$transaction->addErrorMessage(new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__('Transaction aborted.')));
		$transaction->setUncertainTransactionFinallyDeclined();
		$transaction->setTransactionFailedDuringUpdate(true);
	}
}