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
require_once 'Customweb/Form/Validator/IValidator.php';
require_once 'Customweb/Form/Validator/Abstract.php';

/**
 * 
 * @author Bjoern Hasselmann
 */
class Customweb_Mpay24_Validator_AreaCodeValidator extends Customweb_Form_Validator_Abstract implements 
		Customweb_Form_Validator_IValidator {

	/**
	 *
	 * @param Customweb_Form_Control_IControl $control
	 */
	public function __construct(Customweb_Form_Control_IControl $control){
		parent::__construct($control, "Please provide an area code (e.g., +49 for Germany)");
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see Customweb_Form_Validator_Abstract::getValidationCondition()
	 */
	public function getValidationCondition(){
		return 'element.value.toString().startsWith("00") || element.value.toString().startsWith("+")';
	}
}