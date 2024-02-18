<?php

require_once 'Mpay24Cw/BackendFormRenderer.php';
require_once 'Mpay24Cw/Util.php';
require_once 'Customweb/Form/Control/IEditableControl.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/IRefund.php';
require_once 'Customweb/Core/Http/ContextRequest.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICancel.php';
require_once 'Customweb/Form/Control/MultiControl.php';
require_once 'Customweb/Form.php';
require_once 'Customweb/Licensing/Mpay24Cw/License.php';
require_once 'Customweb/Payment/Authorization/DefaultInvoiceItem.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICapture.php';
require_once 'Customweb/IForm.php';



// Make sure we don't expose any info if called directly         		   	 	  	  	
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit();
}

// Add some CSS and JS for admin         		   	 	  	  	
function woocommerce_mpay24cw_admin_add_setting_styles_scripts(){
	wp_register_style('woocommerce_mpay24cw_admin_styles', plugins_url('resources/css/settings.css', __FILE__));
	wp_enqueue_style('woocommerce_mpay24cw_admin_styles');
	
	wp_register_script('woocommerce_mpay24cw_admin_js', plugins_url('resources/js/settings.js', __FILE__));
	wp_enqueue_script('woocommerce_mpay24cw_admin_js');
}
add_action('admin_init', 'woocommerce_mpay24cw_admin_add_setting_styles_scripts');

function woocommerce_mpay24cw_admin_notice_handler(){
	if (get_transient(get_current_user_id() . '_mpay24cw_am') !== false) {
		
		foreach (get_transient(get_current_user_id() . '_mpay24cw_am') as $message) {
			$cssClass = '';
			if (strtolower($message['type']) == 'error') {
				$cssClass = 'error';
			}
			else if (strtolower($message['type']) == 'info') {
				$cssClass = 'updated';
			}
			
			echo '<div class="' . $cssClass . '">';
			echo '<p>mPAY24: ' . $message['message'] . '</p>';
			echo '</div>';
		}
		delete_transient(get_current_user_id() . '_mpay24cw_am');
	}
}
add_action('admin_notices', 'woocommerce_mpay24cw_admin_notice_handler');

function woocommerce_mpay24cw_admin_show_message($message, $type){
	$existing = array();
	if (get_transient(get_current_user_id() . '_mpay24cw_am') === false) {
		$existing = get_transient(get_current_user_id() . '_mpay24cw_am');
	}
	$existing[] = array(
		'message' => $message,
		'type' => $type 
	);
	set_transient(get_current_user_id() . '_mpay24cw_am', $existing);
}

/**
 * Add the configuration menu
 */
