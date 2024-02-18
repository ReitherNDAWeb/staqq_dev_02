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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SortField.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SortType.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
/**
 * @XmlType(name="ListNotCleared", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
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
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="sortField", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	private $sortField;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="sortType", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType
	 */
	private $sortType;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="listInProgress", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $listInProgress;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
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
	
	
	/**
	 * Returns the value for the property sortField.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public function getSortField(){
		return $this->sortField;
	}
	
	/**
	 * Sets the value for the property sortField.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField $sortField
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
	 */
	public function setSortField($sortField){
		if ($sortField instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField) {
			$this->sortField = $sortField;
		}
		else if (is_object($sortField) && get_class($sortField) == "Customweb_Xml_Nil") {
			$this->sortField = $sortField;
		}
		else {
			throw new BadMethodCallException("Type of argument sortField must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property sortType.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType
	 */
	public function getSortType(){
		return $this->sortType;
	}
	
	/**
	 * Sets the value for the property sortType.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType $sortType
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
	 */
	public function setSortType($sortType){
		if ($sortType instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType) {
			$this->sortType = $sortType;
		}
		else if (is_object($sortType) && get_class($sortType) == "Customweb_Xml_Nil") {
			$this->sortType = $sortType;
		}
		else {
			throw new BadMethodCallException("Type of argument sortType must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property listInProgress.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getListInProgress(){
		return $this->listInProgress;
	}
	
	/**
	 * Sets the value for the property listInProgress.
	 * 
	 * @param boolean $listInProgress
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared
	 */
	public function setListInProgress($listInProgress){
		if ($listInProgress instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->listInProgress = $listInProgress;
		}
		else if (is_object($listInProgress) && get_class($listInProgress) == "Customweb_Xml_Nil") {
			$this->listInProgress = $listInProgress;
		}
		else {
			$this->listInProgress = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($listInProgress);
		}
		return $this;
	}
	
	
	
}