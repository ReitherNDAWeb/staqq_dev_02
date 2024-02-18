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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
/**
 * Configured payment method
 * 
 * @XmlType(name="PaymentMethod", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod {
	/**
	 * @XmlElement(name="pType", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	private $pType;
	
	/**
	 * @XmlValue(name="brand", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $brand;
	
	/**
	 * @XmlValue(name="description", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $description;
	
	/**
	 * @XmlAttribute(name="id", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer')) 
	 * @var integer
	 */
	private $id;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod();
		return $i;
	}
	/**
	 * Returns the value for the property pType.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType
	 */
	public function getPType(){
		return $this->pType;
	}
	
	/**
	 * Sets the value for the property pType.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType $pType
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod
	 */
	public function setPType($pType){
		if ($pType instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType) {
			$this->pType = $pType;
		}
		else {
			throw new BadMethodCallException("Type of argument pType must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property brand.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBrand(){
		return $this->brand;
	}
	
	/**
	 * Sets the value for the property brand.
	 * 
	 * @param string $brand
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod
	 */
	public function setBrand($brand){
		if ($brand instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->brand = $brand;
		}
		else {
			$this->brand = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($brand);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param string $description
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->description = $description;
		}
		else {
			$this->description = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($description);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property id.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getId(){
		return $this->id;
	}
	
	/**
	 * Sets the value for the property id.
	 * 
	 * @param integer $id
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentMethod
	 */
	public function setId($id){
		if ($id instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->id = $id;
		}
		else {
			$this->id = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($id);
		}
		return $this;
	}
	
	
	
}