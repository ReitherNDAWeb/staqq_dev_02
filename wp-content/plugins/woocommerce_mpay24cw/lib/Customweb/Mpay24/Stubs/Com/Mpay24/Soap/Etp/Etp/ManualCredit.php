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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Float.php';
/**
 * @XmlType(name="ManualCredit", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
	/**
	 * @XmlValue(name="mpayTID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $mpayTID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="stateID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $stateID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="amount", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $amount;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit
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
	 * Returns the value for the property mpayTID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getMpayTID(){
		return $this->mpayTID;
	}
	
	/**
	 * Sets the value for the property mpayTID.
	 * 
	 * @param float $mpayTID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit
	 */
	public function setMpayTID($mpayTID){
		if ($mpayTID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->mpayTID = $mpayTID;
		}
		else {
			$this->mpayTID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($mpayTID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property stateID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getStateID(){
		return $this->stateID;
	}
	
	/**
	 * Sets the value for the property stateID.
	 * 
	 * @param float $stateID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit
	 */
	public function setStateID($stateID){
		if ($stateID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->stateID = $stateID;
		}
		else if (is_object($stateID) && get_class($stateID) == "Customweb_Xml_Nil") {
			$this->stateID = $stateID;
		}
		else {
			$this->stateID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($stateID);
		}
		return $this;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit
	 */
	public function setAmount($amount){
		if ($amount instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->amount = $amount;
		}
		else if (is_object($amount) && get_class($amount) == "Customweb_Xml_Nil") {
			$this->amount = $amount;
		}
		else {
			$this->amount = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($amount);
		}
		return $this;
	}
	
	
	
}