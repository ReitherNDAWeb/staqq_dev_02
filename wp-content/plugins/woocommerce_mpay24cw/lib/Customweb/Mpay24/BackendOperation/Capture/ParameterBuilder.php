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

require_once 'Customweb/Mpay24/Configuration.php';
require_once 'Customweb/Mpay24/AbstractEtpParameterBuilder.php';



/**
 * This class builds the parameters for manual capturing, which
 * means a Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order object for a ManualClear SOAP class.
 * Do not confuse this class with Customweb_Mpay24_Authorization_ParameterBuilder,
 * which builds a Customweb_Mpay24_Stubs_Order object.
 *
 * @author Bjoern Hasselmann
 *
 */
final class Customweb_Mpay24_BackendOperation_Capture_ParameterBuilder extends Customweb_Mpay24_AbstractEtpParameterBuilder {
	
	/**
	 * Overridden
	 */
	public function getOrder(){
		return parent::getOrder()->setUserField(substr(Customweb_Mpay24_Configuration::SHOP_SYSTEM_TAG, 0, 255));
	}
	
}