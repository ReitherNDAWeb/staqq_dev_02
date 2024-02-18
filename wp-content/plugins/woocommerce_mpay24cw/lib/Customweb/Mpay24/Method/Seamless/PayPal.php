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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentPAYPAL.php';
require_once 'Customweb/Mpay24/Method/DefaultMethod.php';
require_once 'Customweb/Mpay24/Method/Seamless/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 * @Method(paymentMethods={'PayPal'})
 */
class Customweb_Mpay24_Method_Seamless_PayPal extends Customweb_Mpay24_Method_Seamless_DefaultMethod {

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_Seamless_DefaultMethod::getPaymentElement()
	 */
	public function getPaymentElement(array $formData = array()) {
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL();
		return $payment;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		$elements = array();
		$country = trim($orderContext->getBillingAddress()->getCountryIsoCode());
		if ($country === 'US') {
			if ($element = $this->elementBuilder->getStateElement($orderContext, $customerPaymentContext)) {
				$elements[] = $element;
			}
		}
		return $elements;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_DefaultMethod::storeFormData()
	 */
	public function storeFormData(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $formFields){
		if (isset($formFields['state'])) {
			return $paymentCustomerContext->updateMap(array( 'state' => $formFields['state']));
		}
		return $paymentCustomerContext;
	}
}