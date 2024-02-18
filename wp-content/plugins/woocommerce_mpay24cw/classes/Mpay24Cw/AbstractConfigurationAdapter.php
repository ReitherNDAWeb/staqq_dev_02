<?php
/**
 * * You are allowed to use this API in your web application.
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
require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/Payment/IConfigurationAdapter.php';


/**
 *
 */
abstract class Mpay24Cw_AbstractConfigurationAdapter implements Customweb_Payment_IConfigurationAdapter
{
	
	protected $settingsMap=array(
		'operation_mode' => array(
			'id' => 'mpay24-operation-mode-setting',
 			'machineName' => 'operation_mode',
 			'type' => 'select',
 			'label' => 'Operation Mode',
 			'description' => 'If the test mode is selected the test account is used. Otherwise the configured account is used.',
 			'defaultValue' => 'test',
 			'allowedFileExtensions' => array(
			),
 		),
 		'merchant_id_test' => array(
			'id' => 'mpay24-merchant-id-test',
 			'machineName' => 'merchant_id_test',
 			'type' => 'textfield',
 			'label' => 'Test Merchant ID ',
 			'description' => 'Merchant ID for test mode (beginning with 9). The Merchant ID will be provided by mPAY24',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'password_test' => array(
			'id' => 'mpay24-password-test',
 			'machineName' => 'password_test',
 			'type' => 'textfield',
 			'label' => 'Test Password',
 			'description' => 'The password will be provided in the initial set up documents by mPAY24.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'merchant_id_live' => array(
			'id' => 'mpay24-merchant-id-live',
 			'machineName' => 'merchant_id_live',
 			'type' => 'textfield',
 			'label' => 'Live Merchant ID ',
 			'description' => 'Merchant ID for productive mode (beginning with 7) will be provided by mPAY24.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'password_live' => array(
			'id' => 'mpay24-password-live',
 			'machineName' => 'password_live',
 			'type' => 'textfield',
 			'label' => 'Live Password',
 			'description' => 'The password will be provided in the initial set up documents by mPAY24.',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'order_id_schema' => array(
			'id' => 'mpay24-order-id-schema-setting',
 			'machineName' => 'order_id_schema',
 			'type' => 'textfield',
 			'label' => 'Transaction Number Prefix',
 			'description' => 'Here you can insert an order prefix. The prefix allows you to change the order number that is transmitted to mPAY24. The prefix must contain the tag {id}. It will then be replaced by the transaction number (e.g. order_{id}).',
 			'defaultValue' => '{id}',
 			'allowedFileExtensions' => array(
			),
 		),
 		'order_description' => array(
			'id' => 'mpay24-order-description-setting',
 			'machineName' => 'order_description',
 			'type' => 'textfield',
 			'label' => 'Order Description',
 			'description' => 'Here you can insert an order description. If the description contains the tag {id}, it will then be replaced by the transaction id. (e.g. name {id}).',
 			'defaultValue' => '',
 			'allowedFileExtensions' => array(
			),
 		),
 		'responsive_paypage' => array(
			'id' => 'mpay24-paypage-style-setting',
 			'machineName' => 'responsive_paypage',
 			'type' => 'select',
 			'label' => 'Dynamic Payment Page',
 			'description' => 'If activating this setting, the Payment Page adapts itself to the resolution of the screen. Smallest resolution of width: 300px. (Also suitable for mobile platforms)',
 			'defaultValue' => '0',
 			'allowedFileExtensions' => array(
			),
 		),
 		'ajax_form_style' => array(
			'id' => 'mpay24-ajax-form-style-setting',
 			'machineName' => 'ajax_form_style',
 			'type' => 'textfield',
 			'label' => 'Ajax Input Form Styling',
 			'description' => 'When using Ajax Authorization, a styling for the input form can be deposited for a merchant’s account at mPAY24. To create the styling the mPAY24 Designer should be used, which is located at https://test.mpay24.com/web/designer.',
 			'defaultValue' => 'DEFAULT',
 			'allowedFileExtensions' => array(
			),
 		),
 		'review_input_form' => array(
			'id' => 'woocommerce-input-form-in-review-pane-setting',
 			'machineName' => 'review_input_form',
 			'type' => 'select',
 			'label' => 'Review Input Form',
 			'description' => 'Should the input form for credit card data rendered in the review pane? To work the user must have JavaScript activated. In case the browser does not support JavaScript a fallback is provided. This feature is not supported by all payment methods.',
 			'defaultValue' => 'active',
 			'allowedFileExtensions' => array(
			),
 		),
 		'order_identifier' => array(
			'id' => 'woocommerce-order-number-setting',
 			'machineName' => 'order_identifier',
 			'type' => 'select',
 			'label' => 'Order Identifier',
 			'description' => 'Set which identifier should be sent to the payment service provider. If a plugin modifies the order number and can not guarantee it\'s uniqueness, select Post Id.',
 			'defaultValue' => 'ordernumber',
 			'allowedFileExtensions' => array(
			),
 		),
 	);

	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IConfigurationAdapter::getConfigurationValue()
	 */
	public function getConfigurationValue($key, $languageCode = null) {

		$setting = $this->settingsMap[$key];
		$value =  get_option('woocommerce_mpay24cw_' . $key, $setting['defaultValue']);
		
		if($setting['type'] == 'file') {
			if(isset($value['path']) && file_exists($value['path'])) {
				return new Customweb_Core_Stream_Input_File($value['path']);
			}
			else {
				$resolver = Mpay24Cw_Util::getAssetResolver();
				return $resolver->resolveAssetStream($setting['defaultValue']);
			}
		}
		else if($setting['type'] == 'multiselect') {
			if(empty($value)){
				return array();
			}
		}
		return $value;
	}
		
	public function existsConfiguration($key, $languageCode = null) {
		if ($languageCode !== null) {
			$languageCode = (string)$languageCode;
		}
		$value = get_option('woocommerce_mpay24cw_' . $key, null);
		if ($value === null) {
			return false;
		}
		else {
			return true;
		}
	}
	
	
}