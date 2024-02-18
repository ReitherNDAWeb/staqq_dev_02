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

require_once 'Customweb/Payment/Authorization/DefaultTransactionCapture.php';

class Customweb_Mpay24_Authorization_TransactionCapture extends Customweb_Payment_Authorization_DefaultTransactionCapture {
	
	/**
	 *
	 * @var double
	 */
	private $refundedAmount = 0;
	
	/**
	 * 
	 * @var string
	 */
	private $stateId = null;
	
	/**
	 * @return string
	 */
	public function getStateId() {
		return $this->stateId;
	}
	
	/**
	 * 
	 * @param string $stateId
	 * @return string
	 */
	public function setStateId($stateId) {
		$this->stateId = $stateId;
		return $this;
	}

	/**
	 *
	 * @return double
	 */
	public function getRefundedAmount(){
		return $this->refundedAmount;
	}

	/**
	 *
	 * @param double $refundedAmount
	 * @return Customweb_Mpay24_Authorization_TransactionCapture
	 */
	public function setRefundedAmount($refundedAmount){
		$this->refundedAmount = $refundedAmount;
		return $this;
	}
}