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

require_once 'Customweb/Core/String.php';
require_once 'Customweb/Xml/Binding/Annotation/IXmlAnnotation.php';


/**
 * Defines a XML facet.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlFacet implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {
	
	private $name = null;
	
	private $value = null;
	
	private static $allowedNames = array(
		'enumeration',
		'fractionDigits',
		'length',
		'maxExclusive',
		'maxInclusive',
		'maxLength',
		'minExclusive',
		'minInclusive',
		'minLength',
		'pattern',
		'totalDigits',
		'whiteSpace',
	);

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		if (!in_array($name, self::$allowedNames)) {
			throw new Exception(Customweb_Core_String::_("Not allowed facet name '@name'.")->format(array('@name' => $name)));
		}
		$this->name = $name;
		return $this;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
		return $this;
	}
}