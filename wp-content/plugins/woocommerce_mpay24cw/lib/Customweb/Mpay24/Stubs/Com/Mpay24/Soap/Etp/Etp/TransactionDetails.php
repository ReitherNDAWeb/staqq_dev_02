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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Transaction.php';
/**
 * Detailed transaction status
 * 
 * @XmlType(name="TransactionDetails", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Transaction {
	/**
	 * @XmlValue(name="orderDescription", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $orderDescription;
	
	/**
	 * @XmlElement(name="pType", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	private $pType;
	
	/**
	 * @XmlValue(name="brand", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $brand;
	
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
	 * @XmlValue(name="bifStatus", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $bifStatus;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails();
		return $i;
	}
	/**
	 * Returns the value for the property orderDescription.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getOrderDescription(){
		return $this->orderDescription;
	}
	
	/**
	 * Sets the value for the property orderDescription.
	 * 
	 * @param string $orderDescription
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
	 */
	public function setOrderDescription($orderDescription){
		if ($orderDescription instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->orderDescription = $orderDescription;
		}
		else {
			$this->orderDescription = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($orderDescription);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pType.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	public function getPType(){
		return $this->pType;
	}
	
	/**
	 * Sets the value for the property pType.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType $pType
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
	 */
	public function setPType($pType){
		if ($pType instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType) {
			$this->pType = $pType;
		}
		else {
			throw new BadMethodCallException("Type of argument pType must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property brand.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBrand(){
		return $this->brand;
	}
	
	/**
	 * Sets the value for the property brand.
	 * 
	 * @param string $brand
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
	 */
	public function setBrand($brand){
		if ($brand instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->brand = $brand;
		}
		else {
			$this->brand = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($brand);
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
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
	 * Returns the value for the property bifStatus.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBifStatus(){
		return $this->bifStatus;
	}
	
	/**
	 * Sets the value for the property bifStatus.
	 * 
	 * @param string $bifStatus
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionDetails
	 */
	public function setBifStatus($bifStatus){
		if ($bifStatus instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->bifStatus = $bifStatus;
		}
		else {
			$this->bifStatus = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($bifStatus);
		}
		return $this;
	}
	
	
	
}