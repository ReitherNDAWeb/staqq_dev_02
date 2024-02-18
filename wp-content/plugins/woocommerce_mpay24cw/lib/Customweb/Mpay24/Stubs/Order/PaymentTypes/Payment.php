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

require_once 'Customweb/Mpay24/Stubs/PaymentTypeType.php';
require_once 'Customweb/Mpay24/Stubs/PaymentBrandType.php';
require_once 'Customweb/Mpay24/Stubs/PaymentSubBrandType.php';
/**
 * @XmlType(name="Payment", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment {
	/**
	 * @XmlAttribute(name="Type", simpleType=@XmlSimpleTypeDefinition(typeName='PaymentTypeType', typeNamespace='', type='Customweb_Mpay24_Stubs_PaymentTypeType')) 
	 * @var Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	private $type;
	
	/**
	 * @XmlAttribute(name="Brand", simpleType=@XmlSimpleTypeDefinition(typeName='PaymentBrandType', typeNamespace='', type='Customweb_Mpay24_Stubs_PaymentBrandType')) 
	 * @var Customweb_Mpay24_Stubs_PaymentBrandType
	 */
	private $brand;
	
	/**
	 * @XmlAttribute(name="SubBrand", simpleType=@XmlSimpleTypeDefinition(typeName='PaymentSubBrandType', typeNamespace='', type='Customweb_Mpay24_Stubs_PaymentSubBrandType')) 
	 * @var Customweb_Mpay24_Stubs_PaymentSubBrandType
	 */
	private $subBrand;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment();
		return $i;
	}
	/**
	 * Returns the value for the property type.
	 * 
	 * @return Customweb_Mpay24_Stubs_PaymentTypeType
	 */
	public function getType(){
		return $this->type;
	}
	
	/**
	 * Sets the value for the property type.
	 * 
	 * @param Customweb_Mpay24_Stubs_PaymentTypeType $type
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment
	 */
	public function setType($type){
		if ($type instanceof Customweb_Mpay24_Stubs_PaymentTypeType) {
			$this->type = $type;
		}
		else {
			throw new BadMethodCallException("Type of argument type must be Customweb_Mpay24_Stubs_PaymentTypeType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property brand.
	 * 
	 * @return Customweb_Mpay24_Stubs_PaymentBrandType
	 */
	public function getBrand(){
		return $this->brand;
	}
	
	/**
	 * Sets the value for the property brand.
	 * 
	 * @param Customweb_Mpay24_Stubs_PaymentBrandType $brand
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment
	 */
	public function setBrand($brand){
		if ($brand instanceof Customweb_Mpay24_Stubs_PaymentBrandType) {
			$this->brand = $brand;
		}
		else {
			throw new BadMethodCallException("Type of argument brand must be Customweb_Mpay24_Stubs_PaymentBrandType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property subBrand.
	 * 
	 * @return Customweb_Mpay24_Stubs_PaymentSubBrandType
	 */
	public function getSubBrand(){
		return $this->subBrand;
	}
	
	/**
	 * Sets the value for the property subBrand.
	 * 
	 * @param Customweb_Mpay24_Stubs_PaymentSubBrandType $subBrand
	 * @return Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment
	 */
	public function setSubBrand($subBrand){
		if ($subBrand instanceof Customweb_Mpay24_Stubs_PaymentSubBrandType) {
			$this->subBrand = $subBrand;
		}
		else {
			throw new BadMethodCallException("Type of argument subBrand must be Customweb_Mpay24_Stubs_PaymentSubBrandType.");
		}
		return $this;
	}
	
	
	
}