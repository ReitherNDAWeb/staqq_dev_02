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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
/**
 * Common payment parameters
 * 
 * @XmlType(name="Payment", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="amount", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $amount;
	
	/**
	 * @XmlValue(name="currency", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $currency;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="manualClearing", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $manualClearing;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="useProfile", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $useProfile;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="profileID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $profileID;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment();
		return $i;
	}
	/**
	 * Returns the value for the property amount.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getAmount(){
		return $this->amount;
	}
	
	/**
	 * Sets the value for the property amount.
	 * 
	 * @param integer $amount
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function setAmount($amount){
		if ($amount instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->amount = $amount;
		}
		else {
			$this->amount = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($amount);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property currency.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCurrency(){
		return $this->currency;
	}
	
	/**
	 * Sets the value for the property currency.
	 * 
	 * @param string $currency
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function setCurrency($currency){
		if ($currency instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->currency = $currency;
		}
		else {
			$this->currency = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($currency);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property manualClearing.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getManualClearing(){
		return $this->manualClearing;
	}
	
	/**
	 * Sets the value for the property manualClearing.
	 * 
	 * @param boolean $manualClearing
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function setManualClearing($manualClearing){
		if ($manualClearing instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->manualClearing = $manualClearing;
		}
		else if (is_object($manualClearing) && get_class($manualClearing) == "Customweb_Xml_Nil") {
			$this->manualClearing = $manualClearing;
		}
		else {
			$this->manualClearing = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($manualClearing);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property useProfile.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getUseProfile(){
		return $this->useProfile;
	}
	
	/**
	 * Sets the value for the property useProfile.
	 * 
	 * @param boolean $useProfile
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
	 */
	public function setUseProfile($useProfile){
		if ($useProfile instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->useProfile = $useProfile;
		}
		else if (is_object($useProfile) && get_class($useProfile) == "Customweb_Xml_Nil") {
			$this->useProfile = $useProfile;
		}
		else {
			$this->useProfile = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($useProfile);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment
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
	
	
	
}