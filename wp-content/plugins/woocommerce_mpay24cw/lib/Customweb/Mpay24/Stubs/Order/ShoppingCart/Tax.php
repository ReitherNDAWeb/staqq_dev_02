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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Float.php';
require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/PriceType.php';
/**
 * @XmlType(name="Tax", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax extends Customweb_Mpay24_Stubs_PriceType {
	/**
	 * @XmlAttribute(name="Percent", simpleType=@XmlSimpleTypeDefinition(typeName='float', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float')) 
	 * @var float
	 */
	private $percent;
	
	/**
	 * @XmlAttribute(name="Header", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $header;
	
	/**
	 * @XmlAttribute(name="HeaderStyle", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $headerStyle;
	
	/**
	 * @XmlAttribute(name="Style", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $style;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax();
		return $i;
	}
	/**
	 * Returns the value for the property percent.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float
	 */
	public function getPercent(){
		return $this->percent;
	}
	
	/**
	 * Sets the value for the property percent.
	 * 
	 * @param float $percent
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public function setPercent($percent){
		if ($percent instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float) {
			$this->percent = $percent;
		}
		else {
			$this->percent = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_Float::_()->set($percent);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property header.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getHeader(){
		return $this->header;
	}
	
	/**
	 * Sets the value for the property header.
	 * 
	 * @param string $header
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public function setHeader($header){
		if ($header instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->header = $header;
		}
		else {
			$this->header = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($header);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property headerStyle.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getHeaderStyle(){
		return $this->headerStyle;
	}
	
	/**
	 * Sets the value for the property headerStyle.
	 * 
	 * @param string $headerStyle
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public function setHeaderStyle($headerStyle){
		if ($headerStyle instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->headerStyle = $headerStyle;
		}
		else {
			$this->headerStyle = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($headerStyle);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property style.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getStyle(){
		return $this->style;
	}
	
	/**
	 * Sets the value for the property style.
	 * 
	 * @param string $style
	 * @return Customweb_Mpay24_Stubs_Order_ShoppingCart_Tax
	 */
	public function setStyle($style){
		if ($style instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->style = $style;
		}
		else {
			$this->style = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($style);
		}
		return $this;
	}
	
	
	
}