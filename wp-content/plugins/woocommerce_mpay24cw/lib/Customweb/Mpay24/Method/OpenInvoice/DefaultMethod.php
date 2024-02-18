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

require_once 'Customweb/Mpay24/Stubs/PaymentBrandType.php';
require_once 'Customweb/Mpay24/Stubs/PaymentTypeType.php';
require_once 'Customweb/Mpay24/Stubs/Order/PaymentTypes/Payment.php';
require_once 'Customweb/Mpay24/Method/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Method(paymentMethods={'OpenInvoice'})
 */
class Customweb_Mpay24_Method_OpenInvoice_DefaultMethod extends Customweb_Mpay24_Method_DefaultMethod {

	public function prepareOrderObject(Customweb_Mpay24_Stubs_Order $order, Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$parameter = $this->getPaymentMethodParameters();
		$payment = new Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment();
		$payment->setType(Customweb_Mpay24_Stubs_PaymentTypeType::_()->set($this->getPaymentMethodConfigurationValue('processor')));
		$payment->setBrand(Customweb_Mpay24_Stubs_PaymentBrandType::_()->set($parameter['brand']));
		$order->setPaymentTypes($this->createPaymentTypes($payment));
	}
}