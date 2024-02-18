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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentToken.php';
require_once 'Customweb/Mpay24/Authorization/Widget/ParameterBuilder.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Mpay24/Authorization/AbstractRedirectAdapter.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/Control/TextInput.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
abstract class Customweb_Mpay24_Authorization_AbstractTokenAdapter extends Customweb_Mpay24_Authorization_AbstractRedirectAdapter {

	/** The alias form field where the profile ID is transmitted in */
	public static $ALIAS_FORM_FIELD = 'mpayAlias';
	
	/**
	 * Overridden
	 *
	 * @return Customweb_Mpay24_Authorization_Widget_ParameterBuilder
	 */
	protected function getParameterBuilder(Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		return new Customweb_Mpay24_Authorization_Widget_ParameterBuilder($transaction, $this->getContainer());
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order
	 */
	public function getOrder(Customweb_Mpay24_Authorization_Transaction $transaction){
		return $this->getParameterBuilder($transaction, array())->getOrder();
	}

	/**
	 *
	 * @param $orderContext
	 * @param $profileId The alias ID used by mPAY24
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentTokenResponse
	 */
	protected function createPaymentToken(Customweb_Payment_Authorization_IOrderContext $orderContext, $profileId = null) {
		$request = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken();
		$request->setMerchantID($this->getConfiguration()->getMerchantId());
		$request->setPType(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentType::CC());
		$request->setLanguage($orderContext->getLanguage()->getIso2LetterCode());
		$request->setStyle($this->getConfiguration()->getAjaxFormStyle());
		
		if($profileId !== null) {
			$request->setCustomerID($orderContext->getCustomerId());
			$request->setProfileID($profileId);
		}
		
		return self::getSoapService()->createPaymentToken($request);
	}
	
	protected function createAliasFormField($aliasTransaction){
		$aliasControl = new Customweb_Form_Control_TextInput(self::$ALIAS_FORM_FIELD);
		$aliasElement = new Customweb_Form_Element(Customweb_I18n_Translation::__('Profile Name'), $aliasControl);
		$aliasElement->setRequired(false)->setDescription(
				Customweb_I18n_Translation::__('For comfy future payments, enter a profile name here to store your data securily at mPAY24.'));
		return $aliasElement;
	}
}