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

require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Number.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/ProductNr.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Description.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Package.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Quantity.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/ItemPrice.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Price.php';
/**
 * @XmlType(name="Item", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShoppingCart_Item {
	/**
	 * @XmlElement(name="Number", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number
	 */
	private $number;
	
	/**
	 * @XmlElement(name="ProductNr", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr
	 */
	private $productNr;
	
	/**
	 * @XmlElement(name="Description", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description
	 */
	private $description;
	
	/**
	 * @XmlElement(name="Package", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package
	 */
	private $package;
	
	/**
	 * @XmlElement(name="Quantity", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity
	 */
	private $quantity;
	
	/**
	 * @XmlElement(name="ItemPrice", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice
	 */
	private $itemPrice;
	
	/**
	 * @XmlElement(name="Price", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price
	 */
	private $price;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Item();
		return $i;
	}
	/**
	 * Returns the value for the property number.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number
	 */
	public function getNumber(){
		return $this->number;
	}
	
	/**
	 * Sets the value for the property number.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number $number
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setNumber($number){
		if ($number instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number) {
			$this->number = $number;
		}
		else {
			throw new BadMethodCallException("Type of argument number must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Number.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property productNr.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr
	 */
	public function getProductNr(){
		return $this->productNr;
	}
	
	/**
	 * Sets the value for the property productNr.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr $productNr
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setProductNr($productNr){
		if ($productNr instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr) {
			$this->productNr = $productNr;
		}
		else {
			throw new BadMethodCallException("Type of argument productNr must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description $description
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description) {
			$this->description = $description;
		}
		else {
			throw new BadMethodCallException("Type of argument description must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property package.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package
	 */
	public function getPackage(){
		return $this->package;
	}
	
	/**
	 * Sets the value for the property package.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package $package
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setPackage($package){
		if ($package instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package) {
			$this->package = $package;
		}
		else {
			throw new BadMethodCallException("Type of argument package must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Package.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property quantity.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity
	 */
	public function getQuantity(){
		return $this->quantity;
	}
	
	/**
	 * Sets the value for the property quantity.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity $quantity
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setQuantity($quantity){
		if ($quantity instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity) {
			$this->quantity = $quantity;
		}
		else {
			throw new BadMethodCallException("Type of argument quantity must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property itemPrice.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice
	 */
	public function getItemPrice(){
		return $this->itemPrice;
	}
	
	/**
	 * Sets the value for the property itemPrice.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice $itemPrice
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setItemPrice($itemPrice){
		if ($itemPrice instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice) {
			$this->itemPrice = $itemPrice;
		}
		else {
			throw new BadMethodCallException("Type of argument itemPrice must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property price.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price
	 */
	public function getPrice(){
		return $this->price;
	}
	
	/**
	 * Sets the value for the property price.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price $price
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item
	 */
	public function setPrice($price){
		if ($price instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price) {
			$this->price = $price;
		}
		else {
			throw new BadMethodCallException("Type of argument price must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price.");
		}
		return $this;
	}
	
	
	
}