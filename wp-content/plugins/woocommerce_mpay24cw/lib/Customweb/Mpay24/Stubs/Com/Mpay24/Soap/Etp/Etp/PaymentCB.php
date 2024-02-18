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
 * Carte Bleue specific payment parameters
 * 
 * @XmlType(name="PaymentCB", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="identifier", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $identifier;
	
	/**
	 * @XmlValue(name="expiry", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $expiry;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="cvc", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $cvc;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB();
		return $i;
	}
	/**
	 * Returns the value for the property identifier.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getIdentifier(){
		return $this->identifier;
	}
	
	/**
	 * Sets the value for the property identifier.
	 * 
	 * @param string $identifier
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB
	 */
	public function setIdentifier($identifier){
		if ($identifier instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->identifier = $identifier;
		}
		else {
			$this->identifier = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($identifier);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expiry.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getExpiry(){
		return $this->expiry;
	}
	
	/**
	 * Sets the value for the property expiry.
	 * 
	 * @param integer $expiry
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB
	 */
	public function setExpiry($expiry){
		if ($expiry instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->expiry = $expiry;
		}
		else {
			$this->expiry = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($expiry);
		}
		return $this;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentCB
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
	
	
	
}