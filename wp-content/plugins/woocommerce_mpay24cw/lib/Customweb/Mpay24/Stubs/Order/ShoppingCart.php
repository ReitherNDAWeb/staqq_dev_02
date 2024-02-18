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

require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Description.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/SubTotal.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Discount.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/ShippingCosts.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Tax.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * @XmlType(name="ShoppingCart", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShoppingCart {
	/**
	 * @XmlElement(name="Description", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Description")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Description
	 */
	private $description;
	
	/**
	 * @XmlList(name="Item", type='Customweb_Mpay24_Stubs_Order_ShoppingCart_Item')
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Item[]
	 */
	private $item;
	
	/**
	 * @XmlElement(name="SubTotal", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal
	 */
	private $subTotal;
	
	/**
	 * @XmlElement(name="Discount", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount
	 */
	private $discount;
	
	/**
	 * @XmlElement(name="ShippingCosts", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts
	 */
	private $shippingCosts;
	
	/**
	 * @XmlElement(name="Tax", type="Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	private $tax;
	
	/**
	 * @XmlAttribute(name="Header", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $header;
	
	/**
	 * @XmlAttribute(name="HeaderStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $headerStyle;
	
	/**
	 * @XmlAttribute(name="Style", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $style;
	
	/**
	 * @XmlAttribute(name="CaptionStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $captionStyle;
	
	/**
	 * @XmlAttribute(name="NumberHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $numberHeader;
	
	/**
	 * @XmlAttribute(name="NumberStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $numberStyle;
	
	/**
	 * @XmlAttribute(name="ProductNrHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $productNrHeader;
	
	/**
	 * @XmlAttribute(name="ProductNrStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $productNrStyle;
	
	/**
	 * @XmlAttribute(name="DescriptionHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $descriptionHeader;
	
	/**
	 * @XmlAttribute(name="DescriptionStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $descriptionStyle;
	
	/**
	 * @XmlAttribute(name="PackageHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $packageHeader;
	
	/**
	 * @XmlAttribute(name="PackageStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $packageStyle;
	
	/**
	 * @XmlAttribute(name="QuantityHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $quantityHeader;
	
	/**
	 * @XmlAttribute(name="QuantityStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $quantityStyle;
	
	/**
	 * @XmlAttribute(name="ItemPriceHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $itemPriceHeader;
	
	/**
	 * @XmlAttribute(name="ItemPriceStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $itemPriceStyle;
	
	/**
	 * @XmlAttribute(name="PriceHeader", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $priceHeader;
	
	/**
	 * @XmlAttribute(name="PriceStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $priceStyle;
	
	public function __construct() {
		$this->item = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShoppingCart();
		return $i;
	}
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Description
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Description $description
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Description) {
			$this->description = $description;
		}
		else {
			throw new BadMethodCallException("Type of argument description must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Description.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property item.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Item[]
	 */
	public function getItem(){
		return $this->item;
	}
	
	/**
	 * Sets the value for the property item.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item $item
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
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
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Item $item
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function addItem(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item $item) {
		if (!($this->item instanceof ArrayObject)) {
			$this->item = new ArrayObject();
		}
		$this->item[] = $item;
		return $this;
	}
	
	/**
	 * Returns the value for the property subTotal.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal
	 */
	public function getSubTotal(){
		return $this->subTotal;
	}
	
	/**
	 * Sets the value for the property subTotal.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal $subTotal
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setSubTotal($subTotal){
		if ($subTotal instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal) {
			$this->subTotal = $subTotal;
		}
		else {
			throw new BadMethodCallException("Type of argument subTotal must be Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property discount.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount
	 */
	public function getDiscount(){
		return $this->discount;
	}
	
	/**
	 * Sets the value for the property discount.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount $discount
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setDiscount($discount){
		if ($discount instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount) {
			$this->discount = $discount;
		}
		else {
			throw new BadMethodCallException("Type of argument discount must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shippingCosts.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts
	 */
	public function getShippingCosts(){
		return $this->shippingCosts;
	}
	
	/**
	 * Sets the value for the property shippingCosts.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts $shippingCosts
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setShippingCosts($shippingCosts){
		if ($shippingCosts instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts) {
			$this->shippingCosts = $shippingCosts;
		}
		else {
			throw new BadMethodCallException("Type of argument shippingCosts must be Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tax.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public function getTax(){
		return $this->tax;
	}
	
	/**
	 * Sets the value for the property tax.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax $tax
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setTax($tax){
		if ($tax instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax) {
			$this->tax = $tax;
		}
		else {
			throw new BadMethodCallException("Type of argument tax must be Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property header.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getHeader(){
		return $this->header;
	}
	
	/**
	 * Sets the value for the property header.
	 * 
	 * @param string $header
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setHeader($header){
		if ($header instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->header = $header;
		}
		else {
			$this->header = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($header);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property headerStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getHeaderStyle(){
		return $this->headerStyle;
	}
	
	/**
	 * Sets the value for the property headerStyle.
	 * 
	 * @param string $headerStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setHeaderStyle($headerStyle){
		if ($headerStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->headerStyle = $headerStyle;
		}
		else {
			$this->headerStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($headerStyle);
		}
		return $this;
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
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
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
	 * Returns the value for the property captionStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCaptionStyle(){
		return $this->captionStyle;
	}
	
	/**
	 * Sets the value for the property captionStyle.
	 * 
	 * @param string $captionStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setCaptionStyle($captionStyle){
		if ($captionStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->captionStyle = $captionStyle;
		}
		else {
			$this->captionStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($captionStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property numberHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getNumberHeader(){
		return $this->numberHeader;
	}
	
	/**
	 * Sets the value for the property numberHeader.
	 * 
	 * @param string $numberHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setNumberHeader($numberHeader){
		if ($numberHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->numberHeader = $numberHeader;
		}
		else {
			$this->numberHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($numberHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property numberStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getNumberStyle(){
		return $this->numberStyle;
	}
	
	/**
	 * Sets the value for the property numberStyle.
	 * 
	 * @param string $numberStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setNumberStyle($numberStyle){
		if ($numberStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->numberStyle = $numberStyle;
		}
		else {
			$this->numberStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($numberStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property productNrHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProductNrHeader(){
		return $this->productNrHeader;
	}
	
	/**
	 * Sets the value for the property productNrHeader.
	 * 
	 * @param string $productNrHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setProductNrHeader($productNrHeader){
		if ($productNrHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->productNrHeader = $productNrHeader;
		}
		else {
			$this->productNrHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($productNrHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property productNrStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProductNrStyle(){
		return $this->productNrStyle;
	}
	
	/**
	 * Sets the value for the property productNrStyle.
	 * 
	 * @param string $productNrStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setProductNrStyle($productNrStyle){
		if ($productNrStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->productNrStyle = $productNrStyle;
		}
		else {
			$this->productNrStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($productNrStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property descriptionHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDescriptionHeader(){
		return $this->descriptionHeader;
	}
	
	/**
	 * Sets the value for the property descriptionHeader.
	 * 
	 * @param string $descriptionHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setDescriptionHeader($descriptionHeader){
		if ($descriptionHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->descriptionHeader = $descriptionHeader;
		}
		else {
			$this->descriptionHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($descriptionHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property descriptionStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDescriptionStyle(){
		return $this->descriptionStyle;
	}
	
	/**
	 * Sets the value for the property descriptionStyle.
	 * 
	 * @param string $descriptionStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setDescriptionStyle($descriptionStyle){
		if ($descriptionStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->descriptionStyle = $descriptionStyle;
		}
		else {
			$this->descriptionStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($descriptionStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property packageHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPackageHeader(){
		return $this->packageHeader;
	}
	
	/**
	 * Sets the value for the property packageHeader.
	 * 
	 * @param string $packageHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setPackageHeader($packageHeader){
		if ($packageHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->packageHeader = $packageHeader;
		}
		else {
			$this->packageHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($packageHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property packageStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPackageStyle(){
		return $this->packageStyle;
	}
	
	/**
	 * Sets the value for the property packageStyle.
	 * 
	 * @param string $packageStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setPackageStyle($packageStyle){
		if ($packageStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->packageStyle = $packageStyle;
		}
		else {
			$this->packageStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($packageStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property quantityHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getQuantityHeader(){
		return $this->quantityHeader;
	}
	
	/**
	 * Sets the value for the property quantityHeader.
	 * 
	 * @param string $quantityHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setQuantityHeader($quantityHeader){
		if ($quantityHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->quantityHeader = $quantityHeader;
		}
		else {
			$this->quantityHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($quantityHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property quantityStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getQuantityStyle(){
		return $this->quantityStyle;
	}
	
	/**
	 * Sets the value for the property quantityStyle.
	 * 
	 * @param string $quantityStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setQuantityStyle($quantityStyle){
		if ($quantityStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->quantityStyle = $quantityStyle;
		}
		else {
			$this->quantityStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($quantityStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property itemPriceHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getItemPriceHeader(){
		return $this->itemPriceHeader;
	}
	
	/**
	 * Sets the value for the property itemPriceHeader.
	 * 
	 * @param string $itemPriceHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setItemPriceHeader($itemPriceHeader){
		if ($itemPriceHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->itemPriceHeader = $itemPriceHeader;
		}
		else {
			$this->itemPriceHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($itemPriceHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property itemPriceStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getItemPriceStyle(){
		return $this->itemPriceStyle;
	}
	
	/**
	 * Sets the value for the property itemPriceStyle.
	 * 
	 * @param string $itemPriceStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setItemPriceStyle($itemPriceStyle){
		if ($itemPriceStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->itemPriceStyle = $itemPriceStyle;
		}
		else {
			$this->itemPriceStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($itemPriceStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property priceHeader.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPriceHeader(){
		return $this->priceHeader;
	}
	
	/**
	 * Sets the value for the property priceHeader.
	 * 
	 * @param string $priceHeader
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setPriceHeader($priceHeader){
		if ($priceHeader instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->priceHeader = $priceHeader;
		}
		else {
			$this->priceHeader = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($priceHeader);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property priceStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPriceStyle(){
		return $this->priceStyle;
	}
	
	/**
	 * Sets the value for the property priceStyle.
	 * 
	 * @param string $priceStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function setPriceStyle($priceStyle){
		if ($priceStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->priceStyle = $priceStyle;
		}
		else {
			$this->priceStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($priceStyle);
		}
		return $this;
	}
	
	
	
}