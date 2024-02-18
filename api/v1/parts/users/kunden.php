<?php

    $app->get('/kunden', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT kunden.*, CONCAT(kunden.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM kunden LEFT JOIN bewertungen ON kunden.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'kunde' AND bewertungen.status = 1 GROUP BY kunden.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });
    
    $app->get('/kunden/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT *, CONCAT(kunden.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM kunden LEFT JOIN bewertungen ON kunden.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'kunde' AND bewertungen.status = 1 WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
            
            $sth = $db->prepare("
				SELECT 
					dienstleister.id, 
					dienstleister.firmenwortlaut, 
					CONCAT(dienstleister.firmenwortlaut, ' (★ ', IFNULL(AVG(bewertungen.bewertung), 0), ')') AS firmenwortlaut_inkl_bewertung 
				FROM 
					relation_kunden_dienstleister 
				LEFT JOIN 
					dienstleister ON dienstleister.id = relation_kunden_dienstleister.dienstleister_id 
				LEFT JOIN 
					bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1
				WHERE 
					relation_kunden_dienstleister.kunden_id=:id
				GROUP BY 
					dienstleister.id
			");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['dienstleister'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT * FROM arbeitsstaetten WHERE kunden_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['arbeitsstaetten'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $body = json_encode($res);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });
    
    $app->get('/kunden/{id}/joborders', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut,
                    dienstleister.website AS dienstleister_website,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis 
                FROM 
                    joborders 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = joborders.dienstleister_id 
                WHERE 
                    creator_type='kunde' 
                    AND creator_id=:id
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            for($i=0;$i<count($joborders);$i++){
                $sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_gesamt'] = $r['anz'];
				
                $sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='vergeben'");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_vergeben'] = $r['anz'];
				
                $sth = $db->prepare("SELECT bewerbungen.*, COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='einsatz_bestaetigt'");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $bewerbung_bestaetigt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_einsatz_bestaetigt'] = $bewerbung_bestaetigt['anz'];
				
                $sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='einsatz_bestaetigt' AND dienstleister_einsatz_bestaetigt=1 AND ressource_einsatz_bestaetigt=1");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_erfolgter_einsatz_bestaetigt'] = $r['anz'];
                
                $sth = $db->prepare("SELECT berufsfelder.* FROM relation_joborders_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $joborders[$i]['berufsfelder'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                
				if ($joborders[$i]['dienstleister_vorgegeben'] == 1 && $joborders[$i]['dienstleister_single'] == 0){
					$sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM relation_joborders_dienstleister_auswahl
 LEFT JOIN dienstleister ON dienstleister.id = relation_joborders_dienstleister_auswahl.dienstleister_id LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE relation_joborders_dienstleister_auswahl.joborders_id=:id GROUP BY dienstleister.id");
					$sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
					$sth->execute();
					$joborders[$i]['dienstleister_auswahl'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
					$joborders[$i]['dienstleister_auswahl_firmenwortlaute'] = array();
					foreach($joborders[$i]['dienstleister_auswahl'] as $dl){array_push($joborders[$i]['dienstleister_auswahl_firmenwortlaute'], $dl['firmenwortlaut']);}
				}
				
				if (intval($joborders[$i]['anzahl_bewerbungen_einsatz_bestaetigt']) > 0){
					$sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut, dienstleister.website, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM dienstleister LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE id=:id GROUP BY dienstleister.id");
					$sth->bindParam(':id', $bewerbung_bestaetigt['dienstleister_id'], PDO::PARAM_INT);
					$sth->execute();
					$joborders[$i]['eingesetzter_dienstleister'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
				}
            }
            
            $body = json_encode($joborders);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->post('/kunden', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
            
            include("../../wp-load.php");

            $email = $request->getParsedBody()['email'];
            $passwort = $request->getParsedBody()['passwort'];

            $user_info = array(
                "user_pass"     => $passwort,
                "user_login"    => 'kunde_'.$request->getParsedBody()['ansprechpartner_vorname'].'_'.$request->getParsedBody()['ansprechpartner_nachname'].'_'.time(),
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['ansprechpartner_titel'].' '.$request->getParsedBody()['ansprechpartner_vorname'].' '.$request->getParsedBody()['ansprechpartner_nachname'],
                "first_name"    => $request->getParsedBody()['ansprechpartner_vorname'],
                "last_name"     => $request->getParsedBody()['ansprechpartner_nachname'],
                "role"          => "kunde"
            );
            
            if (!username_exists($email) && !email_exists($email)) {

                $insert_user_result = wp_insert_user($user_info);

                try{
					
					update_user_meta($insert_user_result, 'billing_first_name', $request->getParsedBody()['ansprechpartner_vorname']);
					update_user_meta($insert_user_result, 'billing_last_name', $request->getParsedBody()['ansprechpartner_nachname']);
					update_user_meta($insert_user_result, 'billing_company', $request->getParsedBody()['firmenwortlaut']);
					update_user_meta($insert_user_result, 'billing_address_1', $request->getParsedBody()['firmensitz_adresse']);
					update_user_meta($insert_user_result, 'billing_address_2', "UID: " . $request->getParsedBody()['uid']);
					update_user_meta($insert_user_result, 'billing_city', $request->getParsedBody()['firmensitz_ort']);
					update_user_meta($insert_user_result, 'billing_postcode', $request->getParsedBody()['firmensitz_plz']);
					update_user_meta($insert_user_result, 'billing_country', "AT");
					update_user_meta($insert_user_result, 'billing_email', $email);
					update_user_meta($insert_user_result, 'billing_phone', $request->getParsedBody()['ansprechpartner_telefon']);
					
					
                    $db = getDB();
                    $sth = $db->prepare("INSERT INTO kunden (email, firmenwortlaut, gesellschaftsform, ansprechpartner_anrede, ansprechpartner_titel, ansprechpartner_vorname, ansprechpartner_nachname, ansprechpartner_position, ansprechpartner_telefon, uid, fn, firmensitz_plz, firmensitz_adresse, firmensitz_ort, anzahl_user, anzahl_joborders, registrations_id, agb_accept, website) VALUES (:email, :firmenwortlaut, :gesellschaftsform, :ansprechpartner_anrede, :ansprechpartner_titel, :ansprechpartner_vorname, :ansprechpartner_nachname, :ansprechpartner_position, :ansprechpartner_telefon, :uid, :fn, :firmensitz_plz, :firmensitz_adresse, :firmensitz_ort, :anzahl_user, :anzahl_joborders, :registrations_id, :agb_accept, :website)");

                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':firmenwortlaut', $request->getParsedBody()['firmenwortlaut'], PDO::PARAM_STR);
                    $sth->bindParam(':gesellschaftsform', $request->getParsedBody()['gesellschaftsform'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_anrede', $request->getParsedBody()['ansprechpartner_anrede'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_titel', $request->getParsedBody()['ansprechpartner_titel'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_vorname', $request->getParsedBody()['ansprechpartner_vorname'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_nachname', $request->getParsedBody()['ansprechpartner_nachname'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_position', $request->getParsedBody()['ansprechpartner_position'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_telefon', $request->getParsedBody()['ansprechpartner_telefon'], PDO::PARAM_STR);
                    $sth->bindParam(':uid', $request->getParsedBody()['uid'], PDO::PARAM_STR);
                    $sth->bindParam(':fn', $request->getParsedBody()['fn'], PDO::PARAM_STR);
                    $sth->bindParam(':firmensitz_plz', $request->getParsedBody()['firmensitz_plz'], PDO::PARAM_INT);
                    $sth->bindParam(':firmensitz_adresse', $request->getParsedBody()['firmensitz_adresse'], PDO::PARAM_STR);
                    $sth->bindParam(':firmensitz_ort', $request->getParsedBody()['firmensitz_ort'], PDO::PARAM_STR);
                    $sth->bindParam(':anzahl_user', $request->getParsedBody()['anzahl_user'], PDO::PARAM_INT);
                    $sth->bindParam(':anzahl_joborders', $request->getParsedBody()['anzahl_joborders'], PDO::PARAM_INT);
                    $sth->bindParam(':registrations_id', $request->getParsedBody()['registrations_id'], PDO::PARAM_INT);
                    $sth->bindParam(':agb_accept', $request->getParsedBody()['agb_accept'], PDO::PARAM_INT);
                    $sth->bindParam(':website', addhttp($request->getParsedBody()['website']), PDO::PARAM_STR);


                    $sth->execute();

                    if ($insert_user_result){
                        $user_id = $db->lastInsertId();
                        add_user_meta($insert_user_result, 'staqq_id', $user_id);
                        
                        foreach (json_decode($request->getParsedBody()['dienstleister']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_kunden_dienstleister (kunden_id, dienstleister_id) VALUES (:kunden_id, :dienstleister_id)");
                            $sth->bindParam(':kunden_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':dienstleister_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['arbeitsstaetten']) as $f){
                            $sth = $db->prepare("INSERT INTO arbeitsstaetten (name, kunden_id) VALUES (:name, :kunden_id)");
                            $sth->bindParam(':name', $f, PDO::PARAM_STR);
                            $sth->bindParam(':kunden_id', $user_id, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        $body = json_encode(['status' => true, 'id' => $user_id]);
                    }

                } catch(PDOException $e){
                    $response->withStatus(400);
                    $body = json_encode(['status' => false, 'msg' => $e]);
                }
            } else {
                $response->withStatus(400);
                $body = json_encode(['status' => false, 'msg' => "Benutzer existiert bereits"]);
            }
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/kunden/{id}', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
            include("../../wp-load.php");
            
            $email_old = $request->getParsedBody()['old_email'];
            $email = $request->getParsedBody()['email'];
            
            if (($email_old == $email) || (!isset($request->getParsedBody()['old_email']))) {
                $updateEmail = false;
                $user_id = email_exists($email);
            }else{
                $updateEmail = true;
                $user_id = email_exists($email_old);
            }

            $user_info = array(
                "ID"            => $user_id,
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['ansprechpartner_titel'].' '.$request->getParsedBody()['ansprechpartner_vorname'].' '.$request->getParsedBody()['ansprechpartner_nachname'],
                "first_name"    => $request->getParsedBody()['ansprechpartner_vorname'],
                "last_name"     => $request->getParsedBody()['ansprechpartner_nachname'],
                "role"          => "kunde"
            );

            if ((email_exists($email) && (!$updateEmail)) || ((!email_exists($email)) && $updateEmail)) {

                $insert_user_result = wp_update_user($user_info);

                try{
					
					update_user_meta($user_id, 'billing_first_name', $request->getParsedBody()['ansprechpartner_vorname']);
					update_user_meta($user_id, 'billing_last_name', $request->getParsedBody()['ansprechpartner_nachname']);
					update_user_meta($user_id, 'billing_company', $request->getParsedBody()['firmenwortlaut']);
					update_user_meta($user_id, 'billing_address_1', $request->getParsedBody()['firmensitz_adresse']);
					update_user_meta($user_id, 'billing_address_2', "UID: " . $request->getParsedBody()['uid']);
					update_user_meta($user_id, 'billing_city', $request->getParsedBody()['firmensitz_ort']);
					update_user_meta($user_id, 'billing_postcode', $request->getParsedBody()['firmensitz_plz']);
					update_user_meta($user_id, 'billing_country', "AT");
					update_user_meta($user_id, 'billing_email', $email);
					update_user_meta($user_id, 'billing_phone', $request->getParsedBody()['ansprechpartner_telefon']);
					
                    $db = getDB();
                    $sth = $db->prepare("UPDATE kunden SET email=:email, firmenwortlaut=:firmenwortlaut, gesellschaftsform=:gesellschaftsform, ansprechpartner_anrede=:ansprechpartner_anrede, ansprechpartner_titel=:ansprechpartner_titel, ansprechpartner_vorname=:ansprechpartner_vorname, ansprechpartner_nachname=:ansprechpartner_nachname, ansprechpartner_position=:ansprechpartner_position, ansprechpartner_telefon=:ansprechpartner_telefon, uid=:uid, fn=:fn, firmensitz_plz=:firmensitz_plz, firmensitz_adresse=:firmensitz_adresse, firmensitz_ort=:firmensitz_ort, agb_accept=:agb_accept, website=:website WHERE id=:id");

                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':firmenwortlaut', $request->getParsedBody()['firmenwortlaut'], PDO::PARAM_STR);
                    $sth->bindParam(':gesellschaftsform', $request->getParsedBody()['gesellschaftsform'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_anrede', $request->getParsedBody()['ansprechpartner_anrede'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_titel', $request->getParsedBody()['ansprechpartner_titel'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_vorname', $request->getParsedBody()['ansprechpartner_vorname'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_nachname', $request->getParsedBody()['ansprechpartner_nachname'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_position', $request->getParsedBody()['ansprechpartner_position'], PDO::PARAM_STR);
                    $sth->bindParam(':ansprechpartner_telefon', $request->getParsedBody()['ansprechpartner_telefon'], PDO::PARAM_STR);
                    $sth->bindParam(':uid', $request->getParsedBody()['uid'], PDO::PARAM_STR);
                    $sth->bindParam(':fn', $request->getParsedBody()['fn'], PDO::PARAM_STR);
                    $sth->bindParam(':firmensitz_plz', $request->getParsedBody()['firmensitz_plz'], PDO::PARAM_INT);
                    $sth->bindParam(':firmensitz_adresse', $request->getParsedBody()['firmensitz_adresse'], PDO::PARAM_STR);
                    $sth->bindParam(':firmensitz_ort', $request->getParsedBody()['firmensitz_ort'], PDO::PARAM_STR);
                    $sth->bindParam(':agb_accept', $request->getParsedBody()['agb_accept'], PDO::PARAM_INT);
                    $sth->bindParam(':website', addhttp($request->getParsedBody()['website']), PDO::PARAM_STR);
                    $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();
                    

                    $sth = $db->prepare("DELETE FROM relation_kunden_dienstleister WHERE kunden_id=:kunden_id");
                    $sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();
                    
                    foreach (json_decode($request->getParsedBody()['dienstleister']) as $f){
                        $sth = $db->prepare("INSERT INTO relation_kunden_dienstleister (kunden_id, dienstleister_id) VALUES (:kunden_id, :dienstleister_id)");
                        $sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':dienstleister_id', $f, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    
                    $sth = $db->prepare("DELETE FROM arbeitsstaetten WHERE kunden_id=:kunden_id");
                    $sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['arbeitsstaetten']) as $f){
                        $sth = $db->prepare("INSERT INTO arbeitsstaetten (name, kunden_id) VALUES (:name, :kunden_id)");
                        $sth->bindParam(':name', $f, PDO::PARAM_STR);
                        $sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    if ($request->getParsedBody()['dl_anforderung_bool'] == 1){
						$sth = $db->prepare("INSERT INTO dienstleister_nicht_in_auswahl (name, ansprechpartner_titel, ansprechpartner_vorname, ansprechpartner_nachname, ansprechpartner_email, kunden_id) VALUES (:name, :ansprechpartner_titel, :ansprechpartner_vorname, :ansprechpartner_nachname, :ansprechpartner_email, :kunden_id)");
						$sth->bindParam(':name', $request->getParsedBody()['dl_anforderung_name'], PDO::PARAM_STR);
						$sth->bindParam(':ansprechpartner_titel', $request->getParsedBody()['dl_anforderung_ansprechpartner_titel'], PDO::PARAM_STR);
						$sth->bindParam(':ansprechpartner_vorname', $request->getParsedBody()['dl_anforderung_ansprechpartner_vorname'], PDO::PARAM_STR);
						$sth->bindParam(':ansprechpartner_nachname', $request->getParsedBody()['dl_anforderung_ansprechpartner_nachname'], PDO::PARAM_STR);
						$sth->bindParam(':ansprechpartner_email', $request->getParsedBody()['dl_anforderung_ansprechpartner_email'], PDO::PARAM_STR);
						$sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
						$sth->execute();
						
						$html =  "Sehr geehrte(r) {$request->getParsedBody()['dl_anforderung_ansprechpartner_titel']} {$request->getParsedBody()['dl_anforderung_ansprechpartner_vorname']} {$request->getParsedBody()['dl_anforderung_ansprechpartner_nachname']}!";
						$html .= "<br><br>";
						$html .= nl2br($request->getParsedBody()['dl_anforderung_infotext']);
						
						include("../../wp-load.php");
						$betreff = utf8_decode(get_option('dienstleister_einladen_betreff'));
						
						$ret = sendMail($request->getParsedBody()['dl_anforderung_ansprechpartner_email']. ", " . API_STAQQ_EMAIL, $betreff, $html, "Bcc: ".API_STAQQ_EMAIL."\r\n");
					}else{
						
						$ret = true;
						
					}

                    $body = json_encode(['status' => $ret]);
                    
                } catch(PDOException $e){
                    $response->withStatus(400);
                    $body = json_encode(['status' => false, 'msg' => $e]);
                }
            } else {
                $response->withStatus(400);
                $body = json_encode(['status' => false, 'msg' => "Die E-Mail-Adresse wird schon von einem anderen Benutzer verwendet!", 'id' => $user_id, 'email_exists' => email_exists($email), '$updateEmail' => $updateEmail, 'email' => $email, 'old_email' => $old_email]);
            }
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/kunden/{id}/notificationSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					kunden 
				SET 
					push_bool=:push_bool
				WHERE 
					id=:id
			");
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->bindParam(':push_bool', $request->getParsedBody()['push_bool'], PDO::PARAM_INT);
			$result = $sth->execute();
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/kunden/{id}/backendSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					kunden 
				SET 
					anzahl_joborders=:anzahl_joborders,
					anzahl_user=:anzahl_user
				WHERE 
					id=:id
			");
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->bindParam(':anzahl_joborders', $request->getParsedBody()['anzahl_joborders'], PDO::PARAM_INT);
            $sth->bindParam(':anzahl_user', $request->getParsedBody()['anzahl_user'], PDO::PARAM_INT);
			$result = $sth->execute();
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });


    $app->put('/kunden/{id}/acceptAGB', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("UPDATE kunden SET agb_accept=1 WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();

            $body = json_encode(['status' => true]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/kunden/{id}/changePasswort', function($request, $response, $args) {
        
        include("../../wp-load.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        $passwort_neu = $request->getParsedBody()['passwort_neu'];
        $passwort_alt = $request->getParsedBody()['passwort_alt'];
        
        $res = wp_signon(array('user_login' => $email, 'user_password' => $passwort_alt, 'remember' => false));
        
        if ($passwort_neu != "" && $passwort_alt != ""){
                        
            if (gettype($res->data) == "object"){
                wp_set_password($passwort_neu, $user_id);
                $body = json_encode(['status' => true]);
            }else{
                $body = json_encode(['status' => false, 'msg' => 'Das alte Passwort stimmt nicht.']);
            }
            
        }else{
            $body = json_encode(['status' => false, 'msg' => 'Das alte und neue Passwort darf nicht leer sein!']);
        }
            
        $response->write($body);
        return $response;
        
    });

    $app->post('/kunden/{id}/requestDelete', function($request, $response, $args) {
        
        $db = getDB();
        $sth = $db->prepare("SELECT * FROM kunden WHERE id=:id");
        $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $sth->execute();
        $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
        
        $html  = "<p>Hallo STAQQ-Team!</p>";
        $html .= "<p>Anfrage zur Account-Löschung eines <strong>Kunden:</strong></p>";
        $html .= "<table>";
        $html .= "<tr><th>ID</th><td>".$res['id']."</td></tr>";
        $html .= "<tr><th>Firmenwortlaut</th><td>".$res['firmenwortlaut']."</td></tr>";
        $html .= "<tr><th>Ansprechpartner Vorname</th><td>".$res['ansprechpartner_vorname']."</td></tr>";
        $html .= "<tr><th>Ansprechpartner Nachname</th><td>".$res['ansprechpartner_nachname']."</td></tr>";
        $html .= "<tr><th>E-Mail</th><td>".$res['email']."</td></tr>";
        $html .= "</table>";
        
        $body = json_encode(['status' => sendMail(API_STAQQ_EMAIL, "Account löschen", $html, '')]);
        $response->write($body);
        return $response;
    });

    $app->delete('/kunden/{id}', function($request, $response, $args) {
        
        include("../../wp-load.php");
		include("../../wp-admin/includes/user.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        		
		if (wp_delete_user($user_id)){
			try{
				$db = getDB();
				$sth = $db->prepare("DELETE FROM kunden WHERE id=:id LIMIT 1");

				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->execute();
				$body = json_encode(['status' => true]);

			} catch(PDOException $e){
				$response->withStatus(400);
				$body = json_encode(['status' => false, 'msg' => $e]);
			}
		}else{
        	$body = json_encode(['status' => false, 'msg' => 'WP-User konnte nicht gelöscht werden!']);
		}
		
        $response->write($body);
        return $response;
    });


    $app->get('/kunden/{id}/zahlen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    bewertungen
                WHERE 
					von_type = 'kunde' AND
                    von_id=:id AND 
					status = 0
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
			
			$anzahlen = array();
            $anzahlen['bewertungen']['offen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['offen'];
			
			$sth = $db->prepare("
                SELECT 
                    anzahl_joborders, 
					anzahl_user
                FROM 
                    kunden
                WHERE 
					id=:id
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
			
			$res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
            $anzahlen['joborders'] = $res['anzahl_joborders'];
            $anzahlen['user'] = $res['anzahl_user'];
            
            $body = json_encode($anzahlen);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
   });

   $app->post('/kunden/{id}/dienstleisterEinladen', function($request, $response, $args) {
	   
		try{
			
            $email = $request->getParsedBody()['email'];
			
			$db = getDB();
			$sth = $db->prepare("INSERT INTO dienstleister_nicht_in_auswahl (name, ansprechpartner_titel, ansprechpartner_vorname, ansprechpartner_nachname, ansprechpartner_email, kunden_id) VALUES (:name, :ansprechpartner_titel, :ansprechpartner_vorname, :ansprechpartner_nachname, :ansprechpartner_email, :kunden_id)");
			$sth->bindParam(':name', $request->getParsedBody()['dl_anforderung_name'], PDO::PARAM_STR);
			$sth->bindParam(':ansprechpartner_titel', $request->getParsedBody()['dl_anforderung_ansprechpartner_titel'], PDO::PARAM_STR);
			$sth->bindParam(':ansprechpartner_vorname', $request->getParsedBody()['dl_anforderung_ansprechpartner_vorname'], PDO::PARAM_STR);
			$sth->bindParam(':ansprechpartner_nachname', $request->getParsedBody()['dl_anforderung_ansprechpartner_nachname'], PDO::PARAM_STR);
			$sth->bindParam(':ansprechpartner_email', $request->getParsedBody()['dl_anforderung_ansprechpartner_email'], PDO::PARAM_STR);
			$sth->bindParam(':kunden_id', $args['id'], PDO::PARAM_INT);
			$sth->execute();
			
			$html =  "Sehr geehrte(r) {$request->getParsedBody()['dl_anforderung_ansprechpartner_titel']} {$request->getParsedBody()['dl_anforderung_ansprechpartner_vorname']} {$request->getParsedBody()['dl_anforderung_ansprechpartner_nachname']}!";
			
			$html .= "<br><br>";
			$html .= nl2br($request->getParsedBody()['dl_anforderung_infotext']);
			
			include("../../wp-load.php");
			$betreff = utf8_decode(get_option('dienstleister_einladen_betreff'));

			$ret = sendMail($request->getParsedBody()['dl_anforderung_ansprechpartner_email']. ", " . API_STAQQ_EMAIL, $betreff, $html, "Bcc: ".API_STAQQ_EMAIL."\r\n");
			
			$body = json_encode(['status' => $ret]);

		} catch(PDOException $e){
			$response->withStatus(400);
			$body = json_encode(['status' => false, 'msg' => $e]);
		}

		$response->write($body);
		return $response;
    });



?>