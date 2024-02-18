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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Item.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
/**
 * Shopping cart content
 * 
 * @XmlType(name="ShoppingCart", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart {
	/**
	 * @XmlList(name="item", type='Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item')
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item[]
	 */
	private $item;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="discount", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $discount;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="shippingCosts", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $shippingCosts;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="shippingTax", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $shippingTax;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="tax", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $tax;
	
	public function __construct() {
		$this->item = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart();
		return $i;
	}
	/**
	 * Returns the value for the property item.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item[]
	 */
	public function getItem(){
		return $this->item;
	}
	
	/**
	 * Sets the value for the property item.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item $item
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function setItem($item){
		if (is_array($item)) {
			$item = new ArrayObject($item);
		}
		if ($item instanceof ArrayObject) {
			$this->item = $item;
		}
		else {
			throw new BadMethodCallException("Type of argument item must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of item.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item $item
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function addItem(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item $item) {
		if (!($this->item instanceof ArrayObject)) {
			$this->item = new ArrayObject();
		}
		$this->item[] = $item;
		return $this;
	}
	
	/**
	 * Returns the value for the property discount.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getDiscount(){
		return $this->discount;
	}
	
	/**
	 * Sets the value for the property discount.
	 * 
	 * @param integer $discount
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function setDiscount($discount){
		if ($discount instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->discount = $discount;
		}
		else if (is_object($discount) && get_class($discount) == "Customweb_Xml_Nil") {
			$this->discount = $discount;
		}
		else {
			$this->discount = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($discount);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shippingCosts.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getShippingCosts(){
		return $this->shippingCosts;
	}
	
	/**
	 * Sets the value for the property shippingCosts.
	 * 
	 * @param integer $shippingCosts
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function setShippingCosts($shippingCosts){
		if ($shippingCosts instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->shippingCosts = $shippingCosts;
		}
		else if (is_object($shippingCosts) && get_class($shippingCosts) == "Customweb_Xml_Nil") {
			$this->shippingCosts = $shippingCosts;
		}
		else {
			$this->shippingCosts = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($shippingCosts);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shippingTax.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getShippingTax(){
		return $this->shippingTax;
	}
	
	/**
	 * Sets the value for the property shippingTax.
	 * 
	 * @param integer $shippingTax
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	public function setShippingTax($shippingTax){
		if ($shippingTax instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->shippingTax = $shippingTax;
		}
		else if (is_object($shippingTax) && get_class($shippingTax) == "Customweb_Xml_Nil") {
			$this->shippingTax = $shippingTax;
		}
		else {
			$this->shippingTax = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($shippingTax);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
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
	
	
	
}