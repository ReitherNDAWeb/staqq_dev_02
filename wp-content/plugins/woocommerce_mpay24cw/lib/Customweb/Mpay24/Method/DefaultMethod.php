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

require_once 'Customweb/Mpay24/Stubs/PaymentTypeType.php';
require_once 'Customweb/Mpay24/Stubs/PaymentBrandType.php';
require_once 'Customweb/Mpay24/Stubs/Order/PaymentTypes/Payment.php';
require_once 'Customweb/Mpay24/Stubs/Order/PaymentTypes.php';
require_once 'Customweb/Mpay24/Method/DefaultMethod.php';
require_once 'Customweb/Mpay24/Method/ElementBuilder.php';
require_once 'Customweb/Payment/Authorization/AbstractPaymentMethodWrapper.php';

require_once 'Customweb/Payment/Authorization/AbstractPaymentMethodWrapper.php';
require_once 'Customweb/Payment/Authorization/Server/IAdapter.php';

/**
 *
 * @author Bjoern Hasselmann
 * @Method()
 */
class Customweb_Mpay24_Method_DefaultMethod extends Customweb_Payment_Authorization_AbstractPaymentMethodWrapper {
	
	/**
	 *
	 * @var Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment;
	 */
	private $payment = null;
	
	/**
	 * This map contains all supported payment methods.
	 *         		   	 	  	  	
	 *
	 * @var array
	 */
	protected static $paymentMapping = array(
		'creditcard' => array(
			'machine_name' => 'CreditCard',
 			'method_name' => 'Credit Card',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'visa' => array(
			'machine_name' => 'Visa',
 			'method_name' => 'Visa',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => 'VISA',
 			),
 			'not_supported_features' => array(
			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '4',
 				),
 				'lengths' => array(
					0 => '13',
 					1 => '16',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'Visa',
 				'cvv_length' => '3',
 				'cvv_required' => 'true',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'mastercard' => array(
			'machine_name' => 'MasterCard',
 			'method_name' => 'MasterCard',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => 'MASTERCARD',
 			),
 			'not_supported_features' => array(
			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '2221',
 					1 => '2222',
 					2 => '2223',
 					3 => '2224',
 					4 => '2225',
 					5 => '2226',
 					6 => '2227',
 					7 => '2228',
 					8 => '2229',
 					9 => '223',
 					10 => '224',
 					11 => '225',
 					12 => '226',
 					13 => '227',
 					14 => '228',
 					15 => '229',
 					16 => '23',
 					17 => '24',
 					18 => '25',
 					19 => '26',
 					20 => '270',
 					21 => '271',
 					22 => '2720',
 					23 => '51',
 					24 => '52',
 					25 => '53',
 					26 => '54',
 					27 => '55',
 				),
 				'lengths' => array(
					0 => '16',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'MasterCard',
 				'cvv_length' => '3',
 				'cvv_required' => 'true',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD0AAAAyCAYAAADvNNM8AAAEu0lEQVR42u2ZP2gbVxjAn2rHURObKo1llHsX0ODBgymCmJLBg8BDhiSEDm0pLog20AymZDDBBA8umKDBUBdM4ySOdEOHDBlC0ODBg4cMGjx4yNDBgwdDTW3Hok2qO0WWXr5P/hTOsmyf7j5JIb0PPqTTO717v/f9ue+9J4Qvvvjiiy//U3klpL4t9NFtoU1tCzm/I6QBn7NbQk7+LS5e2RLhbif9KCMaNA09njf0CSutz5iGNEDnTUObMtMyYT3W+9sKmhPR0I7QJwBuFVSdoCZoBiZjpF5feUNetlL6MwAzQdUJ+hInIWdEQy2DVUJ07ghtDKy66QD2kIL1s6Ax7Ms0IlGAWHIAekittMzlU3IcvaPp1oWBL7mBPaABWbK+6nlupmTBDXCNZt8Y0UhTgMG6AzDgNc/AoPkvu5VKCLV354wCcMUAvlEwtIFmWJgF+L9YTwW4qnt3z3JAg2qbbBbHGGZxadB/9PMHgKv6NnmOCVxmWWIcBnuLA3in64IqfdNRF1r9GFDWgwgPOGR2T8D4fnWbpQ/F8aWe+sBVN584wwKNWf3fh1qvh+RVeQ97t3KnpsrffXIstPqBz9pY2HhwbW2FA/p1/7njgUmL059xxfa6h9LSOzCqFf/UEXTp9mkuaPXG2C+AGrQy1tI80KWvOxxBY0LjgsZqzUUSk5NMWbvsCJjUut/GuN4S+hwH9O7ZSKkR6MJsmMvaf7jI3JXlYeuhf+3lgU5pi26gp9sBbc31MRUp0nCzwBhjSWQBqcrfB5xDP7rQvsoMF/xc2bt4/ZQj4PJPHWzZ20zpow1Dr4toEAb8uhUlKHcpClp0XYrCgJ9wQOfCYWdJbOY8F/SyhzJUj7O5+LWuk107xVSYpLVvPS4ttcVmrqXfr6nvhbhWWaue19O74uIgDLrIAV4YCdavuX/uYrMyvJ+HWXZPtoR2kwP61ek6Gwm4gcBUeoJOsu6TQXzPsBQroT5VHg28B25r2ekwvqdYsvnnfeW90VNvC7+FyyxxbMhZ9YvobNreN1RqN2DgOY/gy7sj+hf5tMx43RqCGL7ZwiOdSm1uNgi7Bv9L2PuyHsurmHEbLT7Quk3b5D9O/hJaL0JAvD87qnqD9nUIiwX4fhW3k4/qCw/uzLS2AEBrR4CauHJCy+YXpP7BnF7i7imsw/uxqMFXHXqEq73238PdeGKBE4GfLT2s88WbYOwNt+A5mC+ucHSEroWHY1HQ6pHJoDgYnzrdd5musW2IfkO5DYo7GXFbHwO271GamCHb/2O2ZwRtY4jUuR/b8cB+isA9S7zyihZiBXQT9AXon6AvqX0CdIOuTfoNVzlPCDRCn2uguJuBSz4sJJbof4M0WPw+TXD4nKegMwSGz8/S74ma+2PU/sLWzgK9QrOOIEnQ7sqSe3/GN2igA5W32b6MEdSwrQ/D5upFAsfFwSRBJKk9SddVmaNrfH7GBp08pp0Fujpgu/ssEzRaYJxcWNlcd5CsHyNdIXcPktVv0KToNf3eoskIUf/j9IyhGksnbKGzWtPuWWLkwrWJYtYWVxmamAzN+BxNyoItbg0avE7Ai2Tt/pp+g+S2WZqAELk5es483We/v9q+bGv3xRdffPHlo5N3CwbjLLTGqs0AAAAASUVORK5CYII=',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD0AAAAyEAAAAACaz1CjAAAEV0lEQVR42u3Yf2gbVRwA8AjdaCfI0FSCpNI/wggjlvyRyQ2C3krAdEanc7Wdy9rDDreaMjbs1lO6eY6sDTSUrNZRtWhS1/24ti6stLSha7RBiz1G0sYuhbpdbaCBZnLY3jzZWc88j5Kl6eXdVUHF3hcC7+VdPrwffN97UQn/2KPapDfpfwV9r2CU7S5qf6QV/zhwZf5WEVeV3WbFsdg78+xk8wR76/PptrnCZeov0izZU+hgy3yZse/g+3xEn2710/PfaPq2khWZMfz0dNuDlg3RKyX97jf8a9l0nDx5p1MQ7r/wdclaNB3XhRluxaGQZsn3SqVZMV68dEnXMy4Ni3FzB3dfAR131FTD4DKfo8DZfGHk2lcwvH90KSCTZkk58NFXnc0g2nfBaLLihm29nquy5xg+1GW+Q3kiDKKzBY7f3JE951n0YDkcfsl8lkvTTbWXQ3B8ug1Cc1W5VvVq1L6ZhkG0LcLp68KvyZx0TyEcthmIZCZ9fkpOvyebc9LHA3AaeyoTBvFJKZweeDIHfa8ADqeSiTGbbtXDabKCiUjSo6wc+iyWTTfVyqFnOEn6yryM1c1kwyC6P1I62xn0xTE4vf/R9Wnf23D6u+ck6VZ847R3EE6PbZGku05vnP7iIpyeYCXpfjec3ouc+3A9+upjSjNaBh3Ry1nh7+7Nhl035KzwH0sl6QfP7N+lPI3KTaU9X2am0jXZzOWB06+fz6Y/+x5OB2/nTKRTe+QMOT65drjhBwayYt4H2TTPbFO2W4P4FIXDgQHofj03bDsDx9/RpWH3HTl9TvbJOCAN58Ppl4tXDwtNtXJS6O0+mcfCzstw/LWaD34DsPIECjkMdxfB8XKX85WuajgcOfX7YUVXgPHW8sdz0w1vLRwNXYUdi+42bODiw5Jdp/cdXJ+tqR7ZKbZaaAkMSKWQyCmp47+M697PnpGd55IP5zjs2wtPTBxaKXm41WIv9cPg8TTat3Vsy92GXw7/LZdcrmph99SeuWGWlG7DU0uBxd6lQO5L3n/1ap9IhEJK3/F6h4agNMPEYjTNpQ5w0SjP/3n5izPM+HhqQHmKYhhB8His1mAQtIjFwCdNJxIUBb4Ph8EbHAd+IZFYree42VmC8HqhdDCoVptMGo3ZrNcbDKm9zKXVGgz5+YKAopWVVmsiYbXqdBiWTNrtFotWG40ShFbb2BiLaTQHDtTXU5RajSAajdcr1ofDarXZDMoyaJOJ5ysrcXx5ubiYprXaWOrZvl0Q2tstFjDUwSCGgWHPy7PbjUankyBwXBBwnCDA+3V1BMHzNhugQX26LIMGPywOEIrSNIK43R6PSgWGNxo1GMKpx2RiGI7T6fz+UCgeF9t2dBiNDEPTbjeCUJTYa1Dv8RiNYhlKh8Mu1+qyOHECzJbNhmE2G8/X1aHokSNgdjEMQeJxv99qtdtnZ8W2HNfYiCAdHQxTX2+xHDs2NCTWgzKKgvLm/2ab9P+L/gM0nBMV21FYiQAAAABJRU5ErkJggg==',
 		),
 		'maestro' => array(
			'machine_name' => 'Maestro',
 			'method_name' => 'Maestro',
 			'parameters' => array(
				'type' => 'MAESTRO',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'WidgetAuthorization',
 				1 => 'AjaxAuthorization',
 				2 => 'Capturing',
 				3 => 'Refund',
 			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '5018',
 					1 => '5020',
 					2 => '5038',
 					3 => '6304',
 					4 => '6759',
 					5 => '6761',
 					6 => '6762',
 					7 => '6763',
 					8 => '6764',
 					9 => '6765',
 					10 => '6766',
 					11 => '564182',
 					12 => '633110',
 					13 => '6333',
 				),
 				'lengths' => array(
					0 => '12',
 					1 => '13',
 					2 => '14',
 					3 => '15',
 					4 => '16',
 					5 => '17',
 					6 => '18',
 					7 => '19',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'Maestro',
 				'cvv_length' => '3',
 				'cvv_required' => 'false',
 				'issuer_number_length' => '2',
 				'issuer_number_required' => 'false',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD0AAAAyCAYAAADvNNM8AAAE9UlEQVR42u2ZX2gcRRjAD3JXIkSI0MJxt7kd9vauJwk2tQEFA55UiKFilIq1Bg1SqWJaT1tq0FQiDXjiIUqPNkKL29wVxD+Qhz4EDRLTFluaYKp9yMOlvUrS3eXykIc85CEP4/ft7YaouWSz+yWndD/4uLvZmbnvN/N9M7Pf+HyeeOKJJ57cpzIblgU9FD+gC7GUGoqnNSGWUcOxXlWQO7Vggtnu6LtSnT+ntgVyWrc/r/XVDGpZ87MLylt9o9xfVdAiY/VaSO7Tw7FJLRzj62gR6vWXGAuu1lfNoN4BUCP+nLYIyiurPh/I63kYiORWw9ZqgtwDEPM2YP+pi9A2W9rRWId9ofE1Oa2wNmhFHQ4os81b48b2ZnZNvcse0fd8dvOiQ9iVuhQYVN/cNGCI1VYtFNfcAv8pNvEvX/mKv3NsjO88XeAE4By8ZYA83ktCVAaD59wC32vYyU8fHODHU6OGpt77hUfO3iEBhzUhTQcM8QcGT7kFRv2m/cNlYEvfPn6ZP3R+hmbG82onCTTE8BcUwBO72v8FbOnzfRNEs63P+5RSkMKtlyigM69dqAiNys7cpplt2NtdLl7yOQrg648+tyYw6osf3SCabW3Jd3FWcATMfUk/GLxAAX3+hU/XhUalim04wKQcxnJ8LwUw6sm3LtmC3v35FNVKPuJ0X05TAN96OGkLGLX91G90Lu5EwGCFAnrssZdtQ7/6wTUqaO4orsHgUQrokSe6bEMfPnGVDDqQU1uqBv1j6+tVgXb0JqYL8tD/eaa3KWrCyUwPUEDfaH7WNjThXs0xIbFx6FC8mwL6jrTbNvRTn/xOBT3jbPUOJhjVPr3eEdRS6cw00VFUPefmZWOSAnro6XfXBca3rdoLKtXhpM05dEg+RAE9LbXw94/+tCb0k+k/qBIKBVcJBfP8XaAA//aZnorAR46N8Qe/nqV6p97vPk3UILdRQN9lu/ipN37Y5DO3dqVxR2MdY6yeIpHQT5VIOHH0578Bd3w8QbdiK6UgAsuMPU6SQQGjv6c6i1vgB3uv8weUexTAC46OnbbiW5CzVOAvnfyVBBgWruK2nN60qblvXNEdJvqXE/545bP97PQef16fdAl9yXVObENXOkIsY9xY2IfFXJuCebfljmBrMe6tIB439jIBg7XVVzsr08N4SaeH43m8r1oliTgHx9lhvNjD25GKHQE8HigwaQ9Qt1YBnQMdhzq9W3KV4yDjsh2PsEWX20atojHUqt9UerIJAnssgz02+Z81MMZYc7Qh2gRGdiRhOwN7g5Io7sPvJkA9/N6PIFjXLAtiffistfqRIpG9UoPUgicpOcLSUZENRRnrMp5Be2yLis+h/ID1f1WBliKsDwycN4wUWVES2aQssiksRzgoW4xGmBIVxQUsMwZJZBr8zoKOYx/m917QjNHGqM9Gsb75fAn7L7cVx43/jLABGIx81aBBUzjqCGPMNMwYGi2LYjcaZ9brKQ+Q2A9awOc4EOglWAcHCqGxH3RtC9iEnkOvAE1Au+EV5TPVm2nTDXGmrZg0oBAIweA5DgjWBaA2wxvgXIxhYLpvJw4UlmNbc9Cu4efKfg3XhgGz2sL3K1WBxtiSIlKrOfIZ/IzDdoUzawLtM12x04pDjEl0YYxVI4ZF8RC6OLbDNljH9Ips2YPK/VprCLo1PmNlSVjtPPHEE088uR/kL0AODRA6ZWjXAAAAAElFTkSuQmCC',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD0AAAAyEAAAAACaz1CjAAAECUlEQVR42u3Yb0gbZxgA8OJg7Es+xA8lZKKDQBx2tJXqMdBiR2a6Kv1Q6EBjd8PRSzdLg51amlxC2sqscqYcom2NzLmU0i6T+a82iBARdHXZqFsqWZSu6GzVRk9rQyR2Sd7laqUmOe+5mJaNzTxfAveEH/e+7z33PNmB/rHPjm16m/5X0EzznXdsMzc0100dtUMWzzxXzurCxMpIiV3aPWmX3k2f7AllJUj7qHabNrlYHxmaUmvLk29fZrmaWquM+aR0Y1TXf9/5wLFF+tlw94XjWDS7Hnhv20G/GKEHDpM5Et0Ybd/MXIubZppj7zY6yrJvjm7OroVhjyM9Ltpt+bwPglW/n76pO6S7C+GktCuNe+c56DmrmgLhgtMmrSMcfwrB+xoF0X5xhRmCi/UnU57Dz4N8A8Z/tQigLT/BcOmhl7DWodsH09X13v0APWc9JoHpilMb6TB+C8a7JwHa/B4MfxYFhyME04Y9y5/w0MHC0iMwrUmLoQXt949NPPSYCoaL9WdCsbTuBEy3VvHQNzQwjDtj4TAtEbLkPPTVXTB9vIyL1iKYJqWRux1BVythmhjeOv1wKTE6uHU68l0WQV/64PXetefppvTXhIBK1spJh4TQqwub0n0MTB/7iPOEEzBc18Vzwj3zQp7rilMcJWUvTP/QwltI4QahWP/Fya1Vs4kVXnogU8CSv3n2SdRyn4Nhkzm6YYiig4XlQRgvuxNBd5Bvw/TYL+D7+jc3TJdoq67FV7/NuA9f9oINkrVFSLNw9q8XsEHI2fbuX/aOSgS0hfTHQmo5i+t26log+LwqsoDy0sHCtoOCXiT1MExVP94b5wgwkLn5ALA2BHTUPrzd2MkPW3pjezIBg4+Pum7CezkfL8nVXXNWNieUNVJS18XNNgKjDzDu+cVDlianpnS9WVRTte/aZpjmjTmhrImVrrSGt9bJr2ou7xtw8Y08cQ65Tyc98z6KP2cpbylPyIz5Xxntp2dHUl4p7ZKNK/uTAoSHsacGCISWvTbJ9KxLFn7HMf1J/lU2Z2jFKffhdXp1QzuDkE3ikrlkPrxngf1dAjSN7T6jbsg1FOQrBmnMw6R/WZmT4aYxlyxbaxQdXkTIKGqU1iR7mMqcIorGEJKNqRtcssOLNEYqyu8lRLcWBohsrYdxyosoy4ekAqErB2jMtDPvURGV4R5XkgrFYE1ygBhJYWGEMv/wr96f+vQS+/39qYRodhFzDexeFlHjygx3O5OtpbFBVJA/KrGnItQpdsoL8qdnnfIjF53ytVwfnveIvXrUmwDdn/RzLkI1yQgtqq4cQMieSio6xewu9ixU5tgkPvw7pVG0qEIoQNCYURQg2Fz2jJTfM4qmZ+9Psde2/zfbpv+f9N/ed38ctvffyAAAAABJRU5ErkJggg==',
 		),
 		'americanexpress' => array(
			'machine_name' => 'AmericanExpress',
 			'method_name' => 'American Express',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => 'AMEX',
 			),
 			'not_supported_features' => array(
			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '34',
 					1 => '37',
 				),
 				'lengths' => array(
					0 => '14',
 					1 => '15',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'American Express',
 				'cvv_length' => '4',
 				'cvv_required' => 'true',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAALzklEQVR42r2XB1jTZx7HaYun1YqjQ8+F11NE6T126FljORH1aqu9WgWLqGft4ylDVggzyIhAWGHKxgBBCIRlWIGQkMESlRF2SBgyRIQISEIYQu73/ycG1HrP0z7X8n0esuD7eX/j/b1vNBR/wI+GQiGMqItu2CcwFvg0CpovgoJB8NgoEAwIjBui6qJrv7nfWkOu7qp6u/wIT6fMrNS15GDRF3ln75jn6uXQcg5kD2WxsiwzAzNdadyMJxluGTvTL6RrpM2m1aaKhzRRSEVKfnshlxFQsp1JYemzAlhtoACWPnO0BMtoK1qZ3043zTHM/Dp99+17yf9JUMQwbhaHngpk+7K9jrjLrsuv67rtwp9zveAS4hzq5OCY5pCOE9qL7Ffamdpm2JBELBRS5Q2IthJO6RirrcyIY8yhgIzLjNjbAGSsxNzZmb0mYzrtZspu8mD83ihCmISE8Uu9YeKx1j34eogbD1/uKnW5iEIqAEKzF2G5WC3bCVtDFaTaDKLgsPTLlnIo3EaeNu8aSJvbyKGUGbECEEzhe3npuaFZemgsxxLyYjZHWAS3BHzsPeEx6Z4JkDCAUF0mnTucdzppOR50OASQzpcgNedLtpeOAWKUp80/Wb60fBi0lH+Ld40zChj9EmwRtQBLXwmxZKUdo0SRv4uNi1wCCbP1EXrK3WXuR67rAqQCIFNOYoCscjiEO2yPs+PbrbaRqSD3lkEt2jgUQDAr9lWaVRaCzCr28ZmAobC3MUeVseRk0Tqpzilu5MG4PZGJoSNB7xKXe4kWVcXAJQQgei8gWBM7KkCESkh+6VdlRtxG/kkEUVVU/Q6iykLA3OI2liVDLNuLTPNkuZ1own5KWhdPiKoPkwRJ/FYQdD3WvlR6eye+GuJoR7UNEgWhkPs6rACOMU+7fCmK+L46AfQ9YMzKlyKxsKApIGHb7+zMck53u30v6XJ8ffSmcAyJ6GdC4KGlP7qovxDIGoDsAIjpAuQnNFnXyocrzSCGhLuedz0BA7GUDyN1YbVB8fUB4phVmfF+6jpo47zohnBfgIxDf2Wg/bULr6WGpP0fIEl1vwXyR6QLCj/2uxf+N7Tw41/dwn/IZvx1YyWJ/pvGysKAZG/73QZkRQpntqNH5CK+0IDpnOo62nVUuJ4V0DAulotpIpeOHmF4+6XW6pZvmh4I+huu1nlU2NE33H270rv8ZKJBXnXZSJkP+ymbyN6aic93LGWWni56L7m+RFLiW3xg0ajnV/Zajf+7z0jy0Sxj+szAgYED8/V3s2d8h/b1U8Zl47Je5kP/nrN9ZLm1uE10VijuaZRbz/g2GUrPKBSy5qYdzePy0rq/1brMeU37NBk+eH+sQ240cEygq1AsPk9y5vZwI0vIpZvmyJKPikwZ+v0UeelkYNFXhWeER9s/yLfmfcL5uXL5Y8+kdXlb8rbEr6edHk8nLu8xK13h6RDxPONExVs+Fi6TbX4Khd9Gx4PxIwpFyf4btQqFjczmsOhbFNL9liQre81wTL5hn9FITcH2+6lcOJdb+/lrmfVtd1tdmXlDc0OXn3Y+/iJBMaEzTyhnRq0f3eV9vuNdTzG3WaGY8wosZG9NXkLWB4hZwmmcsGm8ZL/3BojE0EZHBRndUHmbYfFknrO+bGY4JrfzyTzdtH9fEaaXyWC0fNN8h5ZNx+QIufxHA7GDUYRw3+CWqsIxU68jLY7uwaJrsByWK1XAZ/7oJH5ykVjANKbhvT0KWm9cgUhI1mIVZLA2dfbOu/l/KThF62z/IMtZZlqVSh/Pb5+vL0hsetD0YekV5Z3j0YkowqMTY1rFtNChMVOPyW6fBIPcaJk+2YZACfjc3wtvlztN1GAaS1vctrpa3diEQjgqSLVvhuE8AbEprKffTt8tWzl8PH13K3xIxwj6BdHJx8hxCVfScANmERbjsp5Gsb73qjEtd1m3T8sqnyXIDhG2If/NprgFeDYy90GVI7FaiKGNjrWuCjKwferU0Lqkyw+1p0akKVLuPGFmv5Q7s39mv2wc+T2BndCZ0JGeeT44LpsnNBk+1xzTml8/pvVcUxLyXHM0bXTVnJe/V7LguebT9KfpcqPujdMHJNIxrEJhLbbiqSDcS3lbqFqwVh5Do/gzRHRM8Wf58QWnivILawu+z7Ogb8h5nL0l0yi9JZUdPZckSiQlLiPrkn/0tvb4MdIl/mAUx0nskhGDi7kd7Rf9D7/qoKqb7JtnIkysda3OdvSikGxSBCNqb3RD7L9iYTfHE+LrQYT4vXF7YuNiNkcRbhaHY0KXkDABNsQd3qs85bDLYZSgQxEdJujsRXe6evqiNy7rECveNb4KQlsWuiQsKWLzzeLIU1EwxKM33b+6+JI540sxEWJfvJplPHwkCVE+n/PqzeuPXfhLuVF78uxJ5fO2A1Jr5LGvD4WkNQaeImGCW0KXhCaGScIx4Zi7CYOPEuXkDPLqW5/Eh9XVzBOkKbGuERohj4MHgz3TtCUhDFyQeeCWwE/JxCeTFVf8vvQ7TtSI3DHtc4fk63zjCsFMoShq9Z3yeOBOFw2jkJRLPkIiz78lgBXIDpKQiCRiVWHfniBJm7R3sPedqo1+mFq3qA/J/iXBgV92+zTz/c1yP82aj5juMhe2+d+nXS9lhl7s1OzUfHii/hCOKtAV7xWR+x9a6/I1RFc6Gh6SUUjSek/5jRXeq3yCfNlEnJ+Jn0k5s/cdIi55xe2/pvhDa7Z6TEZ8N7OpbIRYWtdVdZJwm4HLig78lOVfSMW314lLT7sPx+hHPUuJlX3sakWaTiis3D1X513luy4Sw/J62IhCEre6yzzWekx60ryOEHQJOAKP+7THjKBbZdbwdX3ELOPWeYI0cOPI2rIzXttupZANCg/LAjL7fP9O66eY4e2aOUxWAP1+1v2jAo5CMXSppjuHZ6Pz6O7YinuZDIHV8uo7KIT883W5e7B7JpxxCAzEMer28VjLWMUx4iynWAV4D+PTtEl0ek5QAwyhtJ4fJlZk4uPan2tO+8SdzchlLvP9DEb7ft7AwLFiS0Zz0lXbscczRUsLk6j/NGcLwlHILdJ1XWhJEBykcgRYNjJcmbMu57JSw/i+P89sytfLmmesVCjgJJ/s0r5H51o8fdZZXNNbc7zZhJpH7aW65ml1XU11T72UzRftk1pT5ihRmYd65vo1UEjChNsuN55bl1sYwBAdzdnQ1aBU9+buzQ8+cj+U79xljqrIxdC5o+JK19udxQ1p5d9CwX8QJ6A6Jd6LlFxUV6eb29HRgKgJw47unFVCvsWfw5cjcjMF3IJMle/CPaTCVYpEAIApOGLFTg7odQHZfMjXHdh+WC271bZBNiRkWlntuvbMUmoxad5hrmNu34FHIfE/uV4AUV0rAPaSwJyKfAb2yL7uUAH0HCtUiMO/gIBdbim1JJmTEIQaEidyCXExRI0mXQ1QICIDdO2TLhfBfmoRwEkFoCEIuJO8hrj2D0sDy+1KxALkT872zqFg0+E8BTi1wBo1R+zhqoOkCCKAC88adQxcuMCZwp1kMeKcpYFFuzn7FUjs5058JwfnnWAkBpxaiDVqDvYASEMjQADCRWkCBJzkb0SoITEVYFCBGIH0AKiUnvIdR+RTZP3KFAkXYkDTlIEgrEPehFiAvA8GIMfzYPayzis/cTikXr8SgMRARdJkuw1iEFs7QEehtXgVoYZEbwQDIY6GWL0qdO1gj8OC/Q57nP3KF0myzYC7CJImjhXP6izStJak1xFqSBTT/giyRhwWzF4WFl07rF65fju+KoIMVR3ESJoAcQ5BQEe9hlBDImdhdVxsJ2L1qqBFkeQo7U2hBguAEBUAqcSLrfcaYgECxyVWC0z4UEzHRTJBrFFz6gt7VYqUgF1KwC9V4jXIzSDI74TthN1qEHWRVqPWSPaDVPaH1SlCAM+g1BCDRfCbEWpIRK0NyXYbmMjAKmhB6GtD6B8SsnqlPfSRMkUo4EWpzbBvQqghNVUMkVpTxYZKMaYWvStiHGGEMXBFEaj0ECHf+QrXFOBB1f9LkuMo5Pf/+S9MtpzOyKtavAAAAABJRU5ErkJggg==',
 		),
 		'diners' => array(
			'machine_name' => 'Diners',
 			'method_name' => 'Diners Club',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => 'DINERS',
 			),
 			'not_supported_features' => array(
			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '300',
 					1 => '301',
 					2 => '302',
 					3 => '303',
 					4 => '304',
 					5 => '305',
 					6 => '309',
 					7 => '36',
 					8 => '38',
 					9 => '39',
 				),
 				'lengths' => array(
					0 => '16',
 					1 => '14',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'Diners Club',
 				'cvv_length' => '3',
 				'cvv_required' => 'true',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'jcb' => array(
			'machine_name' => 'Jcb',
 			'method_name' => 'JCB',
 			'parameters' => array(
				'type' => 'CC',
 				'brand' => 'JCB',
 			),
 			'not_supported_features' => array(
			),
 			'credit_card_information' => array(
				'issuer_identification_number_prefixes' => array(
					0 => '3528',
 					1 => '3529',
 					2 => '353',
 					3 => '354',
 					4 => '355',
 					5 => '356',
 					6 => '357',
 					7 => '358',
 				),
 				'lengths' => array(
					0 => '16',
 				),
 				'validators' => array(
					0 => 'LuhnAlgorithm',
 				),
 				'name' => 'JCB',
 				'cvv_length' => '3',
 				'cvv_required' => 'true',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEEAAAAyEAAAAAB2ujW1AAAEQUlEQVR42mP4P+CAYdQJ2Jxwt2Dl23k98wUWVC6csmj94hdLWZblLO9YsXjlvlcHkdXd0Vv7ZVHuoj2LDi3WX1y/RHpJ9pIbSyYu1V1a+1IEWd3NnTu+bDqwxW7ri+2pO/l3Oewx3/tvf9xBtUNhP5yxOOGmffpv85VWXjaNdooOS53uuMa7b/EM8b7hxx/gGnTyKhdM3TWN1PVOx50tXdRcHrlauH5xe+Ae7P7J448nixefV/KlUpi6y40lJ+NMEj+nvMoQyrbKSyzsLEmuUKr2rCtsnNEy4cNlDCfsmWAra1pE2AkH77vscFIn7IStfeFPo3lJcML9dquZxtaEnXB1t/MZJybCTjjzJ5SLRCekcxlsJ8YJKQaOYoSd8Nc9K4VEJzydry9OjBNu3HTgIcYJZyQCH5PohB1OxDlhvQdxTlghQ7ITFjwlzgkLWIhzwqQQkp0w7dmoE0adMOoEypwQ9Tw3rril+FrJ3YRP/rdo4oRG6xddLz695H+57OXhw3cQTogXWyJ4rfTnH9RK/l3Fme2rJkb9gTjhU/Iri1ctry6+zni99Y3+m+o3J97Gv13zlOdc5pzlJDihSx5hweWLsNJxXxG+5kf5XOTKGjvY+48iJ6D4u2h+TvqvmGkxL9I+td3d+undUXQnvP/WEtn2vPNg99VNMn8nw0T/afW4UMUJNyuCYlGTo/efDum0DchOeHURkRaOuCP0zuelghP+esZqE241ITthvxKVQ+EcBzENN0RELC7+yQoTPbiSKmlhVSMxTsAEdxWWy1KYI2BguQl5Tvj//4nUsi9UccLxF8Q4AZEWchYc7EPo3l5EpBOWHEdoOq+I6oSff0IWkpYc808g6T7dnIvhhKPqnuWoTvC89PYdQtPSAvRMeTrU4wO6Ewp1E9bjckLtLWTdE+Ow9iNOlrZdiZhhddvKy35z4Yc7WgiZT/JxHJhF032/Dp6AHJAT/LfkNy3MvmuLu2iaFfbwGkLnFyYcXRlc4H14+R1YNbVb6epuSgvof1rLxbA44dyeQ1/f5GAqf/R9kVzYedSaslx4T8RHNUy1j+0O1qNGBCb4suzy7RlX8OQIB6boulyPlvttEu0mTfPyy0PscFfW4SVF2h083frdjd0XKwzSJXw/j7aaRp0w6oRB6oQbmjRzwl0Z4pzwRoQ4J/ySINEJEbG/cohxQvRskHmEnTDDC23Qj7ATpk0Hj0MQdMKck8Q54ZQwiU6I7nqzkhgnxP75Uk2ME6YG/d5HkhPC7K49g47G4HVCiP2NAog6/E7oynvjijH6is8JBTH3EmHK8Tmh7PYzQZg6fE5YcOCTDpYB4P18tRfqORtUG780C0Bqyk7mLvnudwtnXjVBVn7ErYO9k69zVefZrqyu/K5SSE3Zs2uJ9PV2ZHW7D01unVoz3Xlm+6zncyfNj1oYuHjTUqHlnHt+vogZHYkfpE4AAH4T2J6tZ6Y7AAAAAElFTkSuQmCC',
 		),
 		'openinvoice' => array(
			'machine_name' => 'OpenInvoice',
 			'method_name' => 'Open Invoice',
 			'parameters' => array(
				'brand' => 'INVOICE',
 			),
 			'not_supported_features' => array(
				0 => 'WidgetAuthorization',
 				1 => 'AjaxAuthorization',
 				2 => 'AliasManager',
 				3 => 'Capturing',
 				4 => 'Recurring',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 		'directdebits' => array(
			'machine_name' => 'DirectDebits',
 			'method_name' => 'Direct Debits',
 			'parameters' => array(
				'type' => 'ELV',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'Cancellation',
 				4 => 'Capturing',
 				5 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAyCAYAAAAqRkmtAAAEFElEQVR42u2ZWUwTQRjHG+MFKjHqgw888ACKCQ8aE+ObPICaaDxQ0BgSiEc8ovHCIx5QS1FEPJDGqAQKAkEBpWqiRSVFeglFa2y0WoOK1KCpwbMiAf2738ASKkV3G2kr6Zf8s7szszO/nfl2vt0ZiSRgg2lSTagkTZs+Rm64HSzXG32hsRkGXVC6TiFJ080eCDJshEz3ddb5h5/PmlpRaH7nMyVefoaRMn2HJLVuWT/O4HRD0dKLTzrhJ0adxcHa+4FOzDQ+UFnf+wsnvnR0gXNDcCM9yQV00tF7Zs3Lj25vsrxziho65YUbOLdDCqMsEygsFC6t1qXdHtCwv4IaWz4jpsjSfYNAJUyfg6jwCEyLmALFhIlcaxLhSk4WD9re+QOhxxtEQc6PXc0AeXkF1Nz6VRQkadXU6d4HpXOxoIvDIwOgHoNOPlYPqaYZ448YhYEOHw6kpABLlngPlAtzsDq+sXJhJ03CQAmSjKYhb4ESHG+CQQkwAPq/g1IgePmhnalvUBAEWlnJPV2Ye/F+7NPpiQcVYQHQAOiQB6WwSeHzd+VFzWBwvOqDgvuDms2AVOpeKtXgzaMuFh098Bzp6wl/ZcVTRCsfMe2YGoWk0NBeVYWEBCLT0AIdna6HtvmTONANG7wPyn+THqh5Je7DOTERWLgw8Cvi36Ce/C7HRUR5H7Tzx0+XF0WIYueu8z4omenNF9GrJXEz53p3SadvzxIw5QlVTY0JpYdzYL5Qxjm7RrisVs9BfWlDF3Tfnr1u0/POnR+wkWq1Gg/pk06A1d+rR9WVK56B0rJjtt7eC2p7ZkPN7TvsWnE6FzabDSvjE1BZXgFTQwM78nnU6P3GRjQ1NbHrrq6u7koVCqClBW9bWxmc0+lkZemc2rDb7eJB6QVae/U5Kh87WCVZmUeRc/IUzPcfYN2aNSgtLsbObduRxIXF41lZ7NxisWDRggUsrYTLr7hUzspeKivrrjQmBpDLcf3qNWzeuAnKggJIU9OgvnGT3S8/JPMsMkXmNiKl+gUDJRGAMr+gd5gobTf3L069R2n0IFSG0gvy81GkLHId0p7ph8rPi4llrhG/NA46rY6V+93FBIF+aO+E/O5rZGpbWAXkc2fPnEGtphZbt2zBkYwMdqQ8GtrSkhIc3LffBfSW+lZvWWb0BbV8Oes5chtVlYr1JP/wHoGyRQ1u2CmN9z/qsba2NjaU1Bu13NzH59GDaOu07AWjNMojH6Wy5BLdw6RhKyWUdyI7Gw6Hg0Gbubqol/m6/ghK2zfq521+MzXRy9wDOtkFdJhUVxJfbnX6CyhtAwXLDe/dbDEaIkfK9M4VFU9/Us+KCZn/WruqX3QEyfXfJam69QPshxoix2UYi8lffalRMr1Kklo3L7CLPpj2CzVm4QqPFGMTAAAAAElFTkSuQmCC',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAyEAAAAABfvcoyAAADDklEQVR42mP4TwPAQEND301clzohsuM2+bB7xbJzd5WRDH0jkm3XqbZ/45G1lMBZaRkzzwjCDZ3vP7WBGt7ev7E0Dm5ox4dzXdQw9EdLosbnHqihnbo3zBBST9Zh994StvqD01/sVcEGrx6D6E3UeCOCYehd4+6CRA1s0NZfbYVaqaWpTzc2OEEKp6G/mYvmYjfSs1atFATJMPSRAXYjEzXMyTf0hhkuQw0bB7ehBXIbdmUrYRrqHz1Pt+U6WYZmLH6u+/9/qTSmofOA4ntVyDK0VBokhs3QvSojwNCiuW943vBAsgOmoUenJQsgICiUKUxSIEOxg1FDB8DQbKUNu2DQT8DSFASdTsAMvWexbD4CnkgnKZ1CQOVU5FRJceKf/rzjY8dHOxsDCxC0Sxwx2TRN9dZW7IZO3U22oaASdZ0N9kK617OJfdjVUbiraOMSsg392wiJFiyNiVayDf3///4mXG0Uu7VkNnsgrr2/6YYZNrg/fKLYhu2XvmKDj2/iNZQyQF9DK6oR7FkByFp2sl6QwTTopNG633gM/c28wxRk6C3nPUX//0/2vHUrLHJ14mnx1Ykg3rrfZyXv3p3s+efP//9bNr3xfmFy0ujr13W/TxpVVD95gtPQ+5vmJ5/hrqjutJ/gdq4l+e8S28KSWKfuwsKSy5d9DGOdFn9YlZD8d4Xj//81aSsLNmVk5c57XW+6PbewpKkVT46q/L3SvqK6ojrWaV4IyFMV1aV8ZyXX/Z7gFutUUT331YJiiFdBSeispKvHBZmghUd01/2GBRkWQ7+xbbbcur2ieifrdIMDmnnsbfJ57BXVf/4s+VhdBzF0Zy9I9P//qbvbVzS1hkVukCwsAVmPx9D//89w3zADheAEt3fvVjhekDnAA+LtZD2sMytgdeIBnrt3Vzhevvz//6WvR6cd4OlVe/26qfX8+bOSIFVohnZ8uNxGjQT1mzlR4yM/1NBZa2cVUcPQI2uLLsA7Z88tszlmMF9uw549iYWrp2Rb71+K1OF9bjm/qVOXMjjV8PJk2nfNqQsAzAyRrevQ0QEAAAAASUVORK5CYII=',
 		),
 		'eps' => array(
			'machine_name' => 'Eps',
 			'method_name' => 'EPS',
 			'parameters' => array(
				'type' => 'EPS',
 				'brand' => 'EPS',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Cancellation',
 				6 => 'Capturing',
 				7 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE0AAAAyCAYAAAAZfVakAAAFC0lEQVR42u2aIXDbSBSGAw64Z6tj0Jsp6MwVFHQ6AQUFBQWdKThwoKDgQEAU7crpxKAgc5HcgHjG4MCBgIACg4KAgoCAAwUHDNrEnbYzBQYBAQUGAQcCAgIMeu9fSclqrZUtW3Ybe3fmjRxrdxV9evv2f09eWDDNNNNMM820LK21UC8cWjV2WPL2D0t+h45fyPbwHZ37yRBSWrvkPyZQXbJvGjt+f33joSEVtvc/bzwgKL0UYJGdf7C8R2ZJ/lIvwYticIr+14OS34QleF8Xy3iuoVHMqspQDor+axkKPrctfzcO1Xsx79D25biVFPCFN5L3XfSz/LdzDs0/kaDtaDcK2dsI4LxDu1h2tINupeyuWwbaJbSeBG0zBdqmvIznGtpB6eUiNBoMsUu7y5br5ajf4XX/jhFqpmXIAsr+7VHtw7WNW/OWMiE+nQ2RAQww75R03frsp0yUP44PK26UOTybcS+rvRkA4Yg8aBveCJkRplLHAzxuP+2alUrlxgrnf9jM9ei46TjuEud86OXtOJVHGGs7fCvVbLs8GYkhK/u4RmunJeNi17RqnzTgWkljGGN3HMberDDeI/ummsP4W+qzqLsmwK44/J+ksUlm289vTxGatz1MvQx9Qs8bCI1g/E43cjbEzRJQtqyOJ68pELCjYYFNFRoS9ByWeEtdTjrv0hkt2VhcxHLLMn6a0PrKPPCmdtFfonOvCE4jacmG5aSTJGjCQxjv9t8U+0rHXbKmxoNOEfuieejvT8r5kx8kpnmrKjD6/t+E5bunLl9IjURozH2RAKxRr8fHO5xX+73R/VuCdh7zIs4ff79cU4L22Vq/EQNheU+xXBONzsl9IW6ToBGgdzEQDt/T/S+ApHqjBO0/ZZ4jxD7VsKwntiwToHVzLCtJ0JQ447r3deOxnPrjkn0znKeZMaZ9SbtWLtAgMcae61KC6KFRjEubQ41/dqVy90Lbqd422M5pGT+cnKflUBMDrEHQ0saHm0ZPtwM6jvMgq+xAfzV+5hrT1J0TO2W7WFse1oLsYXRolB08VfqfqX3W1tZKjsMZxb8dOt9KsGP1msuMPZna7vmx+OdNCUQWywwNHtUnTVI2DV0DVBrbUTaU1UnqtI56HjsqYIYCtjWcedvamEZSQbYgU2CNpGwhkhUi11TG6QyA+qQLefCkM4JcSztZVbxkTTHedX8bYw6RlmUpBoyce+ZZ2hnxRlvYFMKldjwONPK+7WlVOXrwuDx+5JLVKxDgsdsJzZahoqGrmgD8JN4+ddJ+5HJg+R5+2zFqOXuIm+sGeSVroHQkNgUSpWFuOgqs03C+1YVJNSTiuVdupbiYRXJcmRbsjiPJCp115GU9k9AuSjtWjaGcPY6FP/YrpC1P885vhJhmiOQITQhYygqiqoaBNgAa3kZBYkBqoBiJ3HKca2KuaCeeWWgkQF+FL18WIRVsxl5DgsDrgpyUNaDqUeWAWEXqFcB1n0Ge4HMoUxrQZTiP/qIfPZDob7w2rFarv0ILRg8mKF7yJs2xfrWgOXwLN0vHv1A/g84SwAgQQISAliI4UZUXsDEGN47PAAGQIfACQIj5ON8MC5zNy/yUbGX1XvCAoOvcnR8JWqx0o69M0NMnKMF7BXEjuyggCngEVdTSJMGK76L3qCKDiODQEfDEWOZ6Qay0y+KB4I0WJe+YMwwJBQGa5hg3JMxNE7U58kYAy71QOcvNwDLNtCvb/gd00MUhADFJoAAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE0AAAAyEAAAAABshtU7AAAEfElEQVR42u2YX0hbVxzHO8iDDFsp820+trAy2MNeNpfuYS9jFBmhdTA1yJiE0j86SqStU7Lk9sFqLUYqK3dNJGADobrFsCKVSYgBG1skElKkMUhYuFtsk3mD3ovJDad3OT09u+fGm79rkxS8XzCc3z039+P5/c7v98s5JNbtdegA7QCt1mhC62LDcFuf+dJno0cWG0BL3aAF+Z4RzeeSzh0ODdQFWth9+gUJBvWNZ52pOdpe/NxhhKPzTQqTAl6/nhGhtcZo8x8jlIkQQhFazZ8gy+8f1RhtuA1FlxT6e3GdD9qor2qM9t1LjF9+JW1o3XS+GqMh5zkspM1hqQs0tDtntKRtRoucXGO0Px1BPsjvxUkb/y60xToOCpUy2vMvCylxo0ZoM9pvqdwqkKuuD+baq44WGiiGhfVwrspoN0/IAS74rd0zWodlUsCFC2u4Tf4lu7uP6Xn6vskX2d5SrMmqedqlkYvPlIGGMj7SlaPyYh7k+6elu0PETn0WpU/qtN//jTV+lUmTT25vTXwt3ZWUaK4Izdq9vz8DLZPCfrQAe/5U7kt12uXe/7o+MNioBFYh2kQo32TscowWVpHrRWrVj2a4NMr3K0KTWh/QsvTh7bj9ueTavTiqrwhNAP3H8YsuX7tzy2aSVuji0u4unEOxaHzJ+Rpi7QGHwX56Hztw9Ah28Fy7hPbHdQziVINX3+HW43W899KpZ4No9PTu/9qhCG2nE40e0RMhSY9oZE3ckNCGH6LX/vwF+YX3evE6wtEPn6LRYONyL9aqv7gzFdB6Roo9AF2K0PCaRWU9Cp/B9mR2p9pMypFmvCp/qgS0K0eLPQCTiBxNADkzXkVgbApmPLxuuTob3BwvC614RzbUkYuW8yMR4GhDbots5Esfg42gvFjD+3OdceuVdMFfGG2NQtbzp7AlxXkZu3H0DNbAe/jJ9esV7VD2RwihrPxoiWbsTvnmIK8UZ3gHzfEYykLrM+PxTucD7uaJoY79snaTaE/vIgVYp1qqDTBdhFX4HimPAbt8jSqzGpTa9OTL81A2kyg+sRaaAQuacjNQsIaW1vTkf+noGQGkOCmmlOVoqqC8n34x1178ACbfWtiNIJvdlPsNskNJcSWj9ZnlBzC/tYTdhRru3Jf1H6ey0fYsKopRy+Vr+aEuLlFs4Q2wD+12vNQuF0WjcvJ4I13uTmf+dEGqz4ycXUU02PQsNjgshbXYgJNyVdHKu94ytLAq0ZxM1yGaL8JnQLad9BY5v+QzcB9XFW36mCgyaY/BuuJUJ9OJZqd6eyuy4WgKsG79qj9qceujFqc6xQXY7a0A64vAz8f0P6zdCP+Z5V6baWHsDaG5NClutis2RbHJtKPJqXbrfRGIA3vf6WOzXcvZv15m1e9UC2BhLDZ138RnbCZYVT2GvzLWFSoL+VrQcJND9hR2o1svitaVO7c2x5NplyaygZKrSwN/rwIR4sSmvMzm+DwdVvGZ2S6XZo1Kpn0RAXgZ+iQZCnVzUpTiFsa8DKjPQyzwFp+vHaCVcP0LD+1u09BGa4cAAAAASUVORK5CYII=',
 		),
 		'giropay' => array(
			'machine_name' => 'Giropay',
 			'method_name' => 'giropay',
 			'parameters' => array(
				'type' => 'GIROPAY',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Cancellation',
 				6 => 'Capturing',
 				7 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGwAAAAyEAAAAADMGb3VAAAFc0lEQVR42u2ab0hbVxTAnfswqg0IC2LBDYclCsLUhqaoQ4YMi9DM4CamtLWODE2skKnDQRdamrWZoywmDSvWP8WUVKwzVKRi1xmaLVlmUwhoiKyIzvBwEAhNPohGSZf15uTkxRhrEszaRHM+5J373n2c3zvnnnvuezfNl6K/tH0D9uxnfefd35NLHv5mOeY9viOYp/ZGe/F5BjM5JZfTuebIjAC2qGR/mKxQKDnS6fEwMEdmvjvZsYhkUYgWAKvpgxMFz0dUq7JEDmrZoUSHpHs6CDY9Do1Vo25dorNVosEYzG81QbAv7/ojVG4/m/g0nHiwAn0QDHKhYPD/mF8SD8Zg2s8FwJgTRP2pNVXAzK0BMFA12lQBM3x2ALZPwKwlRP6aTTkwLp+IQH8Alixgih4it+8cJI83C2z23e6Kdmt3xaOxdTm1Bl6i1sI9NqMGjVwvvdVuVXdC7xn1zdKLBW2l3RXqzqX6cLC8So2WSLWSwWxp/nXIwtZoBYMhCxC5YHDAa+DZKLNonCXOZhpJa6Udeim/w+vOW6GlajRqMM0nMJKIfNPwtAOOrCXhY2x4HbSFq7xC8k8QHb3tVro3l88rVPSsy0PBiqZAa2kOrXdGVFlLYEvH8taHvMIqmiK4uPIovhKoMUSwRM5tiBIMQVAa398NTKCHf1XTZqM4HfvVbdAP50XxdrBnY5EDtaXZ53PrbNTcETwzd4RAD3hBu6iARVbACdqoQ1HiQaCJ8vm065lo3s5gRC4/uS+ylqg7QRN9MaP2+Zbqm1ygTy1sB3vp3cNdpmrl1Dxobl2OHILu1D0MSoSrMZJ2ODZJyTlxNmhbA/GVYBBWXL6dBToatzMYvw+vRX/hyDKkoc+2g3lqSYgR8z210MLPR/OKrwgGxdkXuEMUhi1ptbBBK3jOYD6WgddjSB7oL9RvvbUbWP8cXLnZCA+l3hz0SW/o3baCWdhozAMGtHSZiFatXFSF51MAQy91mXIbvBw6LGMCq9vAIb872GQGXOkqQw/ivZxCaGlybQdbVKExIwEQkhurlWDyqswk1Wgfy0LB0LcmKawfPbV5lTGAYSjq/SCrut2Th06CfevN0PLPn5j4Qb/WGmmMlW/6X8Is4eqdjBdIEV4OW0jO/eAOBaPthIw4di6meezyEzCm3tw/N7x+5tPdkwcNpmrCVEL8PaNuVoT6NBzMRvHza4wGXmjygHHk1pEkXr65wtoKVjUaGqCYZKIEs7PQZ1vTdjRgTiE+iLoNnAS4fIknUrqPXJdgulhhEWAIy5dJKRsNt1FBO8/GXHkY0jCkiFGTGdGD+XwLV+mZDORrmass0gRtYZukdL9xFiR7tpB+W+blnHGGF2P09H3pdBwllVM4mXGzVNHzaOxFMdYhMG4ilVTzYV8BdJLrmeL0Jlezorvij1nw1nYwAy9H/uMvZtEKy8KGfIipfoiyUY7DFvbnHxHLiGAoMpi5DZBAvJyj78QM5hTSx64yCC5e4V4VwTRYPEVu1SiE5zgrjiJY0SPQ376jk0wt9M/x+0Lz2usEO3VvwDtEYaBW2uMAw6KKFn5fqBdfD5j0Y/pOA964li10fQgiTo/vHcfegtFrgSEKVwIxJw9H79MOnWR4/b7IkIZ14F6BMY01foHpOXo5UXqBKzvUsfzqfgev3w7A3jSwLCq1wEg14wcr6iHqpdMp9xmJb4E3R875VADL+4BsjfCDaU9CEz8fK+lkBvvqRPCLpvc4519oLN80SRMLl2gw5gQJxOCuAdtyjjR4ylhprzEmSuDlTeJE/XfYBhaTNPl3emRRg8sRthw5Mtsa4Gt0cgq3zXJsx01iq9ceUH3vff92csmNdu3JlaP7dVtfqvz+AwuJuc7pa4yAAAAAAElFTkSuQmCC',
 		),
 		'mpass' => array(
			'machine_name' => 'Mpass',
 			'method_name' => 'mpass',
 			'parameters' => array(
				'type' => 'MPASS',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Capturing',
 				5 => 'Recurring',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAxEAAAAABkyO7pAAAJoUlEQVR42uWafVAU5x3HkUQm4zTvdkhIG1JrGCclvGhAlJeDC7pEMeDheafXItsBjkBoaRix6mhAIqPY1jGORoIhoOgY4QHRUEaqQkaGSsl5iiVCrsBpaXgLQjzu8Ja7o/vsw96ze2+8hJk72/39szzPPnv72ef7+z6/5zi3yf+zw81ex3Bp8wsVp05HnI5oXHxT+69DA0u0QxN5pv9NYF3f7pythL3Ie/+TiYpTjYvvfHF/7PsB7ZBh32MOPH78vRH7uDC2MCGlpAQMCR1k356hkyNfPtV0vH3vdwdGCscHjPLHBrhw6bSoZlAJsZnaTGwmxJSYgLGJ2kRsIhKoBCKBEFHyXR+Bkp7L/i3pnaf7fzXmpi8xuR7wgx/sg9pHpUEpBnQKVUSIiI0UHW/Ed9FBxFEw3mXiUM2NFx997jLAFxdPJ18rVGJaVAKhvktsoOggYqm4rzuLXAQ4uc4hKjEnVAKj0kGsp2D0/94FgIeengaVsESlQVnUNxhUgo/KgFIMKLV+KtYx8dFCFwCuqbGdqVaoBItqnan2URHoO1MRQ7kA8G/v/nhTsiVfS1QmgNOBh56eoynNEpVgQmpyOnDN0jn6LzEdagwPdS0TZT5OB04atzYlDuosTYkvXwYVMKhgLVhDrQFd7k4GHtw+36ZkjUqD0qjRFAxDipOBqw/NtynZQ40Gb1O5S51eeCQum19TQplqjUoHEFI3tzkZePCZ+TYlHipgUAFEFQIhiKJ0A04Grjo6vSk5QLU2JTMqO6csahSIAmnfOH3z8Gu36f3XWr7p3jWVl6MvR3/207WU6FTFhZsRd3Obg9/fyKKKr52+dHNbe8GVw7teRaiRVCSIBFfOOhl48Bk7merQf68Xs7fpWHJnkYlTSFw8+za19Ytvvbkf1fQ8RBVQdICHzt4PVxbO3pQ+qHJ04+pLRqNl24laAYigIqj4H2x+saTv8Orw0ult369Polqg9Ozw0ozb6tVP3EtSet5L0k9Y9mjG4bg+iQXwlp2z99/m4Nm+XdXCCBABwkFNPKMqWU7BmpGwhrCGbLXiuWy1QAnPwxoSPdt8uKBlYrkKXYcip6A7g4talZVejXtFtTkF12WwZ1Rb7CtNY9sFSplHfkCHFwM8sGMupqTzwB9L7W1NqYs18b7HMhrv1FS9/OhD3PKfX4bTuGGgjwHKKWAfJvZZ/MAoFM+hEfkB7GvghkCpWsCqgrxm3X+QfqH3kmImrXvqMxngitqZlg+oKIT+m9qJQe6Gx5RD/z0Qy6nbnpD4QAFHN3Guez6MxhX+Dp53Z1g/Do5ET3hNr8Ref7YazS53bvFra87sk8R5W/cIlKNaBliycfaVUv0oi2EyETrkv5/cwHCpLYx8qcSjuO38a6EgFBw/As/LdVwAUW1BJH+ee+msOycNaxD25AfUZ3ZnDMquy/BsplfDe7S7s38Le8rEBqPB2CLOuiXs0enx3UW1V3dDJdQlyjzgKBp44CdzqZQ0P2cx/l2IlhoBpVjGtmmLwylGvtRJfwy8ZedqsBp0VcLzzEb88EpPNF8448IaYFvWrWOlwxo8vkzMn2GMFTOJbQmOzFazPckKg5HN9g4vBvj8+RmgcisluoBIeIAfo+jvcKGB8sXVk2IZFG8YPZ9d5isfTq4CMIyp0DtxbraI2Ss+PoKB4cNxzWlYU58pV7G9JVGw7Vgpvj7OuyIZezS+MqyBvIZMzOzSm/Is5EtNXyldLMO3WN9KLzW0fFP/jNuyvoXihYEXp/qzq8gQsO8FeH51NxYjfkwuMJ6xNp9i32QFP4fbma1li5jfKhaw/l7sy+/JbGTv52ZIsW1K9lCRfB8Eso/TvwhmKpTv9SXYsyEqlO8BP87XR9Eh5EpwuxSeF0TiRQZfgYUoqkVraEmUqBbLFs8mO+JwnqV/12eikVw7Q6PvJTHAOg9HmWqNCiul9a34Ic+EwkyF8h170jwnT0BYKN/bf2PbxkwrwUoyGDz6FP6FDaom0uzrMixzuLDURLKIMfTcqxbgDD4Yjz//6m7+8iMWoHaD8UQaf0nLzWeATfLZoKJK6Uwo/sCYCZSrW1/EbXvSaFhaviHA8BLbdsMvGASTKQv57sqVLp51gbI7A4temjYo4+dl4zv8WqokiouGU6RXkpuP25MVUzm8XW1tSjQoxYCyqIwpwUyFlVL/IrOV7EeZuhrU/cVccHhBVCjfDxbhx0pvDwJBZCOzepdEsQ+xZgQZk07PFefBeJ0e11ZVWci0cD8qO8p1o1rr7BfV6idKolhnNhjxa5qa4cnJLnf+ThXPqTUqDOE/8TbhQs5qgOQ7spdt6zTQ4mXk22peph59+hagg9QwZsO3oGSFXCXs4RYdOr3SE/9droN1084TuOVwXlUW9PkY2pw6vEa1ZWI8Pj8AWpk0rSoLrt35AXgUSh6m8DigdIzKrqloqUGFAzo2iNBSE/s657+Pw7R46QgC49+zbbcqV4AVQHTJcq5s1Vhw5e2VcEVqXSSWibHkuRH77KDsT3+w1ZNejWadATbJ9+2aCSqSr/ood2Vl5AuqzG0meTBJi5eObefwS9i5YzlYDio3wPO6RHuwAiUU89SIE9yeOG/s4DC6M7hzh18MrMHFAusemYd5WTLPwVu/yWFNyR4qkm/fU2NPojjrGQIY+YIbhOY1Jtz/ERJEBpFQvicTNe4oBnuXk4EgEAweYyxtO86qXsk5KVpApGnQibm7pD3bYR4Le5IV56Sa8VEtvE7YQ17LD2jOhDopicpWY7cXC9iqTLXg4yNyFVZFsqIiGW86ed9LD+8/E7pOhTLVFiqSL/JfaEowU2GuQv9lZpVEmQrlu4JcQdKzSiLUQDKQDL+KbATbUV0iu+ext6Hk735tXTeqbfPp8OIWoPiVKT27Myz3z1b/LjWZ1NWFf2RBHaGiTJ0JagAIIAPIojZU6WKhYZd1+q94DC99/Yv31jlGRZnqCJUGZVD9gT/pT6rz+PWvXOVSP1tC1dFfB+L7ISrKVEeo0JSmUM1zSqMy4Qf8SD8SfT0g8+BvAFwKeKpanvxsa/hFrnyRKTGoJIvKl68ZlYk36difjfKKdV1oWC4KjDK705DbOZNMRfLlor5J+gJfsm0/vM+Xcdnqch3XjV0UGB0TKc17E+McoyL5clF9yfTAr4pMXi77O63pjoc/u3A7utDalCxQ6YhMKr2vfhVu+F36h2kzO77zOHYlWGkPdVdCU7bGfdIFD7cfM9iY+s0rO0K48l37ypmm+1pXke+8A0/thPZ8VbRx4sNVrS+PuU26/PEYPOL8Hv8FO/kly0SnMq4AAAAASUVORK5CYII=',
 		),
 		'paybox' => array(
			'machine_name' => 'Paybox',
 			'method_name' => 'Paybox Mobile Phone Payment',
 			'parameters' => array(
				'type' => 'PB',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'Capturing',
 				4 => 'Recurring',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'paysafecard' => array(
			'machine_name' => 'Paysafecard',
 			'method_name' => 'paysafecard',
 			'parameters' => array(
				'type' => 'PSC',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Cancellation',
 				6 => 'Capturing',
 				7 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAVCAYAAACNDipWAAAEpklEQVR42u1ZIVAbQRRdgUBUVFQwSTpFVFRUIBDtTAUzSAQCUVGBQCAqEBUIBJ1BpMl1JgIRgYioqKhAIBCICGZKNnQmAoFApEM6g4hARCAQ6f9/b+/+3e7tXdK004TszB+Y7L/d2//+//v+PyFioy3mH/8S+WUU/F9Mx2QMAHO2IwpeR+TvQfqhFA4B7MLUQmM8+kLMAJh1H9Se//9RR+Ru/N+6DwrkUqMgyo33wpO7wjtbGsszfKzPkuCAKN3W0QqRPBeN6lwR565F/uRBgOvJFVGW/UAQ5LE8Bzimdk4A8BLkAgG16cLcGYLMwZ/YUW7WJxHgu2uRe5ukey2eLoLOrUtncgCWbR/YK0rVY5uJGMDImCEFV+BvLUH2fopnr9tibt6S62fAGJtwZ9UiUmpWwECvAr1PjTeGTqj7QVRaIWMvyW011/Ri0eUpfZjX4/OPJ7D/hnVd/J0O21i17y0P6N3xDDaAaQ14Njwnpu+q85xK9xHM7YF8sb4P7WN9nypJ8ftzw854znJji96Z277UXKZ3MNc6JoB9gtWNMme7QASvmoQEF2cpLSr39GIKtHWHXp+MYabJtjW6cD4wpOw41qz59+quc29P7ph7xFJ0qfnV8XwvIDRqjSMyLnecrAPthXvxUTybh7OcwLkXYnzhWyIJ1BEMxGopC7hKcgeJKS1JSs132QCWdwTYIACX5GKK02QDuNy4TAW4LG/dTtJYjRj+z4jeRgRMZPTlxpqF6e+lpmhIv+vZAc7XLQD3w5TWnAvTcQJJQa9GjySBVFSWh4Eu/jYIwHiAEKRiptJB7+2dv4TnWsHzxh6+c8TPiZGkSxCMfNs5ByFmaAMNhhYMCgwIvp62DQeQ6/x1gJMMwg9Ld6jsJkbBoABzR8IMQM+BYIrDOQ4sXgGYSpP2zgwwrO/JfeMcgwJMzkn38g4BxQWddewAjoIxGoAV8blKTpsQpcpAm6l7ZwbYkDMyNL+DMwEsTyPPuMAbC4D5HUzMU3urvBgaYDoIplpijW1f2F3ps3B+ByNjx33pnpM3QwLcpTNoBzLBSwc4TqT+e4CVRyrWiCWPG+DlaEmUCPBtwMJx7SAtNuvuNqODZGkip979cKgUnRR5gwAcX3/UAKONBwfYyqK5Z1/44ISli65ZkQXyCFB32am1pMIyI0re6tFU7AOMTFPfu4HwvSHK4k5EAJLeOfvtJgPA3Ygzx/flxnaBF+oUHXNr6QBT5tpyONk+VRnYvDC/INkFGyIpAJt1sGbWinX2HLrH0bLAta6NRVv1Fvza8kVKKVdJBRhLH3ctzcgkErqE9B3qbBkNEl3b414cUBvAlNFgH94g4swcg419bFgD8E5B2jYBcFv40QGbIo4U3WP3YJvSX7wIpyim6An1qCUIBuYHUORp1y9j+Jr30ToYDBSd19IiJ4kbFAlRRA/qX2SxOnNo8qOi3LN0kmo+Z7DsyaKJdP2uW1InSzVpqqqBwjprGNnokKYzmG1T1QCJ77GfqD9k79ZOskb/+SvbHTwdI2/Ojx5g1RaMRwnvJFWnhh9ngOOf7Mz7bmVq+H/6/ZRY5PYII7hismNLh2o6Usdvqzly4PW2s40AAAAASUVORK5CYII=',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAVEAAAAAD49anJAAAEQ0lEQVR42t2Y32sTWRTHW+j0P/Bpkbzpk3nbJeShLEgI3cUKWyRLRhYswpaC2IqNMoHBdAujGKaCSEw3DTsEQg1MAxoToRRCl27woa21oCWIFdyWUIO6EuzYMlx7enq99zZTrWCq23ugJGfOzbmf++N77rSJbLXayVltVqudJPu8NcGftSN/Bn5y+b1gEd+LiX0ObLv7437v8Rf9cfXnX//we08Uvg7yq6PFjlyxLDUuw3rLessG8K2HsK4vr+JaJw/6vRf9e487P9TdCZYrNi5HWSpLG8Cnv//9u7UjzH122u9F/L1surJnwMek4gPBfeyXOdGzFy0sd3eqba+ONjLHFvCsdvOH6DtmhvfRzcoIDbIjk5YRRMuYTy+D70kz9YCNn3p7F7z3XhtBswt7mV1G8N7rTfX3TAVY7FSAkLnD7HtqetKyIwzYCM4dhpzzQ2m3mJMQS7stJS32O4Sw30m70+6V9g8VxzNRTU3j6BekjEmjrh/aALbdJwqoz7z98xftnDFxq6H15GoeQko+3tfdmbTopgzLbL10BQZ5cY2PNIKE5Ipi74KL9qBbOiHzz3tb11sg4oZWlnBynFrNk9jKXc1fyz6/gJ+Hx3gR3FzhuXQ9rt87NMJvNd7u36kHPnPA0pyBn70RI52AL0nbgfseixGw6jD4j2/YqQBiFjtmYlT3b0t1W3rc5wTcH6dBkFBt+28cNjIvKnakmq/mV9pjFfBW887AZQmeZlP1BQJ6L60OLsJz2gOmg+a8loUiUnCxnM5yttIOGGD375R8GAejQUD0fDYwPxBMa3ad9/BrsBMwTtKZA7qiKwn5STPCJq3eVr63E7CujC7THDsBlyUjWHCVfGjZVMOAEWM3wHZEbePjllYJmbS293YCpnbFKPnwDNcDR0P4RMRrADCe4YwJ8zqgfgyYkKVVIxiWwzKeS1BxPMPjp0q+qUAovjPweU/GhAmirR6YytQXB46GQB3f3hWBFyQsRjxw32NQcTsCmxGB2cVRFC2QOUJQAZy3NL96zsA0frfACzsDM5XG2R5QdQULDFTXmRiugK5EQ6xY3dBQ4HQFtzEAP78ApxcMe2dMOkVhWVe0H+FTKL4dGM9uNET74rBFPGiiGM7EtgMvrU5U+YjR5Wdvmioj9D2Jt1lNBGZ1GPR6vUUUneuHsByIsUylmUHhqPSJPpgEEXh4TIzAtU1a/AaHNlGllxKo+MNjCMqA7UjSwksR6vmAuvny8Pe/517+ZjLraU4etN08cG8rnMKwHKvQMj4T0xX0qW0ZExPYkVxxcBG9PTkEfnoZv4MNLhY76ECvGOi7JBVcsDtAgMIyvafVPEZwQGU9cZ1qHri/8TctS0u7EzLe2LKpSh/9dXZBreZpj9Fl9Dd96v7Ji9Zum9MZ/qb+AfBlgBMfVgQVOe3e58D0BY/a/ND/EhhUEt97PtUyJlVVdqv69tp7fUWmd6agnD8AAAAASUVORK5CYII=',
 		),
 		'quick' => array(
			'machine_name' => 'Quick',
 			'method_name' => 'Quick',
 			'parameters' => array(
				'type' => 'QUICK',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Capturing',
 				6 => 'Cancellation',
 				7 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'safetypay' => array(
			'machine_name' => 'SafetyPay',
 			'method_name' => 'SafetyPay',
 			'parameters' => array(
				'type' => 'SAFETYPAY',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Capturing',
 				6 => 'Cancellation',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAdEAAAAAAUpiukAAAFI0lEQVR42u2Yf0xTVxTHm6lZZAlLkJFtTJewhGmyEZIt2R9z8Q9kwVEokA7SAmE0dIUBsiFC2SamJAQmIiEGVgKBuiJEqRqwQleplnYoUClgC2GT8EtCLbJ1ltpSKNxxevN4r2pZzNKkoXsn7fuec899fZ++c09fHw352EbzrtNZ3uVTwGOK4pgxhc8AAy6YZ5Fp3obraWSa9+F6FpnmLbg1nYoQDKsWenIt07wF12FASC0E5dn2RfMeXNgAWS30JLIT+GlTXVjmIMeeOVjRPM4nhjqlHDvHXpmMvb4fOEddDaEOjWvkTBtCMMfVlkZyddGmWNVCFUKORdDxtcb2F+H+G3J9DWEtPbqLyFkL5hPgd8+AXmkGrRWAtlwE/Ufon59Jq+9Z+kql1VvAK/u5VrqYLmar4T3p76dNeOi4CHxGoTkHvJ6haJOrIdQa7xrh9yEEc1xt8ZzOD0bLjxBHETXgTxjfzY/jx5WFrDRTsVQ2fpzKRoyP7yZHXBvbsPO8lPPYW/8IPOkF0GtZCLWlFscIBtY34RUt2viG1ynASgmcluRrhGRRoMT1MGDgg044RhfLjSRwCUvnRxgBXK0nIlObx9BNgqXWwWx1Kui1cIQEVyDzwQfcN6NNbH+L87qNpZ4UYSu97orcqzop6lUROWOpVOCrr60LlneBKr8AMcEAgBXHzEyAt5YFI8p58wnYT7ZBzCZffdsmt8m3gKc/x2iVybIow1ZBX4qCa14io4vLKkjg8iPGdmyrDAK4gYUj1FPm2PG1JfyFqlhVtCllFvK7kyCiP5TPIu30uO0xdb7ycD5LeZjI0x/C0YLEgsSODlhtggrQqPOvV2D/25OCxJZenDNYA5GqUHjhon/BGq5MJguwVLOy33nwMLr4VJC4Hr4KiDxb0uQVJkvcPTBCP1twVuYbjkWErDfyAlztR/XGMPUItfS8gHkNoczOLym3P7f/tOjq2YoIUI2b9903r8F+4Tz4uKg3Mgo3wMvtf3Rwmy59J6ky+ct3MHLx9wgtjYBqOqVxrkmlhABmZhINakJJACd9SjSx7YCflDEzIVvzPvbn92RrqDa/hzr/flC2RhECShGSrbkfhKM8KWnCy6tdCH3H442qUla7eKO80cnfcdbEJ+AJb7vt0oprrYOtg+actXC8mhmF60OdUtzGvroCeyhqDFytp07GwK3xzx/2eeDN2FHIJkv/YVFWMGEPi6iZI3NZwT1s50JiZwWPzBHx9ND0UOF71r3WvY6PwV8KhEjBT6XReARnGR+Ap85zC1wXBid3PsCcM3sHmhTXilDRGWqfhaJ2D0ysYWO7yf9lgBGa03L1YHNaF9y7XL2cB0rO4+pH7pIjbCFb2BJE+r9OQIQ0R6MTOAz0baNb4MVzuJgZhfhdKcEFfVwEPbZKhovaPbDrz9LLAG8iv5tuOxtIjQxz020yByiZI902zKWOMf2Yfs1ppJ9xjOmXf91gM9huBcPYtLNOHlUwRUzRreBtbjwM/CoZ18pWc+wlMt0k/FDBDcOlKBgbVYEWXv7vwIUxsNIfm11PYLYgLfKXDwlPezAtslsCqluSFql9pu3E7ovd17jVeU3+4N+MAG3/BrTQmW/4gox75b30jCalVmQBNZSQUvttOdq8Nl1lKbVDCTv239KMhsVoWh2IYDHAmlZvvMVi3Duwo/8PTxclvko1TdGOf+IxZUxQEjYY6BPPtKb6GctgAxk+89Ry6gC9vT/cp55LW0Q+9iDe89v/wDt9+we2giezh4iPaQAAAABJRU5ErkJggg==',
 		),
 		'sofortueberweisung' => array(
			'machine_name' => 'Sofortueberweisung',
 			'method_name' => 'Sofortüberweisung',
 			'parameters' => array(
				'type' => 'SOFORT',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Recurring',
 				5 => 'Capturing',
 				6 => 'Cancellation',
 				7 => 'Refund',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAlEAAAAAD8j65kAAAKD0lEQVR42uVZ30tb2RbukwwUUbh/gLQPfRtfSpFyMAMyloC0A1WEmZbiw4BaOnOFdBCRSJFWRgiVsWgTpMF0xulIRbGEaNPJrajR2uuY1kuKP9oZPLWmN7WxNdEaNZ7Jl+V273NyTnT6OHP2S84+e6+9fnzrW+ucHFL2ud6NPV0aPe31GY1nN7Aqmv24ov+Us8/Z1730sPt/C0quVs6WdUYylvPchDVvTY9Ge2shpcfzsHtGUksIjKv3PK6YOx5a3bImH+UO+7wHGsGGQ5mMjWb3n/rhs0xjshouGXiine9eWjeLkiar2+uNZLTuJB2UNLa3Vvvk3mR8jklIHNWXcOvyYo+iLPZk1pON56YMBkemOjyZNrfuIC7Pbugr0uFJ+T51DfuMpXR4Xv0XDmnd0Xv607dMxoxkLOPpkqLsFxoM+8nEUUODt6zOvszb545nNgVxo+gar3FsRKaU3HSE8PHHEZKSySD7SUUJNuxv8K9fKIqhwWNfZt48elq7pr3eflK87z8FORsF6lk1Rl6+VpT759XKq9dDSUWJdXIEdHh6PN1LbVniqo2CTAhgA1gyMDg+Jwq8dXk8/OyGeii54hHt9Ul456pdQHBUOwUkxwfMncoS4S0fhhQx4j0eSBFXAcCKIh8WHaco62aSKSJh2KfRWTE0+OmS1jPphMZzt73+/+9oViQPZx9mbl3mM+NhrZTQKo9cCt6p69kNrcE/f8ru27I2CrQn0Rq6fvqWr+Qswi8Dg7tVBj+uSF8hepJ8jmvuuBrSL1+Lct6NaaXcecOfvtjmBUjEhKKE1/i95/N0p/ACJq68f17PMgODtZzZWTPsC6/x56J/O2t41RVJbDipqtcnRnyxhw2KUnok6fJ8zuenshRl9LTWLdFsXkHuvOE7xfOT6XFwg/WJpv8UA4lYM4MNfJ/I7PJho9rZukMGd9boqafelXRzLk+LtqzQ6svXk9Xc3A4PSwQ0IOJ8evOTweBfv9DnOYpDZEqkq8RRPUCh5hkx571JLe1QvtMlzifRo0kLbdshmKvaCXz9BYOVXKO69zbZbIyH9TNFhB4ONJKBCq4uR2NfcikiRwPQ6rIl4uRht5qWxJViAh7E4FSe3ptUVzsMkPuP/9YjjMRRxwafj0ytm/W7J4YJMW3QHtK1buZngpG3rEadnLp5RavEd/IO7S8YTEbMHVcfCMIRvcy7XbHXcX+v5lrHxruxaDYNUlQNf55vj0bVKDFuKLTFUqRA9PgfZbCWoBCd9FpLruHU0rqDAsRr5w+f/edfWqmiIZxnxb7MfhKuEU/vrOFVNr3siCtjnR9pcDRb3aOi0RM9eeuyHs097MbbT+bWRYz/3SrGHPcm1fkrtpToB8Syo24sYp38SW+tsUWHMrOglibQUb3YVr+pbBSE18TK+fOnyFGxpQTXai+1I+eObxSEVsUYJZXOVbeUiNtzUzr5pb+iUBNpaLARC6YPRE5dlPTIhAqF2FI+Gk0/OLObnX2U6WJaIG7rZnVnfvCWcs9gIxbUq8FM0N0qozXt9VQO9mspAV+x7dB3mkhsrB6IFcKxcfCWcs/gg7xW7dJOLm/59Z105w0zTWwp9zJUc/1xRL9s9daygiPWdVbMvKo3cFZt928p9wxO/7CSHrX757VlPLym/RrS4QmMM5eom0P2IUCv0mtb2M4avHgyDIhpQe/F2txPnnnAllKIsPZNVxwvtt+aDATkhteeLnl9PR6vbzycbByEVezdlAav1Hp1PrQaGB940luLj3KhVVFKfE6UEs3Wk03sL67kLcxH1+G/1yUYvBD6zZv0eWLCHY7+Awx+Hyk+Zi5MvuD5JfmXin+AwaFYSzEi7LXZHR+2/+YGh2Ku+aFBNuUe6fKQyYGFgSDG0GBklj2dXqE5DJodGqQ73+33kd2utsnpZzsGgk5/KLb7JfSV0490WZzlMuZT37lGAk7/4ixzfZfHlm930JNEorepy5NI7HK03+mfmSFEYjdLvpEA0znVGs32O9oam11dnvmwrsGNX0mya54m5sOSfLYEB4Sjprgk0yjKWQjRMUU5bM4Uh1Fjr9i9JBcfg9KRWfwmI702/B57lSpCs6Z4WcPmlqJU5vE9vtuK8mEbUkl5p5+d+vUnuP/NK8nly0zdc1clGThUFEsL1rQUp/roWFHO2RKWms0urrck//4kzeAP28XHmIKK0npJktsa8euXCkm2VodiE26oA8WSPZZFkmvqAgsYJMpajfWBhX4HxHttiAKcQYqUlGKW/AwVYfpi0iHmQpIxvQLXukck+ZvUB3dIqcxbCEVm71oIc2IwZmYQjFQfECVzLp4gTEpyRx/FFi65eMJ3eyE0vWJ3lC8zbAgGIwq0EQA6c40pWLFK3oT/inIIol9/IskjAeEdJfnMFEdsYjEoAByMBCT53FU8teWTr2MxmrWm3lI7+iS52SUq8c0RSXaP4BdO58mlFwy7A7+6PNAZjsMdfuHkD9swt/XSPjlcU8eOU5QJtyRXrDJol5SGYkG/pcUUR+RQuADuCTdiA2iSb2vqYC4iTWYgSpYWxMMUv1IFoCvK5lZZg7mQQFvWgDoAGXSPaBXlIAPfR+Ce8mUCLUsJHgzghXB14aYpPjSI1ZHZUIzBv61Rkr8z7UNayNSinNiuDwEgKkrYzAZBnGLD8pd2kJfLGoABu4Pgg1XIrcq8ktLpFUm+cJOKXW8TkR6XS7F0zUvylSoea4zGr+heDAbYggejpo7cM+HG/rsWxi9gEae/rAGDSVEZTJnKAASAAryJxNkSiOltQowkOZDqhzHnmgc7TriJTxGbiydwEHOKojRdh9MQe/cIEGNpCSWBX5lH7mh2wTzI8NpoBjAkWgMSnH6iRXAxBYOxLzSBYQRtYA4R720qXzbFUR9wIqWSa77pOpKjy6NjMGI0ENx97bMwX4MbyZuJBI6fXkGREvmSxQZexD7KJhaVgWBJaWUeKdHsqntgihMUN7fMhRSFvU89M0gdkVqQ7QRdJAcShuioKMdcCFyBZ4qPwQ3AA6iQYAxXIpVY6BjvawwGKRAD//6kpNQUJ2UAbfImjKlYhUIQ6PSLm8uXidbgCklmsxdugmlNccQI8IZLiWpQs/FM9R/HJaKZRCLo524nM3EiGbO5BTfS6UANgbWlmJc2kmQuJHIdCHJXaQwGTEtKbfnWalMcRMC58TtT03Ucc+YaGHBzC3OWlqbrGPA0yg9VbDKYcSliKMm2fAZvSabqi6vuAXKaZAA1RERwDeJqabE7oMfZEnK7PVXqrNW2fADUWk04QDCI1nqb8NxcSNLhCGhkrb5SBR0YbjUGDw2SgqZ43QPWlwDQNC7ctDuof4J5bHBOpMgBlpT7uFCKyhqI1OCwohzOumLbAgfhJJAa1CU9inJs+UxSOMpalHNXB4IM9kU5ZQ30eyGEs1iVRlwRFIwz15pdzMnq609IOA/Os2nn9gAAAABJRU5ErkJggg==',
 		),
 		'paypal' => array(
			'machine_name' => 'PayPal',
 			'method_name' => 'PayPal',
 			'parameters' => array(
				'type' => 'PAYPAL',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'IframeAuthorization',
 				1 => 'WidgetAuthorization',
 				2 => 'AjaxAuthorization',
 				3 => 'AliasManager',
 				4 => 'Capturing',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 	);
	
	/**
	 *
	 * @var Customweb_Mpay24_Method_ElementBuilder
	 */
	protected $elementBuilder = null;
	/**
	 *
	 * @var Customweb_Mpay24_Configuration
	 */
	private $globalConfiguration = null;

	public function __construct(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, Customweb_Mpay24_Configuration $config){
		parent::__construct($paymentMethod);
		$this->globalConfiguration = $config;
		$this->elementBuilder = new Customweb_Mpay24_Method_ElementBuilder();
	}

	public function getRedirectionUrl(Customweb_Mpay24_Authorization_AbstractRedirectAdapter $adapter, Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$response = $adapter->selectPaymentCall($transaction, $formData);
		$adapter->checkSelectPaymentResponse($response);
		return (string) $response->getLocation()->get();
	}

	/**
	 *
	 * @return Customweb_Mpay24_Configuration
	 */
	protected function getGlobalConfiguration(){
		return $this->globalConfiguration;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see Customweb_Payment_Authorization_AbstractPaymentMethodWrapper::getPaymentInformationMap()
	 * @return array
	 */
	protected function getPaymentInformationMap(){
		return self::$paymentMapping;
	}

	/**
	 * This method returns a list of form elements.
	 * This form elements are used to generate the user input.
	 * Sub classes may override this method to provide their own form fields.
	 *
	 * @return array List of form elements
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto, Customweb_Payment_Authorization_IPaymentCustomerContext $customerPaymentContext){
		return array();
	}

	/**
	 * Adds Payment Types to the order object.
	 *
	 * To overwrite:
	 * This method has to call 'Customweb_Mpay24_Method_DefaultMethod::createPaymentTypes' to wrap
	 * the created payment method.
	 *
	 * @param Customweb_Mpay24_Stubs_Order $order
	 * @param Customweb_Mpay24_Authorization_Transaction $transaction
	 * @param array $formData
	 */
	public function prepareOrderObject(Customweb_Mpay24_Stubs_Order $order, Customweb_Mpay24_Authorization_Transaction $transaction, array $formData){
		$parameters = $this->getPaymentMethodParameters();
		$payment = new Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment();
		if (!empty($parameters['brand'])) {
			$payment->setBrand(Customweb_Mpay24_Stubs_PaymentBrandType::_()->set($parameters['brand']));
		}
		$payment->setType(Customweb_Mpay24_Stubs_PaymentTypeType::_()->set($parameters['type']));
		
		$order->setPaymentTypes($this->createPaymentTypes($payment));
	}

	/**
	 *
	 * @param Customweb_Mpay24_Stubs_OrderPaymentTypesPayment $payment
	 * @return Customweb_Mpay24_Stubs_OrderPaymentTypes
	 */
	protected function createPaymentTypes(Customweb_Mpay24_Stubs_Order_PaymentTypes_Payment $payment){
		$paymentTypes = new Customweb_Mpay24_Stubs_Order_PaymentTypes();
		$paymentTypes->addPayment($payment);
		$paymentTypes->setEnable(true);
		
		return $paymentTypes;
	}

	/**
	 * Does nothing per default.
	 *
	 * To overwrite:
	 * This method has to store payment method specific form fields.
	 *
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext
	 * @param array $formFields
	 * @return Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	public function storeFormData(Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $formFields){
		return $paymentCustomerContext;
	}
	
	/**
	 * @return Customweb_Mpay24_Authorization_IPaymentInformationProvider | null
	 */
	public function getPaymentInformationProvider() {
		return null;
	}
}