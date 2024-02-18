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
require_once 'Customweb/Mpay24/Stubs/PriceType.php';
/**
 * @XmlType(name="ItemPrice", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice extends Customweb_Mpay24_Stubs_PriceType {
	/**
	 * @XmlAttribute(name="Style", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $style;
	
	/**
	 * @XmlAttribute(name="Tax", simpleType=@XmlSimpleTypeDefinition(typeName='PriceType', typeNamespace='', type='Customweb_Mpay24_Stubs_PriceType')) 
	 * @var Customweb_Mpay24_Stubs_PriceType
	 */
	private $tax;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice();
		return $i;
	}
	/**
	 * Returns the value for the property style.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getStyle(){
		return $this->style;
	}
	
	/**
	 * Sets the value for the property style.
	 * 
	 * @param string $style
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice
	 */
	public function setStyle($style){
		if ($style instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->style = $style;
		}
		else {
			$this->style = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($style);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tax.
	 * 
	 * @return Customweb_Mpay24_Stubs_PriceType
	 */
	public function getTax(){
		return $this->tax;
	}
	
	/**
	 * Sets the value for the property tax.
	 * 
	 * @param Customweb_Mpay24_Stubs_PriceType $tax
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice
	 */
	public function setTax($tax){
		if ($tax instanceof Customweb_Mpay24_Stubs_PriceType) {
			$this->tax = $tax;
		}
		else {
			throw new BadMethodCallException("Type of argument tax must be Customweb_Mpay24_Stubs_PriceType.");
		}
		return $this;
	}
	
	
	
}