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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
/**
 * @XmlType(name="SelectPaymentResponse", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse {
	/**
	 * @XmlElement(name="status", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status
	 */
	private $status;
	
	/**
	 * @XmlValue(name="returnCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $returnCode;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="errNo", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $errNo;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="errText", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $errText;
	
	/**
	 * @XmlValue(name="location", simpleType=@XmlSimpleTypeDefinition(typeName='anyURI', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $location;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse();
		return $i;
	}
	/**
	 * Returns the value for the property status.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status
	 */
	public function getStatus(){
		return $this->status;
	}
	
	/**
	 * Sets the value for the property status.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status $status
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public function setStatus($status){
		if ($status instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status) {
			$this->status = $status;
		}
		else {
			throw new BadMethodCallException("Type of argument status must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property returnCode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getReturnCode(){
		return $this->returnCode;
	}
	
	/**
	 * Sets the value for the property returnCode.
	 * 
	 * @param string $returnCode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public function setReturnCode($returnCode){
		if ($returnCode instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->returnCode = $returnCode;
		}
		else {
			$this->returnCode = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($returnCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errNo.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getErrNo(){
		return $this->errNo;
	}
	
	/**
	 * Sets the value for the property errNo.
	 * 
	 * @param integer $errNo
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public function setErrNo($errNo){
		if ($errNo instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->errNo = $errNo;
		}
		else if (is_object($errNo) && get_class($errNo) == "Customweb_Xml_Nil") {
			$this->errNo = $errNo;
		}
		else {
			$this->errNo = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($errNo);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errText.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrText(){
		return $this->errText;
	}
	
	/**
	 * Sets the value for the property errText.
	 * 
	 * @param string $errText
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public function setErrText($errText){
		if ($errText instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->errText = $errText;
		}
		else if (is_object($errText) && get_class($errText) == "Customweb_Xml_Nil") {
			$this->errText = $errText;
		}
		else {
			$this->errText = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($errText);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property location.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getLocation(){
		return $this->location;
	}
	
	/**
	 * Sets the value for the property location.
	 * 
	 * @param string $location
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */
	public function setLocation($location){
		if ($location instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->location = $location;
		}
		else {
			$this->location = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($location);
		}
		return $this;
	}
	
	
	
}