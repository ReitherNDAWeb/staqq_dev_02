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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TxState.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/DateTime.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
/**
 * Entries in the transaction history
 * 
 * @XmlType(name="HistoryEntry", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry {
	/**
	 * @XmlValue(name="stateID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $stateID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="parentStateID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $parentStateID;
	
	/**
	 * @XmlElement(name="txState", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState
	 */
	private $txState;
	
	/**
	 * @XmlValue(name="amount", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $amount;
	
	/**
	 * @XmlValue(name="timeStamp", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_DateTime'))
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $timeStamp;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="approvalCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $approvalCode;
	
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
	 * @XmlValue(name="profileStatus", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $profileStatus;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry();
		return $i;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public function setStateID($stateID){
		if ($stateID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->stateID = $stateID;
		}
		else {
			$this->stateID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($stateID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property parentStateID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getParentStateID(){
		return $this->parentStateID;
	}
	
	/**
	 * Sets the value for the property parentStateID.
	 * 
	 * @param float $parentStateID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public function setParentStateID($parentStateID){
		if ($parentStateID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->parentStateID = $parentStateID;
		}
		else if (is_object($parentStateID) && get_class($parentStateID) == "Customweb_Xml_Nil") {
			$this->parentStateID = $parentStateID;
		}
		else {
			$this->parentStateID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($parentStateID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property txState.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState
	 */
	public function getTxState(){
		return $this->txState;
	}
	
	/**
	 * Sets the value for the property txState.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState $txState
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public function setTxState($txState){
		if ($txState instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState) {
			$this->txState = $txState;
		}
		else {
			throw new BadMethodCallException("Type of argument txState must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TxState.");
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
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
	 * Returns the value for the property approvalCode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getApprovalCode(){
		return $this->approvalCode;
	}
	
	/**
	 * Sets the value for the property approvalCode.
	 * 
	 * @param string $approvalCode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public function setApprovalCode($approvalCode){
		if ($approvalCode instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->approvalCode = $approvalCode;
		}
		else if (is_object($approvalCode) && get_class($approvalCode) == "Customweb_Xml_Nil") {
			$this->approvalCode = $approvalCode;
		}
		else {
			$this->approvalCode = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($approvalCode);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
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
	 * Returns the value for the property profileStatus.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProfileStatus(){
		return $this->profileStatus;
	}
	
	/**
	 * Sets the value for the property profileStatus.
	 * 
	 * @param string $profileStatus
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_HistoryEntry
	 */
	public function setProfileStatus($profileStatus){
		if ($profileStatus instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->profileStatus = $profileStatus;
		}
		else {
			$this->profileStatus = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($profileStatus);
		}
		return $this;
	}
	
	
	
}