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


require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPayment.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPaymentElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPaymentResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptPaymentResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptWithdraw.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptWithdrawElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptWithdrawResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AcceptWithdrawResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Address.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AddressMode.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/AirlineTicket.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Callback.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CallbackMASTERPASS.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CallbackPAYPAL.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ClearingDetails.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Confirmation.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ConfirmationStatus.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Confirmed.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentToken.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentTokenElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentTokenResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreatePaymentTokenResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreateProfile.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreateProfileElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreateProfileResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/CreateProfileResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/DeleteProfile.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/DeleteProfileElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/DeleteProfileResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/DeleteProfileResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Gender.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/HistoryEntry.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/IndustrySpecific.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Item.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListNotCleared.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListNotClearedElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListNotClearedResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListNotClearedResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListPaymentMethods.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListPaymentMethodsElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListPaymentMethodsResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListPaymentMethodsResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfiles.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfilesElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfilesResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ListProfilesResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCallback.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCallbackElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCallbackResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCallbackResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualClear.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualClearElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualClearResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualClearResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCredit.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCreditElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCreditResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualCreditResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualReverse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualReverseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualReverseResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ManualReverseResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Order.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Parameter.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentBILLPAY.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentCB.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentCC.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentELV.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentEPS.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentGIROPAY.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentKLARNA.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentMAESTRO.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentMASTERPASS.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentMethod.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentPAYPAL.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentPB.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentProfile.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentTOKEN.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/PaymentType.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Profile.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ProfilePaymentCC.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ProfilePaymentELV.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ProfilePaymentPB.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPayment.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPaymentElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPaymentResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SelectPaymentResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/ShoppingCart.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SortField.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/SortType.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Status.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TStatus.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Transaction.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionConfirmation.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionConfirmationElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionConfirmationResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionConfirmationResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionDetails.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionHistory.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionHistoryElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionHistoryResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionHistoryResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatus.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatusElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatusResponse.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TransactionStatusResponseElement.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/TxState.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Withdraw.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/WithdrawCC.php');
require_once('Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/WithdrawMAESTRO.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/AnyType.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Boolean.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Date.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/DateTime.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Float.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/Integer.php');
require_once('Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php');
require_once 'Customweb/Soap/AbstractService.php';
/**
 *	mPAY24 ETP (Electronic Transaction Processing) Interface WebService
 * 
 */

class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ETP extends Customweb_Soap_AbstractService {

	/**
	 * @var Customweb_Soap_IClient
	 */
	private $soapClient;
		
	/**
	 * Interactive payment interface
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPayment $selectPayment
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse
	 */ 
	public function selectPayment(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPayment $selectPayment){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("SelectPayment", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_SelectPaymentResponse", "SelectPayment");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Interactive interface for tokenization of sensitive payment data
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken $createPaymentToken
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentTokenResponse
	 */ 
	public function createPaymentToken(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentToken $createPaymentToken){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("CreatePaymentToken", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreatePaymentTokenResponse", "CreatePaymentToken");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Direct payment interface
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment $acceptPayment
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse
	 */ 
	public function acceptPayment(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPayment $acceptPayment){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("AcceptPayment", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptPaymentResponse", "AcceptPayment");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Process suspended payment
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCallback $manualCallback
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCallbackResponse
	 */ 
	public function manualCallback(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCallback $manualCallback){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ManualCallback", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCallbackResponse", "ManualCallback");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Clear transaction(s)
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClear $manualClear
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClearResponse
	 */ 
	public function manualClear(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClear $manualClear){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ManualClear", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualClearResponse", "ManualClear");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Reversal (not cleared) transaction
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualReverse $manualReverse
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualReverseResponse
	 */ 
	public function manualReverse(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualReverse $manualReverse){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ManualReverse", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualReverseResponse", "ManualReverse");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Credit already cleared transaction
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit $manualCredit
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCreditResponse
	 */ 
	public function manualCredit(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCredit $manualCredit){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ManualCredit", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ManualCreditResponse", "ManualCredit");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Direct withdraw interface
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw $acceptWithdraw
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdrawResponse
	 */ 
	public function acceptWithdraw(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdraw $acceptWithdraw){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("AcceptWithdraw", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_AcceptWithdrawResponse", "AcceptWithdraw");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Get transaction status for specified mpayTID or tid
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus $transactionStatus
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatusResponse
	 */ 
	public function transactionStatus(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatus $transactionStatus){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("TransactionStatus", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionStatusResponse", "TransactionStatus");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Get transaction confirmation calls for specified mpayTID
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionConfirmation $transactionConfirmation
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionConfirmationResponse
	 */ 
	public function transactionConfirmation(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionConfirmation $transactionConfirmation){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("TransactionConfirmation", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionConfirmationResponse", "TransactionConfirmation");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Get all transaction's states for specified mpayTID or the last transaction with the specified TID
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionHistory $transactionHistory
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionHistoryResponse
	 */ 
	public function transactionHistory(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionHistory $transactionHistory){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("TransactionHistory", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_TransactionHistoryResponse", "TransactionHistory");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * List transactions to be cleared
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared $listNotCleared
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotClearedResponse
	 */ 
	public function listNotCleared(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotCleared $listNotCleared){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ListNotCleared", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListNotClearedResponse", "ListNotCleared");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * List available payment methods (for specific pType)
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListPaymentMethods $listPaymentMethods
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListPaymentMethodsResponse
	 */ 
	public function listPaymentMethods(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListPaymentMethods $listPaymentMethods){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ListPaymentMethods", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListPaymentMethodsResponse", "ListPaymentMethods");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Interactive creation of payment profiles
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreateProfile $createProfile
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreateProfileResponse
	 */ 
	public function createProfile(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreateProfile $createProfile){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("CreateProfile", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_CreateProfileResponse", "CreateProfile");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * List stored payment profiles
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles $listProfiles
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse
	 */ 
	public function listProfiles(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfiles $listProfiles){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("ListProfiles", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_ListProfilesResponse", "ListProfiles");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
		
	/**
	 * Delete stored payment profile
	 * 
	 * @param Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_DeleteProfile $deleteProfile
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_DeleteProfileResponse
	 */ 
	public function deleteProfile(Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_DeleteProfile $deleteProfile){
		$data = func_get_args();
		if (count($data) > 0) {;
			$data = current($data);
		} else {;
			 throw new InvalidArgumentException();
		};
		$call = $this->createSoapCall("DeleteProfile", $data, "Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_DeleteProfileResponse", "DeleteProfile");
		$call->setStyle(Customweb_Soap_ICall::STYLE_DOCUMENT);
		$call->setInputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setOutputEncoding(Customweb_Soap_ICall::ENCODING_LITERAL);
		$call->setSoapVersion(Customweb_Soap_ICall::SOAP_VERSION_11);
		$call->setLocationUrl($this->resolveLocation("https://www.mpay24.com/app/bin/etpproxy_v15"));
		$result = $this->getClient()->invokeOperation($call);
		return $result;
		
	}
	
}