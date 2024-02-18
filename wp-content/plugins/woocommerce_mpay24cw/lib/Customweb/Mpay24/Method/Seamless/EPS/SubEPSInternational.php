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

require_once 'Customweb/Mpay24/Method/Seamless/EPS/ISubEPS.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentEPS.php';



/**
 *
 * @author Bjoern Hasselmann
 */
class Customweb_Mpay24_Method_Seamless_EPS_SubEPSInternational implements Customweb_Mpay24_Method_Seamless_EPS_ISubEPS {

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_Seamless_EPS_ISubEPS::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		return array();
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_Seamless_EPS_ISubEPS::getPaymentElement()
	 */
	public function getPaymentElement($brand, array $formData = array()){
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentEPS();
		$payment->setBrand($brand);
		return $payment;
	}
}