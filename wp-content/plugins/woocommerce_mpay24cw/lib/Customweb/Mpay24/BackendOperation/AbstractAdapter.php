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
require_once 'Customweb/Mpay24/Constants/Error.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Mpay24/AbstractAdapter.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
abstract class Customweb_Mpay24_BackendOperation_AbstractAdapter extends Customweb_Mpay24_AbstractAdapter {

	/**
	 * In case something's wrong, an exception is thrown.
	 * Does nothing otherwise.
	 *
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status $state
	 * @param string $responseReturnCode
	 *
	 * @throws Exception
	 */
	protected final function checkResponseState(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status $state, $responseReturnCode){
		if ($state != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
			$code = Customweb_Mpay24_Constants_ReturnCode::get($responseReturnCode);
			throw new Exception(Customweb_I18n_Translation::__('Operation failed: @details', array(
				'@details' => $code->getMessage() 
			)));
		}
	}

	/**
	 * In case something's wrong, an exception is thrown.
	 * Does nothing otherwise.
	 *
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction $transaction
	 * @param string $targetTState
	 *
	 * @throws Exception
	 */
	protected final function checkTransactionState(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction $transaction, $targetTState){
		$tState = $transaction->getTStatus();
		if ($tState != $targetTState) {
			$errMsg = '';
			$tid = $transaction->getTid();
			switch ($tState) {
				case 'NOTFOUND':
					$errMsg = Customweb_I18n_Translation::__('The transaction @tid could not be found!', array('@tid' => $tid));
					break;
				case 'FAILED':
					$errMsg = Customweb_I18n_Translation::__('The operation failed.');
					break;
				default:
					$errMsg = Customweb_I18n_Translation::__('The transaction @tid had the unexcpected state @tState', array('@tid' => $tid, '@tState' => $tState));
					break;
			}
			$frontendMessage = Customweb_Mpay24_Constants_Error::getFrontendMessage();
			throw new Customweb_Payment_Exception_PaymentErrorException(new Customweb_Payment_Authorization_ErrorMessage($frontendMessage, $errMsg));
		}
	}
}