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
require_once 'Customweb/Form/Renderer.php';
require_once 'Customweb/Payment/Authorization/IPaymentMethod.php';
require_once 'Mpay24Cw/Util.php';
require_once 'Mpay24Cw/ConfigurationAdapter.php';
require_once 'Customweb/Payment/Authorization/Widget/IAdapter.php';
require_once 'Customweb/Util/Html.php';
require_once 'Mpay24Cw/CartOrderContext.php';
require_once 'Customweb/Payment/Authorization/Server/IAdapter.php';
require_once 'Customweb/Payment/Authorization/Hidden/IAdapter.php';
require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Mpay24Cw/TransactionContext.php';
require_once 'Customweb/Payment/Authorization/Ajax/IAdapter.php';
require_once 'Mpay24Cw/Entity/Transaction.php';
require_once 'Mpay24Cw/OrderContext.php';
require_once 'Mpay24Cw/PaymentMethodWrapper.php';
require_once 'Mpay24Cw/PaymentGatewayProxy.php';
require_once 'Customweb/Payment/Authorization/PaymentPage/IAdapter.php';



/**
 *         		   	 	  	  	
 * This class handlers the main payment interaction with the
 * Mpay24Cw server.
 */
abstract class Mpay24Cw_AbstractPaymentMethod extends Mpay24Cw_PaymentGatewayProxy implements 
		Customweb_Payment_Authorization_IPaymentMethod {
	public $class_name;
	public $id;
	public $title;
	public $chosen;
	public $has_fields = FALSE;
	public $countries;
	public $availability;
	public $enabled = 'no';
	public $icon;
	public $description;
	private $isCartTotalCalculated = FALSE;

	public function __construct(){
		$this->class_name = substr(get_class($this), 0, 39);
		
		$this->id = $this->class_name;
		$this->method_title = $this->admin_title;
		
		parent::__construct();
		
		$title = $this->getPaymentMethodConfigurationValue('title');
		if (!empty($title)) {
			$this->title = $title;
		}
		
		$this->description = $this->getPaymentMethodConfigurationValue('description');
	}

	public function getPaymentMethodName(){
		return $this->machineName;
	}

	public function getPaymentMethodDisplayName(){
		return $this->title;
	}

	public function receipt_page($order){}

	public function getBackendDescription(){
		return __('The configuration values for mPAY24 can be set under:', 'woocommerce_mpay24cw') .
				 ' <a href="options-general.php?page=woocommerce-mpay24cw">' .
				 __('mPAY24 Settings', 'woocommerce_mpay24cw') . '</a>';
	}

	public function isAliasManagerActive(){
		$result = false;
		
		$result = ($this->getPaymentMethodConfigurationValue('alias_manager') == 'active');
		
		return $result;
	}

	public function getCurrentSelectedAlias(){
		$aliasTransactionId = null;
		
		if (isset($_REQUEST[$this->getAliasHTMLFieldName()])) {
			$aliasTransactionId = $_REQUEST[$this->getAliasHTMLFieldName()];
		}
		else if (isset($_POST['post_data'])) {
			parse_str($_POST['post_data'], $data);
			if (isset($data[$this->getAliasHTMLFieldName()])) {
				$aliasTransactionId = $data[$this->getAliasHTMLFieldName()];
			}
		}
		
		return $aliasTransactionId;
	}

	protected function showError($errorMessage){
		echo '<div class="woocommerce-error">' . $errorMessage . '</div>';
		die();
	}
	
	public function processShopPayment($orderPostId, $aliasTransactionId = NULL, $failedTransactionId = NULL, $failedValidate = null){
		require_once 'Customweb/Licensing/Mpay24Cw/License.php';
		$arguments = array(
			'aliasTransactionId' => $aliasTransactionId,
 			'failedTransactionId' => $failedTransactionId,
 			'orderPostId' => $orderPostId,
 			'failedValidate' => $failedValidate,
 		);
		return Customweb_Licensing_Mpay24Cw_License::run('552v5ad9o788odq7', $this, $arguments);
	}

	final public function call_8njku99dspt8iunq() {
		$arguments = func_get_args();
		$method = $arguments[0];
		$call = $arguments[1];
		$parameters = array_slice($arguments, 2);
		if ($call == 's') {
			return call_user_func_array(array(get_class($this), $method), $parameters);
		}
		else {
			return call_user_func_array(array($this, $method), $parameters);
		}
		
		
	}
	
	
	public function processTransaction($orderPostId, $aliasTransactionId = NULL){
		require_once 'Customweb/Licensing/Mpay24Cw/License.php';
		$arguments = array(
			'aliasTransactionId' => $aliasTransactionId,
 			'orderPostId' => $orderPostId,
 		);
		return Customweb_Licensing_Mpay24Cw_License::run('jn9du99h2cgb4d2c', $this, $arguments);
	}

	final public function call_mcod9t8k2psjdv1b() {
		$arguments = func_get_args();
		$method = $arguments[0];
		$call = $arguments[1];
		$parameters = array_slice($arguments, 2);
		if ($call == 's') {
			return call_user_func_array(array(get_class($this), $method), $parameters);
		}
		else {
			return call_user_func_array(array($this, $method), $parameters);
		}
		
		
	}
	

	
	/**
	 *
	 * @return Mpay24Cw_CartOrderContext
	 */
	protected function getCartOrderContext(){
		if (!isset($_POST['post_data'])) {
			return null;
		}
		
		parse_str($_POST['post_data'], $data);
		
		return new Mpay24Cw_CartOrderContext($data, new Mpay24Cw_PaymentMethodWrapper($this));
	}

	public function payment_fields(){
		parent::payment_fields();
		
		
		if ($this->isAliasManagerActive()) {
			$userId = get_current_user_id();
			$aliases = Mpay24Cw_Util::getAliasTransactions($userId, $this->getPaymentMethodName());
			
			if (count($aliases) > 0) {
				$selectedAlias = $this->getCurrentSelectedAlias();
				
				echo '<div class="mpay24cw-alias-input-box"><div class="alias-field-description">' .
						 __('You can choose a previous used card:', 'woocommerce_mpay24cw') . '</div>';
				echo '<select name="' . $this->getAliasHTMLFieldName() . '">';
				echo '<option value="new"> -' . __('Select card', 'woocommerce_mpay24cw') . '- </option>';
				foreach ($aliases as $aliasTransaction) {
					echo '<option value="' . $aliasTransaction->getTransactionId() . '"';
					if ($selectedAlias == $aliasTransaction->getTransactionId()) {
						echo ' selected="selected" ';
					}
					echo '>' . $aliasTransaction->getAliasForDisplay() . '</option>';
				}
				echo '</select></div>';
			}
			else {
				echo '<div class="mpay24cw-alias-hidden-new"><input type="hidden" name="' . $this->getAliasHTMLFieldName() .
						 '" value="new" /></div>';
			}
		}
		
		

		$orderContext = $this->getCartOrderContext();
		if ($orderContext !== null) {
			$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
			$aliasTransactionObject = null;
			
			if ($this->isAliasManagerActive()) {
				$aliasTransactionObject = "new";
				$selectedAlias = $this->getCurrentSelectedAlias();
				if ($selectedAlias !== null) {
					$aliasTransaction = Mpay24Cw_Util::getTransactionById($selectedAlias);
					if ($aliasTransaction !== null && $aliasTransaction->getCustomerId() == get_current_user_id()) {
						$aliasTransactionObject = $aliasTransaction->getTransactionObject();
					}
				}
			}
			
			
			echo $this->getReviewFormFields($orderContext, $aliasTransactionObject);
		}
	}
	
	
	public function getAliasHTMLFieldName(){
		return 'mpay24cw_alias_' . $this->getPaymentMethodName();
	}
	
	public function has_fields(){
		$fields = parent::has_fields();
		
		if ($this->isAliasManagerActive()) {
			$userId = get_current_user_id();
			$aliases = Mpay24Cw_Util::getAliasTransactions($userId, $this->getPaymentMethodName());
			
			if (count($aliases) > 0) {
				return true;
			}
		}
		
		$orderContext = $this->getCartOrderContext();
		if ($orderContext !== null) {
			$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
			$aliasTransactionObject = null;
			
			if ($this->isAliasManagerActive()) {
				$aliasTransactionObject = "new";
				$selectedAlias = $this->getCurrentSelectedAlias();
				if ($selectedAlias !== null) {
					$aliasTransaction = Mpay24Cw_Util::getTransactionById($selectedAlias);
					if ($aliasTransaction !== null && $aliasTransaction->getCustomerId() == get_current_user_id()) {
						$aliasTransactionObject = $aliasTransaction->getTransactionObject();
					}
				}
			}
			
			$generated = $this->getReviewFormFields($orderContext, $aliasTransactionObject);
			if (!empty($generated)) {
				return true;
			}
		}
		return $fields;
	}

	/**
	 * This function creates a new Transaction
	 *
	 * @param Mpay24Cw_OrderContext $order
	 * @return Mpay24Cw_Entity_Transaction
	 */
	public function newDatabaseTransaction(Mpay24Cw_OrderContext $orderContext){
		$dbTransaction = new Mpay24Cw_Entity_Transaction();
		
		$this->destroyCheckoutId();
		
		$dbTransaction->setPostId($orderContext->getOrderPostId())->setOrderId($orderContext->getOrderNumber())->setCustomerId($orderContext->getCustomerId())->setPaymentClass(get_class($this))->setPaymentMachineName(
				$this->getPaymentMethodName());
		Mpay24Cw_Util::getEntityManager()->persist($dbTransaction);
		return $dbTransaction;
	}

	/**
	 * This function creates a new Transaction and transaction object and persists them in the DB
	 *
	 * @param Mpay24Cw_OrderContext $orderContext
	 * @param Customweb_Payment_Authorization_ITransactionContext | null $aliasTransaction
	 * @param Customweb_Payment_Authorization_ITransactionContext |null $failedTransaction
	 * @return Mpay24Cw_Entity_Transaction
	 */
	public function prepare(Mpay24Cw_OrderContext $orderContext, $aliasTransaction = null, $failedTransaction = null){
		$dbTransaction = $this->newDatabaseTransaction($orderContext);
		$transactionContext = $this->newTransactionContext($dbTransaction, $orderContext, $aliasTransaction);
		$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
		$transaction = $adapter->createTransaction($transactionContext, $failedTransaction);
		$dbTransaction->setTransactionObject($transaction);
		return Mpay24Cw_Util::getEntityManager()->persist($dbTransaction);
	}

	public function newTransactionContext(Mpay24Cw_Entity_Transaction $dbTransaction, $orderContext, $aliasTransaction = null){
		return new Mpay24Cw_TransactionContext($dbTransaction, $orderContext, $aliasTransaction);
	}

	/**
	 * This method generates a HTML form for each payment method.
	 */
	public function createMethodFormFields(){
		return array(
			'enabled' => array(
				'title' => __('Enable/Disable', 'woocommerce_mpay24cw'),
				'type' => 'checkbox',
				'label' => sprintf(__('Enable %s', 'woocommerce_mpay24cw'), $this->admin_title),
				'default' => 'no' 
			),
			'title' => array(
				'title' => __('Title', 'woocommerce_mpay24cw'),
				'type' => 'text',
				'description' => __('This controls the title which the user sees during checkout.', 'woocommerce_mpay24cw'),
				'default' => __($this->title, 'woocommerce_mpay24cw') 
			),
			'description' => array(
				'title' => __('Description', 'woocommerce_mpay24cw'),
				'type' => 'textarea',
				'description' => __('This controls the description which the user sees during checkout.', 'woocommerce_mpay24cw'),
				'default' => sprintf(
						__("Pay with %s over the interface of mPAY24.", 'woocommerce_mpay24cw'), 
						$this->title) 
			),
			'min_total' => array(
				'title' => __('Minimal Order Total', 'woocommerce_mpay24cw'),
				'type' => 'text',
				'description' => __(
						'Set here the minimal order total for which this payment method is available. If it is set to zero, it is always available.', 
						'woocommerce_mpay24cw'),
				'default' => 0 
			),
			'max_total' => array(
				'title' => __('Maximal Order Total', 'woocommerce_mpay24cw'),
				'type' => 'text',
				'description' => __(
						'Set here the maximal order total for which this payment method is available. If it is set to zero, it is always available.', 
						'woocommerce_mpay24cw'),
				'default' => 0 
			) 
		);
	}

	protected function getOrderStatusOptions($statuses = array()){
		$terms = get_terms('shop_order_status', array(
			'hide_empty' => 0,
			'orderby' => 'id' 
		));
		
		foreach ($statuses as $k => $value) {
			$statuses[$k] = __($value, 'woocommerce_mpay24cw');
		}
		
		foreach ($terms as $term) {
			$statuses[$term->slug] = $term->name;
		}
		return $statuses;
	}

	protected function getReviewFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction){
		if (Mpay24Cw_ConfigurationAdapter::isReviewFormInputActive()) {
			$paymentContext = Mpay24Cw_Util::getPaymentCustomerContext($orderContext->getCustomerId());
			$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
			$fields = array();
			if (method_exists($adapter, 'getVisibleFormFields')) {
				$fields = $adapter->getVisibleFormFields($orderContext, $aliasTransaction, null, $paymentContext);
			}
			Mpay24Cw_Util::persistPaymentCustomerContext($paymentContext);
			
			$result = '<div class="mpay24cw-preview-fields';
			if (!($adapter instanceof Customweb_Payment_Authorization_Ajax_IAdapter ||
					 $adapter instanceof Customweb_Payment_Authorization_Hidden_IAdapter)) {
				$result .= ' mpay24cw-validate';
			}
			$result .= '">';
			
			$result .= $this->getCompatibilityFormFields();
			
			if ($fields !== null && count($fields) > 0) {
				$renderer = new Customweb_Form_Renderer();
				$renderer->setRenderOnLoadJs(false);
				$renderer->setNameSpacePrefix('mpay24cw_' . $orderContext->getPaymentMethod()->getPaymentMethodName());
				$renderer->setCssClassPrefix('mpay24cw-');
				
				$result .= $renderer->renderElements($fields) . '</div>';
			}
			else {
				$result .= '</div>';
			}
			return $result;
		}
		
		return '';
	}

	public function getFormActionUrl(Mpay24Cw_OrderContext $orderContext){
		$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
		$identifiers = array(
			'cwoid' => $orderContext->getOrderPostId(),
			'cwot' => Mpay24Cw_Util::computeOrderValidationHash($orderContext->getOrderPostId()) 
		);
		if ($adapter instanceof Customweb_Payment_Authorization_Iframe_IAdapter) {
			return Mpay24Cw_Util::getPluginUrl('iframe', $identifiers);
		}
		if ($adapter instanceof Customweb_Payment_Authorization_Widget_IAdapter) {
			return Mpay24Cw_Util::getPluginUrl('widget', $identifiers);
		}
		if ($adapter instanceof Customweb_Payment_Authorization_PaymentPage_IAdapter) {
			return Mpay24Cw_Util::getPluginUrl('redirection', $identifiers);
		}
		if ($adapter instanceof Customweb_Payment_Authorization_Server_IAdapter) {
			return Mpay24Cw_Util::getPluginUrl('authorize', $identifiers);
		}
	}

	protected function getCheckoutFormVaiables(Mpay24Cw_OrderContext $orderContext, $aliasTransaction, $failedTransaction){
		$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
		
		$visibleFormFields = array();
		if (method_exists($adapter, 'getVisibleFormFields')) {
			
			$customerContext = Mpay24Cw_Util::getPaymentCustomerContext($orderContext->getCustomerId());
			$visibleFormFields = $adapter->getVisibleFormFields($orderContext, $aliasTransaction, $failedTransaction, $customerContext);
			Mpay24Cw_Util::persistPaymentCustomerContext($customerContext);
		}
		
		$html = '';
		if ($visibleFormFields !== null && count($visibleFormFields) > 0) {
			$renderer = new Customweb_Form_Renderer();
			$renderer->setCssClassPrefix('mpay24cw-');
			$html = $renderer->renderElements($visibleFormFields);
		}
		
		if ($adapter instanceof Customweb_Payment_Authorization_Ajax_IAdapter) {
			$dbTransaction = $this->prepare($orderContext, $aliasTransaction, $failedTransaction);
			$ajaxScriptUrl = $adapter->getAjaxFileUrl($dbTransaction->getTransactionObject());
			$callbackFunction = $adapter->getJavaScriptCallbackFunction($dbTransaction->getTransactionObject());
			Mpay24Cw_Util::getEntityManager()->persist($dbTransaction);
			return array(
				'visible_fields' => $html,
				'template_file' => 'payment_confirmation_ajax',
				'ajaxScriptUrl' => (string) $ajaxScriptUrl,
				'submitCallbackFunction' => $callbackFunction 
			);
		}
		
		if ($adapter instanceof Customweb_Payment_Authorization_Hidden_IAdapter) {
			$dbTransaction = $this->prepare($orderContext, $aliasTransaction, $failedTransaction);
			$formActionUrl = $adapter->getFormActionUrl($dbTransaction->getTransactionObject());
			$hiddenFields = Customweb_Util_Html::buildHiddenInputFields($adapter->getHiddenFormFields($dbTransaction->getTransactionObject()));
			Mpay24Cw_Util::getEntityManager()->persist($dbTransaction);
			return array(
				'form_target_url' => $formActionUrl,
				'hidden_fields' => $hiddenFields,
				'visible_fields' => $html,
				'template_file' => 'payment_confirmation' 
			);
		}
		
		return array(
			'form_target_url' => $this->getFormActionUrl($orderContext),
			'visible_fields' => $html,
			'template_file' => 'payment_confirmation' 
		);
	}

	public function validate(array $formData){
		$orderContext = new Mpay24Cw_CartOrderContext($formData, new Mpay24Cw_PaymentMethodWrapper($this));
		$paymentContext = Mpay24Cw_Util::getPaymentCustomerContext($orderContext->getCustomerId());
		$adapter = Mpay24Cw_Util::getAuthorizationAdapterByContext($orderContext);
		
		// Validate transaction
		$errorMessage = null;
		try {
			if (Mpay24Cw_ConfigurationAdapter::isReviewFormInputActive() && isset($_REQUEST['mpay24cw-preview-fields'])) {
				$adapter->validate($orderContext, $paymentContext, $formData);
			}
		}
		catch (Exception $e) {
			$errorMessage = $e->getMessage();
		}
		Mpay24Cw_Util::persistPaymentCustomerContext($paymentContext);
		
		if ($errorMessage !== null) {
			throw new Exception($errorMessage);
		}
	}

	protected abstract function getCompatibilityFormFields();
	
	
	protected abstract function destroyCheckoutId();
}
