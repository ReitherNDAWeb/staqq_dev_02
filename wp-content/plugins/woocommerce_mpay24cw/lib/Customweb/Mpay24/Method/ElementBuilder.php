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
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/TextInput.php';

/**
 *
 * @author Bjoern Hasselmann
 *
 */
final class Customweb_Mpay24_Method_ElementBuilder {

	/**
	 * Returns NULL if the gender is already set.
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @return Customweb_Form_Element || NULL
	 */
	public function getGenderElement(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$element = null;
		$gender = $orderContext->getBillingAddress()->getGender();
		if ($gender != 'male' && $gender != 'female') {
			$elementName = 'gender';
			$default = $this->getDefaultValue($elementName, $paymentCustomerContext);
			$genders = array(
				'none' => Customweb_I18n_Translation::__('Select your gender'),
				'f' => Customweb_I18n_Translation::__('Female'),
				'm' => Customweb_I18n_Translation::__('Male') 
			);
			$genderControl = new Customweb_Form_Control_Select($elementName, $genders, $default);
			$genderControl->addValidator(
					new Customweb_Form_Validator_NotEmpty($genderControl, Customweb_I18n_Translation::__("Please select your gender.")));
			
			$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Gender'), $genderControl, 
					Customweb_I18n_Translation::__('Please select your gender.'));
		}
		return $element;
	}
	
	/**
	 * Returns NULL if the phone number is already set.
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @return Customweb_Form_Element || NULL
	 */
	public function getPhoneNumberElement(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$element = null;
		$phone = $orderContext->getBillingAddress()->getPhoneNumber();
		if (!(isset($phone) && $phone != '')) {
			$elementName = 'phoneNumber';
			$default = $this->getDefaultValue($elementName, $paymentCustomerContext);
			$phoneControl = new Customweb_Form_Control_TextInput($elementName, $default);
			$phoneControl->addValidator(
					new Customweb_Form_Validator_NotEmpty($phoneControl, Customweb_I18n_Translation::__("Please enter your phone number")));
			$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Phone number'), $phoneControl, 
					Customweb_I18n_Translation::__("Please enter your phone number"));
		}
		return $element;
	}
	
	/**
	 * Returns NULL if the state is already set.
	 *
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @return Customweb_Form_Element || NULL
	 */
	public function getStateElement(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$element = null;
		$state = $orderContext->getBillingAddress()->getState();
		if (!(isset($state) && $state != '')) {
			$elementName = 'state';
			$default = $this->getDefaultValue($elementName, $paymentCustomerContext);
			$stateControl = new Customweb_Form_Control_TextInput($elementName, $default);
			$stateControl->addValidator(
					new Customweb_Form_Validator_NotEmpty($stateControl, Customweb_I18n_Translation::__("Please enter the state you live in")));
			$element = new Customweb_Form_Element(Customweb_I18n_Translation::__("State"), $stateControl, 
					Customweb_I18n_Translation::__("Please enter the state you live in"));
		}
		return $element;
	}

	/**
	 * Only works for string elements!
	 * Returns the value or an empty string, if element was not found (or empty)
	 *
	 * @param string $elementName
	 * @param Customweb_Payment_Authorization_IOrderContext $orderContext
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext
	 * @return string
	 */
	private function getDefaultValue($elementName, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$custMap = $paymentCustomerContext->getMap();
		if (key_exists($elementName, $custMap)) {
			$custValue = $custMap[$elementName];
		}
		if (isset($custValue)) {
			return $custValue;
		}
		else {
			return '';
		}
	}
}