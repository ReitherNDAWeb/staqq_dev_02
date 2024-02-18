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
/**
 * Address fields modification mode
 * 
 * @XmlType(name="AddressMode", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode
	 */
	public static function READONLY() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode::_()->set('READONLY');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode
	 */
	public static function READWRITE() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode::_()->set('READWRITE');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode();
		return $i;
	}
	
}