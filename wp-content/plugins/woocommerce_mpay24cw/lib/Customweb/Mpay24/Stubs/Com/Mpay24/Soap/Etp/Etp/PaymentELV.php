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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * Direct debit specific payment parameters
 * 
 * @XmlType(name="PaymentELV", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="brand", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $brand;
	
	/**
	 * @XmlValue(name="iban", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $iban;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="bic", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $bic;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="mandateID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $mandateID;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="dateOfSignature", simpleType=@XmlSimpleTypeDefinition(typeName='date', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date'))
	 * @var Customweb_Xml_Binding_DateHandler_Date
	 */
	private $dateOfSignature;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV();
		return $i;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
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
	 * Returns the value for the property iban.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getIban(){
		return $this->iban;
	}
	
	/**
	 * Sets the value for the property iban.
	 * 
	 * @param string $iban
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
	 */
	public function setIban($iban){
		if ($iban instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->iban = $iban;
		}
		else {
			$this->iban = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($iban);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property bic.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBic(){
		return $this->bic;
	}
	
	/**
	 * Sets the value for the property bic.
	 * 
	 * @param string $bic
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
	 */
	public function setBic($bic){
		if ($bic instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->bic = $bic;
		}
		else if (is_object($bic) && get_class($bic) == "Customweb_Xml_Nil") {
			$this->bic = $bic;
		}
		else {
			$this->bic = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($bic);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property mandateID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getMandateID(){
		return $this->mandateID;
	}
	
	/**
	 * Sets the value for the property mandateID.
	 * 
	 * @param string $mandateID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
	 */
	public function setMandateID($mandateID){
		if ($mandateID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->mandateID = $mandateID;
		}
		else if (is_object($mandateID) && get_class($mandateID) == "Customweb_Xml_Nil") {
			$this->mandateID = $mandateID;
		}
		else {
			$this->mandateID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($mandateID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dateOfSignature.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date
	 */
	public function getDateOfSignature(){
		return $this->dateOfSignature;
	}
	
	/**
	 * Sets the value for the property dateOfSignature.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_Date $dateOfSignature
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentELV
	 */
	public function setDateOfSignature($dateOfSignature){
		if ($dateOfSignature instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date) {
			$this->dateOfSignature = $dateOfSignature;
		}
		else if (is_object($dateOfSignature) && get_class($dateOfSignature) == "Customweb_Xml_Nil") {
			$this->dateOfSignature = $dateOfSignature;
		}
		else {
			$this->dateOfSignature = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Date::_()->set($dateOfSignature);
		}
		return $this;
	}
	
	
	
}