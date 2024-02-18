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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Withdraw.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Order.php';
/**
 * @XmlType(name="AcceptWithdraw", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw {
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
	 * @XmlElement(name="withdraw", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw
	 */
	private $withdraw;
	
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * Returns the value for the property withdraw.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw
	 */
	public function getWithdraw(){
		return $this->withdraw;
	}
	
	/**
	 * Sets the value for the property withdraw.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw $withdraw
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
	 */
	public function setWithdraw($withdraw){
		if ($withdraw instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw) {
			$this->withdraw = $withdraw;
		}
		else if (is_object($withdraw) && get_class($withdraw) == "Customweb_Xml_Nil") {
			$this->withdraw = $withdraw;
		}
		else {
			throw new BadMethodCallException("Type of argument withdraw must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Withdraw.");
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw
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