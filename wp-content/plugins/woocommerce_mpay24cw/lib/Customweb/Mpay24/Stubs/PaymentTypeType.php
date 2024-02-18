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
 * @XmlType(name="PaymentTypeType", namespace="")
 */ 
class Customweb_Mpay24_Stubs_PaymentTypeType extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function CC() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('CC');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function CB() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('CB');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function MAESTRO() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('MAESTRO');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function EPS() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('EPS');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function MIA() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('MIA');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function PB() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('PB');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function PSC() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('PSC');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function CASHTICKET() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('CASH-TICKET');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function ELV() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('ELV');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function QUICK() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('QUICK');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function GIROPAY() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('GIROPAY');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function PAYPAL() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('PAYPAL');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function MPASS() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('MPASS');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function BILLPAY() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('BILLPAY');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function INVOICE() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('INVOICE');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function HP() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('HP');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function SAFETYPAY() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('SAFETYPAY');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function KLARNA() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('KLARNA');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function SOFORT() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('SOFORT');
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function MASTERPASS() {
		return Customweb_Mpay24_Stubs_PaymentTypeType::_()->set('MASTERPASS');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_PaymentTypeType();
		return $i;
	}
	
}