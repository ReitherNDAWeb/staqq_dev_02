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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Float.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TStatus.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * Transaction status
 * 
 * @XmlType(name="Transaction", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction {
	/**
	 * @XmlValue(name="mpayTID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $mpayTID;
	
	/**
	 * @XmlElement(name="tStatus", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	private $tStatus;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="stateID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $stateID;
	
	/**
	 * @XmlValue(name="tid", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $tid;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction();
		return $i;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction
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
	 * Returns the value for the property tStatus.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public function getTStatus(){
		return $this->tStatus;
	}
	
	/**
	 * Sets the value for the property tStatus.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus $tStatus
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction
	 */
	public function setTStatus($tStatus){
		if ($tStatus instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus) {
			$this->tStatus = $tStatus;
		}
		else {
			throw new BadMethodCallException("Type of argument tStatus must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus.");
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction
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
	 * Returns the value for the property tid.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTid(){
		return $this->tid;
	}
	
	/**
	 * Sets the value for the property tid.
	 * 
	 * @param string $tid
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction
	 */
	public function setTid($tid){
		if ($tid instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->tid = $tid;
		}
		else {
			$this->tid = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($tid);
		}
		return $this;
	}
	
	
	
}