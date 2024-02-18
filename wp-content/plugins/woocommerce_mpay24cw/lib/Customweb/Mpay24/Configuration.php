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
require_once 'Customweb/Core/Exception/InvalidPatternException.php';
require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Bean
 */
final class Customweb_Mpay24_Configuration {
	
	const SHOP_SYSTEM_TAG = "cw:WooCommerce";
	
	/**
	 *
	 * @var Customweb_Payment_IConfigurationAdapter
	 */
	private $configurationAdapter = null;

	public function __construct(Customweb_Payment_IConfigurationAdapter $configurationAdapter){
		$this->configurationAdapter = $configurationAdapter;
	}

	/**
	 *
	 * @return Customweb_Payment_IConfigurationAdapter
	 */
	public function getConfigurationAdapter(){
		return $this->configurationAdapter;
	}
	
	public function getTransactionNumberSchema() {
		return $this->configurationAdapter->getConfigurationValue('order_id_schema');
	}

	public function getMerchantId(){
		$mid = "";
		if ($this->isTestMode()) {
			$mid = $this->configurationAdapter->getConfigurationValue('merchant_id_test');
		}
		else {
			$mid = $this->configurationAdapter->getConfigurationValue('merchant_id_live');
		}
		return $this->checkTextField("Merchant ID", $mid);
	}

	public function getEndpointUrl(){
		if ($this->isTestMode()) {
			return $this->getTestUrl();
		}
		else {
			return $this->getLiveUrl();
		}
	}
	
	public function getLiveUrl(){
		return 'https://www.mpay24.com/app/bin/etpproxy_v15';
	}
	
	public function getTestUrl(){
		return 'https://test.mpay24.com/app/bin/etpproxy_v15';
	}

	public function isTestMode(){
		return $this->getConfigurationAdapter()->getConfigurationValue('operation_mode') == 'test';
	}

	public function getPortAtPsp(){
		return array(
			443 
		);
	}

	public function getPortAtMerchant(){
		return array(
			80,
			443 
		);
	}

	public function getIpFromMerchantToPsp(){
		if ($this->isTestMode()) {
			return '213.164.23.169';
		}
		else {
			return '213.164.25.234';
		}
	}

	public function getIpFromPspToMerchant(){
		if ($this->isTestMode()) {
			return '213.164.25.245';
		}
		else {
			return '213.164.23.169';
		}
	}

	public function getUserName(){
		return 'u' . $this->getMerchantId();
	}

	public function getPassword(){
		$pw = "";
		if($this->isTestMode()){
			$pw = $this->configurationAdapter->getConfigurationValue('password_test');
		} else {
			$pw = $this->configurationAdapter->getConfigurationValue('password_live');
		}
		return $pw;
	}
	
	public function getAjaxFormStyle() {
		return $this->configurationAdapter->getConfigurationValue('ajax_form_style');
	}
	
	public function getOrderDescription(){
		return $this->configurationAdapter->getConfigurationValue('order_description');
	}
	
	/**
	 * Sets the update schedule to the next execution date specified
	 * by the update configuration value.
	 * Does nothing if no update interval is specified.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function callUpdateService(Customweb_Payment_Authorization_ITransaction $transaction){
		$hours = $transaction->getPaymentMethod()->getPaymentMethodConfigurationValue('update');
		if (!$hours)
			return;
		$date = new Customweb_Core_DateTime();
		$date = $date->addHours($hours);
		$transaction->setUpdateExecutionDate($date);
	}
	
	/**
	 * Trims given string and checks if it's empty
	 * 
	 * @param string $name
	 * @param string value
	 * @throws Customweb_Core_Exception_InvalidPatternException
	 */
	private function checkTextField($name, $value){
		$value = trim($value);
		if(empty($value)){
			throw new Customweb_Core_Exception_InvalidPatternException(Customweb_I18n_Translation::__("No @name found in settings", array( "@name" => $name)));
		} 
		return $value;
	}
}