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

require_once 'Customweb/Mpay24/Styling/Elements.php';
require_once 'Customweb/Form/Button.php';
require_once 'Customweb/Form/ElementGroup.php';
require_once 'Customweb/IForm.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/WideElement.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/Textarea.php';
require_once 'Customweb/Form/IButton.php';
require_once 'Customweb/Payment/BackendOperation/Form/Abstract.php';


/**
 * @BackendForm(0)
 */
final class Customweb_Mpay24_BackendOperation_Form_StylingForm extends Customweb_Payment_BackendOperation_Form_Abstract {
	private $defaultButton;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_IForm::getTitle()
	 */
	public function getTitle() {
		return Customweb_I18n_Translation::__ ( "Payment Page Styling" );
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_BackendOperation_Form_Abstract::isProcessable()
	 */
	public function isProcessable() {
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_BackendOperation_Form_Abstract::getElementGroups()
	 */
	public function getElementGroups() {
		return array (
				$this->getElementGroup () 
		);
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_BackendOperation_Form_Abstract::getButtons()
	 */
	public function getButtons() {
		return array (
				$this->getDefaultButton (),
				$this->getSaveButton ()
		);
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_BackendOperation_Form_Abstract::process()
	 */
	public function process(Customweb_Form_IButton $pressedButton, array $formData) {
		if ($pressedButton->getType () === Customweb_Form_IButton::TYPE_SUCCESS) {
			$this->getSettingHandler ()->processForm ( $this, $formData );
		} elseif ($pressedButton->getType () === Customweb_Form_IButton::TYPE_DEFAULT) {
			$this->getSettingHandler ()->processForm ( $this, array () );
		}
	}
	private function getElementGroup() {
		$group = new Customweb_Form_ElementGroup ();
		
		$description = Customweb_I18n_Translation::__ ( "The following input fields allows the styling of the payment page. The input must be valid CSS instructions. e.g. 'background-color: #FF0000;'.
				Except the fields ending with 'Text', which will insert the its value literally" );
		$group->addElement ( new Customweb_Form_WideElement ( new Customweb_Form_Control_Html ( 'description', $description ) ) );
		
		foreach ( Customweb_Mpay24_Styling_Elements::getStylingElements () as $element ) {
			$value = $this->getSettingHandler ()->getSettingValue ( $element->getName () );
			if ($value === null) {
				$value = $element->getDefault ();
			}
			$control = new Customweb_Form_Control_Textarea ( $element->getName (), trim($value) );
			$htmlElement = new Customweb_Form_Element ( $element->getLabel (), $control, '', false, ! $this->getSettingHandler ()->hasCurrentStoreSetting ( $element->getName () ) );
			$htmlElement->setRequired ( false );
			$group->addElement ( $htmlElement );
		}
		return $group;
	}
	private function getDefaultButton() {
		if ($this->defaultButton === null) {
			$this->defaultButton = new Customweb_Form_Button ();
			$this->defaultButton->setMachineName ( "default" )->setTitle ( Customweb_I18n_Translation::__ ( "Default All" ) )->setType ( Customweb_Form_IButton::TYPE_DEFAULT );
		}
		return $this->defaultButton;
	}
}