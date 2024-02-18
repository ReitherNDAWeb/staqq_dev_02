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

require_once 'Customweb/Xml/Binding/DateHandler/Date.php';
require_once 'Customweb/Util/String.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Core/Number.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
abstract class Customweb_Mpay24_AbstractParameterBuilder {
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_IOrderContext
	 */
	protected $orderContext;
	/**
	 *
	 * @var Customweb_Payment_Authorization_ITransactionContext
	 */
	protected $transactionContext;
	/**
	 *
	 * @var Customweb_Mpay24_Authorization_Transaction
	 */
	protected $transaction;
	
	/**
	 *
	 * @var Customweb_DependencyInjection_IContainer
	 */
	protected $container = null;
	
	/**
	 *
	 * @var Customweb_Mpay24_Configuration
	 */
	protected $configuration = null;
	
	/**
	 *
	 * @var Customweb_Mpay24_Method_Factory
	 */
	protected $paymentMethodFactory = null;

	public function __construct(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){
		$this->transactionContext = $transaction->getTransactionContext();
		$this->orderContext = $this->transactionContext->getOrderContext();
		$this->transaction = $transaction;
		$this->container = $container;
		$this->configuration = $container->getBean('Customweb_Mpay24_Configuration');
		$this->paymentMethodFactory = $container->getBean('Customweb_Mpay24_Method_Factory');
	}

	/**
	 * Returns the amount in cents corresponding to its currency
	 *
	 * @param number $value
	 * @return Customweb_Core_Number
	 */
	public final function formatAmount($value, $decimalSeparator = '.'){
		return new Customweb_Core_Number($value, Customweb_Util_Currency::getDecimalPlaces($this->orderContext->getCurrencyCode()), $decimalSeparator, 
				'');
	}

	/**
	 * This method formats the name corresponding to the mPAY24 specification
	 * including length check
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return string
	 */
	protected final function formatName(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$firstName = $address->getFirstName();
		$lastName = $address->getLastName();
		$name = str_replace(" ", "_", $firstName) . " " . str_replace(" ", "_", $lastName);
		
		return Customweb_Util_String::substrUtf8($name, 0, 50);
	}

	/**
	 * Splits the address' street into two lines and returns it as an array. The second line may be empty.
	 * 
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return array The two street lines of an address, whereby the second may be empty
	 */
	protected final function getStreet(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$street1 = "";
		$street2 = "";
		$maxLength = 50;
		$street = $address->getStreet();
		if(strlen($street) > $maxLength){
			$pos = strrpos($street, ' ',  $maxLength - strlen($street));
			$street1 = substr($street, 0, $pos);
			$street2 = substr($street, $pos + 1, $maxLength); // ''$pos + 1'' bc. white space > newline
		} else {
			$street1 = $street;
		}
		return array($street1, $street2);
	}

	/**
	 * This method formats the birthday to our custom Date class
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return Customweb_Xml_Binding_DateHandler_Date
	 */
	protected final function formatBirthday(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$birthday = $address->getDateOfBirth();
		return new Customweb_Xml_Binding_DateHandler_Date($birthday);
	}

	/**
	 *
	 * @return string
	 */
	protected final function getNotificationUrl(){
		$url = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter')->getUrl('process', 'index', 
				array(
					'cw_transaction_id' => $this->getTransaction()->getExternalTransactionId() 
				));
		return $url;
	}

	/**
	 *
	 * @return string
	 */
	protected final function getFailedUrl(){
		$url = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter')->getUrl('process', 'failed', 
				array(
					'cw_transaction_id' => $this->getTransaction()->getExternalTransactionId() 
				));
		return $url;
	}

	protected final function getCancelledUrl(){
		$url = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter')->getUrl('process', 'cancelled', 
				array(
					'cw_transaction_id' => $this->getTransaction()->getExternalTransactionId(),
					'signature' => $this->getTransaction()->getSecuritySignature('process/cancelled') 
				));
		return $url;
	}

	public function getOrderContext(){
		return $this->orderContext;
	}

	public function getTransactionContext(){
		return $this->transactionContext;
	}

	public function getTransaction(){
		return $this->transaction;
	}

	public function getContainer(){
		return $this->container;
	}

	public function getConfiguration(){
		return $this->configuration;
	}

	public function getPaymentMethodFactory(){
		return $this->paymentMethodFactory;
	}
}