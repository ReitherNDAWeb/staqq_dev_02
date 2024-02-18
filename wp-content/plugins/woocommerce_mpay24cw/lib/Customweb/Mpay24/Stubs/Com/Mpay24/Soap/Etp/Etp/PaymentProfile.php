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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/DateTime.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Address.php';
/**
 * Payment profile details
 * 
 * @XmlType(name="PaymentProfile", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile {
	/**
	 * @XmlNillable
	 * @XmlValue(name="pMethodID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $pMethodID;
	
	/**
	 * @XmlValue(name="profileID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $profileID;
	
	/**
	 * @XmlValue(name="updated", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime'))
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $updated;
	
	/**
	 * @XmlValue(name="identifier", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $identifier;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="expires", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date'))
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $expires;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="adress", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	private $adress;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile();
		return $i;
	}
	/**
	 * Returns the value for the property pMethodID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getPMethodID(){
		return $this->pMethodID;
	}
	
	/**
	 * Sets the value for the property pMethodID.
	 * 
	 * @param integer $pMethodID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setPMethodID($pMethodID){
		if ($pMethodID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->pMethodID = $pMethodID;
		}
		else if (is_object($pMethodID) && get_class($pMethodID) == "Customweb_Xml_Nil") {
			$this->pMethodID = $pMethodID;
		}
		else {
			$this->pMethodID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($pMethodID);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setProfileID($profileID){
		if ($profileID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->profileID = $profileID;
		}
		else {
			$this->profileID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($profileID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property updated.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getUpdated(){
		return $this->updated;
	}
	
	/**
	 * Sets the value for the property updated.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $updated
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setUpdated($updated){
		if ($updated instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->updated = $updated;
		}
		else {
			$this->updated = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime::_()->set($updated);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property identifier.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getIdentifier(){
		return $this->identifier;
	}
	
	/**
	 * Sets the value for the property identifier.
	 * 
	 * @param string $identifier
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setIdentifier($identifier){
		if ($identifier instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->identifier = $identifier;
		}
		else {
			$this->identifier = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($identifier);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expires.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date
	 */
	public function getExpires(){
		return $this->expires;
	}
	
	/**
	 * Sets the value for the property expires.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_Date $expires
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setExpires($expires){
		if ($expires instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date) {
			$this->expires = $expires;
		}
		else if (is_object($expires) && get_class($expires) == "Customweb_Xml_Nil") {
			$this->expires = $expires;
		}
		else {
			$this->expires = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date::_()->set($expires);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property adress.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	public function getAdress(){
		return $this->adress;
	}
	
	/**
	 * Sets the value for the property adress.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address $adress
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentProfile
	 */
	public function setAdress($adress){
		if ($adress instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address) {
			$this->adress = $adress;
		}
		else if (is_object($adress) && get_class($adress) == "Customweb_Xml_Nil") {
			$this->adress = $adress;
		}
		else {
			throw new BadMethodCallException("Type of argument adress must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address.");
		}
		return $this;
	}
	
	
	
}