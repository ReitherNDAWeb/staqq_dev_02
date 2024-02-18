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

require_once 'Customweb/Form/Validator/NotEmpty.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Mpay24/Method/DefaultMethod.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentPB.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/TextInput.php';
require_once 'Customweb/Mpay24/Method/Seamless/DefaultMethod.php';
require_once 'Customweb/Mpay24/Validator/AreaCodeValidator.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 * @Method(paymentMethods={'Paybox'})
 */
class Customweb_Mpay24_Method_Seamless_Paybox extends Customweb_Mpay24_Method_Seamless_DefaultMethod {
	const IDENTIFIER_FIELD_NAME = "PBIDENTIFIER";

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_Seamless_DefaultMethod::getPaymentElement()
	 */
	public function getPaymentElement(array $formData = array()){
		$payment = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPB();
		$payment->setIdentifier($this->getPhoneIdentifier($formData[self::IDENTIFIER_FIELD_NAME]));
		return $payment;
	}

	/**
	 *
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 */
	private function getPhoneIdentifier($identifier){
		$identifier = $this->formatPhoneIdentifier($identifier);
		if ($identifier == '') {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("The phone number has to start with an area code (e.g., +49 for Germany)"), 
							Customweb_I18n_Translation::__("Phone number was missing area code")));
		}
		return $identifier;
	}

	/**
	 * Checks whether an area code is given or not (and replaces '00' with '+' if necessary.
	 * Also, removes all whitespaces.
	 *
	 * If no area code was given, an empty String is returned.
	 *
	 * @return the formatted identifier or an empty String, if no area code was given.
	 */
	private function formatPhoneIdentifier($identifier){
		if (!isset($identifier))
			return '';
		$identifier = preg_replace('/\s+/', '', $identifier); // replace all whitespaces
		if (substr($identifier, 0, 1) == '+') {
			return $identifier;
		}
		elseif (substr($identifier, 0, 2) == '00') {
			return '+' . substr($identifier, 2); // e.g., 0041 => +41
		}
		return '';
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		return array(
			$this->getIdentifierField(self::IDENTIFIER_FIELD_NAME, $orderContext) 
		);
	}

	private function getIdentifierField($fieldName, Customweb_Payment_Authorization_IOrderContext $orderContext){
		$phone = $orderContext->getBillingAddress()->getPhoneNumber();
		$phoneControl = new Customweb_Form_Control_TextInput($fieldName, $this->formatPhoneIdentifier($phone));
		$warning = Customweb_I18n_Translation::__("Please enter your phone number registered as Paybox identifier.");
		$phoneControl->addValidator(new Customweb_Form_Validator_NotEmpty($phoneControl, $warning))->addValidator(
				new Customweb_Mpay24_Validator_AreaCodeValidator($phoneControl));
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Phone number'), $phoneControl, $warning);
		return $element->setRequired(true);
	}
}

