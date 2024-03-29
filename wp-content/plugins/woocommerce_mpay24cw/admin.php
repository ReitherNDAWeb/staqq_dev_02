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

// Make sure we don't expose any info if called directly         		   	 	  	  	
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit();
}

require_once dirname(__FILE__) . '/lib/loader.php';
require_once 'classes/Mpay24Cw/Util.php';

require_once 'Customweb/Core/Util/Xml.php';
require_once 'Mpay24Cw/Util.php';
require_once 'Customweb/Util/Url.php';



// Get all general wordpress settings functionality
require_once plugin_dir_path(__FILE__) . 'settings.php';


// Add some CSS and JS for admin         		   	 	  	  	
function woocommerce_mpay24cw_admin_add_shop_style_scripts(){
	wp_register_style('woocommerce_mpay24cw_admin_styles', plugins_url('resources/css/admin.css', __FILE__));
	wp_enqueue_style('woocommerce_mpay24cw_admin_styles');
}
add_action('admin_init', 'woocommerce_mpay24cw_admin_add_shop_style_scripts');


function woocommerce_mpay24cw_meta_boxes(){
	global $post;
	if ($post->post_type != 'shop_order' && $post->post_type != 'shop_subscription') {
		return;
	}
	$transactions = Mpay24Cw_Util::getTransactionsByPostId($post->ID);
	if(empty($transactions)){
		$transactions = Mpay24Cw_Util::getTransactionsByOrderId($post->ID);
	}
	if (count($transactions) > 0) {
		add_meta_box('woocommerce-mpay24cw-information', 
				__('mPAY24 Transactions', 'woocommerce_mpay24cw'), 
				'woocommerce_mpay24cw_transactions', 'shop_order', 'normal', 'default');
	}
	
	// On the subscription page, just show related orders
	if (class_exists('WC_Subscriptions') && version_compare(WC_Subscriptions::$version, '2.0') >= 0) {
		if (wcs_is_subscription($post->ID)) {
			$intitialId = get_post_meta($post->ID, 'cwInitialTransactionRecurring', true);
			if(empty($intitialId)){
				$initialRecurring = get_post_meta($post->ID, 'cwCurrentInitialRecurring', true);
				if($initialRecurring == null) {
					$subscription = wcs_get_subscription( $post->ID);
					if ( false !== $subscription->order ) {
						$initialRecurring = $subscription->order->id;
					}
	
				}
				$transactions = Mpay24Cw_Util::getTransactionsByPostId($initialRecurring);
				if(empty($transactions)){
					$transactions = Mpay24Cw_Util::getTransactionsByOrderId($initialRecurring);
				}
				if (count($transactions) > 0) {
					add_meta_box('woocommerce-mpay24cw-information',
							__('mPAY24 Transactions', 'woocommerce_mpay24cw'),
							'woocommerce_mpay24cw_subscriptions', 'shop_subscription', 'normal', 'default');
				}
			}
			else{
				add_meta_box('woocommerce-mpay24cw-information',
						__('mPAY24 Transactions', 'woocommerce_mpay24cw'),
						'woocommerce_mpay24cw_subscriptions', 'shop_subscription', 'normal', 'default');
			}
			
			
			
		}
	}
	
}
add_action('add_meta_boxes', 'woocommerce_mpay24cw_meta_boxes');

