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
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * CreditCard specific profile payment parameters
 * 
 * @XmlType(name="ProfilePaymentCC", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentCC extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlNillable
	 * @XmlValue(name="cvc", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $cvc;
	
	/**
	 * @XmlValue(name="auth3DS", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $auth3DS = 'false';
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentCC
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentCC();
		return $i;
	}
	/**
	 * Returns the value for the property cvc.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCvc(){
		return $this->cvc;
	}
	
	/**
	 * Sets the value for the property cvc.
	 * 
	 * @param string $cvc
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentCC
	 */
	public function setCvc($cvc){
		if ($cvc instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->cvc = $cvc;
		}
		else if (is_object($cvc) && get_class($cvc) == "Customweb_Xml_Nil") {
			$this->cvc = $cvc;
		}
		else {
			$this->cvc = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($cvc);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property auth3DS.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getAuth3DS(){
		return $this->auth3DS;
	}
	
	/**
	 * Sets the value for the property auth3DS.
	 * 
	 * @param boolean $auth3DS
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentCC
	 */
	public function setAuth3DS($auth3DS){
		if ($auth3DS instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->auth3DS = $auth3DS;
		}
		else {
			$this->auth3DS = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($auth3DS);
		}
		return $this;
	}
	
	
	
}