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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Profile.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
/**
 * @XmlType(name="ListProfilesResponse", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse {
	/**
	 * @XmlElement(name="status", type="Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status")
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status
	 */
	private $status;
	
	/**
	 * @XmlValue(name="returnCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $returnCode;
	
	/**
	 * @XmlList(name="profile", type='Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile')
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile[]
	 */
	private $profile;
	
	/**
	 * @XmlValue(name="all", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $all;
	
	public function __construct() {
		$this->profile = new ArrayObject();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse();
		return $i;
	}
	/**
	 * Returns the value for the property status.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status
	 */
	public function getStatus(){
		return $this->status;
	}
	
	/**
	 * Sets the value for the property status.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status $status
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public function setStatus($status){
		if ($status instanceof Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status) {
			$this->status = $status;
		}
		else {
			throw new BadMethodCallException("Type of argument status must be Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property returnCode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getReturnCode(){
		return $this->returnCode;
	}
	
	/**
	 * Sets the value for the property returnCode.
	 * 
	 * @param string $returnCode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public function setReturnCode($returnCode){
		if ($returnCode instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->returnCode = $returnCode;
		}
		else {
			$this->returnCode = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($returnCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property profile.
	 * 
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile[]
	 */
	public function getProfile(){
		return $this->profile;
	}
	
	/**
	 * Sets the value for the property profile.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile $profile
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public function setProfile($profile){
		if (is_array($profile)) {
			$profile = new ArrayObject($profile);
		}
		if ($profile instanceof ArrayObject) {
			$this->profile = $profile;
		}
		else {
			throw new BadMethodCallException("Type of argument profile must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of profile.
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile $item
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public function addProfile(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Profile $item) {
		if (!($this->profile instanceof ArrayObject)) {
			$this->profile = new ArrayObject();
		}
		$this->profile[] = $item;
		return $this;
	}
	
	/**
	 * Returns the value for the property all.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getAll(){
		return $this->all;
	}
	
	/**
	 * Sets the value for the property all.
	 * 
	 * @param integer $all
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */
	public function setAll($all){
		if ($all instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->all = $all;
		}
		else {
			$this->all = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($all);
		}
		return $this;
	}
	
	
	
}