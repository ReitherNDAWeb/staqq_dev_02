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
 * Basic name/value parameter
 * 
 * @XmlType(name="Parameter", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter {
	/**
	 * @XmlValue(name="name", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $name;
	
	/**
	 * @XmlValue(name="value", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $value;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter();
		return $i;
	}
	/**
	 * Returns the value for the property name.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Sets the value for the property name.
	 * 
	 * @param string $name
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter
	 */
	public function setName($name){
		if ($name instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->name = $name;
		}
		else {
			$this->name = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($name);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property value.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getValue(){
		return $this->value;
	}
	
	/**
	 * Sets the value for the property value.
	 * 
	 * @param string $value
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Parameter
	 */
	public function setValue($value){
		if ($value instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->value = $value;
		}
		else {
			$this->value = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($value);
		}
		return $this;
	}
	
	
	
}