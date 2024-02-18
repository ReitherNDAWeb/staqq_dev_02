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

require_once 'Customweb/Mpay24/Stubs/Order/Tid.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/SubTotal.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/ProductNr.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Email.php';
require_once 'Customweb/Mpay24/Styling/Elements.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Street.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/ItemPrice.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Mpay24/Stubs/Order/Currency.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Phone.php';
require_once 'Customweb/Mpay24/Stubs/Order/BillingAddr.php';
require_once 'Customweb/Mpay24/Stubs/Order/Customer.php';
require_once 'Customweb/Mpay24/Configuration.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Description.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Discount.php';
require_once 'Customweb/Mpay24/Stubs/Order/TemplateSet.php';
require_once 'Customweb/Mpay24/AbstractParameterBuilder.php';
require_once 'Customweb/Mpay24/Stubs/Order.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Description.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Price.php';
require_once 'Customweb/Payment/Util.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShippingAddr.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Name/Gender.php';
require_once 'Customweb/Mpay24/Stubs/AddressModeType.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Country.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/ShippingCosts.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Name.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart/Item/Quantity.php';
require_once 'Customweb/Mpay24/Stubs/Order/UserField.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/Country/Code.php';
require_once 'Customweb/Mpay24/Stubs/Order/Price.php';
require_once 'Customweb/Mpay24/Stubs/AddressType/State.php';
require_once 'Customweb/Mpay24/Stubs/AddressFieldType.php';
require_once 'Customweb/Mpay24/Stubs/Order/ShoppingCart.php';
require_once 'Customweb/Mpay24/Stubs/LanguageType.php';
require_once 'Customweb/Mpay24/Stubs/Order/Customer/Id.php';



/**
 * This class builds the parameters for the Merchant Data eXchange Interface (MDXI), which
 * means a Customweb_Mpay24_Stubs_Order.
 * Do not confuse this class with Customweb_Mpay24_BackendOperation_Capture_ParameterBuilder,
 * which builds a Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Order object.
 *
 * @author Bjoern Hasselmann
 *
 */
abstract class Customweb_Mpay24_Authorization_AbstractParameterBuilder extends Customweb_Mpay24_AbstractParameterBuilder {
	
	/**
	 *
	 * @var array
	 */
	private $formData;
	
	/**
	 * The default language in Case mPAY24 doesn't support the given lanugage.
	 * This is necessary because if you send an unsupported language code, i.e.
	 * it's not in the set of mPAY24, the MDXI check fails.
	 *
	 * @var string
	 */
	const DEFAULT_LANGUAGE = 'EN';

	final public function __construct(Customweb_Mpay24_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container, $formData){
		parent::__construct($transaction, $container);
		$this->formData = $formData;
	}

	/**
	 * This method fills in the styling parameters defined in the styling form.
	 * Inheriting classes should always call the parent method first, when overwriting
	 * this method!
	 *
	 * @param Customweb_Mpay24_Stubs_Order $order
	 */
	protected function setStylingAttributes(Customweb_Mpay24_Stubs_Order $order){
		$elements = Customweb_Mpay24_Styling_Elements::getStylingElements();
		foreach ($elements as $element) {
			$methods = explode('/', $element->getName());
			$this->traverseAndSet($order, $methods, $element);
		}
	}

	private function traverseAndSet($node, array $methods, Customweb_Mpay24_Styling_Element $element){
		$len = count($methods);
		for ($i = 0; $i < $len; ++$i) {
			if ($node === null) {
				return;
			}
			if ($i == $len - 1) {
				$value = $this->getStylingConfiguration($element);
				if ($value == null) {
					continue;
				}
				$method = "set" . $methods[$i];
				$node->$method($value);
			}
			else {
				$name = $methods[$i];
				if ($pos = strpos($name, '{')) {
					$method = "get" . substr($name, 0, $pos);
					$list = $node->$method();
					foreach ($list as $item) {
						$this->traverseAndSet($item, array_slice($methods, $i + 1), $element);
					}
					return;
				}
				else {
					$method = "get" . $name;
					$node = $node->$method();
				}
			}
		}
	}

