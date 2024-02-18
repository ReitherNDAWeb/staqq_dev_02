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

require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/IRefund.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCredit.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Mpay24/BackendOperation/AbstractAdapter.php';
require_once 'Customweb/Util/Invoice.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 */
final class Customweb_Mpay24_BackendOperation_Refund_Adapter extends Customweb_Mpay24_BackendOperation_AbstractAdapter implements 
		Customweb_Payment_BackendOperation_Adapter_Service_IRefund {
	const ORIGINAL_TSTATE = 'BILLED';
	const TARGET_TSTATE = 'CREDITED';

	public function refund(Customweb_Payment_Authorization_ITransaction $transaction){
		$items = $transaction->getNonRefundedLineItems();
		$this->partialRefund($transaction, $items, true);
	}
	
	public function partialRefund(Customweb_Payment_Authorization_ITransaction $transaction, $items, $close){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		$transaction->refundDry($items, $close);
		
		$residualAmount = $amount;
		foreach ($transaction->getCaptures() as $capture) {
			if ($residualAmount <= 0) {
				break;
			}
			
			$amountToRefund = $residualAmount;
			$refundableAmount = $capture->getAmount() - $capture->getRefundedAmount();
			if ($refundableAmount < $residualAmount) {
				$amountToRefund = $refundableAmount;
			}
			
			if ($amountToRefund <= 0) {
				continue;
			}
			
			$residualAmount = $residualAmount - $amountToRefund;
			
			$closeRefund = false;
			if ($close) {
				if ($residualAmount <= 0) {
					$closeRefund = true;
				}
			}
			$transaction->refundDry($amountToRefund, $closeRefund);
			$this->refundCapture($transaction, $capture, $amountToRefund, $closeRefund);
		}
	}

	protected function refundCapture(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_Mpay24_Authorization_TransactionCapture $capture, $amount, $close){
		$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit();
		$param->setMerchantID($this->getConfiguration()->getMerchantId());
		$param->setMpayTID($transaction->getMpayTid());
		
		$amountFormatted = Customweb_Util_Currency::formatAmount($amount, $transaction->getCurrencyCode(), '', '');
		$param->setAmount($amountFormatted);
		
		$stateId = $capture->getStateId();
		if ($stateId != null || !empty($stateId)) {
			$param->setStateID($capture->getStateId());
		}
		else {
			$close = true;
		}
		
		$response = $this->getSoapService()->ManualCredit($param);
		$this->checkResponseState($response->getStatus(), $response->getReturnCode());
		
		$respTrans = $response->getTransaction();
		$this->checkTransactionState($respTrans, self::TARGET_TSTATE);
		
		$transaction->refund($amount, $close);
		$capture->setRefundedAmount(($capture->getRefundedAmount() + $amount));
	}
}