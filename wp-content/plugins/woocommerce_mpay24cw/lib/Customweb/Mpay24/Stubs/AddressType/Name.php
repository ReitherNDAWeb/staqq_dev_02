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

require_once 'Customweb/Mpay24/Stubs/AddressType/Name/Gender.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php';
require_once 'Customweb/Mpay24/Stubs/AddressFieldType.php';
/**
 * @XmlType(name="Name", namespace="")
 */ 
class Customweb_Mpay24_Stubs_AddressType_Name extends Customweb_Mpay24_Stubs_AddressFieldType {
	/**
	 * @XmlAttribute(name="Gender", simpleType=@XmlSimpleTypeDefinition(typeName='Gender', typeNamespace='', type='Customweb_Mpay24_Stubs_AddressType_Name_Gender')) 
	 * @var Customweb_Mpay24_Stubs_AddressType_Name_Gender
	 */
	private $gender;
	
	/**
	 * @XmlAttribute(name="Birthday", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date')) 
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $birthday;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_AddressType_Name
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_AddressType_Name();
		return $i;
	}
	/**
	 * Returns the value for the property gender.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Name_Gender
	 */
	public function getGender(){
		return $this->gender;
	}
	
	/**
	 * Sets the value for the property gender.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Name_Gender $gender
	 * @return Customweb_Mpay24_Stubs_AddressType_Name
	 */
	public function setGender($gender){
		if ($gender instanceof Customweb_Mpay24_Stubs_AddressType_Name_Gender) {
			$this->gender = $gender;
		}
		else {
			throw new BadMethodCallException("Type of argument gender must be Customweb_Mpay24_Stubs_AddressType_Name_Gender.");
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
	 * @return Customweb_Mpay24_Stubs_AddressType_Name
	 */
	public function setBirthday($birthday){
		if ($birthday instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date) {
			$this->birthday = $birthday;
		}
		else {
			$this->birthday = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date::_()->set($birthday);
		}
		return $this;
	}
	
	
	
}