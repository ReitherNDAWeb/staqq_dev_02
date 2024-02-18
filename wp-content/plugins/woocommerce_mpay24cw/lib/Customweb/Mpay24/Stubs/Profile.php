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
require_once 'Customweb/Mpay24/Stubs/Profile/TemplateSet.php';
require_once 'Customweb/Mpay24/Stubs/Profile/PaymentTypes.php';
require_once 'Customweb/Mpay24/Stubs/Profile/CustomerID.php';
require_once 'Customweb/Mpay24/Stubs/AddressType.php';
require_once 'Customweb/Mpay24/Stubs/Profile/URL.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * @XmlType(name="Profile", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Profile {
	/**
	 * @XmlElement(name="ClientIP", type="Customweb_Mpay24_Stubs_ClientIPType")
	 * @var Customweb_Mpay24_Stubs_ClientIPType
	 */
	private $clientIP;
	
	/**
	 * @XmlElement(name="TemplateSet", type="Customweb_Mpay24_Stubs_Profile_TemplateSet")
	 * @var Customweb_Mpay24_Stubs_Profile_TemplateSet
	 */
	private $templateSet;
	
	/**
	 * @XmlElement(name="PaymentTypes", type="Customweb_Mpay24_Stubs_Profile_PaymentTypes")
	 * @var Customweb_Mpay24_Stubs_Profile_PaymentTypes
	 */
	private $paymentTypes;
	
	/**
	 * @XmlElement(name="CustomerID", type="Customweb_Mpay24_Stubs_Profile_CustomerID")
	 * @var Customweb_Mpay24_Stubs_Profile_CustomerID
	 */
	private $customerID;
	
	/**
	 * @XmlElement(name="BillingAddr", type="Customweb_Mpay24_Stubs_AddressType")
	 * @var Customweb_Mpay24_Stubs_AddressType
	 */
	private $billingAddr;
	
	/**
	 * @XmlElement(name="URL", type="Customweb_Mpay24_Stubs_Profile_URL")
	 * @var Customweb_Mpay24_Stubs_Profile_URL
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
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Profile();
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * Returns the value for the property templateSet.
	 * 
	 * @return Customweb_Mpay24_Stubs_Profile_TemplateSet
	 */
	public function getTemplateSet(){
		return $this->templateSet;
	}
	
	/**
	 * Sets the value for the property templateSet.
	 * 
	 * @param Customweb_Mpay24_Stubs_Profile_TemplateSet $templateSet
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public function setTemplateSet($templateSet){
		if ($templateSet instanceof Customweb_Mpay24_Stubs_Profile_TemplateSet) {
			$this->templateSet = $templateSet;
		}
		else {
			throw new BadMethodCallException("Type of argument templateSet must be Customweb_Mpay24_Stubs_Profile_TemplateSet.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property paymentTypes.
	 * 
	 * @return Customweb_Mpay24_Stubs_Profile_PaymentTypes
	 */
	public function getPaymentTypes(){
		return $this->paymentTypes;
	}
	
	/**
	 * Sets the value for the property paymentTypes.
	 * 
	 * @param Customweb_Mpay24_Stubs_Profile_PaymentTypes $paymentTypes
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public function setPaymentTypes($paymentTypes){
		if ($paymentTypes instanceof Customweb_Mpay24_Stubs_Profile_PaymentTypes) {
			$this->paymentTypes = $paymentTypes;
		}
		else {
			throw new BadMethodCallException("Type of argument paymentTypes must be Customweb_Mpay24_Stubs_Profile_PaymentTypes.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property customerID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Profile_CustomerID
	 */
	public function getCustomerID(){
		return $this->customerID;
	}
	
	/**
	 * Sets the value for the property customerID.
	 * 
	 * @param Customweb_Mpay24_Stubs_Profile_CustomerID $customerID
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public function setCustomerID($customerID){
		if ($customerID instanceof Customweb_Mpay24_Stubs_Profile_CustomerID) {
			$this->customerID = $customerID;
		}
		else {
			throw new BadMethodCallException("Type of argument customerID must be Customweb_Mpay24_Stubs_Profile_CustomerID.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property billingAddr.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function getBillingAddr(){
		return $this->billingAddr;
	}
	
	/**
	 * Sets the value for the property billingAddr.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType $billingAddr
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public function setBillingAddr($billingAddr){
		if ($billingAddr instanceof Customweb_Mpay24_Stubs_AddressType) {
			$this->billingAddr = $billingAddr;
		}
		else {
			throw new BadMethodCallException("Type of argument billingAddr must be Customweb_Mpay24_Stubs_AddressType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property uRL.
	 * 
	 * @return Customweb_Mpay24_Stubs_Profile_URL
	 */
	public function getURL(){
		return $this->uRL;
	}
	
	/**
	 * Sets the value for the property uRL.
	 * 
	 * @param Customweb_Mpay24_Stubs_Profile_URL $uRL
	 * @return Customweb_Mpay24_Stubs_Profile
	 */
	public function setURL($uRL){
		if ($uRL instanceof Customweb_Mpay24_Stubs_Profile_URL) {
			$this->uRL = $uRL;
		}
		else {
			throw new BadMethodCallException("Type of argument uRL must be Customweb_Mpay24_Stubs_Profile_URL.");
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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
	 * @return Customweb_Mpay24_Stubs_Profile
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