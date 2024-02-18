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
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Mpay24/BackendOperation/AbstractAdapter.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICancel.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualReverse.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 */
final class Customweb_Mpay24_BackendOperation_Cancel_Adapter extends Customweb_Mpay24_BackendOperation_AbstractAdapter implements 
		Customweb_Payment_BackendOperation_Adapter_Service_ICancel {
	const ORIGINAL_TSTATE = 'RESERVED';
	const TARGET_TSTATE = 'REVERSED';

	public function cancel(Customweb_Payment_Authorization_ITransaction $transaction){
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Mpay24_Authorization_Transaction');
		}
		$transaction->cancelDry();
		
		$param = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualReverse();
		$param->setMerchantID($this->getConfiguration()->getMerchantId());
		$param->setMpayTID($transaction->getMpayTid());
		$response = self::getSoapService()->ManualReverse($param);
		$this->checkResponseState($response->getStatus(), $response->getReturnCode());
		
		$respTrans = $response->getTransaction();
		$this->checkTransactionState($respTrans, self::TARGET_TSTATE);
		$transaction->cancel();
	}
}