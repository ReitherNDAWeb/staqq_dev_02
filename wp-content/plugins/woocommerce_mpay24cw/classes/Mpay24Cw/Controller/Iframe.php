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
require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Mpay24Cw/ContextRequest.php';
require_once 'Mpay24Cw/Util.php';
require_once 'Customweb/Util/Url.php';
require_once 'Mpay24Cw/PaymentMethodWrapper.php';
require_once 'Mpay24Cw/OrderContext.php';
require_once 'Mpay24Cw/Controller/Abstract.php';


/**
 *
 * @author Nico Eigenmann
 *
 */
class Mpay24Cw_Controller_Iframe extends Mpay24Cw_Controller_Abstract {

	public function indexAction() {
		$parameters = Mpay24Cw_ContextRequest::getInstance()->getParameters();
		if(!isset($parameters['cwsubmit'])|| $parameters['cwsubmit'] != 'true') {
			return;
		}
		try {
			$order = $this->loadOrder($parameters);
		}
		catch(Exception $e) {
			return $this->formatErrorMessage($e->getMessage());
		}
		
		$paymentModule = Mpay24Cw_Util::getPaymentMehtodInstance($order->payment_method);
	
		if ($paymentModule === NULL) {
			return $this->formatErrorMessage(__('Could not load payment module.', 'woocommerce_mpay24cw'));
		}
	
		$orderContext = new Mpay24Cw_OrderContext($order, new Mpay24Cw_PaymentMethodWrapper($paymentModule));
		
		$authorizationAdapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
	
		if (!($authorizationAdapter instanceof Customweb_Payment_Authorization_Iframe_IAdapter)) {
			return $this->formatErrorMessage(__('Wrong authorization type.', 'woocommerce_mpay24cw'));
		}
	
		$this->validateTransaction($orderContext, $authorizationAdapter, $parameters);
		
		$aliasTransaction = $this->getAlias($parameters, $orderContext->getCustomerId());
		$failedTransaction = $this->getFailed($parameters);
		
		$dbTransaction = $paymentModule->prepare($orderContext, $aliasTransaction, $failedTransaction);
	
		$variables = array(
			'iframe_url' => $authorizationAdapter->getIframeUrl($dbTransaction->getTransactionObject(), $parameters),
			'iframe_height' => $authorizationAdapter->getIframeHeight($dbTransaction->getTransactionObject(), $parameters),
		);
		Mpay24Cw_Util::getEntityManager()->persist($dbTransaction);
	
		ob_start();
		Mpay24Cw_Util::includeTemplateFile('payment_iframe', $variables);
		$content = ob_get_clean();
		return $content;
	}

	public function breakOutAction() {
		
		$GLOBALS['woo_mpay24cwTitle'] = __('Break Out' , 'woocommerce_mpay24cw');
		
		$parameters = Mpay24Cw_ContextRequest::getInstance()->getParameters();
		$dbTransaction = null;
		try {
			$dbTransaction = $this->loadTransaction($parameters);
		}
		catch(Exception $e) {
			echo $this->formatErrorMessage($e->getMessage());
			die();
		}
	
		$redirectionUrl = '';
		if ($dbTransaction->getTransactionObject()->isAuthorizationFailed()) {
			$redirectionUrl = Customweb_Util_Url::appendParameters(
					$dbTransaction->getTransactionObject()->getTransactionContext()->getFailedUrl(),
					$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
			);
		}
		else {
			$redirectionUrl = Customweb_Util_Url::appendParameters(
					$dbTransaction->getTransactionObject()->getTransactionContext()->getSuccessUrl(),
					$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
			);
		}
	
		ob_start();
		$variables = array( 'url' => $redirectionUrl);
		Mpay24Cw_Util::includeTemplateFile('iframe_break_out', $variables);
		$content = ob_get_clean();
		echo $content;
		die();
	}
	
}