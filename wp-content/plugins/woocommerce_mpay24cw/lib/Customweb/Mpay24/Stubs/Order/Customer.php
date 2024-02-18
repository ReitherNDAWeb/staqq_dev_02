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

require_once 'Customweb/Mpay24/Stubs/Order/Customer/Id.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
require_once 'Customweb/Mpay24/Stubs/CustomerType.php';
/**
 * @XmlType(name="Customer", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_Customer extends Customweb_Mpay24_Stubs_CustomerType {
	/**
	 * @XmlAttribute(name="Id", simpleType=@XmlSimpleTypeDefinition(typeName='Id', typeNamespace='', type='Customweb_Mpay24_Stubs_Order_Customer_Id')) 
	 * @var Customweb_Mpay24_Stubs_Order_Customer_Id
	 */
	private $id;
	
	/**
	 * @XmlAttribute(name="UseProfile", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean')) 
	 * @var boolean
	 */
	private $useProfile;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_Customer
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_Customer();
		return $i;
	}
	/**
	 * Returns the value for the property id.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_Customer_Id
	 */
	public function getId(){
		return $this->id;
	}
	
	/**
	 * Sets the value for the property id.
	 * 
	 * @param Customweb_Mpay24_Stubs_Order_Customer_Id $id
	 * @return Customweb_Mpay24_Stubs_Order_Customer
	 */
	public function setId($id){
		if ($id instanceof Customweb_Mpay24_Stubs_Order_Customer_Id) {
			$this->id = $id;
		}
		else {
			throw new BadMethodCallException("Type of argument id must be Customweb_Mpay24_Stubs_Order_Customer_Id.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property useProfile.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getUseProfile(){
		return $this->useProfile;
	}
	
	/**
	 * Sets the value for the property useProfile.
	 * 
	 * @param boolean $useProfile
	 * @return Customweb_Mpay24_Stubs_Order_Customer
	 */
	public function setUseProfile($useProfile){
		if ($useProfile instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->useProfile = $useProfile;
		}
		else {
			$this->useProfile = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($useProfile);
		}
		return $this;
	}
	
	
	
}