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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ShoppingCart.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/IndustrySpecific.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Address.php';
/**
 * Customer order definition
 * 
 * @XmlType(name="Order", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order {
	/**
	 * @XmlNillable
	 * @XmlValue(name="clientIP", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $clientIP;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="description", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $description;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="userField", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $userField;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="shoppingCart", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	private $shoppingCart;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="industrySpecific", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific
	 */
	private $industrySpecific;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="billing", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	private $billing;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="shipping", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	private $shipping;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order();
		return $i;
	}
	/**
	 * Returns the value for the property clientIP.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getClientIP(){
		return $this->clientIP;
	}
	
	/**
	 * Sets the value for the property clientIP.
	 * 
	 * @param string $clientIP
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setClientIP($clientIP){
		if ($clientIP instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->clientIP = $clientIP;
		}
		else if (is_object($clientIP) && get_class($clientIP) == "Customweb_Xml_Nil") {
			$this->clientIP = $clientIP;
		}
		else {
			$this->clientIP = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($clientIP);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param string $description
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->description = $description;
		}
		else if (is_object($description) && get_class($description) == "Customweb_Xml_Nil") {
			$this->description = $description;
		}
		else {
			$this->description = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($description);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property userField.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getUserField(){
		return $this->userField;
	}
	
	/**
	 * Sets the value for the property userField.
	 * 
	 * @param string $userField
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setUserField($userField){
		if ($userField instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->userField = $userField;
		}
		else if (is_object($userField) && get_class($userField) == "Customweb_Xml_Nil") {
			$this->userField = $userField;
		}
		else {
			$this->userField = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($userField);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shoppingCart.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function getShoppingCart(){
		return $this->shoppingCart;
	}
	
	/**
	 * Sets the value for the property shoppingCart.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart $shoppingCart
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setShoppingCart($shoppingCart){
		if ($shoppingCart instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart) {
			$this->shoppingCart = $shoppingCart;
		}
		else if (is_object($shoppingCart) && get_class($shoppingCart) == "Customweb_Xml_Nil") {
			$this->shoppingCart = $shoppingCart;
		}
		else {
			throw new BadMethodCallException("Type of argument shoppingCart must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property industrySpecific.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific
	 */
	public function getIndustrySpecific(){
		return $this->industrySpecific;
	}
	
	/**
	 * Sets the value for the property industrySpecific.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific $industrySpecific
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setIndustrySpecific($industrySpecific){
		if ($industrySpecific instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific) {
			$this->industrySpecific = $industrySpecific;
		}
		else if (is_object($industrySpecific) && get_class($industrySpecific) == "Customweb_Xml_Nil") {
			$this->industrySpecific = $industrySpecific;
		}
		else {
			throw new BadMethodCallException("Type of argument industrySpecific must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property billing.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function getBilling(){
		return $this->billing;
	}
	
	/**
	 * Sets the value for the property billing.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address $billing
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setBilling($billing){
		if ($billing instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address) {
			$this->billing = $billing;
		}
		else if (is_object($billing) && get_class($billing) == "Customweb_Xml_Nil") {
			$this->billing = $billing;
		}
		else {
			throw new BadMethodCallException("Type of argument billing must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shipping.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function getShipping(){
		return $this->shipping;
	}
	
	/**
	 * Sets the value for the property shipping.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address $shipping
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function setShipping($shipping){
		if ($shipping instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address) {
			$this->shipping = $shipping;
		}
		else if (is_object($shipping) && get_class($shipping) == "Customweb_Xml_Nil") {
			$this->shipping = $shipping;
		}
		else {
			throw new BadMethodCallException("Type of argument shipping must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address.");
		}
		return $this;
	}
	
	
	
}