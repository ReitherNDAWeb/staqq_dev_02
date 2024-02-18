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

require_once 'Customweb/Mpay24/Stubs/URLType.php';
require_once 'Customweb/Mpay24/Authorization/AbstractParameterBuilder.php';
require_once 'Customweb/Mpay24/Stubs/Order/URL.php';



/**
 *
 * @author Bjoern Hasselmann
 */
final class Customweb_Mpay24_Authorization_PaymentPage_ParameterBuilder extends Customweb_Mpay24_Authorization_AbstractParameterBuilder {

	/**
	 * Overridden
	 */
	public function getUrl(){
		$url = new Customweb_Mpay24_Stubs_Order_URL();
		$url->setSuccess(Customweb_Mpay24_Stubs_URLType::_()->set($this->getTransaction()->getSuccessUrl()));
		$url->setCancel(Customweb_Mpay24_Stubs_URLType::_()->set($this->getCancelledUrl()));
		$url->setError(Customweb_Mpay24_Stubs_URLType::_()->set($this->getFailedUrl()));
		$url->setConfirmation(Customweb_Mpay24_Stubs_URLType::_()->set($this->getNotificationUrl()));
	
		return $url;
	}
	
	
}