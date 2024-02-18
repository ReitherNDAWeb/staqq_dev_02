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
require_once 'Mpay24Cw/Util.php';
require_once 'Customweb/Util/Url.php';


/**
 *
 * @author Nico Eigenmann
 *
 */
class Mpay24Cw_Controller_Abstract {
	
	protected function loadTransaction($parameters){
	
		if (!isset($parameters['cwtid'])) {
			throw new Exception(__('No transaction ID provided.', 'woocommerce_mpay24cw'));
		}
		//Make sure payment methods are loaded
		Mpay24Cw_Util::getPaymentMethods(true);
		$dbTransaction = Mpay24Cw_Util::getTransactionById($parameters['cwtid'], false);
	
		if ($dbTransaction === null) {
			throw new Exception(__('Invalid transaction ID provided.', 'woocommerce_mpay24cw'));
		}
		
		if(!isset($parameters['cwtt']) || $parameters['cwtt'] != Mpay24Cw_Util::computeTransactionValidateHash($dbTransaction)) {
			throw new Exception(__('Missing Permissions.', 'woocommerce_mpay24cw'));
		}
		
		return $dbTransaction;
	}
	
	protected function loadOrder($parameters) {
		if (!isset($parameters['cwoid'])) {
			throw new Exception(__('No order ID provided.', 'woocommerce_mpay24cw'));
		}
		
		
		if(!isset($parameters['cwot']) || $parameters['cwot'] != Mpay24Cw_Util::computeOrderValidationHash($parameters['cwoid'])) {
			throw new Exception(__('Missing Permissions.', 'woocommerce_mpay24cw'));
		}
		
		
		$order = Mpay24Cw_Util::loadOrderObjectById($parameters['cwoid']);
		
		return $order;
		
	}
	
	
	protected function formatErrorMessage($error) {
		return '<div class="woocommerce"><div class="payment-error woocommerce-error">'.$error.'</div></div>';
	
	}
	
	/**
	 * This function calls the validation function of the authorization Adapter
	 * If the validation fails the order is cancelled and the customer is redirected to the checkout.
	 * 
	 * @param Mpay24Cw_OrderContext $orderContext
	 * @param Customweb_Payment_Authorization_IAdapter $authorizationAdapter
	 * @param array $parameters
	 */
	protected function validateTransaction(Mpay24Cw_OrderContext $orderContext, Customweb_Payment_Authorization_IAdapter $authorizationAdapter, array $parameters) {
		$errorMessage = null;
		$paymentContext = Mpay24Cw_Util::getPaymentCustomerContext($orderContext->getCustomerId());
		try {
			$authorizationAdapter->validate($orderContext, $paymentContext, $parameters);
		}
		catch(Exception $e) {
			$errorMessage = __('Validation failed:').' '.$e->getMessage();
			$orderContext->getOrderObject()->cancel_order($errorMessage);
				
		}
		Mpay24Cw_Util::persistPaymentCustomerContext($paymentContext);
		
		if ($errorMessage !== null) {
			$option = Mpay24Cw_Util::getCheckoutUrlPageId();
			header('Location: ' .   Customweb_Util_Url::appendParameters(get_permalink(Mpay24Cw_Util::getPermalinkIdModified($option)), array('mpay24cwove' => $errorMessage)));
			die();
		}
	}
	
	protected function getAlias($parameters, $userId) {
		$aliasTransaction = null;
		if(isset($parameters['cwalias'])) {
			$aliasTransaction = Mpay24Cw_Util::getAliasTransactionObject($parameters['cwalias'], $userId);
		}
		return $aliasTransaction;
	}
	
	protected function getFailed($parameters) {
		$failedTransaction = null;
		if(isset($parameters['cwfail'])) {
			$failedTransaction = Mpay24Cw_Util::getFailedTransactionObject($parameters['cwfail'], $parameters['cwfailtoken']);
		}
		return $failedTransaction;
	}

}