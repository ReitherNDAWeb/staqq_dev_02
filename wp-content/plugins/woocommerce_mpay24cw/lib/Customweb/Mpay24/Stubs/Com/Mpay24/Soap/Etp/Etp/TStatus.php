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
 * Transaction status
 * 
 * @XmlType(name="TStatus", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function NOTFOUND() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('NOTFOUND');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function FAILED() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('FAILED');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function RESERVED() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('RESERVED');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function BILLED() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('BILLED');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function REVERSED() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('REVERSED');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function CREDITED() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus::_()->set('CREDITED');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TStatus();
		return $i;
	}
	
}