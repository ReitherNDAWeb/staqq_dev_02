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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
/**
 * Shopping cart item
 * 
 * @XmlType(name="Item", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item {
	/**
	 * @XmlNillable
	 * @XmlValue(name="number", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $number;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="productNr", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $productNr;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="description", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $description;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="package", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $package;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="quantity", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $quantity;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="tax", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $tax;
	
	/**
	 * @XmlValue(name="amount", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $amount;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item();
		return $i;
	}
	/**
	 * Returns the value for the property number.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getNumber(){
		return $this->number;
	}
	
	/**
	 * Sets the value for the property number.
	 * 
	 * @param string $number
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setNumber($number){
		if ($number instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->number = $number;
		}
		else if (is_object($number) && get_class($number) == "Customweb_Xml_Nil") {
			$this->number = $number;
		}
		else {
			$this->number = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($number);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property productNr.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProductNr(){
		return $this->productNr;
	}
	
	/**
	 * Sets the value for the property productNr.
	 * 
	 * @param string $productNr
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setProductNr($productNr){
		if ($productNr instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->productNr = $productNr;
		}
		else if (is_object($productNr) && get_class($productNr) == "Customweb_Xml_Nil") {
			$this->productNr = $productNr;
		}
		else {
			$this->productNr = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($productNr);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
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
	 * Returns the value for the property package.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPackage(){
		return $this->package;
	}
	
	/**
	 * Sets the value for the property package.
	 * 
	 * @param string $package
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setPackage($package){
		if ($package instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->package = $package;
		}
		else if (is_object($package) && get_class($package) == "Customweb_Xml_Nil") {
			$this->package = $package;
		}
		else {
			$this->package = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($package);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property quantity.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getQuantity(){
		return $this->quantity;
	}
	
	/**
	 * Sets the value for the property quantity.
	 * 
	 * @param integer $quantity
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setQuantity($quantity){
		if ($quantity instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->quantity = $quantity;
		}
		else if (is_object($quantity) && get_class($quantity) == "Customweb_Xml_Nil") {
			$this->quantity = $quantity;
		}
		else {
			$this->quantity = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($quantity);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tax.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getTax(){
		return $this->tax;
	}
	
	/**
	 * Sets the value for the property tax.
	 * 
	 * @param integer $tax
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setTax($tax){
		if ($tax instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->tax = $tax;
		}
		else if (is_object($tax) && get_class($tax) == "Customweb_Xml_Nil") {
			$this->tax = $tax;
		}
		else {
			$this->tax = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($tax);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property amount.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getAmount(){
		return $this->amount;
	}
	
	/**
	 * Sets the value for the property amount.
	 * 
	 * @param integer $amount
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item
	 */
	public function setAmount($amount){
		if ($amount instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->amount = $amount;
		}
		else {
			$this->amount = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($amount);
		}
		return $this;
	}
	
	
	
}