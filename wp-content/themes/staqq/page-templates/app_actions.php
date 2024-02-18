<?php

    /**
     *   Template Name: STAQQ / App / Actions
     */

    global $wpUserState, $wpUserRole, $wpUserSTAQQUser, $wpUser, $wpUserSTAQQId, $api, $userBerechtigungen, $wpUserSTAQQDienstleisterId, $wpUserSTAQQKundeId;
    
    require_once get_template_directory().'/vendor/restclient.php';
    require_once get_template_directory().'/vendor/restclient.php';
    
    $wpUserState     = is_user_logged_in();
    $wpUserRole      = false;
    $wpUserSTAQQUser = false;
    $wpUser          = false;
        
	$wpUser = wp_get_current_user();
	$wpUserSTAQQId = get_user_meta($wpUser->ID, 'staqq_id')[0];

	if (in_array("ressource", $wpUser->roles)) {
		$wpUserRole = "ressource";
		$wpUserSTAQQUser = true;
	} else if (in_array("kunde", $wpUser->roles)) {
		$wpUserRole = "kunde";
		$wpUserSTAQQUser = true;
		$wpUserSTAQQKundeId = $wpUserSTAQQId;
	} else if (in_array("dienstleister", $wpUser->roles)) {
		$wpUserRole = "dienstleister";
		$wpUserSTAQQUser = true;
		$wpUserSTAQQDienstleisterId = $wpUserSTAQQId;
	} else if (in_array("kunde_u", $wpUser->roles)) {
		$wpUserRole = "kunde_user";
		$wpUserSTAQQUser = true;
		$b = $api->get("kunden/user/$wpUserSTAQQId/berechtigungen", [])->decode_response();
		$userBerechtigungen = new stdClass();
		$userBerechtigungen->berechtigung_joborders_schalten = filter_var($b->berechtigung_joborders_schalten, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->berechtigung_einkauf = filter_var($b->berechtigung_einkauf, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->berechtigung_auswertung = filter_var($b->berechtigung_auswertung, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->einschraenkung_aktiv_von_bis = filter_var($b->einschraenkung_aktiv_von_bis, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->aktiv_von = $b->aktiv_von;
		$userBerechtigungen->aktiv_bis = $b->aktiv_bis;
		$wpUserSTAQQKundeId = $b->kunden_id;

		if ($userBerechtigungen->einschraenkung_aktiv_von_bis && (time() < strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_von)) || time() > strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_bis)))){
			if ($_SERVER['REQUEST_URI'] != "/app/fehler/?e=1") {wp_redirect('app/fehler/?e=1'); exit;}
		}
	} else if (in_array("dienstleister_u", $wpUser->roles)) {
		$wpUserRole = "dienstleister_user";
		$wpUserSTAQQUser = true;
		$b = $api->get("dienstleister/user/$wpUserSTAQQId/berechtigungen", [])->decode_response();
		$userBerechtigungen = new stdClass();
		$userBerechtigungen->berechtigung_joborders_schalten = filter_var($b->berechtigung_joborders_schalten, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->berechtigung_einkauf = filter_var($b->berechtigung_einkauf, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->berechtigung_auswertung = filter_var($b->berechtigung_auswertung, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->einschraenkung_aktiv_von_bis = filter_var($b->einschraenkung_aktiv_von_bis, FILTER_VALIDATE_BOOLEAN);
		$userBerechtigungen->aktiv_von = $b->aktiv_von;
		$userBerechtigungen->aktiv_bis = $b->aktiv_bis;
		$wpUserSTAQQDienstleisterId = $b->dienstleister_id;

		if ($userBerechtigungen->einschraenkung_aktiv_von_bis && (time() < strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_von)) || time() > strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_bis)))){
			if ($_SERVER['REQUEST_URI'] != "/app/fehler/?e=1") {wp_redirect('app/fehler/?e=1'); exit;}
		}
	} else{
		$wpuserRole = $wpUser->roles;
	}



	/*************************************************************************
	** Actions
	*************************************************************************/
    
	// DL aktualisiert die Einstellung für Empfangs-User bei neuer JO von KD

    if ($_POST['action'] == "dienstleister_verwaltung__select_joborder_empfaenger"){
		
		$response = $api->put("dienstleister/$wpUserSTAQQId/joborderEmpfaengerUser", [
			'dienstleister_user_id' => $_POST['dienstleister_user_id']
		])->decode_response();
		
		wp_redirect('/app/stammdaten/#benutzer-pakete');
		
	}elseif ($_POST['action'] == "dienstleistter_joborders__joborder_ablehnen"){
		
		$response = $api->post("dienstleister/{$_POST['dienstleister_id']}/jobAblehnen/{$_POST['joborders_id']}", [])->decode_response();
				
		wp_redirect('/app/joborders/');
	
	}elseif ($_POST['action'] == "dienstleister_verwaltung__select_rechnungs_empfaenger"){
		
		$response = $api->put("dienstleister/$wpUserSTAQQId/rechnungsEmpfaengerUser", [
			'dienstleister_user_id' => $_POST['dienstleister_user_id']
		])->decode_response();
		
		wp_redirect('/app/stammdaten/#benutzer-pakete');
		
	}elseif ($_POST['action'] == "paket_anfrage_senden"){
		
		if ($wpUserRole == "kunde"){
			$k = $api->get("kunden/$wpUserSTAQQId", [])->decode_response();
			
			$firmenwortlaut = $k->firmenwortlaut;
			$vorname = $k->ansprechpartner_vorname;
			$nachname = $k->ansprechpartner_nachname;
			$telefon = $k->ansprechpartner_telefon;
			$email = $k->email;
			
		}elseif($wpUserRole == "kunde_user"){
			$k = $api->get("kunden/$wpUserSTAQQKundeId", [])->decode_response();
			$u = $api->get("kunden/$wpUserSTAQQKundeId/user/$wpUserSTAQQId", [])->decode_response();
			
			$firmenwortlaut = $k->firmenwortlaut;
			$vorname = $u->vorname;
			$nachname = $u->nachname;
			$telefon = $u->telefon;
			$email = $u->email;
			
		}elseif ($wpUserRole == "dienstleister"){
			$k = $api->get("dienstleister/$wpUserSTAQQId", [])->decode_response();
			
			$firmenwortlaut = $k->firmenwortlaut;
			$vorname = $k->ansprechpartner_vorname;
			$nachname = $k->ansprechpartner_nachname;
			$telefon = $k->ansprechpartner_telefon;
			$email = $k->email;
			
		}elseif ($wpUserRole == "dienstleister_user"){
			$k = $api->get("dienstleister/$wpUserSTAQQDienstleisterId", [])->decode_response();
			$u = $api->get("dienstleister/$wpUserSTAQQDienstleisterId/user/$wpUserSTAQQId", [])->decode_response();
			
			$firmenwortlaut = $k->firmenwortlaut;
			$vorname = $u->vorname;
			$nachname = $u->nachname;
			$telefon = $u->telefon;
			$email = $u->email;
		}
		
		$headers  = "From: STAQQ <support@staqq.at>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP ". phpversion();

        $message  = '<html><body>';
        $message .= nl2br($_POST['content']);
		
		$message .= "<br><br><br>";
		$message .= "<strong>Die Anfrage kommt von:</strong>";
		$message .= "<br>";
		$message .= "<p>$firmenwortlaut<br>";
		$message .= "[$wpUserRole: $wpUserSTAQQId]<br>";
		$message .= "Ansprechpartner: $vorname $nachname<br>";
		$message .= "Telefon: $telefon<br>";
		$message .= "E-Mail: $email<br>";
		$message .= "</p>";
		
        $message .= '</body></html>';
		
		$betreff = '=?utf-8?B?'.base64_encode("Paket-Anfrage").'?=';
		
        mail("manfred.kern@staqq.at", $betreff, $message, $headers);
		wp_redirect('/app/stammdaten/#ordering');
		
	}else{
		
		wp_redirect('/app/');
		
	}