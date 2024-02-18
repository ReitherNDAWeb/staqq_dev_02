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

require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Address.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ShoppingCart.php';
require_once 'Customweb/Util/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Gender.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Mpay24/Stubs/AddressFieldType.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AddressMode.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Item.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Order.php';
require_once 'Customweb/Mpay24/AbstractParameterBuilder.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
abstract class Customweb_Mpay24_AbstractEtpParameterBuilder extends Customweb_Mpay24_AbstractParameterBuilder {
	
	/**
	 *
	 * @var Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	private $items;

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param Customweb_DependencyInjection_IContainer $container
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 */
	public function __construct(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container, $items = null){
		parent::__construct($transaction, $container);
		$this->items = ($items === null ? $this->orderContext->getInvoiceItems() : $items);
	}

	public function getOrder(){
		$order = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order();
		$order->setBilling($this->getBillingAddress());
		$order->setShipping($this->getShippingAddress());
		$order->setShoppingCart($this->getShoppingCart());

		return $order;
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	protected function getBillingAddress(){
		$address = $this->orderContext->getBillingAddress();
		return $this->prepareAddressObject($address);
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	protected function getShippingAddress(){
		$address = $this->orderContext->getShippingAddress();
		return $this->prepareAddressObject($address);
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address
	 */
	protected function prepareAddressObject(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$output = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Address();
		$output->setMode(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AddressMode::READONLY());
		$output->setName($this->formatName($address));
		$gender = $this->formatGender($address);
		if ($gender !== null) {
			$output->setGender($this->formatGender($address));
		}
		$output->setBirthday($this->formatBirthday($address));
		
		$streetLines = $this->getStreet($address);
		$output->setStreet(current($streetLines));
		$street2 = end($streetLines);
		if ($street2 !== null && !empty($street2)) {
			$output->setStreet2($street2);
		}
		
		$zipWrapper = Customweb_Mpay24_Stubs_AddressFieldType::_()->set($address->getPostCode());
		$output->setZip($zipWrapper);
		$output->setCity($address->getCity());
		$output->setState($address->getState());
		$output->setCountryCode(trim($address->getCountryIsoCode()));
		$output->setEmail($address->getEMailAddress());
		$output->setPhone($address->getMobilePhoneNumber());
		
		return $output;
	}

	/**
	 * Note: Amounts include taxes to prevent rounding issues.
	 *
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart
	 */
	protected function getShoppingCart(){
		$shippingCosts = 0;
		$discount = 0;
		$shoppingCart = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ShoppingCart();
		foreach ($this->items as $item) {
			switch ($item->getType()) {
				case Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING:
					$shippingCosts += $item->getAmountIncludingTax();
					break;
				case Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT:
					$discount += $item->getAmountIncludingTax();
					break;
				default: //TYPE_FEE & TYPE_PRODUCT: add to shopping cart like a normal product
					$shoppingCart->addItem($this->formatInvoiceItem($item));
			}
		}
		$shoppingCart->setDiscount($this->formatAmount($discount, '')->multiply(-1.0)); // discount has to be negative
		$shoppingCart->setShippingCosts($this->formatAmount($shippingCosts, ''));
		
		return $shoppingCart;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem $_item
	 * @return Customweb_Mpay24_Stubs_OrderShoppingCartItem
	 */
	private function formatInvoiceItem(Customweb_Payment_Authorization_IInvoiceItem $_item){
		$prodNr = Customweb_Util_String::substrUtf8($_item->getSku(), 0, 255);
		$desc = $_item->getName();
		$quant = intval($_item->getQuantity());
		$itemPrice = $_item->getAmountIncludingTax() / $quant;
		
		$item = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Item();
		$item->setAmount($this->formatAmount($itemPrice, ''));
		$item->setDescription($desc);
		$item->setProductNr($prodNr);
		$item->setQuantity($quant);
		
		return $item;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender
	 */
	protected function formatGender(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		switch ($address->getGender()) {
			case "male":
				return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender::MALE();
			case "female":
				return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Gender::FEMALE();
		}
		return null;
	}
}