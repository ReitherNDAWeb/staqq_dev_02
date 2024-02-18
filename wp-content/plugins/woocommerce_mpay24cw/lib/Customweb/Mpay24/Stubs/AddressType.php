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

require_once 'Customweb/Mpay24/Stubs/AddressType/Name.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/FirstName.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/LastName.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Street.php';
require_once 'Customweb/Mpay24/Stubs/AddressFieldType.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/State.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Country.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Email.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Phone.php';
/**
 * @XmlType(name="AddressType", namespace="")
 */ 
class Customweb_Mpay24_Stubs_AddressType {
	/**
	 * @XmlElement(name="Name", type="Customweb_Mpay24_Stubs_AddressType_Name")
	 * @var Customweb_Mpay24_Stubs_AddressType_Name
	 */
	private $name;
	
	/**
	 * @XmlElement(name="FirstName", type="Customweb_Mpay24_Stubs_AddressType_FirstName")
	 * @var Customweb_Mpay24_Stubs_AddressType_FirstName
	 */
	private $firstName;
	
	/**
	 * @XmlElement(name="LastName", type="Customweb_Mpay24_Stubs_AddressType_LastName")
	 * @var Customweb_Mpay24_Stubs_AddressType_LastName
	 */
	private $lastName;
	
	/**
	 * @XmlElement(name="Street", type="Customweb_Mpay24_Stubs_AddressType_Street")
	 * @var Customweb_Mpay24_Stubs_AddressType_Street
	 */
	private $street;
	
	/**
	 * @XmlElement(name="Street2", type="Customweb_Mpay24_Stubs_AddressFieldType")
	 * @var Customweb_Mpay24_Stubs_AddressFieldType
	 */
	private $street2;
	
	/**
	 * @XmlElement(name="Zip", type="Customweb_Mpay24_Stubs_AddressFieldType")
	 * @var Customweb_Mpay24_Stubs_AddressFieldType
	 */
	private $zip;
	
	/**
	 * @XmlElement(name="City", type="Customweb_Mpay24_Stubs_AddressFieldType")
	 * @var Customweb_Mpay24_Stubs_AddressFieldType
	 */
	private $city;
	
	/**
	 * @XmlElement(name="State", type="Customweb_Mpay24_Stubs_AddressType_State")
	 * @var Customweb_Mpay24_Stubs_AddressType_State
	 */
	private $state;
	
	/**
	 * @XmlElement(name="Country", type="Customweb_Mpay24_Stubs_AddressType_Country")
	 * @var Customweb_Mpay24_Stubs_AddressType_Country
	 */
	private $country;
	
	/**
	 * @XmlElement(name="Email", type="Customweb_Mpay24_Stubs_AddressType_Email")
	 * @var Customweb_Mpay24_Stubs_AddressType_Email
	 */
	private $email;
	
