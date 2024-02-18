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
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/IndustrySpecific.php';
/**
 * Industry specific parameters for airline tickets
 * 
 * @XmlType(name="AirlineTicket", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AirlineTicket extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_IndustrySpecific {
	/**
	 * @XmlValue(name="iataCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $iataCode;
	
	/**
	 * @XmlValue(name="ticketID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $ticketID;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AirlineTicket
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AirlineTicket();
		return $i;
	}
	/**
	 * Returns the value for the property iataCode.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getIataCode(){
		return $this->iataCode;
	}
	
	/**
	 * Sets the value for the property iataCode.
	 * 
	 * @param string $iataCode
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AirlineTicket
	 */
	public function setIataCode($iataCode){
		if ($iataCode instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->iataCode = $iataCode;
		}
		else {
			$this->iataCode = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($iataCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property ticketID.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTicketID(){
		return $this->ticketID;
	}
	
	/**
	 * Sets the value for the property ticketID.
	 * 
	 * @param string $ticketID
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AirlineTicket
	 */
	public function setTicketID($ticketID){
		if ($ticketID instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->ticketID = $ticketID;
		}
		else {
			$this->ticketID = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($ticketID);
		}
		return $this;
	}
	
	
	
}