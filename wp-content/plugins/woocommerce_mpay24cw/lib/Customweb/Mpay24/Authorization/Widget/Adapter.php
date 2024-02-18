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

require_once 'Customweb/Asset/IResolver.php';
require_once 'Customweb/Core/Exception/CastException.php';
require_once 'Customweb/Payment/Authorization/Widget/IAdapter.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php';
require_once 'Customweb/Mpay24/Authorization/Transaction.php';
require_once 'Customweb/Payment/Endpoint/IAdapter.php';
require_once 'Customweb/Mpay24/Authorization/AbstractTokenAdapter.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 *
 */
final class Customweb_Mpay24_Authorization_Widget_Adapter extends Customweb_Mpay24_Authorization_AbstractTokenAdapter implements 
		Customweb_Payment_Authorization_Widget_IAdapter {

	/**
	 * Overridden
	 */
	public function getAuthorizationMethodName(){
		return self::AUTHORIZATION_METHOD_NAME;
	}

	/**
	 * Overridden
	 */
	public function getAdapterPriority(){
		return 500;
	}

	/**
	 * Overridden
	 */
	public function createTransaction(Customweb_Payment_Authorization_Widget_ITransactionContext $transactionContext, $failedTransaction){
		return $this->createTransactionInner($transactionContext, $failedTransaction);
	}

	/**
	 * Overridden
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext){
		$formFields = parent::getVisibleFormFields($orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext);
		if ($aliasTransaction == 'new') {
			$formFields[] = $this->createAliasFormField($aliasTransaction);
		}
		return $formFields;
	}

	/**
	 * Overridden
	 */
	public function getWidgetHTML(Customweb_Payment_Authorization_ITransaction $transaction, array $formData){
		$assetResolver = $this->getContainer()->getBean('Customweb_Asset_IResolver');
		$endpointAdapter = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');
		
		// cast interfaces
		if (!($assetResolver instanceof Customweb_Asset_IResolver)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Asset_IResolver');
		}
		if (!($endpointAdapter instanceof Customweb_Payment_Endpoint_IAdapter)) {
			throw new Customweb_Core_Exception_CastException('Customweb_Payment_Endpoint_IAdapter');
		}
		if (!($transaction instanceof Customweb_Mpay24_Authorization_Transaction)) {
			throw new Customweb_Core_Exception_CastException("Customweb_Mpay24_Authorization_Transaction");
		}
		
		// check existing alias
		$profileId = null;
		if ($transaction->getTransactionContext()->getAlias() instanceof Customweb_Mpay24_Authorization_Transaction) {
			$profileId = $transaction->getTransactionContext()->getAlias()->getAliasId();
		}
		
		// get the widget token
		$response = $this->createPaymentToken($transaction->getTransactionContext()->getOrderContext(), $profileId);
		if ($response->getStatus() != Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Status::OK()) {
			$this->translateErrorMessage($response);
		}
		$transaction->setWidgetToken($response->getToken()->get());
		
		// create the html
		$iFrameCommunicationUri = $assetResolver->resolveAssetUrl('widget/IFrameCommunication.js');
		$mpayIframeUrl = $response->getLocation()->get();
		
		$endpointParams = array(
			'cw_transaction_id' => $transaction->getExternalTransactionId() 
		);
		// check new alias
		if (isset($formData[self::$ALIAS_FORM_FIELD])) {
			$endpointParams[self::$ALIAS_FORM_FIELD] = $formData[self::$ALIAS_FORM_FIELD];
		}
		$endpointURl = $endpointAdapter->getUrl('widgetp', 'process', $endpointParams);
		
		$heightInPixel = $this->getMethodFactory()->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod(), 
				self::AUTHORIZATION_METHOD_NAME)->getPaymentMethodConfigurationValue('widget_frame_height');
		$html = '<div style="position: relative">
					<iframe src="' . $mpayIframeUrl .
				 '" style="border:none; width:100%; height:' . $heightInPixel . '"></iframe>
					<form name="" id="" action="' . $endpointURl .
				 '" method="POST">
						<input id="paybutt" type="submit" value="' .
				 Customweb_I18n_Translation::__("Pay") . '" disabled="" class="button btn btn-success mpay24-widget-pay"/>
						<script src="' . $iFrameCommunicationUri . '"></script>
					</form>
				</div>';
		
		return $html;
	}
}