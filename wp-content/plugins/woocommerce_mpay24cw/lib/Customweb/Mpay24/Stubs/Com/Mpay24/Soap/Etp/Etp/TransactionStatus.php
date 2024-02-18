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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * @XmlType(name="TransactionStatus", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus {
	/**
	 * @XmlValue(name="merchantID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $merchantID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="mpayTID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $mpayTID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="tid", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $tid;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus
	 */
	public function setMpayTID($mpayTID){
		if ($mpayTID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->mpayTID = $mpayTID;
		}
		else if (is_object($mpayTID) && get_class($mpayTID) == "Customweb_Xml_Nil") {
			$this->mpayTID = $mpayTID;
		}
		else {
			$this->mpayTID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($mpayTID);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus
	 */
	public function setTid($tid){
		if ($tid instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->tid = $tid;
		}
		else if (is_object($tid) && get_class($tid) == "Customweb_Xml_Nil") {
			$this->tid = $tid;
		}
		else {
			$this->tid = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($tid);
		}
		return $this;
	}
	
	
	
}