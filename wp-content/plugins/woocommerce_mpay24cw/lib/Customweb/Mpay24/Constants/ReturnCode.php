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

require_once 'Customweb/Mpay24/Constants/ReturnCode.php';
require_once 'Customweb/I18n/Translation.php';



/**
 *
 * @author Bjoern Hasselmann
 */
class Customweb_Mpay24_Constants_ReturnCode {
	private $code;
	private $message;

	private function __construct($value, Customweb_I18n_LocalizableString $message){
		$this->code = $value;
		$this->message = $message;
	}

	public function getCode(){
		return $this->code;
	}

	/**
	 * Returns the translated response message.
	 */
	public function getMessage(){
		return (string)$this->message;
	}

	public function __toString(){
		return (string) $this->code;
	}

	/**
	 * Maps the response code to a corresponding object.<br>
	 * In case the response code can not be mapped, the message value will be empty.
	 *
	 * @param string $code The mPAY24 return code
	 * @return Customweb_Mpay24_Constants_ReturnCode
	 */
	public static function get($code){
		$msg = '';
		switch ($code) {
			case 'OK':
				$msg = Customweb_I18n_Translation::__('The transaction was ok (no error occurred).');
				break;
			case 'DECLINED':
				$msg = Customweb_I18n_Translation::__('The transaction was declined by the external payment interface.');
				break;
			case 'BLOCKED':
				$msg = Customweb_I18n_Translation::__('The transaction was blocked.');
				break;
			case 'ACCESS_DENIED':
				$msg = Customweb_I18n_Translation::__('The merchant’s IP address is not white listed.');
				break;
			case 'MERCHANT_LOCKED':
				$msg = Customweb_I18n_Translation::__('The merchant id is locked.');
				break;
			case 'PAYMENT_METHOD_NOT_ACTIVE':
				$msg = Customweb_I18n_Translation::__('The desired payment system is not active.');
				break;
			case 'PTYPE_MISMATCH':
				$msg = Customweb_I18n_Translation::__('The payment method mismatches.');
				break;
			case 'NOT_FOUND':
				$msg = Customweb_I18n_Translation::__('The transaction was not found.');
				break;
			case 'ALREADY_PROCESSED':
				$msg = Customweb_I18n_Translation::__('The transaction has been processed and can not be processed again.');
				break;
			case 'CACHE_DATA_EXPIRED':
				$msg = Customweb_I18n_Translation::__('The temporary cache data are invalid due to expiration.');
				break;
			case 'INVALID_MDXI':
				$msg = Customweb_I18n_Translation::__('The MDXI XML stream could not be validated.');
				break;
			case 'INVALID_AMOUNT':
				$msg = Customweb_I18n_Translation::__('The parameter amount holds invalid values.');
				break;
			case 'INVALID_PRICE':
				$msg = Customweb_I18n_Translation::__('The parameter price holds invalid values.');
				break;
			case 'INVALID_MAESTRO_NUMBER':
				$msg = Customweb_I18n_Translation::__('The Maestro card number is not plausible.');
				break;
			case 'INVALID_CREDITCARD_NUMBER':
				$msg = Customweb_I18n_Translation::__('The credit card number is not plausible.');
				break;
			case 'INVALID_IBAN':
				$msg = Customweb_I18n_Translation::__('The provided IBAN is not plausible.');
				break;
			case 'PROFILE_NOT_FOUND':
				$msg = Customweb_I18n_Translation::__('mPAY24 payment profile could not be found.');
				break;
			case 'PROFILE_NOT_SUPPORTED':
				$msg = Customweb_I18n_Translation::__('mPAY24 Profile is not activated.');
				break;
			case 'PROFILE_FLEX_NOT_SUPPORTED':
				$msg = Customweb_I18n_Translation::__('mPAY24 Profile FLEX is not activated.');
				break;
			case 'PROFILE_COUNT_EXCEEDED':
				$msg = Customweb_I18n_Translation::__('The maximum number of payment profiles of a customer is reached.');
				break;
			case 'TOKEN_NOT_FOUND':
				$msg = Customweb_I18n_Translation::__('The token has not been found or has already been used.');
				break;
			case 'TOKEN_NOT_VALID':
				$msg = Customweb_I18n_Translation::__('The token is invalid due to missing or incorrect data.');
				break;
			case 'TOKEN_EXPIRED':
				$msg = Customweb_I18n_Translation::__('The token has not been used and is expired.');
				break;
			case 'TOKEN_ENCRYPTION_FAILURE':
				$msg = Customweb_I18n_Translation::__('The token data could not be encrypted.');
				break;
			case 'TOKEN_DECRYPTION_FAILURE':
				$msg = Customweb_I18n_Translation::__('The token data could not be decrypted.');
				break;
			case 'WITHDRAW_NOT_ALLOWED':
				$msg = Customweb_I18n_Translation::__('Withdraw operation is not allowed for the merchant.');
				break;
			case 'TRANSACTION_ALREADY_CLEARED':
				$msg = Customweb_I18n_Translation::__('The transaction has already been cleared.');
				break;
			case 'CREDIT_LIMIT_EXCEEDED':
				$msg = Customweb_I18n_Translation::__('The total amount of all credits exceeds the clearing amount.');
				break;
			case 'CLEARING_LIMIT_EXCEEDED':
				$msg = Customweb_I18n_Translation::__('The total amount of all clearing exceeds the reservation amount.');
				break;
			case 'INTERNAL_ERROR':
				$msg = Customweb_I18n_Translation::__('An error during the communication occurred.');
				break;
			case 'EXTERNAL_ERROR':
				$msg = Customweb_I18n_Translation::__('The external payment interface returned an error.');
				break;
			default:
				if (self::endsWith($code, '_NOT_ENTERED')) {
					$msg = Customweb_I18n_Translation::__('The parameter @param could not be found.', self::getParameterTranslationArray($code, '@param'));
				}
				else if (self::endsWith($code, '_NOT_CORRECT')) {
					$msg = Customweb_I18n_Translation::__('The parameter @param was not valid.', self::getParameterTranslationArray($code, '@param'));
				}
				else if (self::endsWith($code, '_NOT_SUPPORTED')) {
					$msg = Customweb_I18n_Translation::__('The parameter @param is not supported.', self::getParameterTranslationArray($code, '@param'));
				} else {
					// unmapped error
					$msg = Customweb_I18n_Translation::__('Error: @code', array(
						'@code' => $code
					));
				}
		}
		return new Customweb_Mpay24_Constants_ReturnCode($code, $msg);
	}

	/**
	 * Tested string ends with function from <a>http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php</a>
	 *
	 * @param string $haystack The string to search in
	 * @param string $needle The string to search for at the end
	 */
	private static function endsWith($haystack, $needle){
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
	
	/**
	 * Extracts the paramater name from specific return codes ending in '_NOT_*' and maps it to the given key.<br>
	 * E.g. 'CUSTOMER_ID_NOT_ENTERED' results in 'CUSTOMER_ID'
	 */
	private static function getParameterTranslationArray($code, $key) {
		$needle = '_';
		$last = strrpos($code, $needle);
		$secondLast = strrpos($code, $needle, $last - strlen($code) - 1);
		$param = substr($code, 0, $secondLast);
		return array($key => $param);
	}
}