	/**
	 * Returns a URL object with the reaction URLs.
	 *
	 * @return Customweb_Mpay24_Stubs_Order_URL
	 */
	abstract public function getUrl();

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Order $order
	 */
	final public function getOrder(){
		$pm = $this->getPaymentMethodByTransaction($this->getTransaction());
		
		$billingAddress = $this->getBillingAddress();
		$shippingAddress = $this->getShippingAddress();
		$shoppingCart = $this->getShoppingCart();
		$userField = substr(Customweb_Mpay24_Configuration::SHOP_SYSTEM_TAG, 0, 255);
		
		$price = $this->formatAmount($this->getTransaction()->getAuthorizationAmount());
		$currency = $this->getTransaction()->getCurrencyCode();
		$url = $this->getUrl();
		$customer = $this->getCustomer();
		
		$order = new Customweb_Mpay24_Stubs_Order();
		
		$this->setBillingAddress($order, $billingAddress, $pm, $customer);
		$order->setShippingAddr($shippingAddress);
		$order->setShoppingCart($shoppingCart);
		$order->setUserField(Customweb_Mpay24_Stubs_Order_UserField::_()->set($userField));
		$order->setTid(Customweb_Mpay24_Stubs_Order_Tid::_()->set($this->getTransaction()->getTid()));
		$order->setPrice(Customweb_Mpay24_Stubs_Order_Price::_()->set($price));
		$order->setURL($url);
		$order->setCustomer($customer);
		$order->setTemplateSet($this->getTemplateSet());
		
		$currWrapper = new Customweb_Mpay24_Stubs_Order_Currency();
		$currWrapper->set($currency);
		$order->setCurrency($currWrapper);
		
		$paymentMethod = $this->getPaymentMethodByTransaction($this->getTransaction());
		$paymentMethod->prepareOrderObject($order, $this->getTransaction(), $this->formData);
		
		$this->setStylingAttributes($order);
		return $order;
	}

	/**
	 * If the billing address isn't shown on the payment page, the customer's name will be send explicitly for reference, e.g., in transaction
	 * confirmations
	 */
	private function setBillingAddress(Customweb_Mpay24_Stubs_Order $order, Customweb_Mpay24_Stubs_Order_BillingAddr $billingAddress, Customweb_Mpay24_Method_DefaultMethod $pm, Customweb_Mpay24_Stubs_Order_Customer $customer){
		$sendBilling = 'send_billing_address';
		if ((!($pm->existsPaymentMethodConfigurationValue($sendBilling))) || $pm->getPaymentMethodConfigurationValue($sendBilling) == "1") {
			$order->setBillingAddr($billingAddress);
		}
		else {
			$customer->set($billingAddress->getName()->get());
		}
	}

