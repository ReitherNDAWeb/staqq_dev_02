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

class Mpay24Cw_Sofortueberweisung extends Mpay24Cw_PaymentMethod
{
	public $machineName = 'sofortueberweisung';
	public $admin_title = 'Sofortüberweisung';
	public $title = 'Sofortüberweisung';
	
	protected function getMethodSettings(){
		return array(
			'update' => array(
				'title' => __("Update Transactions", 'woocommerce_mpay24cw'),
 				'default' => 'Yes',
 				'description' => __("Determine whether transactions should be updated regularly or not.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'0' => __("No update", 'woocommerce_mpay24cw'),
 					'12' => __("Every 12 hours", 'woocommerce_mpay24cw'),
 					'18' => __("Every 18 hours", 'woocommerce_mpay24cw'),
 					'24' => __("Once a day", 'woocommerce_mpay24cw'),
 					'72' => __("Every 3 days", 'woocommerce_mpay24cw'),
 					'168' => __("Once a week", 'woocommerce_mpay24cw'),
 				),
 			),
 			'failed_status' => array(
				'title' => __("Failed Order Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-cancelled' : 'cancelled',
 				'description' => __("Determine the status of an order, which failed during the update of the transaction over the cron. This setting requires an update interval above.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
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
 			'authorizationMethod' => array(
				'title' => __("Authorization Method", 'woocommerce_mpay24cw'),
 				'default' => 'PaymentPage',
 				'description' => __("Select the authorization method to use for processing this payment method.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'PaymentPage' => __("Payment Page", 'woocommerce_mpay24cw'),
 				),
 			),
 		); 
	}
	
	public function __construct() {
		$this->icon = apply_filters(
			'woocommerce_mpay24cw_sofortueberweisung_icon', 
			Mpay24Cw_Util::getResourcesUrl('icons/sofortueberweisung.png')
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