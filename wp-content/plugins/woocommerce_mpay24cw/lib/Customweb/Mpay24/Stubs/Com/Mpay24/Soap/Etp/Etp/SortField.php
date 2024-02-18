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
 * Transaction field to be used for sorting
 * 
 * @XmlType(name="SortField", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function MPAYTID() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('MPAYTID');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function PTYPE() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('PTYPE');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function BRAND() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('BRAND');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function CURRENCY() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('CURRENCY');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function TID() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('TID');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function ORDERDESC() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('ORDERDESC');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function ORDERNUMBER() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('ORDERNUMBER');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function CURRDATE() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('CURRDATE');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function CURRTIME() {
		return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField::_()->set('CURRTIME');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SortField();
		return $i;
	}
	
}