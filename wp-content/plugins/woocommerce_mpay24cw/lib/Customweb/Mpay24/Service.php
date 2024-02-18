<?php

/**
 *  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ETP.php';


class Customweb_Mpay24_Service extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ETP {
	
	private $username;
	private $password;
	
	public function __construct($username, $password) {
		parent::__construct();
		$this->username = $username;
		$this->password = $password;
	}
	
	protected function createSoapCall($operationName, $data, $outputClassName, $soapActionName = null){
		$call = parent::createSoapCall($operationName, $data, $outputClassName, $soapActionName);
		$call->addBasicAuthentication($this->username, $this->password);
		return $call;
	}
	
}