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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * Klarna specific payment parameters
 * 
 * @XmlType(name="PaymentKLARNA", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="brand", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $brand;
	
	/**
	 * @XmlValue(name="personalNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $personalNumber;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="pClass", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $pClass;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA();
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA
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
	 * Returns the value for the property personalNumber.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPersonalNumber(){
		return $this->personalNumber;
	}
	
	/**
	 * Sets the value for the property personalNumber.
	 * 
	 * @param string $personalNumber
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA
	 */
	public function setPersonalNumber($personalNumber){
		if ($personalNumber instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->personalNumber = $personalNumber;
		}
		else {
			$this->personalNumber = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($personalNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pClass.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getPClass(){
		return $this->pClass;
	}
	
	/**
	 * Sets the value for the property pClass.
	 * 
	 * @param integer $pClass
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentKLARNA
	 */
	public function setPClass($pClass){
		if ($pClass instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->pClass = $pClass;
		}
		else if (is_object($pClass) && get_class($pClass) == "Customweb_Xml_Nil") {
			$this->pClass = $pClass;
		}
		else {
			$this->pClass = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($pClass);
		}
		return $this;
	}
	
	
	
}