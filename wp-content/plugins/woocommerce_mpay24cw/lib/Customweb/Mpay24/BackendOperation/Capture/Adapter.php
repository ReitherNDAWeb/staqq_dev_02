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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ClearingDetails.php';
require_once 'Customweb/Mpay24/BackendOperation/Capture/ParameterBuilder.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualClear.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICapture.php';
require_once 'Customweb/Mpay24/BackendOperation/AbstractAdapter.php';
require_once 'Customweb/Util/Invoice.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 */
final class Customweb_Mpay24_BackendOperation_Capture_Adapter extends Customweb_Mpay24_BackendOperation_AbstractAdapter implements 
		Customweb_Payment_BackendOperation_Adapter_Service_ICapture {
	const ORIGINAL_TSTATE = 'RESERVED';
	const TARGET_TSTATE = 'BILLED';

	public function capture(Customweb_Payment_Authorization_ITransaction $transaction){
		$items = $transaction->getUncapturedLineItems();
		$this->partialCapture($transaction, $items, true);
	}

	public function partialCapture(Customweb_Payment_Authorization_ITransaction $transaction, $items, $close){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		$transaction->partialCaptureByLineItemsDry($items, $close);
		
		$param = $this->setParameter($transaction, $items);
		$response = self::getSoapService()->ManualClear($param);
		$this->checkResponseState($response->getStatus(), $response->getReturnCode());
		
		$transes = $response->getTransaction();
		$respTrans = $transes[0];
		$this->checkTransactionState($respTrans, self::TARGET_TSTATE);
		
		// if there is no state id, the multiple capture feature was not activated, thus only one capture is possible
		$stateId = $respTrans->getStateID();
		if ($stateId == null || empty($stateId)) {
			$close = true;
		}
		$capture = $transaction->partialCaptureByLineItems($items, $close, $stateId);
		$capture->setStateId($stateId);
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 * @throws Customweb_Core_Exception_CastException
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClear
	 */
	private function setParameter(Customweb_Payment_Authorization_ITransaction $transaction, $items){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		$builder = new Customweb_Mpay24_BackendOperation_Capture_ParameterBuilder($transaction, $this->getContainer(), $items);
		$detail = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails();
		$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClear();
		
		$param->setMerchantID($this->getConfiguration()->getMerchantId());
		$detail->setMpayTID($transaction->getMpayTid());
		$detail->setAmount(
				Customweb_Util_Currency::formatAmount(Customweb_Util_Invoice::getTotalAmountIncludingTax($items), $transaction->getCurrencyCode(), ''));
		
		$order = $builder->getOrder();
		$detail->setOrder($order);
		$param->setClearingDetails(array(
			$detail 
		));
		
		return $param;
	}
}