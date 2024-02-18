<?php
	class PushNotifications {

		// (Android)API access key from Google API's Console.
		private static $API_ACCESS_KEY = 'AAAAP0Fstvc:APA91bHlZFmob4b7-YBsBLzwfzt-cMZgU5hzDsDOP1AtgnWuuvLCaMmz31rAhXrjryQ_yLu9h_Iu_S4wTyidMrkp_tRdWcWZqqBWhL4EAgNzvgfGm2XQuGB27cMJPhjxsOnS_1jvq8cy2X4rSqX8JuMfL3E3SRg0Tw';
		// (iOS) Private key's passphrase.
		private static $passphrase = '';

		// Change the above three vriables as per your app.

		public function __construct() {
			//exit('Init function is not allowed');
		}

		// Sends Push notification for Android users
		public function android($data, $reg_ids) {
			$url = 'https://android.googleapis.com/gcm/send';
			$message = array(
				'title' => $data['mtitle'],
				'message' => $data['mdesc'],
				'subtitle' => json_encode($data['msub']),
				'tickerText' => '',
				'msgcnt' => 1,
				'vibrate' => 1,
				'image' => "icon"
			);

			$headers = array(
				'Authorization: key=' .self::$API_ACCESS_KEY,
				'Content-Type: application/json'
			);

			$fields = array(
				'registration_ids' => $reg_ids,
				'data' => $message,
			);

			return $this->useCurl($url, $headers, json_encode($fields));
		}

		// Sends Push notification for iOS users
		public function iOS($data, $devicetoken) {
			// Adjust to your timezone
			date_default_timezone_set('Europe/Rome');
			// Report all PHP errors
			error_reporting(-1);
			// Using Autoload all classes are loaded on-demand
			require_once 'ApnsPHP/Autoload.php';
			// Instantiate a new ApnsPHP_Push object
			
			try{
				$push = new ApnsPHP_Push(
					//ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
					ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
					//realpath(dirname(__FILE__))."/ck_dev.pem"
					realpath(dirname(__FILE__))."/ck.pem"
				);
			}catch(ApnsPHP_Exception $e){
				var_dump($e);
			}
			// Set the Provider Certificate passphrase
			//$push->setProviderCertificatePassphrase('');
			// Set the Root Certificate Autority to verify the Apple remote peer
			//$push->setRootCertificationAuthority('/etc/ssl/certs/Entrust_Root_Certification_Authority.pem');
			// Connect to the Apple Push Notification Service
			$push->connect();

			foreach($devicetoken as $token){

				// Instantiate a new Message with a single recipient
				$message = new ApnsPHP_Message($token);
				// Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
				// over a ApnsPHP_Message object retrieved with the getErrors() message.
				// $message->setCustomIdentifier("Message-Badge-1");
				// Set badge icon to "3"
				// $message->setBadge(1);
				// Set a simple welcome text
				$message->setText($data['mdesc']);
				// Play the default sound
				$message->setSound();
				// Set a custom property
				$message->setCustomProperty('subtitle', $data['msub']);
				// Set the expiry value to 30 seconds
				$message->setExpiry(30);
				// Add the message to the message queue
				$push->add($message);

			}

			// Send all messages in the message queue
			$push->send();
			// Disconnect from the Apple Push Notification Service
			$push->disconnect();
			// Examine the error message container
			$aErrorQueue = $push->getErrors();
			if (!empty($aErrorQueue)) {
				var_dump($aErrorQueue);
			}
		}

		// Curl 
		private function useCurl($url, $headers, $fields = null) {
			// Open connection
			//var_dump($model, $url, $headers, $fields = null);exit;
			$ch = curl_init();
			if ($url) {
				// Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Disabling SSL Certificate support temporarly
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				if ($fields) {
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				}

				// Execute post
				$result = curl_exec($ch);
				if ($result === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}

				// Close connection
				curl_close($ch);

				return $result;
			}
		}

	}
?>