	final protected function getTemplateSet(){
		$tSet = new Customweb_Mpay24_Stubs_Order_TemplateSet();
		$tSet->setLanguage($this->getLanguageType());
		$tSet->setCSSName('MODERN');
		return $tSet;
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_LanguageType
	 */
	final public function getLanguageType(){
		$langCode = strtoupper($this->getOrderContext()->getLanguage()->getIso2LetterCode());
		if (!method_exists('Customweb_Mpay24_Stubs_LanguageType', $langCode)) {
			$langCode = self::DEFAULT_LANGUAGE;
		}
		return Customweb_Mpay24_Stubs_LanguageType::$langCode();
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IPaymentMethod $method
	 * @param string $authorizationMethodName
	 * @return Customweb_Mpay24_Method_DefaultMethod
	 */
	final protected function getPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $method, $authorizationMethodName){
		return $this->getPaymentMethodFactory()->getPaymentMethod($method, $authorizationMethodName);
	}

	/**
	 *
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @return Customweb_Mpay24_Method_DefaultMethod
	 */
	final protected function getPaymentMethodByTransaction(Customweb_Mpay24_Authorization_Transaction $transaction){
		return $this->getPaymentMethod($transaction->getPaymentMethod(), $transaction->getAuthorizationMethod());
	}

	/**
	 * Note that in any case a Customweb_Mpay24_Stubs_Order_Customer object is returned.
	 *
	 * @return Customweb_Mpay24_Stubs_Order_Customer
	 */
	final protected function getCustomer(){
		$custId = $this->transaction->getAliasId();
		$customer = new Customweb_Mpay24_Stubs_Order_Customer();
		$createRecurringProfile = $this->getTransaction()->getCreateProfile();
		if ($createRecurringProfile) {
			$custId = $this->getTransaction()->getRecurringId();
		}
		$customer->setId(Customweb_Mpay24_Stubs_Order_Customer_Id::_()->set($custId));
		$customer->setUseProfile($createRecurringProfile);
		
		return $customer;
	}

	/**
	 * Note: Amounts include taxes to prevent rounding issues.
	 * 
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart
	 */
	final protected function getShoppingCart(){
		$subTotal = $this->formatAmount(0);
		$shippingCosts = $this->formatAmount(0);
		$discount = $this->formatAmount(0);
		$items = $this->orderContext->getInvoiceItems();
		$shoppingCart = new Customweb_Mpay24_Stubs_Order_ShoppingCart();
		
		foreach ($items as $item) {
			switch ($item->getType()) {
				case Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING:
					$shippingCosts = $shippingCosts->add($item->getAmountIncludingTax());
					break;
				case Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT:
					$discount = $discount->add($item->getAmountIncludingTax());
					break;
				case Customweb_Payment_Authorization_IInvoiceItem::TYPE_PRODUCT:
				default: //TYPE_FEE: add to shopping cart like a product
					$shoppingCart->addItem($this->formatInvoiceItem($item));
					$subTotal = $subTotal->add($item->getAmountIncludingTax());
			}
		}
		
		$discountWrapper = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Discount();
		$discountWrapper->set($discount->multiply(-1.0)); // discount has to be negative
		$shoppingCart->setDiscount($discountWrapper);
		$subTotalWrapper = new Customweb_Mpay24_Stubs_Order_ShoppingCart_SubTotal();
		$subTotalWrapper->set($subTotal);
		$shoppingCart->setSubTotal($subTotalWrapper);
		$shippingCostsWrapper = new Customweb_Mpay24_Stubs_Order_ShoppingCart_ShippingCosts();
		$shippingCostsWrapper->set($shippingCosts);
		$shoppingCart->setShippingCosts($shippingCostsWrapper);
		
		$scheme = $this->getConfiguration()->getOrderDescription();
		if (!empty($scheme)) {
			$description = Customweb_Payment_Util::applyOrderSchemaImproved($scheme, $this->getTransaction()->getExternalTransactionId(), 255);
			$shoppingCart->setDescription(Customweb_Mpay24_Stubs_Order_ShoppingCart_Description::_()->set($description));
		}
		return $shoppingCart;
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_Order_BillingAddr
	 */
	final protected function getBillingAddress(){
		$address = $this->orderContext->getBillingAddress();
		$billingAddress = new Customweb_Mpay24_Stubs_Order_BillingAddr();
		return $this->prepareAddressObject($billingAddress, $address);
	}

	/**
	 *
	 * @return Customweb_Mpay24_Stubs_OrderShippingAddr
	 */
	final protected function getShippingAddress(){
		$address = $this->orderContext->getShippingAddress();
		$shippingAddress = new Customweb_Mpay24_Stubs_Order_ShippingAddr();
		return $this->prepareAddressObject($shippingAddress, $address);
	}

	/**
	 *
	 * @param Customweb_Mpay24_Stubs_AddressType $specific
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $general
	 * @return Customweb_Mpay24_Stubs_AddressType
	 */
	private function prepareAddressObject(Customweb_Mpay24_Stubs_AddressType $specific, Customweb_Payment_Authorization_OrderContext_IAddress $general){
		// in Customweb_Mpay24_Stubs_Order_BillingAddr or Customweb_Mpay24_Stubs_Order_ShippingAddr which extend Customweb_Mpay24_Stubs_AddressType
		$specific->setMode(Customweb_Mpay24_Stubs_AddressModeType::READONLY());
		$specific->setName($this->getName($general));
		if ($general->getGender() == 'male') {
			$specific->getName()->setGender(Customweb_Mpay24_Stubs_AddressType_Name_Gender::M());
		}
		else if ($general->getGender() == 'female') {
			$specific->getName()->setGender(Customweb_Mpay24_Stubs_AddressType_Name_Gender::F());
		}
		
		$specific->getName()->setBirthday($this->formatBirthday($general));
		
		$streetLines = $this->getStreet($general);
		$streetWrapper = new Customweb_Mpay24_Stubs_AddressType_Street();
		$streetWrapper->set(current($streetLines));
		$specific->setStreet($streetWrapper);
		$street2 = end($streetLines);
		if (!empty($street2)) {
			$street2Wrapper = new Customweb_Mpay24_Stubs_AddressType_Street();
			$street2Wrapper->set($street2);
			$specific->setStreet2($street2Wrapper);
		}
		
		$zipWrapper = Customweb_Mpay24_Stubs_AddressFieldType::_()->set($general->getPostCode());
		$specific->setZip($zipWrapper);
		
		$cityWrapper = Customweb_Mpay24_Stubs_AddressFieldType::_()->set($general->getCity());
		$specific->setCity($cityWrapper);
		
		$stateWrapper = Customweb_Mpay24_Stubs_AddressType_State::_()->set($general->getState());
		$specific->setState($stateWrapper);
		
		$specific->setCountry(new Customweb_Mpay24_Stubs_AddressType_Country());
		$specific->getCountry()->setCode(Customweb_Mpay24_Stubs_AddressType_Country_Code::_()->set(trim($general->getCountryIsoCode())));
		
		$specific->setEmail(Customweb_Mpay24_Stubs_AddressType_Email::_()->set($general->getEMailAddress()));
		
		$specific->setPhone(Customweb_Mpay24_Stubs_AddressType_Phone::_()->set($general->getMobilePhoneNumber()));
		
		return $specific;
	}

	/**
	 * Formats the name and wraps it.
	 *
	 * @param Customweb_Payment_Authorization_OrderContext_IAddress $address
	 * @return Customweb_Mpay24_Stubs_AddressTypeName
	 */
	final protected function getName(Customweb_Payment_Authorization_OrderContext_IAddress $address){
		$name = $this->formatName($address);
		return Customweb_Mpay24_Stubs_AddressType_Name::_()->set($name);
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem $_item
	 * @return Customweb_Mpay24_Stubs_OrderShoppingCartItem
	 */
	final protected function formatInvoiceItem(Customweb_Payment_Authorization_IInvoiceItem $_item){
		$prodNr = $_item->getSku();
		$desc = $_item->getName();
		$quant = intval($_item->getQuantity());
		$quant = ($quant == 0 ? 1 : $quant);
		$itemPrice = $this->formatAmount($_item->getAmountIncludingTax() / $quant);
		$itemPriceTotal = $this->formatAmount($_item->getAmountIncludingTax());
		$item = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Item();
		$item->setProductNr(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ProductNr::_()->set($prodNr));
		$item->setDescription(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Description::_()->set($desc));
		$item->setQuantity(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Quantity::_()->set($quant));
		$item->setItemPrice(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_ItemPrice::_()->set($itemPrice));
		$item->setPrice(Customweb_Mpay24_Stubs_Order_ShoppingCart_Item_Price::_()->set($itemPriceTotal));
		return $item;
	}

	final protected function getStylingConfiguration(Customweb_Mpay24_Styling_Element $element){
		$value = trim($this->getSettingHandler()->getSettingValue($element->getName()));
		
		if ($value == $element->getDefault()) {
			$value = null;
		}
		
		return $value;
	}

	/**
	 *
	 * @return Customweb_Payment_SettingHandler
	 */
	final protected function getSettingHandler(){
		return $this->getContainer()->getBean('Customweb_Payment_SettingHandler');
	}
}