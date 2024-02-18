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

require_once dirname(dirname(__FILE__)) . '/classes/Mpay24Cw/PaymentMethod.php'; 

class Mpay24Cw_CreditCard extends Mpay24Cw_PaymentMethod
{
	public $machineName = 'creditcard';
	public $admin_title = 'Credit Card';
	public $title = 'Credit Card';
	
	protected function getMethodSettings(){
		return array(
			'send_billing_address' => array(
				'title' => __("Show Billing Address", 'woocommerce_mpay24cw'),
 				'default' => '0',
 				'description' => __("With this payment method it is not necessary to provide the billing address. It is possible to display it on the payment page though.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'0' => __("Don't display", 'woocommerce_mpay24cw'),
 					'1' => __("Display", 'woocommerce_mpay24cw'),
 				),
 			),
 			'widget_frame_height' => array(
				'title' => __("Widget Frame Height", 'woocommerce_mpay24cw'),
 				'default' => '150',
 				'description' => __("This setting defines the absolute height (in pixel) of the IFrame generated during Ajax and / or Widget Authorization.", 'woocommerce_mpay24cw'),
 				'cwType' => 'textfield',
 				'type' => 'text',
 			),
 			'iframe_height' => array(
				'title' => __("IFrame Height", 'woocommerce_mpay24cw'),
 				'default' => '700',
 				'description' => __("This setting defines the absolute height (in pixel) of the IFrame generated during IFrame authorization.", 'woocommerce_mpay24cw'),
 				'cwType' => 'textfield',
 				'type' => 'text',
 			),
 			'status_authorized' => array(
				'title' => __("Authorized Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-processing' : 'processing',
 				'description' => __("This status is set, when the payment was successfull and it is authorized.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'use-default' => __("Use WooCommerce rules", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_uncertain' => array(
				'title' => __("Uncertain Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-on-hold' : 'on-hold',
 				'description' => __("You can specify the order status for new orders that have an uncertain authorisation status.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
				),
 				'is_order_status' => true,
 			),
 			'status_cancelled' => array(
				'title' => __("Cancelled Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-cancelled' : 'cancelled',
 				'description' => __("You can specify the order status when an order is cancelled.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_captured' => array(
				'title' => __("Captured Status", 'woocommerce_mpay24cw'),
 				'default' => 'no_status_change',
 				'description' => __("You can specify the order status for orders that are captured either directly after the order or manually in the backend.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'authorizationMethod' => array(
				'title' => __("Authorization Method", 'woocommerce_mpay24cw'),
 				'default' => 'PaymentPage',
 				'description' => __("Select the authorization method to use for processing this payment method.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'PaymentPage' => __("Payment Page", 'woocommerce_mpay24cw'),
 					'IframeAuthorization' => __("IFrame Authorization", 'woocommerce_mpay24cw'),
 					'WidgetAuthorization' => __("Widget Authorization", 'woocommerce_mpay24cw'),
 					'AjaxAuthorization' => __("Ajax Authorization", 'woocommerce_mpay24cw'),
 				),
 			),
 			'alias_manager' => array(
				'title' => __("Alias Manager", 'woocommerce_mpay24cw'),
 				'default' => 'inactive',
 				'description' => __("The alias manager allows the customer to select from a credit card previously stored. The sensitive data is stored by mPAY24.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'active' => __("Active", 'woocommerce_mpay24cw'),
 					'inactive' => __("Inactive", 'woocommerce_mpay24cw'),
 				),
 			),
 		); 
	}
	
	public function __construct() {
		$this->icon = apply_filters(
			'woocommerce_mpay24cw_creditcard_icon', 
			Mpay24Cw_Util::getResourcesUrl('icons/creditcard.png')
		);
		parent::__construct();
	}
	
	public function createMethodFormFields() {
		$formFields = parent::createMethodFormFields();
		
		return array_merge(
			$formFields,
			$this->getMethodSettings()
		);
	}

}