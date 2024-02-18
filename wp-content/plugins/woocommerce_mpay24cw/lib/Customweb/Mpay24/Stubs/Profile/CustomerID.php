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
require_once 'Customweb/Mpay24/Stubs/CustomerIDType.php';
/**
 * @XmlType(name="CustomerID", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Profile_CustomerID extends Customweb_Mpay24_Stubs_CustomerIDType {
	/**
	 * @XmlAttribute(name="ProfileID", simpleType=@XmlSimpleTypeDefinition(typeName='ProfileIDType', typeNamespace='', type='Customweb_Mpay24_Stubs_ProfileIDType')) 
	 * @var Customweb_Mpay24_Stubs_ProfileIDType
	 */
	private $profileID;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Profile_CustomerID
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Profile_CustomerID();
		return $i;
	}
	/**
	 * Should be set to update an existing profile
	 * 
	 * Returns the value for the property profileID.
	 * 
	 * @return Customweb_Mpay24_Stubs_ProfileIDType
	 */
	public function getProfileID(){
		return $this->profileID;
	}
	
	/**
	 * Should be set to update an existing profile
	 * 
	 * Sets the value for the property profileID.
	 * 
	 * @param Customweb_Mpay24_Stubs_ProfileIDType $profileID
	 * @return Customweb_Mpay24_Stubs_Profile_CustomerID
	 */
	public function setProfileID($profileID){
		if ($profileID instanceof Customweb_Mpay24_Stubs_ProfileIDType) {
			$this->profileID = $profileID;
		}
		else {
			throw new BadMethodCallException("Type of argument profileID must be Customweb_Mpay24_Stubs_ProfileIDType.");
		}
		return $this;
	}
	
	
	
}