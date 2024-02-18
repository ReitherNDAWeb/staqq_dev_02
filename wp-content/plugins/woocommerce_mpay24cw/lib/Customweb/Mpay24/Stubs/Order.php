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

require_once 'Customweb/Mpay24/Stubs/ClientIPType.php';
require_once 'Customweb/Mpay24/Stubs/Order/UserField.php';
require_once 'Customweb/Mpay24/Stubs/Order/Tid.php';
require_once 'Customweb/Mpay24/Stubs/Order/TemplateSet.php';
require_once 'Customweb/Mpay24/Stubs/Order/PaymentTypes.php';
require_once 'Customweb/Mpay24/Stubs/Order/PaymentProfiles.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart.php';
require_once 'Customweb/Mpay24/Stubs/Order/Price.php';
require_once 'Customweb/Mpay24/Stubs/Order/Currency.php';
require_once 'Customweb/Mpay24/Stubs/Order/Customer.php';
require_once 'Customweb/Mpay24/Stubs/Order/BillingAddr.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShippingAddr.php';
require_once 'Customweb/Mpay24/Stubs/Order/URL.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * @XmlType(name="Order", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order {
	/**
	 * @XmlElement(name="ClientIP", type="Customweb_Mpay24_Stubs_ClientIPType")
	 * @var Customweb_Mpay24_Stubs_ClientIPType
	 */
	private $clientIP;
	
	/**
	 * @XmlElement(name="UserField", type="Customweb_Mpay24_Stubs_Order_UserField")
	 * @var Customweb_Mpay24_Stubs_Order_UserField
	 */
	private $userField;
	
	/**
	 * @XmlElement(name="Tid", type="Customweb_Mpay24_Stubs_Order_Tid")
	 * @var Customweb_Mpay24_Stubs_Order_Tid
	 */
	private $tid;
	
	/**
	 * @XmlElement(name="TemplateSet", type="Customweb_Mpay24_Stubs_Order_TemplateSet")
	 * @var Customweb_Mpay24_Stubs_Order_TemplateSet
	 */
	private $templateSet;
	
	/**
	 * @XmlElement(name="PaymentTypes", type="Customweb_Mpay24_Stubs_Order_PaymentTypes")
	 * @var Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	private $paymentTypes;
	
	/**
	 * @XmlElement(name="PaymentProfiles", type="Customweb_Mpay24_Stubs_Order_PaymentProfiles")
	 * @var Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	private $paymentProfiles;
	
	/**
	 * @XmlElement(name="ShoppingCart", type="Customweb_Mpay24_Stubs_Order_ShoppingCart")
	 * @var Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	private $shoppingCart;
	
	/**
	 * @XmlElement(name="Price", type="Customweb_Mpay24_Stubs_Order_Price")
	 * @var Customweb_Mpay24_Stubs_Order_Price
	 */
	private $price;
	
	/**
	 * @XmlElement(name="Currency", type="Customweb_Mpay24_Stubs_Order_Currency")
	 * @var Customweb_Mpay24_Stubs_Order_Currency
	 */
	private $currency;
	
	/**
	 * @XmlElement(name="Customer", type="Customweb_Mpay24_Stubs_Order_Customer")
	 * @var Customweb_Mpay24_Stubs_Order_Customer
	 */
	private $customer;
	
	/**
	 * @XmlElement(name="BillingAddr", type="Customweb_Mpay24_Stubs_Order_BillingAddr")
	 * @var Customweb_Mpay24_Stubs_Order_BillingAddr
	 */
	private $billingAddr;
	
	/**
	 * @XmlElement(name="ShippingAddr", type="Customweb_Mpay24_Stubs_Order_ShippingAddr")
	 * @var Customweb_Mpay24_Stubs_Order_ShippingAddr
	 */
	private $shippingAddr;
	
	/**
	 * @XmlElement(name="URL", type="Customweb_Mpay24_Stubs_Order_URL")
	 * @var Customweb_Mpay24_Stubs_Order_URL
	 */
	private $uRL;
	
	/**
	 * @XmlAttribute(name="Style", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $style;
	
	/**
	 * @XmlAttribute(name="LogoStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $logoStyle;
	
	/**
	 * @XmlAttribute(name="PageHeaderStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $pageHeaderStyle;
	
	/**
	 * @XmlAttribute(name="PageCaptionStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $pageCaptionStyle;
	
	/**
	 * @XmlAttribute(name="PageStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $pageStyle;
	
	/**
	 * @XmlAttribute(name="InputFieldsStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $inputFieldsStyle;
	
	/**
	 * @XmlAttribute(name="DropDownListsStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $dropDownListsStyle;
	
	/**
	 * @XmlAttribute(name="ButtonsStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $buttonsStyle;
	
	/**
	 * @XmlAttribute(name="ErrorsStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $errorsStyle;
	
	/**
	 * @XmlAttribute(name="ErrorsHeaderStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $errorsHeaderStyle;
	
	/**
	 * @XmlAttribute(name="SuccessTitleStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $successTitleStyle;
	
	/**
	 * @XmlAttribute(name="ErrorTitleStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $errorTitleStyle;
	
	/**
	 * @XmlAttribute(name="FooterStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $footerStyle;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order();
		return $i;
	}
	/**
	 * Returns the value for the property clientIP.
	 * 
	 * @return Customweb_Mpay24_Stubs_ClientIPType
	 */
	public function getClientIP(){
		return $this->clientIP;
	}
	
	/**
	 * Sets the value for the property clientIP.
	 * 
	 * @param Customweb_Mpay24_Stubs_ClientIPType $clientIP
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setClientIP($clientIP){
		if ($clientIP instanceof Customweb_Mpay24_Stubs_ClientIPType) {
			$this->clientIP = $clientIP;
		}
		else {
			throw new BadMethodCallException("Type of argument clientIP must be Customweb_Mpay24_Stubs_ClientIPType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property userField.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_UserField
	 */
	public function getUserField(){
		return $this->userField;
	}
	
	/**
	 * Sets the value for the property userField.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_UserField $userField
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setUserField($userField){
		if ($userField instanceof Customweb_Mpay24_Stubs_Order_UserField) {
			$this->userField = $userField;
		}
		else {
			throw new BadMethodCallException("Type of argument userField must be Customweb_Mpay24_Stubs_Order_UserField.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tid.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_Tid
	 */
	public function getTid(){
		return $this->tid;
	}
	
	/**
	 * Sets the value for the property tid.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_Tid $tid
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setTid($tid){
		if ($tid instanceof Customweb_Mpay24_Stubs_Order_Tid) {
			$this->tid = $tid;
		}
		else {
			throw new BadMethodCallException("Type of argument tid must be Customweb_Mpay24_Stubs_Order_Tid.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property templateSet.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_TemplateSet
	 */
	public function getTemplateSet(){
		return $this->templateSet;
	}
	
	/**
	 * Sets the value for the property templateSet.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_TemplateSet $templateSet
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setTemplateSet($templateSet){
		if ($templateSet instanceof Customweb_Mpay24_Stubs_Order_TemplateSet) {
			$this->templateSet = $templateSet;
		}
		else {
			throw new BadMethodCallException("Type of argument templateSet must be Customweb_Mpay24_Stubs_Order_TemplateSet.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property paymentTypes.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes
	 */
	public function getPaymentTypes(){
		return $this->paymentTypes;
	}
	
	/**
	 * Sets the value for the property paymentTypes.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_PaymentTypes $paymentTypes
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPaymentTypes($paymentTypes){
		if ($paymentTypes instanceof Customweb_Mpay24_Stubs_Order_PaymentTypes) {
			$this->paymentTypes = $paymentTypes;
		}
		else {
			throw new BadMethodCallException("Type of argument paymentTypes must be Customweb_Mpay24_Stubs_Order_PaymentTypes.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property paymentProfiles.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	public function getPaymentProfiles(){
		return $this->paymentProfiles;
	}
	
	/**
	 * Sets the value for the property paymentProfiles.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_PaymentProfiles $paymentProfiles
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPaymentProfiles($paymentProfiles){
		if ($paymentProfiles instanceof Customweb_Mpay24_Stubs_Order_PaymentProfiles) {
			$this->paymentProfiles = $paymentProfiles;
		}
		else {
			throw new BadMethodCallException("Type of argument paymentProfiles must be Customweb_Mpay24_Stubs_Order_PaymentProfiles.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shoppingCart.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	public function getShoppingCart(){
		return $this->shoppingCart;
	}
	
	/**
	 * Sets the value for the property shoppingCart.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShoppingCart $shoppingCart
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setShoppingCart($shoppingCart){
		if ($shoppingCart instanceof Customweb_Mpay24_Stubs_Order_ShoppingCart) {
			$this->shoppingCart = $shoppingCart;
		}
		else {
			throw new BadMethodCallException("Type of argument shoppingCart must be Customweb_Mpay24_Stubs_Order_ShoppingCart.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property price.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_Price
	 */
	public function getPrice(){
		return $this->price;
	}
	
	/**
	 * Sets the value for the property price.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_Price $price
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPrice($price){
		if ($price instanceof Customweb_Mpay24_Stubs_Order_Price) {
			$this->price = $price;
		}
		else {
			throw new BadMethodCallException("Type of argument price must be Customweb_Mpay24_Stubs_Order_Price.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property currency.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_Currency
	 */
	public function getCurrency(){
		return $this->currency;
	}
	
	/**
	 * Sets the value for the property currency.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_Currency $currency
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setCurrency($currency){
		if ($currency instanceof Customweb_Mpay24_Stubs_Order_Currency) {
			$this->currency = $currency;
		}
		else {
			throw new BadMethodCallException("Type of argument currency must be Customweb_Mpay24_Stubs_Order_Currency.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property customer.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_Customer
	 */
	public function getCustomer(){
		return $this->customer;
	}
	
	/**
	 * Sets the value for the property customer.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_Customer $customer
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setCustomer($customer){
		if ($customer instanceof Customweb_Mpay24_Stubs_Order_Customer) {
			$this->customer = $customer;
		}
		else {
			throw new BadMethodCallException("Type of argument customer must be Customweb_Mpay24_Stubs_Order_Customer.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property billingAddr.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_BillingAddr
	 */
	public function getBillingAddr(){
		return $this->billingAddr;
	}
	
	/**
	 * Sets the value for the property billingAddr.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_BillingAddr $billingAddr
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setBillingAddr($billingAddr){
		if ($billingAddr instanceof Customweb_Mpay24_Stubs_Order_BillingAddr) {
			$this->billingAddr = $billingAddr;
		}
		else {
			throw new BadMethodCallException("Type of argument billingAddr must be Customweb_Mpay24_Stubs_Order_BillingAddr.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shippingAddr.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShippingAddr
	 */
	public function getShippingAddr(){
		return $this->shippingAddr;
	}
	
	/**
	 * Sets the value for the property shippingAddr.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_ShippingAddr $shippingAddr
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setShippingAddr($shippingAddr){
		if ($shippingAddr instanceof Customweb_Mpay24_Stubs_Order_ShippingAddr) {
			$this->shippingAddr = $shippingAddr;
		}
		else {
			throw new BadMethodCallException("Type of argument shippingAddr must be Customweb_Mpay24_Stubs_Order_ShippingAddr.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property uRL.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_URL
	 */
	public function getURL(){
		return $this->uRL;
	}
	
	/**
	 * Sets the value for the property uRL.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_URL $uRL
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setURL($uRL){
		if ($uRL instanceof Customweb_Mpay24_Stubs_Order_URL) {
			$this->uRL = $uRL;
		}
		else {
			throw new BadMethodCallException("Type of argument uRL must be Customweb_Mpay24_Stubs_Order_URL.");
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
	 * @return Customweb_Mpay24_Stubs_Order
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
	 * Returns the value for the property logoStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getLogoStyle(){
		return $this->logoStyle;
	}
	
	/**
	 * Sets the value for the property logoStyle.
	 * 
	 * @param string $logoStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setLogoStyle($logoStyle){
		if ($logoStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->logoStyle = $logoStyle;
		}
		else {
			$this->logoStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($logoStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pageHeaderStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPageHeaderStyle(){
		return $this->pageHeaderStyle;
	}
	
	/**
	 * Sets the value for the property pageHeaderStyle.
	 * 
	 * @param string $pageHeaderStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPageHeaderStyle($pageHeaderStyle){
		if ($pageHeaderStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->pageHeaderStyle = $pageHeaderStyle;
		}
		else {
			$this->pageHeaderStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($pageHeaderStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pageCaptionStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPageCaptionStyle(){
		return $this->pageCaptionStyle;
	}
	
	/**
	 * Sets the value for the property pageCaptionStyle.
	 * 
	 * @param string $pageCaptionStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPageCaptionStyle($pageCaptionStyle){
		if ($pageCaptionStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->pageCaptionStyle = $pageCaptionStyle;
		}
		else {
			$this->pageCaptionStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($pageCaptionStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pageStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPageStyle(){
		return $this->pageStyle;
	}
	
	/**
	 * Sets the value for the property pageStyle.
	 * 
	 * @param string $pageStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setPageStyle($pageStyle){
		if ($pageStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->pageStyle = $pageStyle;
		}
		else {
			$this->pageStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($pageStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property inputFieldsStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getInputFieldsStyle(){
		return $this->inputFieldsStyle;
	}
	
	/**
	 * Sets the value for the property inputFieldsStyle.
	 * 
	 * @param string $inputFieldsStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setInputFieldsStyle($inputFieldsStyle){
		if ($inputFieldsStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->inputFieldsStyle = $inputFieldsStyle;
		}
		else {
			$this->inputFieldsStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($inputFieldsStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dropDownListsStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDropDownListsStyle(){
		return $this->dropDownListsStyle;
	}
	
	/**
	 * Sets the value for the property dropDownListsStyle.
	 * 
	 * @param string $dropDownListsStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setDropDownListsStyle($dropDownListsStyle){
		if ($dropDownListsStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->dropDownListsStyle = $dropDownListsStyle;
		}
		else {
			$this->dropDownListsStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($dropDownListsStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property buttonsStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getButtonsStyle(){
		return $this->buttonsStyle;
	}
	
	/**
	 * Sets the value for the property buttonsStyle.
	 * 
	 * @param string $buttonsStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setButtonsStyle($buttonsStyle){
		if ($buttonsStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->buttonsStyle = $buttonsStyle;
		}
		else {
			$this->buttonsStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($buttonsStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errorsStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorsStyle(){
		return $this->errorsStyle;
	}
	
	/**
	 * Sets the value for the property errorsStyle.
	 * 
	 * @param string $errorsStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setErrorsStyle($errorsStyle){
		if ($errorsStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->errorsStyle = $errorsStyle;
		}
		else {
			$this->errorsStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($errorsStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errorsHeaderStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorsHeaderStyle(){
		return $this->errorsHeaderStyle;
	}
	
	/**
	 * Sets the value for the property errorsHeaderStyle.
	 * 
	 * @param string $errorsHeaderStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setErrorsHeaderStyle($errorsHeaderStyle){
		if ($errorsHeaderStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->errorsHeaderStyle = $errorsHeaderStyle;
		}
		else {
			$this->errorsHeaderStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($errorsHeaderStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property successTitleStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getSuccessTitleStyle(){
		return $this->successTitleStyle;
	}
	
	/**
	 * Sets the value for the property successTitleStyle.
	 * 
	 * @param string $successTitleStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setSuccessTitleStyle($successTitleStyle){
		if ($successTitleStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->successTitleStyle = $successTitleStyle;
		}
		else {
			$this->successTitleStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($successTitleStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errorTitleStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorTitleStyle(){
		return $this->errorTitleStyle;
	}
	
	/**
	 * Sets the value for the property errorTitleStyle.
	 * 
	 * @param string $errorTitleStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setErrorTitleStyle($errorTitleStyle){
		if ($errorTitleStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->errorTitleStyle = $errorTitleStyle;
		}
		else {
			$this->errorTitleStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($errorTitleStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property footerStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getFooterStyle(){
		return $this->footerStyle;
	}
	
	/**
	 * Sets the value for the property footerStyle.
	 * 
	 * @param string $footerStyle
	 * @return Customweb_Mpay24_Stubs_Order
	 */
	public function setFooterStyle($footerStyle){
		if ($footerStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->footerStyle = $footerStyle;
		}
		else {
			$this->footerStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($footerStyle);
		}
		return $this;
	}
	
	
	
}