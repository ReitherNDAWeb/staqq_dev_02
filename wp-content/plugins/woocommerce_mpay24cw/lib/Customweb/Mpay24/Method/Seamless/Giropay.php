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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentGIROPAY.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/ElementFactory.php';
require_once 'Customweb/Form/Control/TextInput.php';
require_once 'Customweb/Form/Intention/Factory.php';
require_once 'Customweb/Mpay24/Method/Seamless/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 * @Method(paymentMethods={'Giropay'})
 */
class Customweb_Mpay24_Method_Seamless_Giropay extends Customweb_Mpay24_Method_Seamless_DefaultMethod {
	const IBAN_FIELD_NAME = "IBAN";
	const BIC_FIELD_NAME = "BIC";

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_Seamless_DefaultMethod::getPaymentElement()
	 */
	public function getPaymentElement(array $formData = array()){
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY();
		if (isset($formData[self::IBAN_FIELD_NAME])) {
			$payment->setIban($formData[self::IBAN_FIELD_NAME]);
		}
		$payment->setBic($formData[self::BIC_FIELD_NAME]);
		return $payment;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		$elements = array();
		$elements[] = $this->getOptionalIbanElement(self::IBAN_FIELD_NAME);
		$elements[] = Customweb_Form_ElementFactory::getBankCodeElement(self::BIC_FIELD_NAME);
		return $elements;
	}

	private function getOptionalIbanElement($fieldName){
		$control = new Customweb_Form_Control_TextInput($fieldName);
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('IBAN number'), $control, 
				Customweb_I18n_Translation::__('Please enter your IBAN number.'));
		return $element->setElementIntention(Customweb_Form_Intention_Factory::getIbanNumberIntention())->setRequired(false);
	}
}