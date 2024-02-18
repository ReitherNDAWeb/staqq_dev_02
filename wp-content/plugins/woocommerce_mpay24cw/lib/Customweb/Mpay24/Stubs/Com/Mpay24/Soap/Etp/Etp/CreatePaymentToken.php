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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * @XmlType(name="CreatePaymentToken", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
	/**
	 * @XmlElement(name="pType", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	private $pType;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="templateSet", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $templateSet;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="style", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $style;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="customerID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $customerID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="profileID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $profileID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="domain", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $domain;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="language", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $language;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
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
	 * Returns the value for the property templateSet.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTemplateSet(){
		return $this->templateSet;
	}
	
	/**
	 * Sets the value for the property templateSet.
	 * 
	 * @param string $templateSet
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
	 */
	public function setTemplateSet($templateSet){
		if ($templateSet instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->templateSet = $templateSet;
		}
		else if (is_object($templateSet) && get_class($templateSet) == "Customweb_Xml_Nil") {
			$this->templateSet = $templateSet;
		}
		else {
			$this->templateSet = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($templateSet);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
	 */
	public function setStyle($style){
		if ($style instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->style = $style;
		}
		else if (is_object($style) && get_class($style) == "Customweb_Xml_Nil") {
			$this->style = $style;
		}
		else {
			$this->style = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($style);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
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
	 * Returns the value for the property profileID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProfileID(){
		return $this->profileID;
	}
	
	/**
	 * Sets the value for the property profileID.
	 * 
	 * @param string $profileID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
	 */
	public function setProfileID($profileID){
		if ($profileID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->profileID = $profileID;
		}
		else if (is_object($profileID) && get_class($profileID) == "Customweb_Xml_Nil") {
			$this->profileID = $profileID;
		}
		else {
			$this->profileID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($profileID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property domain.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDomain(){
		return $this->domain;
	}
	
	/**
	 * Sets the value for the property domain.
	 * 
	 * @param string $domain
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
	 */
	public function setDomain($domain){
		if ($domain instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->domain = $domain;
		}
		else if (is_object($domain) && get_class($domain) == "Customweb_Xml_Nil") {
			$this->domain = $domain;
		}
		else {
			$this->domain = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($domain);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken
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