function woocommerce_mpay24cw_transactions($post){
	$transactions = Mpay24Cw_Util::getTransactionsByPostId($post->ID);
	if(empty($transactions)){
		$transactions = Mpay24Cw_Util::getTransactionsByOrderId($post->ID);
	}
	
	echo '<table class="wp-list-table widefat table mpay24cw-transaction-table">';
	echo '<thead><tr>';
	echo '<th>#</th>';
	echo '<th>' . __('Transaction Number', 'woocommerce_mpay24cw') . '</th>';
	echo '<th>' . __('Date', 'woocommerce_mpay24cw') . '</th>';
	echo '<th>' . __('Payment Method', 'woocommerce_mpay24cw') . '</th>';
	echo '<th>' . __('Is Authorized', 'woocommerce_mpay24cw') . '</th>';
	echo '<th>' . __('Amount', 'woocommerce_mpay24cw') . '</th>';
	echo '<th>&nbsp;</th>';
	echo '</tr></thead>';
	
	foreach ($transactions as $transaction) {
		echo '<tr class="mpay24cw-main-row"  id="mpay24cw-main_row_' . $transaction->getTransactionId() . '">';
		echo '<td>' . $transaction->getTransactionId() . '</td>';
		echo '<td>' . $transaction->getTransactionExternalId() . '</td>';
		echo '<td>' . $transaction->getCreatedOn()->format("Y-m-d H:i:s") . '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != NULL) {
			echo $transaction->getTransactionObject()->getPaymentMethod()->getPaymentMethodDisplayName();
		}
		else {
			echo '--';
		}
		echo '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != NULL && $transaction->getTransactionObject()->isAuthorized()) {
			echo __('Yes');
		}
		else {
			echo __('No');
		}
		echo '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != NULL) {
			echo number_format($transaction->getTransactionObject()->getAuthorizationAmount(), 2);
		}
		else {
			echo '--';
		}
		echo '</td>';
		echo '<td>
				<a class="mpay24cw-more-details-button button">' . __('More Details', 'woocommerce_mpay24cw') . '</a>
				<a class="mpay24cw-less-details-button button">' . __('Less Details', 'woocommerce_mpay24cw') . '</a>
			</td>';
		echo '</tr>';
		echo '<tr class="mpay24cw-details-row" id="mpay24cw_details_row_' . $transaction->getTransactionId() . '">';
		echo '<td colspan="7">';
		echo '<div class="mpay24cw-box-labels">';
		if ($transaction->getTransactionObject() !== NULL) {
			foreach ($transaction->getTransactionObject()->getTransactionLabels() as $label) {
				echo '<div class="label-box">';
				echo '<div class="label-title">' . $label['label'] . ' ';
				if (isset($label['description']) && !empty($label['description'])) {
					echo woocommerce_mpay24cw_get_help_box($label['description']);
				}
				echo '</div>';
				echo '<div class="label-value">' . Customweb_Core_Util_Xml::escape($label['value']) . '</div>';
				echo '</div>';
			}
		}
		else {
			echo __("No more details available.", 'woocommerce_mpay24cw');
		}
		echo '</div>';
		
		if ($transaction->getTransactionObject() !== NULL) {
			$instructions = $transaction->getTransactionObject()->getPaymentInformation();
			if(!empty($instructions)){
				echo '<div class="mpay24cw-payment-information">';
				echo '<b>'.__('Payment Information', 'woocommerce_mpay24cw').'</b><br />';
				echo $instructions;
				echo '</div>';
			}
		}
		
		if ($transaction->getTransactionObject() !== NULL) {
			
			
			
			if ($transaction->getTransactionObject()->isCapturePossible()) {
				
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-mpay24cw_capture',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Capture</a></p>';
				echo '</div>';
			}
			
			
			if ($transaction->getTransactionObject()->isCancelPossible()) {
				echo '<div class="cancel-box box">';
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-mpay24cw_cancel',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Cancel</a></p>';
				echo '</div>';
			}
			
			
									
			if ($transaction->getTransactionObject()->isRefundPossible()) {
				echo '<div class="refund-box box">';
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-mpay24cw_refund',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Refund</a></p>';
				echo '</div>';
			}
			
			

			
			if (count($transaction->getTransactionObject()->getCaptures())) {
				echo '<div class="capture-history-box box">';
				echo '<h4>' . __('Captures', 'woocommerce_mpay24cw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Amount', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Status', 'woocommerce_mpay24cw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getCaptures() as $capture) {
					echo '<tr>';
					echo '<td>' . $capture->getCaptureDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $capture->getAmount() . '</td>';
					echo '<td>' . $capture->getStatus() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			
			

			
			if (count($transaction->getTransactionObject()->getRefunds())) {
				echo '<div class="refund-history-box box">';
				echo '<h4>' . __('Refunds', 'woocommerce_mpay24cw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Amount', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Status', 'woocommerce_mpay24cw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getRefunds() as $refund) {
					echo '<tr>';
					echo '<td>' . $refund->getRefundedDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $refund->getAmount() . '</td>';
					echo '<td>' . $refund->getStatus() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			
			

			if (count($transaction->getTransactionObject()->getHistoryItems())) {
				echo '<div class="previous-actions box">';
				echo '<h4>' . __('Previous Actions', 'woocommerce_mpay24cw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Action', 'woocommerce_mpay24cw') . '</th>';
				echo '<th>' . __('Message', 'woocommerce_mpay24cw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getHistoryItems() as $historyItem) {
					echo '<tr>';
					echo '<td>' . $historyItem->getCreationDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $historyItem->getActionPerformed() . '</td>';
					echo '<td>' . $historyItem->getMessage() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	
	if (class_exists('WC_Subscriptions') && version_compare(WC_Subscriptions::$version, '2.0') < 0 && class_exists('WC_Subscriptions_Order') &&
			 WC_Subscriptions_Order::order_contains_subscription($post->ID)) {
		echo '<div class="mpay24cw-renewal">';
		echo '<span>' . __('Subscriptions: Add Manual Renewal', 'woocommerce_mpay24cw') . '</span>';
		echo ' <input type="submit" class="button button-primary tips" 
			name="mpay24cw_manual_renewal" 
			value="' . __('Add manual renewal', 'woocommerce_mpay24cw') . '" 
			data-tip="' . __(
				'A manual renewal debits the customer directly for this subscription. This by pass any time restriction of the automatic subscription plugin.', 
				'woocommerce_mpay24cw') . '" />';
		echo '</div>';
	}
	
}

function woocommerce_mpay24cw_subscriptions($post){

	if (class_exists('WC_Subscriptions') && version_compare(WC_Subscriptions::$version, '2.0') >= 0) {
		echo '<div class="mpay24cw-renewal">';
		echo '<span>' . __('Subscriptions: Add Manual Renewal', 'woocommerce_mpay24cw') . '</span>';
		echo ' <input type="submit" class="button button-primary tips"
			name="mpay24cw_manual_renewal"
			value="' . __('Add manual renewal', 'woocommerce_mpay24cw') . '"
					data-tip="' . __(
				'A manual renewal debits the customer directly for this subscription. This by pass any time restriction of the automatic subscription plugin.', 
				'woocommerce_mpay24cw') . '" />';
		echo '</div>';
	}

}


function woocommerce_mpay24cw_get_help_box($text){
		return '<img class="help_tip" data-tip="' . $text . '" src="' . Mpay24Cw_Util::getResourcesUrl('image/help.png') . '" height="16" width="16" />';
}

function woocommerce_mpay24cw_transactions_process($orderId, $post){
	if ($post->post_type == 'shop_order') {
		global $mpay24cw_processing;
		
		try {
			
			//The default payment methods get instanciated per wc_payment_gateways instance
			if (class_exists('WC_Payment_Gateways')) {
				//Method introduced in Woo 2.1
				if (method_exists('WC_Payment_Gateways', 'instance')) {
					WC_Payment_Gateways::instance();
				}
				//Only created instances once
				elseif (!isset($GLOBALS['woocommerce_cw_method_instances_created'])) {
					new WC_Payment_Gateways();
					$GLOBALS['woocommerce_cw_method_instances_created'] = true;
				}
			}
			
			

			if (isset($_POST['mpay24cw_manual_renewal']) && $mpay24cw_processing == NULL) {
				
				$mpay24cw_processing = true;
				
				$initialTransaction = Mpay24Cw_Util::getAuthorizedTransactionByPostId($orderId);
				if(empty($initialTransaction)){
					$initialTransaction = Mpay24Cw_Util::getAuthorizedTransactionByOrderId($orderId);
				}
				if ($initialTransaction === NULL) {
					throw new Exception("This order has no initial transaction, hence no new renewal can be created.");
				}
				$order = $initialTransaction->getOrder();
				$userId = $order->customer_user;
				$subscriptionKey = WC_Subscriptions_Manager::get_subscription_key($orderId);
				WC_Subscriptions_Payment_Gateways::gateway_scheduled_subscription_payment($userId, $subscriptionKey);
				global $mpay24cw_recurring_process_failure;
				if ($mpay24cw_recurring_process_failure === NULL) {
					woocommerce_mpay24cw_admin_show_message(
							__("Successfully add a manual renewal payment.", 'woocommerce_mpay24cw'), 'info');
				}
				else {
					woocommerce_mpay24cw_admin_show_message($mpay24cw_recurring_process_failure, 'error');
				}
			}
			
		}
		catch (Exception $e) {
			woocommerce_mpay24cw_admin_show_message($e->getMessage(), 'error');
		}
	}
}
add_action('save_post', 'woocommerce_mpay24cw_transactions_process', 1, 2);



function woocommerce_mpay24cw_subscriptions_process($subscription, $post){
	if ($post->post_type == 'shop_subscription') {
		global $mpay24cw_processing;
		
		try {
			
			//The default payment methods get instanciated per wc_payment_gateways instance
			if (class_exists('WC_Payment_Gateways')) {
				//Method introduced in Woo 2.1
				if (method_exists('WC_Payment_Gateways', 'instance')) {
					WC_Payment_Gateways::instance();
				}
				//Only created instances once
				elseif (!isset($GLOBALS['woocommerce_cw_method_instances_created'])) {
					new WC_Payment_Gateways();
					$GLOBALS['woocommerce_cw_method_instances_created'] = true;
				}
			}
			if (isset($_POST['mpay24cw_manual_renewal']) && $mpay24cw_processing == NULL) {
				
				$mpay24cw_processing = true;
				global $mpay24cw_recurring_process_failure;
				do_action('woocommerce_scheduled_subscription_payment', $subscription);
				if ($mpay24cw_recurring_process_failure === NULL) {
					woocommerce_mpay24cw_admin_show_message(
							__("Successfully add a manual renewal payment.", 'woocommerce_mpay24cw'), 'info');
				}
				else {
					woocommerce_mpay24cw_admin_show_message($mpay24cw_recurring_process_failure, 'error');
				}
			}
	
		}
		catch (Exception $e) {
			woocommerce_mpay24cw_admin_show_message($e->getMessage(), 'error');
		}
	}
}
add_action('save_post', 'woocommerce_mpay24cw_subscriptions_process', 1, 2);

