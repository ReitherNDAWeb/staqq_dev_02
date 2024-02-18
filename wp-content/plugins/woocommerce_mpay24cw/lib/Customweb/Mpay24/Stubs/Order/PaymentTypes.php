<?php
/**
 * You are allowed to use this API in your web application.
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

require_once 'Customweb/Mpay24/Stubs/Order/PaymentTypes/Payment.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
/**
 * @XmlType(name="PaymentTypes", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_PaymentTypes {
	/**
	 * @XmlList(name="Payment", type='Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment')
	 * @var Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment[]
	 */
	private $payment;
	
	/**
	 * @XmlAttribute(name="Enable", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean')) 
	 * @var boolean
	 */
	private $enable = 'true';
	
	public function __construct() {
		$this->payment = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_PaymentTypes();
		return $i;
	}
	/**
	 * Returns the value for the property payment.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment[]
	 */
	public function getPayment(){
		return $this->payment;
	}
	
	/**
	 * Sets the value for the property payment.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment $payment
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	public function setPayment($payment){
		if (is_array($payment)) {
			$payment = new ArrayObject($payment);
		}
		if ($payment instanceof ArrayObject) {
			$this->payment = $payment;
		}
		else {
			throw new BadMethodCallException("Type of argument payment must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of payment.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment $item
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	public function addPayment(Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment $item) {
		if (!($this->payment instanceof ArrayObject)) {
			$this->payment = new ArrayObject();
		}
		$this->payment[] = $item;
		return $this;
	}
	
	/**
	 * Enable or disable the specified payment types
	 * 
	 * Returns the value for the property enable.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getEnable(){
		return $this->enable;
	}
	
	/**
	 * Enable or disable the specified payment types
	 * 
	 * Sets the value for the property enable.
	 * 
	 * @param boolean $enable
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	public function setEnable($enable){
		if ($enable instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->enable = $enable;
		}
		else {
			$this->enable = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($enable);
		}
		return $this;
	}
	
	
	
}