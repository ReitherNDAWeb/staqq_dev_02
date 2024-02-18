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

require_once 'Customweb/Payment/Authorization/Iframe/ITransactionContext.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Mpay24/Stubs/URLType.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Mpay24/Authorization/AbstractParameterBuilder.php';
require_once 'Customweb/Mpay24/Stubs/Order.php';
require_once 'Customweb/Mpay24/Stubs/Order/URL.php';



/**
 *
 * @author Bjoern Hasselmann
 */
final class Customweb_Mpay24_Authorization_Iframe_ParameterBuilder extends Customweb_Mpay24_Authorization_AbstractParameterBuilder {

	/**
	 * This method calls the Customweb_Mpay24_Stubs_Order::setStyle method with
	 * fixed parameters.
	 * Default: centers the payment page
	 *
	 * @param Customweb_Mpay24_Stubs_Order $order
	 */
	protected function setStylingAttributes(Customweb_Mpay24_Stubs_Order $order){
		parent::setStylingAttributes($order);
		$order->setStyle("");
	}

	/**
	 * Overridden
	 */
	public function getUrl(){
		$transactionContext = $this->getTransaction()->getTransactionContext();
		if (!($transactionContext instanceof Customweb_Payment_Authorization_Iframe_ITransactionContext)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_Authorization_Iframe_ITransactionContext');
		}
		
		$iframeBreakoutUrl = Customweb_Util_Url::appendParameters($transactionContext->getIframeBreakOutUrl(), 
				$transactionContext->getCustomParameters());
		
		$url = new Customweb_Mpay24_Stubs_Order_URL();
		$url->setSuccess(Customweb_Mpay24_Stubs_URLType::_()->set($iframeBreakoutUrl));
		$url->setCancel(Customweb_Mpay24_Stubs_URLType::_()->set($this->getCancelledUrl()));
		$url->setError(Customweb_Mpay24_Stubs_URLType::_()->set($this->getFailedUrl()));
		$url->setConfirmation(Customweb_Mpay24_Stubs_URLType::_()->set($this->getNotificationUrl()));
		
		return $url;
	}
}