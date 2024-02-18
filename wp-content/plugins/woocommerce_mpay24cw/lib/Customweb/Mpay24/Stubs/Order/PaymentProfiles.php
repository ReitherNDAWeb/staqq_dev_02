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

require_once 'Customweb/Mpay24/Stubs/ProfileIDType.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php';
/**
 * @XmlType(name="PaymentProfiles", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_PaymentProfiles {
	/**
	 * @XmlList(name="ProfileID", type='Customweb_Mpay24_Stubs_ProfileIDType')
	 * @var Customweb_Mpay24_Stubs_ProfileIDType[]
	 */
	private $profileID;
	
	/**
	 * @XmlAttribute(name="Enable", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean')) 
	 * @var boolean
	 */
	private $enable = 'true';
	
	public function __construct() {
		$this->profileID = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_PaymentProfiles();
		return $i;
	}
	/**
	 * Returns the value for the property profileID.
	 * 
	 * @return Customweb_Mpay24_Stubs_ProfileIDType[]
	 */
	public function getProfileID(){
		return $this->profileID;
	}
	
	/**
	 * Sets the value for the property profileID.
	 * 
	 * @param Customweb_Mpay24_Stubs_ProfileIDType $profileID
	 * @return Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	public function setProfileID($profileID){
		if (is_array($profileID)) {
			$profileID = new ArrayObject($profileID);
		}
		if ($profileID instanceof ArrayObject) {
			$this->profileID = $profileID;
		}
		else {
			throw new BadMethodCallException("Type of argument profileID must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of profileID.
	 * 
	 * @param Customweb_Mpay24_Stubs_ProfileIDType $item
	 * @return Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	public function addProfileID(Customweb_Mpay24_Stubs_ProfileIDType $item) {
		if (!($this->profileID instanceof ArrayObject)) {
			$this->profileID = new ArrayObject();
		}
		$this->profileID[] = $item;
		return $this;
	}
	
	/**
	 * Enable or disable specified customer payment profiles
	 * 
	 * Returns the value for the property enable.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getEnable(){
		return $this->enable;
	}
	
	/**
	 * Enable or disable specified customer payment profiles
	 * 
	 * Sets the value for the property enable.
	 * 
	 * @param boolean $enable
	 * @return Customweb_Mpay24_Stubs_Order_PaymentProfiles
	 */
	public function setEnable($enable){
		if ($enable instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->enable = $enable;
		}
		else {
			$this->enable = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Boolean::_()->set($enable);
		}
		return $this;
	}
	
	
	
}