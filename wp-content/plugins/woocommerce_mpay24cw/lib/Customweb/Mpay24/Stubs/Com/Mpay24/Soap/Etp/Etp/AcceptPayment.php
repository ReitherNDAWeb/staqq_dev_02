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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Order.php';
/**
 * @XmlType(name="AcceptPayment", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
	/**
	 * @XmlValue(name="tid", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $tid;
	
	/**
	 * @XmlElement(name="pType", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	private $pType;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="payment", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	private $payment;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="customerID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $customerID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="customerName", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $customerName;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="order", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	private $order;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="successURL", simpleType=@XmlSimpleTypeDefinition(typeName='anyURI', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $successURL;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="errorURL", simpleType=@XmlSimpleTypeDefinition(typeName='anyURI', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $errorURL;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="confirmationURL", simpleType=@XmlSimpleTypeDefinition(typeName='anyURI', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $confirmationURL;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="language", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $language;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment();
		return $i;
	}
	/**
	 * Returns the value for the property merchantID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getMerchantID(){
		return $this->merchantID;
	}
	
	/**
	 * Sets the value for the property merchantID.
	 * 
	 * @param integer $merchantID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setMerchantID($merchantID){
		if ($merchantID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->merchantID = $merchantID;
		}
		else {
			$this->merchantID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($merchantID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tid.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTid(){
		return $this->tid;
	}
	
	/**
	 * Sets the value for the property tid.
	 * 
	 * @param string $tid
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setTid($tid){
		if ($tid instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->tid = $tid;
		}
		else {
			$this->tid = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($tid);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pType.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	public function getPType(){
		return $this->pType;
	}
	
	/**
	 * Sets the value for the property pType.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType $pType
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setPType($pType){
		if ($pType instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType) {
			$this->pType = $pType;
		}
		else {
			throw new BadMethodCallException("Type of argument pType must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payment.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function getPayment(){
		return $this->payment;
	}
	
	/**
	 * Sets the value for the property payment.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment $payment
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setPayment($payment){
		if ($payment instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment) {
			$this->payment = $payment;
		}
		else if (is_object($payment) && get_class($payment) == "Customweb_Xml_Nil") {
			$this->payment = $payment;
		}
		else {
			throw new BadMethodCallException("Type of argument payment must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment.");
		}
		return $this;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setCustomerID($customerID){
		if ($customerID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->customerID = $customerID;
		}
		else if (is_object($customerID) && get_class($customerID) == "Customweb_Xml_Nil") {
			$this->customerID = $customerID;
		}
		else {
			$this->customerID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($customerID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property customerName.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCustomerName(){
		return $this->customerName;
	}
	
	/**
	 * Sets the value for the property customerName.
	 * 
	 * @param string $customerName
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setCustomerName($customerName){
		if ($customerName instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->customerName = $customerName;
		}
		else if (is_object($customerName) && get_class($customerName) == "Customweb_Xml_Nil") {
			$this->customerName = $customerName;
		}
		else {
			$this->customerName = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($customerName);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property order.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function getOrder(){
		return $this->order;
	}
	
	/**
	 * Sets the value for the property order.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order $order
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setOrder($order){
		if ($order instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order) {
			$this->order = $order;
		}
		else if (is_object($order) && get_class($order) == "Customweb_Xml_Nil") {
			$this->order = $order;
		}
		else {
			throw new BadMethodCallException("Type of argument order must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property successURL.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getSuccessURL(){
		return $this->successURL;
	}
	
	/**
	 * Sets the value for the property successURL.
	 * 
	 * @param string $successURL
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setSuccessURL($successURL){
		if ($successURL instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->successURL = $successURL;
		}
		else if (is_object($successURL) && get_class($successURL) == "Customweb_Xml_Nil") {
			$this->successURL = $successURL;
		}
		else {
			$this->successURL = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($successURL);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errorURL.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorURL(){
		return $this->errorURL;
	}
	
	/**
	 * Sets the value for the property errorURL.
	 * 
	 * @param string $errorURL
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setErrorURL($errorURL){
		if ($errorURL instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->errorURL = $errorURL;
		}
		else if (is_object($errorURL) && get_class($errorURL) == "Customweb_Xml_Nil") {
			$this->errorURL = $errorURL;
		}
		else {
			$this->errorURL = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($errorURL);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property confirmationURL.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getConfirmationURL(){
		return $this->confirmationURL;
	}
	
	/**
	 * Sets the value for the property confirmationURL.
	 * 
	 * @param string $confirmationURL
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setConfirmationURL($confirmationURL){
		if ($confirmationURL instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->confirmationURL = $confirmationURL;
		}
		else if (is_object($confirmationURL) && get_class($confirmationURL) == "Customweb_Xml_Nil") {
			$this->confirmationURL = $confirmationURL;
		}
		else {
			$this->confirmationURL = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($confirmationURL);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property language.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getLanguage(){
		return $this->language;
	}
	
	/**
	 * Sets the value for the property language.
	 * 
	 * @param string $language
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment
	 */
	public function setLanguage($language){
		if ($language instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->language = $language;
		}
		else if (is_object($language) && get_class($language) == "Customweb_Xml_Nil") {
			$this->language = $language;
		}
		else {
			$this->language = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($language);
		}
		return $this;
	}
	
	
	
}