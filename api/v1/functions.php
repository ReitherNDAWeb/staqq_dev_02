<?php

	require_once dirname(__FILE__) . '/../config.php';

    function utf8_converter($array)
    {
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
            }
        });

        return $array;
    }

	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

	define ("SECRET_KEY", 'tGE(E&GgsVWvC2y8?wKwyZRnM@');
	define ("SECRET_IV", 'a*(3r>Q)T^ni4wyj');
	define ("ENCRYPT_METHOD", "AES-256-CBC");

	function hashId($id){
		$key = hash( 'sha256', SECRET_KEY );
		$iv = substr( hash( 'sha256', SECRET_IV ), 0, 16 );
		
		if (is_numeric($id)){
			return base64_encode( openssl_encrypt( $id, ENCRYPT_METHOD, $key, 0, $iv ) );
		}else{
			return $id;
		}
	}

	function decodeId($hash){
		
		if (strlen($hash) < 5) $hash = intval($hash);
		
		if (is_int($hash)){
			return $hash;
		}else{
			$key = hash( 'sha256', SECRET_KEY );
			$iv = substr( hash( 'sha256', SECRET_IV ), 0, 16 );
			return intval(openssl_decrypt( base64_decode( $hash ), ENCRYPT_METHOD, $key, 0, $iv ));
		}
	}
 
    function getDB() {
        $dbhost = API_DB_HOST;
        $dbuser = API_DB_USER;
        $dbpass = API_DB_PASS;
        $dbname = API_DB_NAME;

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

    function sendSMS($nr, $code){
        
        $url    = "https://rest.messagebird.com/messages";
        $params = array(
            'recipients' => $nr,
            'originator' => "STAQQ",
            'body' => urlencode("Dein Aktivierungscode: ".$code)
        );
        
        $postData = '';
        //create name value pairs seperated by &
        foreach($params as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        $postData = rtrim($postData, '&');

        $ch = curl_init();  

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: AccessKey live_tPRCIR0CP6I4b8jqvsu7xLnlq'));
        curl_setopt($ch, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $response=curl_exec($ch);
        
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);
        return json_decode($body);

    }


    function sendMail($to, $subject, $html, $additionalHeaders){
        
        $headers  = "From: STAQQ <support@staqq.at>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP ". phpversion();
		$headers .= $additionalHeaders;

        $message  = '<html><body>';
        $message .= $html;
        $message .= '</body></html>';
		
		$betreff = '=?utf-8?B?'.base64_encode($subject).'?=';
		
        $res = mail($to, $betreff, $message, $headers);
        return $res;
        
    }


    function getSTAQQScore($ressources_id, $joborders_id){
        $MULTIPLIKATOR_BF   = 3;
        $MULTIPLIKATOR_BG   = 2;
        $MULTIPLIKATOR_BB   = 1;
        $MULTIPLIKATOR_SK   = 3;
        $MULTIPLIKATOR_SOLL = 5;
        $MULTIPLIKATOR_KANN = 2;
        $MULTIPLIKATOR_MUSS = 0;
        
        try{
        
            $db = getDB();
            
            $sth = $db->prepare("SELECT berufsfelder.* FROM relation_joborders_berufsfelder LEFT JOIN 
            berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
            $sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
            $sth->execute();
            $bf_jo_anz = count($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT berufsgruppen.* FROM relation_joborders_berufsgruppen LEFT JOIN 
            berufsgruppen ON berufsgruppen.id = relation_joborders_berufsgruppen.berufsgruppen_id WHERE relation_joborders_berufsgruppen.joborders_id=:id");
            $sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
            $sth->execute();
            $bg_jo_anz = count($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT berufsbezeichnungen.* FROM relation_joborders_berufsbezeichnungen LEFT JOIN 
            berufsbezeichnungen ON berufsbezeichnungen.id = relation_joborders_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_joborders_berufsbezeichnungen.joborders_id=:id");
            $sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
            $sth->execute();
            $bb_jo_anz = count($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT skills_items.*, relation_joborders_skills.praedikat FROM relation_joborders_skills LEFT JOIN 
            skills_items ON relation_joborders_skills.skills_items_id = skills_items.id WHERE relation_joborders_skills.joborders_id=:id");
            $sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
            $sth->execute();
            $sk_jo_anz_muss = 0; $sk_jo_anz_soll = 0; $sk_jo_anz_kann = 0;
            foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $s){if($s['praedikat'] == "muss"){$sk_jo_anz_muss++;}elseif($s['praedikat'] == "soll"){$sk_jo_anz_soll++;}else{$sk_jo_anz_kann++;}}
            
            $score = new stdClass();
            $score->parts = new stdClass();
            
            
            //BF
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS anz 
                    FROM relation_joborders_berufsfelder 
                         INNER JOIN 
                            relation_ressources_berufsfelder 
                            ON relation_joborders_berufsfelder.berufsfelder_id = relation_ressources_berufsfelder.berufsfelder_id 
                    WHERE 
                        relation_joborders_berufsfelder.joborders_id=:joborders_id 
                        AND relation_ressources_berufsfelder.ressources_id=:ressources_id
            ");
            
            $sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
            $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->BF = new stdClass();
            $score->parts->BF->relation = (intval($anz) / $bf_jo_anz) * 100;
            $score->parts->BF->score = $score->parts->BF->relation * $MULTIPLIKATOR_BF * $MULTIPLIKATOR_SOLL;
            $score->parts->BF->any = ($bf_jo_anz > 0) ? true : false;
            
            
            //BG
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS anz 
                    FROM relation_joborders_berufsgruppen 
                         INNER JOIN 
                            relation_ressources_berufsgruppen 
                            ON relation_joborders_berufsgruppen.berufsgruppen_id = relation_ressources_berufsgruppen.berufsgruppen_id 
                    WHERE 
                        relation_joborders_berufsgruppen.joborders_id=:joborders_id 
                        AND relation_ressources_berufsgruppen.ressources_id=:ressources_id
            ");
            
            $sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
            $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->BG = new stdClass();
            $score->parts->BG->relation = (intval($anz) / $bg_jo_anz) * 100;
            $score->parts->BG->score = $score->parts->BG->relation * $MULTIPLIKATOR_BG * $MULTIPLIKATOR_SOLL;
            $score->parts->BG->any = ($bg_jo_anz > 0) ? true : false;
            
            
            //BB
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS anz 
                    FROM relation_joborders_berufsbezeichnungen 
                         INNER JOIN 
                            relation_ressources_berufsbezeichnungen 
                            ON relation_joborders_berufsbezeichnungen.berufsbezeichnungen_id = relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id 
                    WHERE 
                        relation_joborders_berufsbezeichnungen.joborders_id=:joborders_id 
                        AND relation_ressources_berufsbezeichnungen.ressources_id=:ressources_id
            ");
            
            $sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
            $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->BB = new stdClass();
            $score->parts->BB->relation = (intval($anz) / $bb_jo_anz) * 100;
            $score->parts->BB->score = $score->parts->BB->relation * $MULTIPLIKATOR_BB * $MULTIPLIKATOR_SOLL;
            $score->parts->BB->any = ($bb_jo_anz > 0) ? true : false;
            
            
            
            //SK
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS anz 
                    FROM relation_joborders_skills 
                         INNER JOIN 
                            relation_ressources_skills 
                            ON relation_joborders_skills.skills_items_id = relation_ressources_skills.skills_items_id 
                    WHERE 
                        relation_joborders_skills.joborders_id=:joborders_id 
                        AND relation_ressources_skills.ressources_id=:ressources_id 
                        AND relation_joborders_skills.praedikat = :praedikat
            ");
            
            $sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
            
            $p = "muss";
            $sth->bindParam(':praedikat', $p, PDO::PARAM_STR); $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->SK_MUSS = new stdClass();
            $score->parts->SK_MUSS->relation = (intval($anz) / $sk_jo_anz_muss) * 100;
            $score->parts->SK_MUSS->score = $score->parts->SK_MUSS->relation * $MULTIPLIKATOR_SK * $MULTIPLIKATOR_MUSS;
            $score->parts->SK_MUSS->any = ($sk_jo_anz_muss > 0) ? true : false;
            
            $p = "soll";
            $sth->bindParam(':praedikat', $p, PDO::PARAM_STR); $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->SK_SOLL = new stdClass();
            $score->parts->SK_SOLL->relation = (intval($anz) / $sk_jo_anz_soll) * 100;
            $score->parts->SK_SOLL->score = $score->parts->SK_SOLL->relation * $MULTIPLIKATOR_SK * $MULTIPLIKATOR_SOLL;
            $score->parts->SK_SOLL->any = ($sk_jo_anz_soll > 0) ? true : false;
            
            $p = "kann";
            $sth->bindParam(':praedikat', $p, PDO::PARAM_STR); $sth->execute();
            $anz = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'];
            
            $score->parts->SK_KANN = new stdClass();
            $score->parts->SK_KANN->relation = (intval($anz) / $sk_jo_anz_kann) * 100;
            $score->parts->SK_KANN->score = $score->parts->SK_KANN->relation * $MULTIPLIKATOR_SK * $MULTIPLIKATOR_KANN;
            $score->parts->SK_KANN->any = ($sk_jo_anz_kann > 0) ? true : false;
            
            $score->score += $score->parts->BB->score;
            $score->score += $score->parts->SK_MUSS->score;
            $score->score += $score->parts->SK_SOLL->score;
            $score->score += $score->parts->SK_KANN->score;

            
            return $score;
            
            
        } catch(PDOException $e){
            return $e;
        }
    }

	function fireNotification ($prop){
		
		
		/*
		
			'receiver_type'	=> '', 
			'receiver_id' 	=> '', 
			'titel' 		=> '', 
			'nachricht' 	=> '', 
			'kategorie' 	=> '', 
			'link_web' 		=> '', 
			'link_mobile' 	=> '', 
			'send_web' 		=> false, 
			'send_mobile' 	=> true,
			'force' 		=> true   // Notification senden, auch wenn 'push_bool' des Users false
		
		*/
		
		$jetzt = date('Y-m-d H:i:s');
		
		$db = getDB();
		
		if($prop['send_web']){
			
			$sth = $db->prepare("INSERT INTO `notifications` (`kategorie`, `link_web`, `link_mobile`, `titel`, `nachricht`, `receiver_type`, `receiver_id`, `gelesen_timestamp`, `timestamp`) VALUES (:kategorie, :link_web, :link_mobile, :titel, :nachricht, :receiver_type, :receiver_id, null, :timestamp)");

			$sth->bindParam(':kategorie', $prop['kategorie'], PDO::PARAM_INT);
			$sth->bindParam(':link_web', $prop['link_web'], PDO::PARAM_STR);
			$sth->bindParam(':link_mobile', $prop['link_mobile'], PDO::PARAM_STR);
			$sth->bindParam(':titel', $prop['titel'], PDO::PARAM_STR);
			$sth->bindParam(':nachricht', $prop['nachricht'], PDO::PARAM_STR);
			$sth->bindParam(':receiver_type', $prop['receiver_type'], PDO::PARAM_STR);
			$sth->bindParam(':receiver_id', $prop['receiver_id'], PDO::PARAM_INT);
			$sth->bindParam(':timestamp', $jetzt, PDO::PARAM_STR);
			$sth->execute();
			
		}
		
		if($prop['send_mobile']){

			require_once 'push/pushNotifications.php';
			
			if ($prop['receiver_type'] == "ressource"){
				$table = "ressources";
			} elseif ($prop['receiver_type'] == "dienstleister"){
				$table = "dienstleister";
			} elseif ($prop['receiver_type'] == "dienstleister_user"){
				$table = "dienstleister_user";
			} elseif ($prop['receiver_type'] == "kunde"){
				$table = "kunden";
			} elseif ($prop['receiver_type'] == "kunde_user"){
				$table = "kunden_user";
			}
			
			$sth = $db->prepare("SELECT * FROM $table WHERE id=:id");
			$sth->bindParam(':id', $prop['receiver_id'], PDO::PARAM_INT);
			$sth->execute();
			$person = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			if ($person['push_bool'] == "1" || $prop['force']){
			
				$msg_payload = array (
					'mtitle' => $prop['titel'],
					'mdesc' => $prop['subtitle'],
					'msub' => $prop
				);
			
				$notif = new PushNotifications();
				
				try{

					if (strlen($person['push_token_android']) > 0){
						$android = $notif->android($msg_payload, array($person['push_token_android']));
					}

					if (strlen($person['push_token_ios']) > 0){
						$ios = $notif->ios($msg_payload, array($person['push_token_ios']));
					}

				}catch(ApnsPHP_Exception $e){
					
					
				}
			}
		}
	}

	function verrechneJoboorder($joborder_ids, $user_type, $user_id){
		
		require_once dirname(__FILE__) . '/../../wp-load.php';
		//include("../../wp-load.php");
		$db = getDB();
		
		$sth = $db->prepare("SELECT email FROM $user_type WHERE id=:id");
		$sth->bindParam(':id', $user_id, PDO::PARAM_INT);
		$sth->execute();
		
		$email = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['email'];
		$wp_user = get_user_by('email', $email);
		
		$customer_id = $wp_user->ID;
		
		
		// Check if Subuser-Rechnungen
		
		if ($user_type == "dienstleister"){
			
			$sth = $db->prepare("SELECT rechnungs_empfaenger_user FROM dienstleister WHERE id=:id");
			$sth->bindParam(':id', $user_id, PDO::PARAM_INT);
			$sth->execute();
			$rechnungs_empfaenger_user_id = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['rechnungs_empfaenger_user'];
			
			if ($rechnungs_empfaenger_user_id != NULL){
				
				$sth = $db->prepare("SELECT * FROM dienstleister_user WHERE id=:id");
				$sth->bindParam(':id', $rechnungs_empfaenger_user_id, PDO::PARAM_INT);
				$sth->execute();
				
				$dluser = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				$wp_user = get_user_by('email', $dluser['email']);
				$customer_id = $wp_user->ID;
				
			}
		}
		
		$order = wc_create_order(array('customer_id' => $customer_id));
		
		$address = array(
			'first_name' => get_user_meta($wp_user->ID, 'billing_first_name', true),
			'last_name'  => get_user_meta($wp_user->ID, 'billing_last_name', true),
			'company'    => get_user_meta($wp_user->ID, 'billing_company', true),
			'email'      => get_user_meta($wp_user->ID, 'billing_email', true),
			'phone'      => get_user_meta($wp_user->ID, 'billing_phone', true),
			'address_1'  => get_user_meta($wp_user->ID, 'billing_address_1', true),
			'address_2'  => get_user_meta($wp_user->ID, 'billing_address_2', true), 
			'city'       => get_user_meta($wp_user->ID, 'billing_city', true),
			'state'      => get_user_meta($wp_user->ID, 'billing_state', true),
			'postcode'   => get_user_meta($wp_user->ID, 'billing_postcode', true),
			'country'    => get_user_meta($wp_user->ID, 'billing_country', true)
		);
		$order->set_address($address, 'billing');
		$order->set_address($address, 'shipping');
		
		$joborder_ids_rechnung_erstellt = array();
		
		foreach ($joborder_ids as $joborder_id){
			
			$ressources = array();
			
			try{
				$sth = $db->prepare("SELECT joborders.*, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende, verrechnungs_kategorien.name AS verrechnungs_kategorien_name FROM joborders LEFT JOIN verrechnungs_kategorien ON joborders.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE joborders.id=:id");
				$sth->bindParam(':id', $joborder_id, PDO::PARAM_INT);
				$sth->execute();
				$joborder = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				if ($joborder['publisher_type'] == "kunde"){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
					$sth->bindParam(':id', $joborder['publisher_id'], PDO::PARAM_INT);
					$sth->execute();
					$joborder['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
				}
				
				$sth = $db->prepare("SELECT * FROM bewerbungen LEFT JOIN ressources ON ressources.id = bewerbungen.ressources_id WHERE joborders_id=:joborders_id AND dienstleister_einsatz_bestaetigt=1");
				$sth->bindParam(':joborders_id', $joborder_id, PDO::PARAM_INT);
				//$sth->bindParam(':dienstleister_id', $dienstleister_id, PDO::PARAM_INT);
				$sth->execute();
				$bewerbungen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
				
				if ($user_type == "dienstleister"){
					
					foreach($bewerbungen as $bewerbung){
						if ($bewerbung['dienstleister_id'] == $user_id) array_push($ressources, $bewerbung['vorname'] . ' ' . $bewerbung['nachname']);
					}
					
				}

			} catch(PDOException $e){
				var_dump($e);
			}
			
			if ($joborder['rechnung_erstellt'] == '0'){
			
				$product = new WC_product(231);
				$product->set_price($joborder['kosten']);
				$order->add_product($product, 1);

				$items = $order->get_items();
				$last_item_num = count($items) - 1;
				
				$i=0;
				foreach($items as $id => $item){
					if ($i == $last_item_num){
						wc_add_order_item_meta($id, 'ID', $joborder['id']);
						
						wc_add_order_item_meta($id, 'Job Name', $joborder['jobtitel']);
						wc_add_order_item_meta($id, 'Kunde', $joborder['kunde_name']);
						wc_add_order_item_meta($id, 'Bewerber', implode(", ", $ressources));
						wc_add_order_item_meta($id, 'Zeitraum', $joborder['arbeitsbeginn'] . ' bis ' . $joborder['arbeitsende']);
						
						wc_add_order_item_meta($id, 'Tage', $joborder['tage']);
						wc_add_order_item_meta($id, 'Kategorie', $joborder['verrechnungs_kategorien_name']);
					}
					$i++;
				}
				
				array_push($joborder_ids_rechnung_erstellt, $joborder['id']);
			}
		}
		
		array_push($joborder_ids_rechnung_erstellt, '0'); // unmögliche ID damit SQL-Syntax für eine oder mehrere Joborders funktioniert

		$order->calculate_totals();
		$order->update_status('pending', '', true);
		$payment_url = $order->get_checkout_payment_url();
		
		$joborder_ids_rechnung_erstellt_implode = implode(",", $joborder_ids_rechnung_erstellt);
		$now = date('Y-m-d H:i:s');
		
		$sth = $db->prepare("UPDATE joborders SET rechnung_erstellt=1, rechnung_erstellt_datum=:rechnung_erstellt_datum, payment_url=:payment_url, rechnung_order_id=:rechnung_order_id, rechnung_order_post_id=:rechnung_order_post_id, rechnung_wp_user_id=:rechnung_wp_user_id WHERE joborders.id IN ($joborder_ids_rechnung_erstellt_implode)");
		$sth->bindParam(':rechnung_erstellt_datum', $now, PDO::PARAM_STR);
		$sth->bindParam(':payment_url', $payment_url, PDO::PARAM_STR);
		$sth->bindParam(':rechnung_order_id', $order->id, PDO::PARAM_INT);
		$sth->bindParam(':rechnung_order_post_id', $order->post->ID, PDO::PARAM_INT);
		$sth->bindParam(':rechnung_wp_user_id', $wp_user->ID, PDO::PARAM_INT);
		$sth->execute();
		
		return $payment_url;
	}
?>