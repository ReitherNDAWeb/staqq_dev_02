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

require_once 'Customweb/Mpay24/Stubs/AddressModeType.php';
require_once 'Customweb/Mpay24/Stubs/AddressType.php';
/**
 * @XmlType(name="ShippingAddr", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShippingAddr extends Customweb_Mpay24_Stubs_AddressType {
	/**
	 * @XmlAttribute(name="Mode", simpleType=@XmlSimpleTypeDefinition(typeName='AddressModeType', typeNamespace='', type='Customweb_Mpay24_Stubs_AddressModeType')) 
	 * @var Customweb_Mpay24_Stubs_AddressModeType
	 */
	private $mode;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShippingAddr
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShippingAddr();
		return $i;
	}
	/**
	 * Returns the value for the property mode.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressModeType
	 */
	public function getMode(){
		return $this->mode;
	}
	
	/**
	 * Sets the value for the property mode.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressModeType $mode
	 * @return Customweb_Mpay24_Stubs_Order_ShippingAddr
	 */
	public function setMode($mode){
		if ($mode instanceof Customweb_Mpay24_Stubs_AddressModeType) {
			$this->mode = $mode;
		}
		else {
			throw new BadMethodCallException("Type of argument mode must be Customweb_Mpay24_Stubs_AddressModeType.");
		}
		return $this;
	}
	
	
	
}