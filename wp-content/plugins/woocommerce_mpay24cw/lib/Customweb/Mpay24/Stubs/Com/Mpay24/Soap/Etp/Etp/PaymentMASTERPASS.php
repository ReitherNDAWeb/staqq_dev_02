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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * MasterPass specific payment parameters
 * 
 * @XmlType(name="PaymentMASTERPASS", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMASTERPASS extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlValue(name="auth3DS", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $auth3DS = 'false';
	
	/**
	 * @XmlValue(name="commit", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $commit = 'true';
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMASTERPASS
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMASTERPASS();
		return $i;
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMASTERPASS
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
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMASTERPASS
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
	
	
	
}