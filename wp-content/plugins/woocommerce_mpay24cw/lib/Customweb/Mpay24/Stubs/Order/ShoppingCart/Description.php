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
 * @XmlType(name="Description", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShoppingCart_Description extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Description
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Description();
		return $i;
	}
	
}