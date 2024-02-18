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

require_once 'Customweb/Form/Validator/NotEmpty.php';
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Payment/Exception/PaymentErrorException.php';
require_once 'Customweb/Mpay24/Method/Seamless/EPS/ISubEPS.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Form/Element.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Mpay24/Method/Seamless/EPS/SubEPSInternational.php';



/**
 *
 * @author Bjoern Hasselmann
 */
class Customweb_Mpay24_Method_Seamless_EPS_SubEPSEPS extends Customweb_Mpay24_Method_Seamless_EPS_SubEPSInternational {
	
	/**
	 * The name of the bank dropdown
	 */
	const BANK_DROPDOWN_NAME = 'bankdropdown';
	
	/**
	 * A key-value map of banks in Austria with their BIC as key and their name as value.
	 *
	 * @var array
	 */
	private static $BANK_LIST = array(
		'GIBAATWGXXX' => 'Erste Bank und Sparkassen',
		'HYPNATWWXXX' => 'HYPO NOE Landesbank AG',
		'HYINAT22XXX' => 'HYPO NOE Gruppe Bank AG',
		'HAABAT2KXXX' => 'Austrian Anadi Bank AG',
		'BWFBATW1XXX' => 'Ärztebank',
		'VBOEATWWAPO' => 'Apothekerbank',
		'VOHGATW1XXX' => 'Immo-Bank',
		'VRBKAT21XXX' => 'VR-Bank Braunau',
		'SVIEAT21XXX' => 'SPARDA-BANK AUSTRIA',
		'HYPTAT22XXX' => 'Hypo Tirol Bank AG',
		'SPAEAT2SXXX' => 'Bankhaus Carl Spängler & Co.AG',
		'BSSWATWWXXX' => 'Bankhaus Schelhammer & Schattera AG',
		'HYPVAT2BXXX' => 'Hypo Landesbank Vorarlberg',
		'BAWAATWWXXX' => 'BAWAG P.S.K. AG',
		'EASYATW1XXX' => 'Easybank AG',
		'SPADATW1XXX' => 'Sparda-Bank Wien',
		'VBOEATWWXXX' => 'Volksbank Gruppe',
		'SCHOATWWXXX' => 'Schoellerbank AG',
		'BKAUATWWXXX' => 'Bank Austria',
		'EHBBAT2EXXX' => 'HYPO-BANK BURGENLAND Aktiengesellschaft',
		'OBLAAT2LXXX' => 'HYPO Oberösterreich,Salzburg,Steiermark',
		'OBKLAT2LXXX' => 'Oberbank AG',
		'VKBLAT2LXXX' => 'Volkskreditbank AG',
		'BTVAAT22XXX' => 'BTV VIER LÄNDER BANK',
		'BFKKAT2KXXX' => 'BKS Bank AG',
		'HAABAT22XXX' => 'Hypo Alpe-Adria-Bank International AG',
		'RANMAT21XXX' => 'Raiffeisen Bankengruppe Österreich'
	);
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_Seamless_EPS_ISubEPS::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		return array(
			$this->getBanksDropdown()
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Mpay24_Method_Seamless_EPS_ISubEPS::getPaymentElement()
	 */
	public function getPaymentElement($brand, array $formData = array()){
		if (!isset($formData[self::BANK_DROPDOWN_NAME])) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("You have to state your bank.")));
		}
		return parent::getPaymentElement($brand, $formData)->setBic($formData[self::BANK_DROPDOWN_NAME]);
	}
	
	/**
	 * @return Customweb_Form_Element
	 */
	private function getBanksDropdown(){
		$selectControl = new Customweb_Form_Control_Select(self::BANK_DROPDOWN_NAME, self::$BANK_LIST);
		$desc = Customweb_I18n_Translation::__('Please choose your bank.');
		$selectControl->addValidator(new Customweb_Form_Validator_NotEmpty($selectControl, $desc));
		return new Customweb_Form_Element(Customweb_I18n_Translation::__('Bank'), $selectControl, $desc);
	}
	
}