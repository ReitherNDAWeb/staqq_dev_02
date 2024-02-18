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

require_once 'Customweb/Payment/Authorization/IPaymentMethod.php';
require_once 'Mpay24Cw/Util.php';


class Mpay24Cw_PaymentMethodWrapper implements Customweb_Payment_Authorization_IPaymentMethod {
	
	private $paymentClass;
	private $paymentMethodName = "";
	private $paymentMethodDisplayName = "";
	
	/**
	 * @var Mpay24Cw_PaymentMethod
	 */
	private $method = null;
	
	public function __construct(Mpay24Cw_PaymentMethod $method) {
		$this->paymentClass = get_class($method);
		$this->method = $method;
		$this->paymentMethodDisplayName = $method->getPaymentMethodDisplayName();
		$this->paymentMethodName = $this->getPaymentMethodName();
	}
	
	public function getPaymentMethodName() {
		if ($this->getMethod() != null) {
			return $this->getMethod()->getPaymentMethodName();
		}
		else {
			return $this->paymentMethodName;
		}
	}
	
	public function getPaymentMethodDisplayName() {
		if ($this->getMethod() != null) {
			return $this->getMethod()->getPaymentMethodDisplayName();
		}
		else {
			return $this->paymentMethodDisplayName;
		}
	}
	
	public function existsPaymentMethodConfigurationValue($key, $languageCode = null) {
		if ($languageCode !== null) {
			$languageCode = (string) $languageCode;
		}
		return $this->getMethod()->existsPaymentMethodConfigurationValue($key, $languageCode);
	}
	
	public function getPaymentMethodConfigurationValue($key, $languageCode = null) {
		if ($languageCode !== null) {
			$languageCode = (string)$languageCode;
		}
		if ($this->getMethod() != null) {
			return $this->getMethod()->getPaymentMethodConfigurationValue($key, $languageCode);
		}
		else {
			return "";
		}
	}
	
	public function __sleep() {
		return array('paymentClass', 'paymentMethodDisplayName', 'paymentMethodName');
	}
	
	public function __wakeup() {
	}
	
	/**
	 * @return  Mpay24Cw_PaymentMethod
	 */
	protected function getMethod() {
		if ($this->method === null) {
			$paymentMethod = $this->paymentClass;
			Mpay24Cw_Util::includePaymentMethod($paymentMethod);
			$this->method = new $paymentMethod();
		}
		return $this->method;
	}
	
	public function isAliasManagerActive() {
		return $this->getMethod()->isAliasManagerActive();
	}
	
}
	