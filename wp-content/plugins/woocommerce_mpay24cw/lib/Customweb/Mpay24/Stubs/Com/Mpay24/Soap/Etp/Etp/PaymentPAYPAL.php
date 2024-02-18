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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * PayPal specific payment parameters
 * 
 * @XmlType(name="PaymentPAYPAL", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="commit", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $commit = 'true';
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="custom", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $custom;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL();
		return $i;
	}
	/**
	 * Returns the value for the property commit.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getCommit(){
		return $this->commit;
	}
	
	/**
	 * Sets the value for the property commit.
	 * 
	 * @param boolean $commit
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL
	 */
	public function setCommit($commit){
		if ($commit instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->commit = $commit;
		}
		else {
			$this->commit = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($commit);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property custom.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCustom(){
		return $this->custom;
	}
	
	/**
	 * Sets the value for the property custom.
	 * 
	 * @param string $custom
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentPAYPAL
	 */
	public function setCustom($custom){
		if ($custom instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->custom = $custom;
		}
		else if (is_object($custom) && get_class($custom) == "Customweb_Xml_Nil") {
			$this->custom = $custom;
		}
		else {
			$this->custom = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($custom);
		}
		return $this;
	}
	
	
	
}