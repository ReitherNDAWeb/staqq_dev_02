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

require_once 'Customweb/Mpay24/Stubs/AddressType/Country/Code.php';
require_once 'Customweb/Mpay24/Stubs/AddressFieldType.php';
/**
 * @XmlType(name="Country", namespace="")
 */ 
class Customweb_Mpay24_Stubs_AddressType_Country extends Customweb_Mpay24_Stubs_AddressFieldType {
	/**
	 * @XmlAttribute(name="Code", simpleType=@XmlSimpleTypeDefinition(typeName='Code', typeNamespace='', type='Customweb_Mpay24_Stubs_AddressType_Country_Code')) 
	 * @var Customweb_Mpay24_Stubs_AddressType_Country_Code
	 */
	private $code;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_AddressType_Country
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_AddressType_Country();
		return $i;
	}
	/**
	 * Returns the value for the property code.
	 * 
	 * @return Customweb_Mpay24_Stubs_AddressType_Country_Code
	 */
	public function getCode(){
		return $this->code;
	}
	
	/**
	 * Sets the value for the property code.
	 * 
	 * @param Customweb_Mpay24_Stubs_AddressType_Country_Code $code
	 * @return Customweb_Mpay24_Stubs_AddressType_Country
	 */
	public function setCode($code){
		if ($code instanceof Customweb_Mpay24_Stubs_AddressType_Country_Code) {
			$this->code = $code;
		}
		else {
			throw new BadMethodCallException("Type of argument code must be Customweb_Mpay24_Stubs_AddressType_Country_Code.");
		}
		return $this;
	}
	
	
	
}