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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Order.php';
/**
 * Clearing transaction details
 * 
 * @XmlType(name="ClearingDetails", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails {
	/**
	 * @XmlValue(name="mpayTID", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedLong', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float'))
	 * @var float
	 */
	private $mpayTID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="amount", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $amount;
	
	/**
	 * @XmlNillable
	 * @XmlElement(name="order", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	private $order;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails
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
	
	
	/**
	 * Returns the value for the property order.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function getOrder(){
		return $this->order;
	}
	
	/**
	 * Sets the value for the property order.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order $order
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ClearingDetails
	 */
	public function setOrder($order){
		if ($order instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order) {
			$this->order = $order;
		}
		else if (is_object($order) && get_class($order) == "Customweb_Xml_Nil") {
			$this->order = $order;
		}
		else {
			throw new BadMethodCallException("Type of argument order must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order.");
		}
		return $this;
	}
	
	
	
}