function woocommerce_mpay24cw_menu(){
	add_menu_page('mPAY24', __('mPAY24', 'woocommerce_mpay24cw'), 
			'manage_woocommerce', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw_options');
	
	if (isset($_REQUEST['page']) && strpos($_REQUEST['page'], 'woocommerce-mpay24cw') !== false) {
		$container = Mpay24Cw_Util::createContainer();
		if ($container->hasBean('Customweb_Payment_BackendOperation_Form_IAdapter')) {
			$adapter = $container->getBean('Customweb_Payment_BackendOperation_Form_IAdapter');
			foreach ($adapter->getForms() as $form) {
				add_submenu_page('woocommerce-mpay24cw', 'mPAY24 ' . $form->getTitle(), $form->getTitle(), 
						'manage_woocommerce', 'woocommerce-mpay24cw' . $form->getMachineName(), 
						'woocommerce_mpay24cw_extended_options');
			}
		}
	}
	
	add_submenu_page(null, 'mPAY24 Capture', 'mPAY24 Capture', 'manage_woocommerce', 
			'woocommerce-mpay24cw_capture', 'woocommerce_mpay24cw_render_capture');
	add_submenu_page(null, 'mPAY24 Cancel', 'mPAY24 Cancel', 'manage_woocommerce', 
			'woocommerce-mpay24cw_cancel', 'woocommerce_mpay24cw_render_cancel');
	add_submenu_page(null, 'mPAY24 Refund', 'mPAY24 Refund', 'manage_woocommerce', 
			'woocommerce-mpay24cw_refund', 'woocommerce_mpay24cw_render_refund');
}
add_action('admin_menu', 'woocommerce_mpay24cw_menu');

function woocommerce_mpay24cw_render_cancel(){
	
	
	
	

	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = Mpay24Cw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		if (isset($post['cancel'])) {
			$adapter = Mpay24Cw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_ICancel');
			if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_ICancel)) {
				throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_ICancel' provided.");
			}
			
			try {
				$adapter->cancel($transaction->getTransactionObject());
				woocommerce_mpay24cw_admin_show_message(
						__("Successfully cancelled the transaction.", 'woocommerce_mpay24cw'), 'info');
			}
			catch (Exception $e) {
				woocommerce_mpay24cw_admin_show_message($e->getMessage(), 'error');
			}
			Mpay24Cw_Util::getEntityManager()->persist($transaction);
		}
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isCancelPossible()) {
			woocommerce_mpay24cw_admin_show_message(__('Cancel not possible', 'woocommerce_mpay24cw'), 'info');
			wp_redirect($url);
			exit();
		}
		if (isset($_GET['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="mpay24cw-line-item-grid" id="cancel-form">';
		echo '<table class="list">
				<tbody>';
		echo '<tr>
				<td class="left-align">' . __('Are you sure you want to cancel this transaction?', 'woocommerce_mpay24cw') . '</td>
			</tr>';
		echo '<tr>
				<td colspan="1" class="left-align"><a class="button" href="' . $url . '">' . __('No', 'woocommerce_mpay24cw') . '</a></td>
				<td colspan="1" class="right-align">
					<input class="button" type="submit" name="cancel" value="' . __('Yes', 'woocommerce_mpay24cw') . '" />
				</td>
			</tr>
								</tfoot>
			</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_mpay24cw_render_capture(){
	
	
	
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = Mpay24Cw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		
		if (isset($post['quantity'])) {
			
			$captureLineItems = array();
			$lineItems = $transaction->getTransactionObject()->getUncapturedLineItems();
			foreach ($post['quantity'] as $index => $quantity) {
				if (isset($post['price_including'][$index]) && floatval($post['price_including'][$index]) != 0) {
					$originalItem = $lineItems[$index];
					if ($originalItem->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
						$priceModifier = -1;
					}
					else {
						$priceModifier = 1;
					}
					$captureLineItems[$index] = new Customweb_Payment_Authorization_DefaultInvoiceItem($originalItem->getSku(), 
							$originalItem->getName(), $originalItem->getTaxRate(), $priceModifier * floatval($post['price_including'][$index]), 
							$quantity, $originalItem->getType());
				}
			}
			if (count($captureLineItems) > 0) {
				$adapter = Mpay24Cw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_ICapture');
				if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_ICapture)) {
					throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_ICapture' provided.");
				}
				
				$close = false;
				if (isset($post['close']) && $post['close'] == 'on') {
					$close = true;
				}
				try {
					$adapter->partialCapture($transaction->getTransactionObject(), $captureLineItems, $close);
					woocommerce_mpay24cw_admin_show_message(
							__("Successfully added a new capture.", 'woocommerce_mpay24cw'), 'info');
				}
				catch (Exception $e) {
					woocommerce_mpay24cw_admin_show_message($e->getMessage(), 'error');
				}
				Mpay24Cw_Util::getEntityManager()->persist($transaction);
			}
		}
		
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isPartialCapturePossible()) {
			woocommerce_mpay24cw_admin_show_message(__('Capture not possible', 'woocommerce_mpay24cw'), 'info');
			
			wp_redirect($url);
			exit();
		}
		if (isset($_GET['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="mpay24cw-line-item-grid" id="capture-form">';
		echo '<input type="hidden" id="mpay24cw-decimal-places" value="' .
				 Customweb_Util_Currency::getDecimalPlaces($transaction->getTransactionObject()->getCurrencyCode()) . '" />';
		echo '<input type="hidden" id="mpay24cw-currency-code" value="' . strtoupper($transaction->getTransactionObject()->getCurrencyCode()) .
				 '" />';
		echo '<table class="list">
					<thead>
						<tr>
						<th class="left-align">' . __('Name', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('SKU', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('Type', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('Tax Rate', 'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Quantity', 
				'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Total Amount (excl. Tax)', 'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Total Amount (incl. Tax)', 'woocommerce_mpay24cw') . '</th>
						</tr>
				</thead>
				<tbody>';
		foreach ($transaction->getTransactionObject()->getUncapturedLineItems() as $index => $item) {
			
			$amountExcludingTax = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			$amountIncludingTax = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$amountExcludingTax = $amountExcludingTax * -1;
				$amountIncludingTax = $amountIncludingTax * -1;
			}
			echo '<tr id="line-item-row-' . $index . '" class="line-item-row" data-line-item-index="' . $index, '" >
						<td class="left-align">' . $item->getName() . '</td>
						<td class="left-align">' . $item->getSku() . '</td>
						<td class="left-align">' . $item->getType() . '</td>
						<td class="left-align">' . round($item->getTaxRate(), 2) . ' %<input type="hidden" class="tax-rate" value="' . $item->getTaxRate() . '" /></td>
						<td class="right-align"><input type="text" class="line-item-quantity" name="quantity[' . $index . ']" value="' . $item->getQuantity() . '" /></td>
						<td class="right-align"><input type="text" class="line-item-price-excluding" name="price_excluding[' . $index . ']" value="' .
					 $amountExcludingTax . '" /></td>
						<td class="right-align"><input type="text" class="line-item-price-including" name="price_including[' . $index . ']" value="' .
					 $amountIncludingTax . '" /></td>
					</tr>';
		}
		echo '</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="right-align">' . __('Total Capture Amount', 'woocommerce_mpay24cw') . ':</td>
						<td id="line-item-total" class="right-align">' . Customweb_Util_Currency::formatAmount(
				$transaction->getTransactionObject()->getCapturableAmount(), $transaction->getTransactionObject()->getCurrencyCode()) .
				 strtoupper($transaction->getTransactionObject()->getCurrencyCode()) . '
					</tr>';
		
		if ($transaction->getTransactionObject()->isCaptureClosable()) {
			
			echo '<tr>
					<td colspan="7" class="right-align">
						<label for="close-transaction">' . __('Close transaction for further captures', 'woocommerce_mpay24cw') . '</label>
						<input id="close-transaction" type="checkbox" name="close" value="on" />
					</td>
				</tr>';
		}
		
		echo '<tr>
				<td colspan="2" class="left-align"><a class="button" href="' . $url . '">' . __('Back', 'woocommerce_mpay24cw') . '</a></td>
				<td colspan="5" class="right-align">
					<input class="button" type="submit" value="' . __('Capture', 'woocommerce_mpay24cw') . '" />
				</td>
			</tr>
			</tfoot>
			</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_mpay24cw_render_refund(){
	
	
	
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = Mpay24Cw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		
		if (isset($post['quantity'])) {
			
			$refundLineItems = array();
			$lineItems = $transaction->getTransactionObject()->getNonRefundedLineItems();
			foreach ($post['quantity'] as $index => $quantity) {
				if (isset($post['price_including'][$index]) && floatval($post['price_including'][$index]) != 0) {
					$originalItem = $lineItems[$index];
					if ($originalItem->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
						$priceModifier = -1;
					}
					else {
						$priceModifier = 1;
					}
					$refundLineItems[$index] = new Customweb_Payment_Authorization_DefaultInvoiceItem($originalItem->getSku(), 
							$originalItem->getName(), $originalItem->getTaxRate(), $priceModifier * floatval($post['price_including'][$index]), 
							$quantity, $originalItem->getType());
				}
			}
			if (count($refundLineItems) > 0) {
				$adapter = Mpay24Cw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_IRefund');
				if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_IRefund)) {
					throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_IRefund' provided.");
				}
				
				$close = false;
				if (isset($post['close']) && $post['close'] == 'on') {
					$close = true;
				}
				try {
					$adapter->partialRefund($transaction->getTransactionObject(), $refundLineItems, $close);
					woocommerce_mpay24cw_admin_show_message(
							__("Successfully added a new refund.", 'woocommerce_mpay24cw'), 'info');
				}
				catch (Exception $e) {
					woocommerce_mpay24cw_admin_show_message($e->getMessage(), 'error');
				}
				Mpay24Cw_Util::getEntityManager()->persist($transaction);
			}
		}
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isPartialRefundPossible()) {
			woocommerce_mpay24cw_admin_show_message(__('Refund not possible', 'woocommerce_mpay24cw'), 'info');
			wp_redirect($url);
			exit();
		}
		if (isset($query['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="mpay24cw-line-item-grid" id="refund-form">';
		echo '<input type="hidden" id="mpay24cw-decimal-places" value="' .
				 Customweb_Util_Currency::getDecimalPlaces($transaction->getTransactionObject()->getCurrencyCode()) . '" />';
		echo '<input type="hidden" id="mpay24cw-currency-code" value="' . strtoupper($transaction->getTransactionObject()->getCurrencyCode()) .
				 '" />';
		echo '<table class="list">
					<thead>
						<tr>
						<th class="left-align">' . __('Name', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('SKU', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('Type', 'woocommerce_mpay24cw') . '</th>
						<th class="left-align">' . __('Tax Rate', 'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Quantity', 
				'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Total Amount (excl. Tax)', 'woocommerce_mpay24cw') . '</th>
						<th class="right-align">' . __('Total Amount (incl. Tax)', 'woocommerce_mpay24cw') . '</th>
						</tr>
				</thead>
				<tbody>';
		foreach ($transaction->getTransactionObject()->getNonRefundedLineItems() as $index => $item) {
			$amountExcludingTax = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			$amountIncludingTax = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$amountExcludingTax = $amountExcludingTax * -1;
				$amountIncludingTax = $amountIncludingTax * -1;
			}
			echo '<tr id="line-item-row-' . $index . '" class="line-item-row" data-line-item-index="' . $index, '" >
					<td class="left-align">' . $item->getName() . '</td>
					<td class="left-align">' . $item->getSku() . '</td>
					<td class="left-align">' . $item->getType() . '</td>
					<td class="left-align">' . round($item->getTaxRate(), 2) . ' %<input type="hidden" class="tax-rate" value="' . $item->getTaxRate() . '" /></td>
					<td class="right-align"><input type="text" class="line-item-quantity" name="quantity[' . $index . ']" value="' . $item->getQuantity() . '" /></td>
					<td class="right-align"><input type="text" class="line-item-price-excluding" name="price_excluding[' . $index . ']" value="' .
					 $amountExcludingTax . '" /></td>
					<td class="right-align"><input type="text" class="line-item-price-including" name="price_including[' . $index . ']" value="' .
					 $amountIncludingTax . '" /></td>
				</tr>';
		}
		echo '</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="right-align">' . __('Total Refund Amount', 'woocommerce_mpay24cw') . ':</td>
						<td id="line-item-total" class="right-align">' . Customweb_Util_Currency::formatAmount(
				$transaction->getTransactionObject()->getRefundableAmount(), $transaction->getTransactionObject()->getCurrencyCode()) .
				 strtoupper($transaction->getTransactionObject()->getCurrencyCode()) . '
						</tr>';
		
		if ($transaction->getTransactionObject()->isRefundClosable()) {
			echo '<tr>
					<td colspan="7" class="right-align">
						<label for="close-transaction">' . __('Close transaction for further refunds', 'woocommerce_mpay24cw') . '</label>
						<input id="close-transaction" type="checkbox" name="close" value="on" />
					</td>
				</tr>';
		}
		
		echo '<tr>
				<td colspan="2" class="left-align"><a class="button" href="' . $url . '">' . __('Back', 'woocommerce_mpay24cw') . '</a></td>
				<td colspan="5" class="right-align">
					<input class="button" type="submit" value="' . __('Refund', 'woocommerce_mpay24cw') . '" />
				</td>
			</tr>
		</tfoot>
		</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_mpay24cw_extended_options(){
	$container = Mpay24Cw_Util::createContainer();
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$formName = substr($query['page'], strlen('woocommerce-mpay24cw'));
	
	$renderer = new Mpay24Cw_BackendFormRenderer();
	
	if ($container->hasBean('Customweb_Payment_BackendOperation_Form_IAdapter')) {
		$adapter = $container->getBean('Customweb_Payment_BackendOperation_Form_IAdapter');
		
		foreach ($adapter->getForms() as $form) {
			if ($form->getMachineName() == $formName) {
				$currentForm = $form;
				break;
			}
		}
		if ($currentForm === null) {
			if (isset($query['noheader'])) {
				require_once (ABSPATH . 'wp-admin/admin-header.php');
			}
			return;
		}
		
		if ($request->getMethod() == 'POST') {
			
			$pressedButton = null;
			$body = stripslashes_deep($request->getParsedBody());
			foreach ($form->getButtons() as $button) {
				
				if (array_key_exists($button->getMachineName(), $body['button'])) {
					$pressedButton = $button;
					break;
				}
			}
			$formData = array();
			foreach ($form->getElements() as $element) {
				$control = $element->getControl();
				if (!($control instanceof Customweb_Form_Control_IEditableControl)) {
					continue;
				}
				$dataValue = $control->getFormDataValue($body);
				if ($control instanceof Customweb_Form_Control_MultiControl) {
					foreach (woocommerce_mpay24cw_array_flatten($dataValue) as $key => $value) {
						$formData[$key] = $value;
					}
				}
				else {
					$nameAsArray = $control->getControlNameAsArray();
					if (count($nameAsArray) > 1) {
						$tmpArray = array(
							$nameAsArray[count($nameAsArray) - 1] => $dataValue 
						);
						$iterator = count($nameAsArray) - 2;
						while ($iterator > 0) {
							$tmpArray = array(
								$nameAsArray[$iterator] => $tmpArray 
							);
							$iterator--;
						}
						if (isset($formData[$nameAsArray[0]])) {
							$formData[$nameAsArray[0]] = array_merge_recursive($formData[$nameAsArray[0]], $tmpArray);
						}
						else {
							$formData[$nameAsArray[0]] = $tmpArray;
						}
					}
					else {
						$formData[$control->getControlName()] = $dataValue;
					}
				}
			}
			$adapter->processForm($currentForm, $pressedButton, $formData);
			wp_redirect(Customweb_Util_Url::appendParameters($request->getUrl(), $request->getParsedQuery()));
			die();
		}
		
		if (isset($query['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		$currentForm = null;
		foreach ($adapter->getForms() as $form) {
			if ($form->getMachineName() == $formName) {
				$currentForm = $form;
				break;
			}
		}
		
		if ($currentForm->isProcessable()) {
			$currentForm = new Customweb_Form($currentForm);
			$currentForm->setRequestMethod(Customweb_IForm::REQUEST_METHOD_POST);
			$currentForm->setTargetUrl(
					Customweb_Util_Url::appendParameters($request->getUrl(), 
							array_merge($request->getParsedQuery(), array(
								'noheader' => 'true' 
							))));
		}
		echo '<div class="wrap">';
		echo $renderer->renderForm($currentForm);
		echo '</div>';
	}
}

function woocommerce_mpay24cw_array_flatten($array){
	$return = array();
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$return = array_merge($return, woocommerce_mpay24cw_array_flatten($value));
		}
		else {
			$return[$key] = $value;
		}
	}
	return $return;
}

/**
 * Setup the configuration page with the callbacks to the configuration API.
 */
require_once 'Customweb/Licensing/Mpay24Cw/License.php';
Customweb_Licensing_Mpay24Cw_License::run('mg8nb8nidpj9gh1i');


/**
 * Register Settings
 */
function woocommerce_mpay24cw_admin_init(){
	add_settings_section('woocommerce_mpay24cw', 'mPAY24 Basics', 
			'woocommerce_mpay24cw_section_callback', 'woocommerce-mpay24cw');
	add_settings_field('woocommerce_mpay24cw_operation_mode', __("Operation Mode", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_operation_mode', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_operation_mode');
	
	add_settings_field('woocommerce_mpay24cw_merchant_id_test', __("Test Merchant ID", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_merchant_id_test', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_merchant_id_test');
	
	add_settings_field('woocommerce_mpay24cw_password_test', __("Test Password", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_password_test', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_password_test');
	
	add_settings_field('woocommerce_mpay24cw_merchant_id_live', __("Live Merchant ID", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_merchant_id_live', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_merchant_id_live');
	
	add_settings_field('woocommerce_mpay24cw_password_live', __("Live Password", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_password_live', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_password_live');
	
	add_settings_field('woocommerce_mpay24cw_order_id_schema', __("Transaction Number Prefix", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_order_id_schema', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_order_id_schema');
	
	add_settings_field('woocommerce_mpay24cw_order_description', __("Order Description", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_order_description', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_order_description');
	
	add_settings_field('woocommerce_mpay24cw_responsive_paypage', __("Dynamic Payment Page", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_responsive_paypage', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_responsive_paypage');
	
	add_settings_field('woocommerce_mpay24cw_ajax_form_style', __("Ajax Input Form Styling", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_ajax_form_style', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_ajax_form_style');
	
	add_settings_field('woocommerce_mpay24cw_review_input_form', __("Review Input Form", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_review_input_form', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_review_input_form');
	
	add_settings_field('woocommerce_mpay24cw_order_identifier', __("Order Identifier", 'woocommerce_mpay24cw'), 'woocommerce_mpay24cw_option_callback_order_identifier', 'woocommerce-mpay24cw', 'woocommerce_mpay24cw');
	register_setting('woocommerce-mpay24cw', 'woocommerce_mpay24cw_order_identifier');
	
	
}
add_action('admin_init', 'woocommerce_mpay24cw_admin_init');

function woocommerce_mpay24cw_section_callback(){}



function woocommerce_mpay24cw_option_callback_operation_mode() {
	echo '<select name="woocommerce_mpay24cw_operation_mode">';
		echo '<option value="test"';
		 if (get_option('woocommerce_mpay24cw_operation_mode', "test") == "test"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Test Mode", 'woocommerce_mpay24cw'). '</option>';
	echo '<option value="live"';
		 if (get_option('woocommerce_mpay24cw_operation_mode', "test") == "live"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Live Mode", 'woocommerce_mpay24cw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("If the test mode is selected the test account is used. Otherwise the configured account is used.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_merchant_id_test() {
	echo '<input type="text" name="woocommerce_mpay24cw_merchant_id_test" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_merchant_id_test', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Merchant ID for test mode (beginning with 9). The Merchant ID will be provided by mPAY24", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_password_test() {
	echo '<input type="text" name="woocommerce_mpay24cw_password_test" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_password_test', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("The password will be provided in the initial set up documents by mPAY24.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_merchant_id_live() {
	echo '<input type="text" name="woocommerce_mpay24cw_merchant_id_live" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_merchant_id_live', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Merchant ID for productive mode (beginning with 7) will be provided by mPAY24.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_password_live() {
	echo '<input type="text" name="woocommerce_mpay24cw_password_live" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_password_live', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("The password will be provided in the initial set up documents by mPAY24.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_order_id_schema() {
	echo '<input type="text" name="woocommerce_mpay24cw_order_id_schema" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_order_id_schema', '{id}'),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Here you can insert an order prefix. The prefix allows you to change the order number that is transmitted to mPAY24. The prefix must contain the tag {id}. It will then be replaced by the transaction number (e.g. order_{id}).", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_order_description() {
	echo '<input type="text" name="woocommerce_mpay24cw_order_description" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_order_description', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Here you can insert an order description. If the description contains the tag {id}, it will then be replaced by the transaction id. (e.g. name {id}).", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_responsive_paypage() {
	echo '<select name="woocommerce_mpay24cw_responsive_paypage">';
		echo '<option value="0"';
		 if (get_option('woocommerce_mpay24cw_responsive_paypage', "0") == "0"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Deactivated", 'woocommerce_mpay24cw'). '</option>';
	echo '<option value="1"';
		 if (get_option('woocommerce_mpay24cw_responsive_paypage', "0") == "1"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Activated", 'woocommerce_mpay24cw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("If activating this setting, the Payment Page adapts itself to the resolution of the screen. Smallest resolution of width: 300px. (Also suitable for mobile platforms)", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_ajax_form_style() {
	echo '<input type="text" name="woocommerce_mpay24cw_ajax_form_style" value="' . htmlspecialchars(get_option('woocommerce_mpay24cw_ajax_form_style', 'DEFAULT'),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("When using Ajax Authorization, a styling for the input form can be deposited for a merchant’s account at mPAY24. To create the styling the mPAY24 Designer should be used, which is located at https://test.mpay24.com/web/designer.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_review_input_form() {
	echo '<select name="woocommerce_mpay24cw_review_input_form">';
		echo '<option value="active"';
		 if (get_option('woocommerce_mpay24cw_review_input_form', "active") == "active"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Activate input form in review pane.", 'woocommerce_mpay24cw'). '</option>';
	echo '<option value="deactivate"';
		 if (get_option('woocommerce_mpay24cw_review_input_form', "active") == "deactivate"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Deactivate input form in review pane.", 'woocommerce_mpay24cw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Should the input form for credit card data rendered in the review pane? To work the user must have JavaScript activated. In case the browser does not support JavaScript a fallback is provided. This feature is not supported by all payment methods.", 'woocommerce_mpay24cw');
}

function woocommerce_mpay24cw_option_callback_order_identifier() {
	echo '<select name="woocommerce_mpay24cw_order_identifier">';
		echo '<option value="postid"';
		 if (get_option('woocommerce_mpay24cw_order_identifier', "ordernumber") == "postid"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Post ID of the order", 'woocommerce_mpay24cw'). '</option>';
	echo '<option value="ordernumber"';
		 if (get_option('woocommerce_mpay24cw_order_identifier', "ordernumber") == "ordernumber"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Order number", 'woocommerce_mpay24cw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Set which identifier should be sent to the payment service provider. If a plugin modifies the order number and can not guarantee it's uniqueness, select Post Id.", 'woocommerce_mpay24cw');
}

