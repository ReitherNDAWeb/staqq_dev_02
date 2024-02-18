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
require_once 'Mpay24Cw/ContextRequest.php';
require_once 'Mpay24Cw/Util.php';
require_once 'Mpay24Cw/Entity/ExternalCheckoutContext.php';
require_once 'Mpay24Cw/Controller/Abstract.php';



/**
 *
 * @author Nico Eigenmann
 *
 */
class Mpay24Cw_Controller_ExternalLogin extends Mpay24Cw_Controller_Abstract {


	public function indexAction(){
		
		$GLOBALS['woo_mpay24cwTitle'] = __('Login / Register' , 'woocommerce_mpay24cw');
		
		$parameters = Mpay24Cw_ContextRequest::getInstance()->getParameters();
		$context = Mpay24Cw_Entity_ExternalCheckoutContext::getContextById($parameters['mpay24cw-context-id']);
		try{
			Mpay24Cw_Util::checkToken($context, $parameters);
		}
		catch(Exception $e){
			$service = Mpay24Cw_Util::createContainer()->getBean('Mpay24Cw_ExternalCheckoutService');
			$service->markContextAsFailed($context, __('Token expired', 'woocommerce_mpay24cw'));
		}
		if($context->getState() != Mpay24Cw_Entity_ExternalCheckoutContext::STATE_PENDING) {
			wp_redirect($context->getCartUrl());
		}
		$errorMessage = '';
		
		$displayGuest = WC_Checkout::instance()->enable_guest_checkout;
		$emailAddress = $context->getAuthenticationEmailAddress();
		$displayRegister = get_option('users_can_register');
		
		if (isset($parameters['checkout-register']) && isset($parameters['checkout-login'])) {
			//Template Error, or other stuff
			$errorMessage = __('You can not submit both forms at once', 'woocommerce_mpay24cw');
		}
		elseif (isset($parameters['checkout-register'])) {
			if ($displayGuest && !isset($parameters['register-create-account'])) {
				//Guest checkout, no account creation
				if (isset($parameters['register-email']) && is_email($parameters['register-email'])) {
					$context->setCustomerEmailAddress($parameters['register-email']);
					Mpay24Cw_Util::getEntityManager()->persist($context);
					wp_redirect($context->getAuthenticationSuccessUrl());
					die();
				}
				else {
					$errorMessage = __('Please provide a valid email address', 'woocommerce');
				}
			}
			else {
				$emailAddress = isset($parameters['register-email']) ? $parameters['register-email'] : '';
				$password = isset($parameters['register-password']) ? $parameters['register-password'] : '';
				try {
					$userId = Mpay24Cw_Util::createUser($emailAddress, $password);
					wc_set_customer_auth_cookie($userId);
					$context->setCustomerEmailAddress($emailAddress);
					$context->setCustomerId($userId);
					Mpay24Cw_Util::getEntityManager()->persist($context);
					wp_redirect($context->getAuthenticationSuccessUrl());
					die();
				}
				catch (Exception $e) {
					$errorMessage = $e->getMessage();
				}
			}
		}
		else if (isset($parameters['checkout-login'])) {
			$emailAddress = isset($parameters['login-email']) ? $parameters['login-email'] : '';
			$password = isset($parameters['login-password']) ? $parameters['login-password'] : '';
			if (empty($emailAddress)) {
				$errorMessage = __('The email address field was empty', 'woocommerce_mpay24cw');
			}
			elseif (empty($password)) {
				$errorMessage = __('The password field was empty', 'woocommerce_mpay24cw');
			}
			else {
				$secureCookie = false;
				/*@var $user WP_User */
				$tmpUser = false;
				if (is_email($emailAddress)) {
					$tmpUser = get_user_by('email', $emailAddress);
				}
				else {
					$userName = sanitize_user($emailAddress);
					$tmpUser = get_user_by('login', $userName);
				}
				if ($tmpUser !== false && !force_ssl_admin()) {
					if (get_user_option('use_ssl', $tmpUser->ID)) {
						$secureCookie = true;
						force_ssl_admin(true);
					}
				}
				if ($tmpUser !== false) {
					$credentials = array(
						'user_login' => $tmpUser->user_login,
						'user_password' => $password,
						'rememberme' => false 
					);
					
					$user = wp_signon($credentials, $secureCookie);
					if (is_wp_error($user)) {
						$errorMessage = $user->get_error_message();
					}
					else {
						$context->setCustomerEmailAddress($user->get('user_email'));
						$context->setCustomerId($user->ID);
						Mpay24Cw_Util::getEntityManager()->persist($context);
						wp_redirect($context->getAuthenticationSuccessUrl());
						die();
					}
				}
				else {
					$errorMessage = __('Invalid Email/Username', 'woocommerce_mpay24cw');
				}
			}
		}
		ob_start();
		Mpay24Cw_Util::includeTemplateFile('external_login', 
				array(
					'errorMessage' => $errorMessage,
					'displayGuest' => $displayGuest,
					'displayRegister' => $displayRegister,
					'email' => $emailAddress,
					'url' => Mpay24Cw_Util::getPluginUrl('externalLogin', 
							array(
								'mpay24cw-context-id' => $context->getContextId(),
								'token' => $context->getSecurityToken() 
							)) 
				));
		$content = ob_get_clean();
		return $content;
	}
	
}