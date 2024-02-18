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
require_once 'Customweb/Mpay24/Method/OpenInvoice/BillpayPaymentInformationProvider.php';
require_once 'Customweb/Mpay24/Method/OpenInvoice/DefaultMethod.php';



/**
 *
 * @author Bjoern Hasselmann
 * @Method(paymentMethods={'OpenInvoice'}, processors={'Billpay'})
 */
class Customweb_Mpay24_Method_OpenInvoice_Billpay extends Customweb_Mpay24_Method_OpenInvoice_DefaultMethod {
	
	/**
	 * Overridden
	 * @see Customweb_Mpay24_Method_DefaultMethod::getPaymentInformationProvider()
	 */
	public function getPaymentInformationProvider() {
		return new Customweb_Mpay24_Method_OpenInvoice_BillpayPaymentInformationProvider();
	}
	
}