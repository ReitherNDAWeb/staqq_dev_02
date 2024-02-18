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

require_once 'Customweb/Mpay24/Authorization/PaymentPage/ParameterBuilder.php';
require_once 'Customweb/Payment/Authorization/PaymentPage/IAdapter.php';
require_once 'Customweb/Mpay24/Authorization/AbstractRedirectAdapter.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 */
final class Customweb_Mpay24_Authorization_PaymentPage_Adapter extends Customweb_Mpay24_Authorization_AbstractRedirectAdapter implements 
		Customweb_Payment_Authorization_PaymentPage_IAdapter {

	/**
	 * Overridden
	 */
	protected function getParameterBuilder(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		return new Customweb_Mpay24_Authorization_PaymentPage_ParameterBuilder($transaction, $this->getContainer(), $formData);
	}

	/**
	 * Overridden
	 */
	public function getAdapterPriority(){
		return 100;
	}

	/**
	 * Overridden
	 */
	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	/**
	 * Overridden
	 */
	public function createTransaction(Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext, $failedTransaction){
		return $this->createTransactionInner($transactionContext, $failedTransaction);
	}

	/**
	 * Overridden
	 */
	public function isHeaderRedirectionSupported(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		return true;
	}

	/**
	 * Overridden
	 */
	public function getRedirectionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		return $this->getPaymentPageUrl($transaction, $formData);
	}

	/**
	 * Overridden
	 */
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		return array();
	}

	/**
	 * Overridden
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		return $this->getRedirectionUrl($transaction, $formData);
	}
}