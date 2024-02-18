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

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/LanguageType.php';
/**
 * @XmlType(name="TemplateSet", namespace="")
 */ 
class Customweb_Mpay24_Stubs_Profile_TemplateSet extends Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @XmlAttribute(name="CSSName", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $cSSName;
	
	/**
	 * @XmlAttribute(name="Language", simpleType=@XmlSimpleTypeDefinition(typeName='LanguageType', typeNamespace='', type='Customweb_Mpay24_Stubs_LanguageType')) 
	 * @var Customweb_Mpay24_Stubs_LanguageType
	 */
	private $language;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Profile_TemplateSet
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Profile_TemplateSet();
		return $i;
	}
	/**
	 * Returns the value for the property cSSName.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCSSName(){
		return $this->cSSName;
	}
	
	/**
	 * Sets the value for the property cSSName.
	 * 
	 * @param string $cSSName
	 * @return Customweb_Mpay24_Stubs_Profile_TemplateSet
	 */
	public function setCSSName($cSSName){
		if ($cSSName instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->cSSName = $cSSName;
		}
		else {
			$this->cSSName = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($cSSName);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property language.
	 * 
	 * @return Customweb_Mpay24_Stubs_LanguageType
	 */
	public function getLanguage(){
		return $this->language;
	}
	
	/**
	 * Sets the value for the property language.
	 * 
	 * @param Customweb_Mpay24_Stubs_LanguageType $language
	 * @return Customweb_Mpay24_Stubs_Profile_TemplateSet
	 */
	public function setLanguage($language){
		if ($language instanceof Customweb_Mpay24_Stubs_LanguageType) {
			$this->language = $language;
		}
		else {
			throw new BadMethodCallException("Type of argument language must be Customweb_Mpay24_Stubs_LanguageType.");
		}
		return $this;
	}
	
	
	
}