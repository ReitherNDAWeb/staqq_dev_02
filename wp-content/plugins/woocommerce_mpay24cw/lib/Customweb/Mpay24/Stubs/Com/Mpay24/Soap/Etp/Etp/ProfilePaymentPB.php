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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * Paybox specific profile payment parameters
 * 
 * @XmlType(name="ProfilePaymentPB", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentPB extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlNillable
	 * @XmlValue(name="payDays", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $payDays;
	
	/**
	 * @XmlNillable
	 * @XmlValue(name="reserveDays", simpleType=@XmlSimpleTypeDefinition(typeName='unsignedInt', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer'))
	 * @var integer
	 */
	private $reserveDays;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentPB
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentPB();
		return $i;
	}
	/**
	 * Returns the value for the property payDays.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getPayDays(){
		return $this->payDays;
	}
	
	/**
	 * Sets the value for the property payDays.
	 * 
	 * @param integer $payDays
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentPB
	 */
	public function setPayDays($payDays){
		if ($payDays instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->payDays = $payDays;
		}
		else if (is_object($payDays) && get_class($payDays) == "Customweb_Xml_Nil") {
			$this->payDays = $payDays;
		}
		else {
			$this->payDays = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($payDays);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property reserveDays.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getReserveDays(){
		return $this->reserveDays;
	}
	
	/**
	 * Sets the value for the property reserveDays.
	 * 
	 * @param integer $reserveDays
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ProfilePaymentPB
	 */
	public function setReserveDays($reserveDays){
		if ($reserveDays instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer) {
			$this->reserveDays = $reserveDays;
		}
		else if (is_object($reserveDays) && get_class($reserveDays) == "Customweb_Xml_Nil") {
			$this->reserveDays = $reserveDays;
		}
		else {
			$this->reserveDays = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Integer::_()->set($reserveDays);
		}
		return $this;
	}
	
	
	
}