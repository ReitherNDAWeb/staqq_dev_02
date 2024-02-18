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

require_once 'Customweb/Mpay24/Method/DefaultMethod.php';
require_once 'Customweb/Mpay24/Method/Seamless/EPS/SubEPSEPS.php';
require_once 'Customweb/Mpay24/Method/Seamless/EPS/SubEPSInternational.php';
require_once 'Customweb/Mpay24/Method/Seamless/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 * @Method(paymentMethods={'Eps'})
 */
class Customweb_Mpay24_Method_Seamless_EPS_EPS extends Customweb_Mpay24_Method_Seamless_DefaultMethod {
	
	/** 
	 * @var Customweb_Mpay24_Method_Seamless_EPS_ISubEPS 
	 */
	private $submethod;
	
	/**
	 * @var string
	 */
	private $brand;
	
	public function __construct(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, Customweb_Mpay24_Configuration $config){
		parent::__construct($paymentMethod, $config);
		$this->brand = $this->getPaymentMethodConfigurationValue("epsbrand");
		if($this->brand == 'EPS') {
			$this->submethod = new Customweb_Mpay24_Method_Seamless_EPS_SubEPSEPS();
		} else {
			$this->submethod = new Customweb_Mpay24_Method_Seamless_EPS_SubEPSInternational();	
		}
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		return $this->submethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, $customerPaymentContext);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Mpay24_Method_Seamless_DefaultMethod::getPaymentElement()
	 */
	public function getPaymentElement(array $formData = array()){
		return $this->submethod->getPaymentElement($this->brand, $formData);
	}

}