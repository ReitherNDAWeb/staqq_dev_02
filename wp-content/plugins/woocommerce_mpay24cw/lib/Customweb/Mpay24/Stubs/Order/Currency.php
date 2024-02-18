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
require_once 'Customweb/Mpay24/Stubs/CurrencyType.php';
/**
 * @XmlType(name="Currency", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_Currency extends Customweb_Mpay24_Stubs_CurrencyType {
	/**
	 * @XmlAttribute(name="Display", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $display;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_Currency
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_Currency();
		return $i;
	}
	/**
	 * Returns the value for the property display.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDisplay(){
		return $this->display;
	}
	
	/**
	 * Sets the value for the property display.
	 * 
	 * @param string $display
	 * @return Customweb_Mpay24_Stubs_Order_Currency
	 */
	public function setDisplay($display){
		if ($display instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->display = $display;
		}
		else {
			$this->display = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($display);
		}
		return $this;
	}
	
	
	
}