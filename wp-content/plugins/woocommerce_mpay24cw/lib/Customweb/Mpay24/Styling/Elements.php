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

require_once 'Customweb/Mpay24/Styling/Element.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 *
 */
final class Customweb_Mpay24_Styling_Elements {

	private static $list;
	
	private function __construct(){}

	/**
	 * @return Customweb_Mpay24_Styling_Element[]
	 */
	public static function getStylingElements(){
	
		if (self::$list === null) {

			self::$list = array();
			
			//Order
			self::$list[] = new Customweb_Mpay24_Styling_Element('LogoStyle', Customweb_I18n_Translation::__("Logo"));
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('FooterStyle', Customweb_I18n_Translation::__("Footer"), "margin-top: 24px;");
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('PageHeaderStyle', Customweb_I18n_Translation::__("Page Header"), "background-color: #FFF;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('PageCaptionStyle', Customweb_I18n_Translation::__("Page Caption"), "background-color:#FFF;background:transparent;color:#647378;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('PageStyle', Customweb_I18n_Translation::__("Page"), "border:1px solid #838F93;background-color:#FFF;");
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('InputFieldsStyle', Customweb_I18n_Translation::__("Input Fields"), "background-color:#ffffff;border:1px solid #DDE1E7;padding:2px;margin-bottom:5px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('DropDownListsStyle', Customweb_I18n_Translation::__("Drop Down Lists"), "padding:2px;margin-bottom:5px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ButtonsStyle', Customweb_I18n_Translation::__("Buttons"), "background-color: #005AC1;border: none;color: #FFFFFF;cursor: pointer;font-size:10px;font-weight:bold;padding:5px 10px;text-transform:uppercase;");
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('ErrorsStyle', Customweb_I18n_Translation::__("Error Text Style"), "background-color: #FFF;padding: 10px 0px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ErrorsHeaderStyle', Customweb_I18n_Translation::__("Error Header"));
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('SuccessTitleStyle', Customweb_I18n_Translation::__("Success Title"), "background-color: #FFF;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ErrorTitleStyle', Customweb_I18n_Translation::__("Error Title"), "background-color: #FFF;");
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('Style', Customweb_I18n_Translation::__("Order: General"), "margin-left: auto;margin-right: auto;margin-top: 15%;margin-bottom: auto;width: 600px;");
			
			//ShoppingCart
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Style', Customweb_I18n_Translation::__("Shopping Cart: General"));
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: Header"), "background-color:#FFF;margin-bottom:14px;color:#647378");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/CaptionStyle', Customweb_I18n_Translation::__("Shopping Cart: Caption"), "background-color:#FFF;background:transparent;color:#647378;padding-left:0px;font-size:14px;");
			
			//self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/NumberStyle', Customweb_I18n_Translation::__("Shopping Cart: Numbers"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ProductNrStyle', Customweb_I18n_Translation::__("Shopping Cart: Product Numbers"), "width:280px;background-color:#FFF;color:#647378;border: 1px solid #838F93;text-transform:uppercase;padding:5px;padding-right:0px;text-align:left;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/DescriptionStyle', Customweb_I18n_Translation::__("Shopping Cart: Description"), "width:280px;background-color:#FFF;color:#647378;border: 1px solid #838F93;text-transform:uppercase;padding:5px;padding-right:0px;text-align:left;");
			//self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/PackageStyle', Customweb_I18n_Translation::__("Shopping Cart: Package"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/QuantityStyle', Customweb_I18n_Translation::__("Shopping Cart: Quantity"), "width:80px;background-color:#FFF;color:#647378;border: 1px solid #838F93;text-transform:uppercase;padding:5px;text-align:center;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ItemPriceStyle', Customweb_I18n_Translation::__("Shopping Cart: Item Price"), "width:80px;background-color:#FFF;color:#647378;border: 1px solid #838F93;text-transform:uppercase;padding:5px;text-align:center;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/PriceStyle', Customweb_I18n_Translation::__("Shopping Cart: Total Price"), "width:80px;background-color:#FFF;color:#647378;border: 1px solid #838F93;text-transform:uppercase;padding:5px;text-align:center;");
			
// 			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/NumberHeader', Customweb_I18n_Translation::__("Shopping Cart: Numbers Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ProductNrHeader', Customweb_I18n_Translation::__("Shopping Cart: Product Numbers Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/DescriptionHeader', Customweb_I18n_Translation::__("Shopping Cart: Description Header Text"));
// 			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/PackageHeader', Customweb_I18n_Translation::__("Shopping Cart: Package Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/QuantityHeader', Customweb_I18n_Translation::__("Shopping Cart: Quantity Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ItemPriceHeader', Customweb_I18n_Translation::__("Shopping Cart: Item Price Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/PriceHeader', Customweb_I18n_Translation::__("Shopping Cart: Total Price Header Text"));
			
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/SubTotal/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: SubTotal: Header"),"background-color: #FFF; color: #647378;font-weight:normal;padding:3px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/SubTotal/Header', Customweb_I18n_Translation::__("Shopping Cart: SubTotal: Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/SubTotal/Style', Customweb_I18n_Translation::__("Shopping Cart: SubTotal: Element"), "background-color:#FFF;color:#647378;border:none;padding:3px 20px;");
				
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Discount/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: Discount: Header"), "background-color: #FFF; color: #647378;font-weight:normal;padding:3px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Discount/Header', Customweb_I18n_Translation::__("Shopping Cart: Discount: Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Discount/Style', Customweb_I18n_Translation::__("Shopping Cart: Discount: Element"), "background-color:#FFF;color:#647378;border:none;padding:3px 20px;");

			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ShippingCosts/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: ShippingCosts: Header"), "background-color: #FFF; color: #647378;font-weight:normal;padding:3px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ShippingCosts/Header', Customweb_I18n_Translation::__("Shopping Cart: ShippingCosts: Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/ShippingCosts/Style', Customweb_I18n_Translation::__("Shopping Cart: ShippingCosts: Element"), "background-color:#FFF;color:#647378;border:none;padding:3px 20px;");
				
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Tax/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: Tax: Header"), "background-color:#FFF;color: #647378;padding:3px;font-weight:normal;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Tax/Header', Customweb_I18n_Translation::__("Shopping Cart: Tax: Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Tax/Style', Customweb_I18n_Translation::__("Shopping Cart: Tax: Element"), "background-color:#FFF;color:#647378;border:none;font-weight:normal;padding:3px 20px;");

			//(Order)
			self::$list[] = new Customweb_Mpay24_Styling_Element('Price/HeaderStyle', Customweb_I18n_Translation::__("Shopping Cart: Price: Header"), "background-color:#FFF;color: #647378;padding:3px;font-weight:normal;border-top: 1px solid #838F93;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('Price/Header', Customweb_I18n_Translation::__("Shopping Cart: Price: Header Text"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('Price/Style', Customweb_I18n_Translation::__("Shopping Cart: Price: Element"), "background-color:#FFF;color:#005AC1;border:none;padding:4px;font-weight:bold;padding:3px 20px;font-size:14px;border-top: 1px solid #838F93;");
				
			//Item
			//self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/Number/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Numbers"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/ProductNr/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Product Numbers"), "background-color:#FFF;color:#005AC1;border: 1px solid #838F93;font-weight:bold;padding:5px 10px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/Description/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Description"), "background-color:#FFF;color:#005AC1;border: 1px solid #838F93;font-weight:bold;padding:5px 10px;");
			//self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/Package/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Package"));
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/Quantity/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Quantity"), 	"background-color: #FFF;color: #647378; border: 1px solid #838F93; text-align:center; padding:5px 0px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/ItemPrice/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Item Price"), "background-color: #FFF;color: #647378; border: 1px solid #838F93; text-align:center; padding:5px 0px;");
			self::$list[] = new Customweb_Mpay24_Styling_Element('ShoppingCart/Item{}/Price/Style', Customweb_I18n_Translation::__("Shopping Cart: Item: Total Price"), 	"background-color: #FFF;color: #647378; border: 1px solid #838F93; font-weight:normal;padding:5px 20px 5px 0px;");
				
		}
		
		return self::$list;
	}
}