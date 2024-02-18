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

require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Customweb/Mpay24/Authorization/Iframe/ParameterBuilder.php';
require_once 'Customweb/Mpay24/Authorization/AbstractRedirectAdapter.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 */
final class Customweb_Mpay24_Authorization_Iframe_Adapter extends Customweb_Mpay24_Authorization_AbstractRedirectAdapter implements 
		Customweb_Payment_Authorization_Iframe_IAdapter {

	protected function getParameterBuilder(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		return new Customweb_Mpay24_Authorization_Iframe_ParameterBuilder($transaction, $this->getContainer(), $formData);
	}

	public function getAdapterPriority(){
		return 200;
	}

	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	public function createTransaction(Customweb_Payment_Authorization_Iframe_ITransactionContext $transactionContext, $failedTransaction){
		return $this->createTransactionInner($transactionContext, $failedTransaction);
	}

	public function getIframeUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		return $this->getPaymentPageUrl($transaction, $formData);
	}

	public function getIframeHeight(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		$height = (int)$this->getMethodFactory()->getPaymentMethod($transaction->getPaymentMethod(), $this->getAuthorizationMethodName())->getPaymentMethodConfigurationValue("iframe_height");
		return $height <= 0 ? 700 : $height;
	}
}