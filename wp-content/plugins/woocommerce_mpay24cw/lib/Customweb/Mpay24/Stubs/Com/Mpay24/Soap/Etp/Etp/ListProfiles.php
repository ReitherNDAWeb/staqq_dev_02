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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php';
/**
 * @XmlType(name="ListProfiles", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="customerID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $customerID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="expiredBy", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date'))
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $expiredBy;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="begin", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $begin;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="size", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $size;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
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
	 * Returns the value for the property expiredBy.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date
	 */
	public function getExpiredBy(){
		return $this->expiredBy;
	}
	
	/**
	 * Sets the value for the property expiredBy.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_Date $expiredBy
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
	 */
	public function setExpiredBy($expiredBy){
		if ($expiredBy instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date) {
			$this->expiredBy = $expiredBy;
		}
		else if (is_object($expiredBy) && get_class($expiredBy) == "Customweb_Xml_Nil") {
			$this->expiredBy = $expiredBy;
		}
		else {
			$this->expiredBy = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date::_()->set($expiredBy);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property begin.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getBegin(){
		return $this->begin;
	}
	
	/**
	 * Sets the value for the property begin.
	 * 
	 * @param integer $begin
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
	 */
	public function setBegin($begin){
		if ($begin instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->begin = $begin;
		}
		else if (is_object($begin) && get_class($begin) == "Customweb_Xml_Nil") {
			$this->begin = $begin;
		}
		else {
			$this->begin = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($begin);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property size.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getSize(){
		return $this->size;
	}
	
	/**
	 * Sets the value for the property size.
	 * 
	 * @param integer $size
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles
	 */
	public function setSize($size){
		if ($size instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->size = $size;
		}
		else if (is_object($size) && get_class($size) == "Customweb_Xml_Nil") {
			$this->size = $size;
		}
		else {
			$this->size = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($size);
		}
		return $this;
	}
	
	
	
}