	/**
	 * @XmlElement(name="Phone", type="Customweb_Mpay24_Stubs_AddressType_Phone")
	 * @var Customweb_Mpay24_Stubs_AddressType_Phone
	 */
	private $phone;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_AddressType();
		return $i;
	}
	/**
	 * Returns the value for the property name.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Name
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Sets the value for the property name.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Name $name
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setName($name){
		if ($name instanceof Customweb_Mpay24_Stubs_AddressType_Name) {
			$this->name = $name;
		}
		else {
			throw new BadMethodCallException("Type of argument name must be Customweb_Mpay24_Stubs_AddressType_Name.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property firstName.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_FirstName
	 */
	public function getFirstName(){
		return $this->firstName;
	}
	
	/**
	 * Sets the value for the property firstName.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_FirstName $firstName
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setFirstName($firstName){
		if ($firstName instanceof Customweb_Mpay24_Stubs_AddressType_FirstName) {
			$this->firstName = $firstName;
		}
		else {
			throw new BadMethodCallException("Type of argument firstName must be Customweb_Mpay24_Stubs_AddressType_FirstName.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property lastName.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_LastName
	 */
	public function getLastName(){
		return $this->lastName;
	}
	
	/**
	 * Sets the value for the property lastName.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_LastName $lastName
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setLastName($lastName){
		if ($lastName instanceof Customweb_Mpay24_Stubs_AddressType_LastName) {
			$this->lastName = $lastName;
		}
		else {
			throw new BadMethodCallException("Type of argument lastName must be Customweb_Mpay24_Stubs_AddressType_LastName.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property street.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Street
	 */
	public function getStreet(){
		return $this->street;
	}
	
	/**
	 * Sets the value for the property street.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Street $street
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setStreet($street){
		if ($street instanceof Customweb_Mpay24_Stubs_AddressType_Street) {
			$this->street = $street;
		}
		else {
			throw new BadMethodCallException("Type of argument street must be Customweb_Mpay24_Stubs_AddressType_Street.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property street2.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressFieldType
	 */
	public function getStreet2(){
		return $this->street2;
	}
	
	/**
	 * Sets the value for the property street2.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressFieldType $street2
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setStreet2($street2){
		if ($street2 instanceof Customweb_Mpay24_Stubs_AddressFieldType) {
			$this->street2 = $street2;
		}
		else {
			throw new BadMethodCallException("Type of argument street2 must be Customweb_Mpay24_Stubs_AddressFieldType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property zip.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressFieldType
	 */
	public function getZip(){
		return $this->zip;
	}
	
	/**
	 * Sets the value for the property zip.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressFieldType $zip
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setZip($zip){
		if ($zip instanceof Customweb_Mpay24_Stubs_AddressFieldType) {
			$this->zip = $zip;
		}
		else {
			throw new BadMethodCallException("Type of argument zip must be Customweb_Mpay24_Stubs_AddressFieldType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property city.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressFieldType
	 */
	public function getCity(){
		return $this->city;
	}
	
	/**
	 * Sets the value for the property city.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressFieldType $city
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setCity($city){
		if ($city instanceof Customweb_Mpay24_Stubs_AddressFieldType) {
			$this->city = $city;
		}
		else {
			throw new BadMethodCallException("Type of argument city must be Customweb_Mpay24_Stubs_AddressFieldType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property state.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_State
	 */
	public function getState(){
		return $this->state;
	}
	
	/**
	 * Sets the value for the property state.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_State $state
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setState($state){
		if ($state instanceof Customweb_Mpay24_Stubs_AddressType_State) {
			$this->state = $state;
		}
		else {
			throw new BadMethodCallException("Type of argument state must be Customweb_Mpay24_Stubs_AddressType_State.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property country.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Country
	 */
	public function getCountry(){
		return $this->country;
	}
	
	/**
	 * Sets the value for the property country.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Country $country
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setCountry($country){
		if ($country instanceof Customweb_Mpay24_Stubs_AddressType_Country) {
			$this->country = $country;
		}
		else {
			throw new BadMethodCallException("Type of argument country must be Customweb_Mpay24_Stubs_AddressType_Country.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property email.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Email
	 */
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 * Sets the value for the property email.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Email $email
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setEmail($email){
		if ($email instanceof Customweb_Mpay24_Stubs_AddressType_Email) {
			$this->email = $email;
		}
		else {
			throw new BadMethodCallException("Type of argument email must be Customweb_Mpay24_Stubs_AddressType_Email.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property phone.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Phone
	 */
	public function getPhone(){
		return $this->phone;
	}
	
	/**
	 * Sets the value for the property phone.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Phone $phone
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	public function setPhone($phone){
		if ($phone instanceof Customweb_Mpay24_Stubs_AddressType_Phone) {
			$this->phone = $phone;
		}
		else {
			throw new BadMethodCallException("Type of argument phone must be Customweb_Mpay24_Stubs_AddressType_Phone.");
		}
		return $this;
	}
	
	
	
}