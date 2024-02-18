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

require_once 'Customweb/Mpay24/Stubs/URLType.php';
/**
 * @XmlType(name="URL", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Profile_URL {
	/**
	 * @XmlElement(name="Success", type="Customweb_Mpay24_Stubs_URLType")
	 * @var Customweb_Mpay24_Stubs_URLType
	 */
	private $success;
	
	/**
	 * @XmlElement(name="Cancel", type="Customweb_Mpay24_Stubs_URLType")
	 * @var Customweb_Mpay24_Stubs_URLType
	 */
	private $cancel;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Profile_URL
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Profile_URL();
		return $i;
	}
	/**
	 * Returns the value for the property success.
	 * 
	 * @return Customweb_Mpay24_Stubs_URLType
	 */
	public function getSuccess(){
		return $this->success;
	}
	
	/**
	 * Sets the value for the property success.
	 * 
	 * @param Customweb_Mpay24_Stubs_URLType $success
	 * @return Customweb_Mpay24_Stubs_Profile_URL
	 */
	public function setSuccess($success){
		if ($success instanceof Customweb_Mpay24_Stubs_URLType) {
			$this->success = $success;
		}
		else {
			throw new BadMethodCallException("Type of argument success must be Customweb_Mpay24_Stubs_URLType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property cancel.
	 * 
	 * @return Customweb_Mpay24_Stubs_URLType
	 */
	public function getCancel(){
		return $this->cancel;
	}
	
	/**
	 * Sets the value for the property cancel.
	 * 
	 * @param Customweb_Mpay24_Stubs_URLType $cancel
	 * @return Customweb_Mpay24_Stubs_Profile_URL
	 */
	public function setCancel($cancel){
		if ($cancel instanceof Customweb_Mpay24_Stubs_URLType) {
			$this->cancel = $cancel;
		}
		else {
			throw new BadMethodCallException("Type of argument cancel must be Customweb_Mpay24_Stubs_URLType.");
		}
		return $this;
	}
	
	
	
}