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

require_once 'Customweb/Mpay24/Method/DefaultMethod.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';



/**
 * Seamless payment methods require a redirection, but skip the MPAY's payment page.
 *
 *
 * @author Bjoern Hasselmann
 * @Method(paymentMethods={'Sofortueberweisung', 'SafetyPay', 'Paysafecard', 'Mpass', 'Quick'})
 */
class Customweb_Mpay24_Method_Seamless_DefaultMethod extends Customweb_Mpay24_Method_DefaultMethod {

	/**
	 * Override this method if a specific type of PaymentXXX has to sent.
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function getPaymentElement(array $formData = array()){
		return new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment();
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see Customweb_Mpay24_Method_DefaultMethod::getRedirectionUrl()
	 */
	public function getRedirectionUrl(Customweb_Mpay24_Authorization_AbstractRedirectAdapter $adapter, Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$response = $adapter->seamlessAcceptPaymentCall($transaction, $formData);
		return (string) $response->getLocation()->get();
	}
}