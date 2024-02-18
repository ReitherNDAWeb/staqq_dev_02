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

require_once 'Customweb/Mpay24/Authorization/IPaymentInformationProvider.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 */
class Customweb_Mpay24_Method_OpenInvoice_BillpayPaymentInformationProvider implements 
		Customweb_Mpay24_Authorization_IPaymentInformationProvider {

	/**
	 * Overridden
	 *
	 * @see Customweb_Mpay24_Authorization_IPaymentInformationProvider::getPaymentInformation()
	 */
	public function getPaymentInformation(Customweb_Mpay24_Authorization_Transaction $transaction){
		$parameters = $transaction->getAuthorizationParameters();
		$information = '';
		if (isset($parameters['BANK_NAME'])) {
			$information .= Customweb_I18n_Translation::__('Bank: !bank', array(
				"!bank" => $parameters['BANK_NAME'] 
			)) . '<br />';
		}
		if (isset($parameters['ACCT_HOLDER'])) {
			$information .= Customweb_I18n_Translation::__('Account Holder: !holder', array(
				"!holder" => $parameters['ACCT_HOLDER'] 
			)) . '<br />';
		}
		if (isset($parameters['ACCT_NUMBER'])) {
			$information .= Customweb_I18n_Translation::__('IBAN: !iban', array(
				"!iban" => $parameters['ACCT_NUMBER'] 
			)) . '<br />';
		}
		if (isset($parameters['BANK_CODE'])) {
			$information .= Customweb_I18n_Translation::__('BIC: !bic', array(
				"!bic" => $parameters['BANK_CODE'] 
			)) . '<br />';
		}
		if (isset($parameters['REFERENCE'])) {
			$information .= Customweb_I18n_Translation::__('Reference Number: !reference', array(
				"!reference" => $parameters['REFERENCE'] 
			)) . '<br />';
		}

		return $information;
	}
}