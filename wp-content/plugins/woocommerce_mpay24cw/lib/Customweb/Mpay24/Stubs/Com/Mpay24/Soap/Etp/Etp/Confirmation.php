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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ConfirmationStatus.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Confirmed.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/DateTime.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * Results of a confirmation-url call
 * 
 * @XmlType(name="Confirmation", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation {
	/**
	 * @XmlElement(name="status", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus
	 */
	private $status;
	
	/**
	 * @XmlElement(name="confirmed", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed
	 */
	private $confirmed;
	
	/**
	 * @XmlValue(name="timeStamp", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime'))
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $timeStamp;
	
	/**
	 * @XmlValue(name="url", simpleType=@XmlSimpleTypeDefinition(typeName='anyURI', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $url;
	
	/**
	 * @XmlValue(name="result", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $result;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation();
		return $i;
	}
	/**
	 * Returns the value for the property status.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus
	 */
	public function getStatus(){
		return $this->status;
	}
	
	/**
	 * Sets the value for the property status.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus $status
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public function setStatus($status){
		if ($status instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus) {
			$this->status = $status;
		}
		else {
			throw new BadMethodCallException("Type of argument status must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ConfirmationStatus.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property confirmed.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed
	 */
	public function getConfirmed(){
		return $this->confirmed;
	}
	
	/**
	 * Sets the value for the property confirmed.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed $confirmed
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public function setConfirmed($confirmed){
		if ($confirmed instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed) {
			$this->confirmed = $confirmed;
		}
		else {
			throw new BadMethodCallException("Type of argument confirmed must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmed.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property timeStamp.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getTimeStamp(){
		return $this->timeStamp;
	}
	
	/**
	 * Sets the value for the property timeStamp.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $timeStamp
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public function setTimeStamp($timeStamp){
		if ($timeStamp instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->timeStamp = $timeStamp;
		}
		else {
			$this->timeStamp = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime::_()->set($timeStamp);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property url.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getUrl(){
		return $this->url;
	}
	
	/**
	 * Sets the value for the property url.
	 * 
	 * @param string $url
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public function setUrl($url){
		if ($url instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->url = $url;
		}
		else {
			$this->url = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($url);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property result.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getResult(){
		return $this->result;
	}
	
	/**
	 * Sets the value for the property result.
	 * 
	 * @param string $result
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Confirmation
	 */
	public function setResult($result){
		if ($result instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->result = $result;
		}
		else {
			$this->result = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($result);
		}
		return $this;
	}
	
	
	
}