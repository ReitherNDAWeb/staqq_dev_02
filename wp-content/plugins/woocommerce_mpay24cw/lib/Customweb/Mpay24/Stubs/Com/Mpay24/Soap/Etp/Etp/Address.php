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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AddressMode.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Gender.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php';
/**
 * Customer address definition
 * 
 * @XmlType(name="Address", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address {
	/**
	 * @XmlElement(name="mode", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode
	 */
	private $mode = 'READWRITE';
	
	/**
	 * @XmlValue(name="name", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $name;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="gender", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender
	 */
	private $gender;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="birthday", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date'))
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $birthday;
	
	/**
	 * @XmlValue(name="street", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $street;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="street2", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $street2;
	
	/**
	 * @XmlValue(name="zip", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $zip;
	
	/**
	 * @XmlValue(name="city", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $city;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="state", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $state;
	
	/**
	 * @XmlValue(name="countryCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $countryCode;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="email", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $email;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="phone", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $phone;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address();
		return $i;
	}
	/**
	 * Returns the value for the property mode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode
	 */
	public function getMode(){
		return $this->mode;
	}
	
	/**
	 * Sets the value for the property mode.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode $mode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setMode($mode){
		if ($mode instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode) {
			$this->mode = $mode;
		}
		else {
			throw new BadMethodCallException("Type of argument mode must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property name.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Sets the value for the property name.
	 * 
	 * @param string $name
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setName($name){
		if ($name instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->name = $name;
		}
		else {
			$this->name = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($name);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property gender.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender
	 */
	public function getGender(){
		return $this->gender;
	}
	
	/**
	 * Sets the value for the property gender.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender $gender
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setGender($gender){
		if ($gender instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender) {
			$this->gender = $gender;
		}
		else if (is_object($gender) && get_class($gender) == "Customweb_Xml_Nil") {
			$this->gender = $gender;
		}
		else {
			throw new BadMethodCallException("Type of argument gender must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property birthday.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date
	 */
	public function getBirthday(){
		return $this->birthday;
	}
	
	/**
	 * Sets the value for the property birthday.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_Date $birthday
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setBirthday($birthday){
		if ($birthday instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date) {
			$this->birthday = $birthday;
		}
		else if (is_object($birthday) && get_class($birthday) == "Customweb_Xml_Nil") {
			$this->birthday = $birthday;
		}
		else {
			$this->birthday = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date::_()->set($birthday);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property street.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getStreet(){
		return $this->street;
	}
	
	/**
	 * Sets the value for the property street.
	 * 
	 * @param string $street
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setStreet($street){
		if ($street instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->street = $street;
		}
		else {
			$this->street = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($street);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property street2.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getStreet2(){
		return $this->street2;
	}
	
	/**
	 * Sets the value for the property street2.
	 * 
	 * @param string $street2
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setStreet2($street2){
		if ($street2 instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->street2 = $street2;
		}
		else if (is_object($street2) && get_class($street2) == "Customweb_Xml_Nil") {
			$this->street2 = $street2;
		}
		else {
			$this->street2 = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($street2);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property zip.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getZip(){
		return $this->zip;
	}
	
	/**
	 * Sets the value for the property zip.
	 * 
	 * @param string $zip
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setZip($zip){
		if ($zip instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->zip = $zip;
		}
		else {
			$this->zip = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($zip);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property city.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCity(){
		return $this->city;
	}
	
	/**
	 * Sets the value for the property city.
	 * 
	 * @param string $city
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setCity($city){
		if ($city instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->city = $city;
		}
		else {
			$this->city = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($city);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property state.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getState(){
		return $this->state;
	}
	
	/**
	 * Sets the value for the property state.
	 * 
	 * @param string $state
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setState($state){
		if ($state instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->state = $state;
		}
		else if (is_object($state) && get_class($state) == "Customweb_Xml_Nil") {
			$this->state = $state;
		}
		else {
			$this->state = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($state);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property countryCode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCountryCode(){
		return $this->countryCode;
	}
	
	/**
	 * Sets the value for the property countryCode.
	 * 
	 * @param string $countryCode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setCountryCode($countryCode){
		if ($countryCode instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->countryCode = $countryCode;
		}
		else {
			$this->countryCode = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($countryCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property email.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 * Sets the value for the property email.
	 * 
	 * @param string $email
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setEmail($email){
		if ($email instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->email = $email;
		}
		else if (is_object($email) && get_class($email) == "Customweb_Xml_Nil") {
			$this->email = $email;
		}
		else {
			$this->email = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($email);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property phone.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPhone(){
		return $this->phone;
	}
	
	/**
	 * Sets the value for the property phone.
	 * 
	 * @param string $phone
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function setPhone($phone){
		if ($phone instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->phone = $phone;
		}
		else if (is_object($phone) && get_class($phone) == "Customweb_Xml_Nil") {
			$this->phone = $phone;
		}
		else {
			$this->phone = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($phone);
		}
		return $this;
	}
	
	
	
}