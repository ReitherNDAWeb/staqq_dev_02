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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/DateTime.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentProfile.php';
/**
 * Customer profile with payment data
 * 
 * @XmlType(name="Profile", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile {
	/**
	 * @XmlValue(name="customerID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $customerID;
	
	/**
	 * @XmlValue(name="updated", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime'))
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $updated;
	
	/**
	 * @XmlList(name="payment", type='Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile')
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile[]
	 */
	private $payment;
	
	public function __construct() {
		$this->payment = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile();
		return $i;
	}
	/**
	 * Returns the value for the property customerID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCustomerID(){
		return $this->customerID;
	}
	
	/**
	 * Sets the value for the property customerID.
	 * 
	 * @param string $customerID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile
	 */
	public function setCustomerID($customerID){
		if ($customerID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->customerID = $customerID;
		}
		else {
			$this->customerID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($customerID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property updated.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getUpdated(){
		return $this->updated;
	}
	
	/**
	 * Sets the value for the property updated.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $updated
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile
	 */
	public function setUpdated($updated){
		if ($updated instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->updated = $updated;
		}
		else {
			$this->updated = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime::_()->set($updated);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payment.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile[]
	 */
	public function getPayment(){
		return $this->payment;
	}
	
	/**
	 * Sets the value for the property payment.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile $payment
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile
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
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile $item
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile
	 */
	public function addPayment(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile $item) {
		if (!($this->payment instanceof ArrayObject)) {
			$this->payment = new ArrayObject();
		}
		$this->payment[] = $item;
		return $this;
	}
	
	
}