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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Callback.php';
/**
 * MasterPass specific payment callback parameters
 * 
 * @XmlType(name="CallbackMASTERPASS", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CallbackMASTERPASS extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Callback {
	/**
	 * @XmlValue(name="cancel", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean'))
	 * @var boolean
	 */
	private $cancel = 'false';
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CallbackMASTERPASS
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CallbackMASTERPASS();
		return $i;
	}
	/**
	 * Returns the value for the property cancel.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getCancel(){
		return $this->cancel;
	}
	
	/**
	 * Sets the value for the property cancel.
	 * 
	 * @param boolean $cancel
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CallbackMASTERPASS
	 */
	public function setCancel($cancel){
		if ($cancel instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->cancel = $cancel;
		}
		else {
			$this->cancel = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($cancel);
		}
		return $this;
	}
	
	
	
}