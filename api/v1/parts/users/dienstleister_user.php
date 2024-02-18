<?php

    $app->get('/dienstleister/{dienstleister_id}/user', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT dienstleister_user.*, DATE_FORMAT(dienstleister_user.aktiv_von,'%d.%m.%Y') AS aktiv_von,  DATE_FORMAT(dienstleister_user.aktiv_bis,'%d.%m.%Y') AS aktiv_bis FROM dienstleister_user WHERE dienstleister_id=:dienstleister_id");
            $sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
            $sth->execute();
            $users = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			for ($i=0;$i<count($users);$i++){
				$users[$i]['filialen'] = array();
				if ($users[$i]['einschraenkung_filialen'] == 1){
					$sth = $db->prepare("SELECT filialen.name FROM relation_dienstleister_user_filialen LEFT JOIN filialen ON filialen.id = relation_dienstleister_user_filialen.filialen_id WHERE dienstleister_user_id=:dienstleister_user_id");
					$sth->bindParam(':dienstleister_user_id', $users[$i]['id'], PDO::PARAM_INT);
					$sth->execute();
					foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
						array_push($users[$i]['filialen'], $b['name']);
					}
				}
			}
            
            $body = json_encode($users);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->get('/dienstleister/{dienstleister_id}/user/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT dienstleister_user.*, DATE_FORMAT(dienstleister_user.aktiv_von,'%d.%m.%Y') AS aktiv_von,  DATE_FORMAT(dienstleister_user.aktiv_bis,'%d.%m.%Y') AS aktiv_bis FROM dienstleister_user WHERE dienstleister_id=:dienstleister_id AND id=:id");
            $sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
            
            $sth = $db->prepare("SELECT berufsfelder_id AS id, berufsfelder.name AS name FROM relation_dienstleister_user_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_dienstleister_user_berufsfelder.berufsfelder_id WHERE dienstleister_user_id=:dienstleister_user_id");
            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['berufsfelder'] = array();
            $user['berufsfelder_full'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['berufsfelder'], $b['id']);
                array_push($user['berufsfelder_full'], $b);
            }
            
            $sth = $db->prepare("SELECT berufsgruppen_id AS id, berufsgruppen.name AS name, berufsgruppen.berufsfelder_id AS berufsfelder_id FROM relation_dienstleister_user_suchgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_dienstleister_user_suchgruppen.berufsgruppen_id WHERE dienstleister_user_id=:dienstleister_user_id");
            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['suchgruppen'] = array();
            $user['suchgruppen_full'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['suchgruppen'], $b['id']);
                array_push($user['suchgruppen_full'], $b);
            }
            
            $sth = $db->prepare("SELECT filialen_id FROM relation_dienstleister_user_filialen WHERE dienstleister_user_id=:dienstleister_user_id");
            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['filialen'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['filialen'], $b['filialen_id']);
            }
            
            $body = json_encode($user);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->get('/dienstleister/user/{id}/berechtigungen', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    dienstleister_id,
                    berechtigung_joborders_schalten,
                    berechtigung_einkauf,
                    berechtigung_auswertung,
                    einschraenkung_aktiv_von_bis,
                    einschraenkung_filialen,
                    einschraenkung_berufsfelder,
					einschraenkung_suchgruppen,
                    aktiv_von,
                    aktiv_bis
                FROM 
                    dienstleister_user 
                WHERE 
                    id=:id
            ");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->post('/dienstleister/{dienstleister_id}/user', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true, 'fields' => $request->getParsedBody()]);
        }else{
            
            include("../../wp-load.php");

            $email = $request->getParsedBody()['email'];
            $passwort = $request->getParsedBody()['passwort'];

            $user_info = array(
                "user_pass"     => $passwort,
                "user_login"    => 'dienstleister_u_'.$request->getParsedBody()['vorname'].'_'.$request->getParsedBody()['nachname'].'_'.time(),
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['titel'].' '.$request->getParsedBody()['vorname'].' '.$request->getParsedBody()['nachname'],
                "first_name"    => $request->getParsedBody()['vorname'],
                "last_name"     => $request->getParsedBody()['nachname'],
                "role"          => "dienstleister_u"
            );
            
            if (!username_exists($email) && !email_exists($email)) {
				
				try{

                    $insert_user_result = wp_insert_user($user_info);	
					
					$db = getDB();
                    $sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
                    $sth->bindParam(':id', $args['dienstleister_id'], PDO::PARAM_INT);
					$sth->execute();
					$u = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
					
					update_user_meta($insert_user_result, 'billing_first_name', $u['ansprechpartner_vorname']);
					update_user_meta($insert_user_result, 'billing_last_name', $u['ansprechpartner_nachname']);
					update_user_meta($insert_user_result, 'billing_company', $u['firmenwortlaut']);
					update_user_meta($insert_user_result, 'billing_address_1', $u['firmensitz_adresse']);
					update_user_meta($insert_user_result, 'billing_address_2', "UID: " . $u['uid']);
					update_user_meta($insert_user_result, 'billing_city', $u['firmensitz_ort']);
					update_user_meta($insert_user_result, 'billing_postcode', $u['firmensitz_plz']);
					update_user_meta($insert_user_result, 'billing_country', "AT");
					update_user_meta($insert_user_result, 'billing_email', $u['email']);
					update_user_meta($insert_user_result, 'billing_phone', $u['ansprechpartner_telefon']);

					try{

						$db = getDB();
						$sth = $db->prepare("INSERT INTO dienstleister_user (`dienstleister_id`, `anrede`, `titel`, `vorname`, `nachname`, `position`, `telefon`, `email`, `aktiv_von`, `aktiv_bis`, `berechtigung_joborders_schalten`, `berechtigung_einkauf`, `berechtigung_auswertung`, `einschraenkung_aktiv_von_bis`, `einschraenkung_filialen`, `einschraenkung_berufsfelder`, `einschraenkung_suchgruppen`) VALUES (:dienstleister_id, :anrede, :titel, :vorname, :nachname, :position, :telefon, :email, :aktiv_von, :aktiv_bis, :berechtigung_joborders_schalten, :berechtigung_einkauf, :berechtigung_auswertung, :einschraenkung_aktiv_von_bis, :einschraenkung_filialen, :einschraenkung_berufsfelder, :einschraenkung_suchgruppen)");

						$sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
						$sth->bindParam(':titel', $request->getParsedBody()['titel'], PDO::PARAM_STR);
						$sth->bindParam(':anrede', $request->getParsedBody()['anrede'], PDO::PARAM_STR);
						$sth->bindParam(':vorname', $request->getParsedBody()['vorname'], PDO::PARAM_STR);
						$sth->bindParam(':nachname', $request->getParsedBody()['nachname'], PDO::PARAM_STR);
						$sth->bindParam(':position', $request->getParsedBody()['position'], PDO::PARAM_STR);
						$sth->bindParam(':telefon', $request->getParsedBody()['telefon'], PDO::PARAM_STR);
						$sth->bindParam(':email', $email, PDO::PARAM_STR);
						$sth->bindParam(':aktiv_von', $request->getParsedBody()['aktiv_von'], PDO::PARAM_STR);
						$sth->bindParam(':aktiv_bis', $request->getParsedBody()['aktiv_bis'], PDO::PARAM_STR);
						$sth->bindParam(':berechtigung_joborders_schalten', $request->getParsedBody()['berechtigung_joborders_schalten'], PDO::PARAM_INT);
						$sth->bindParam(':berechtigung_einkauf', $request->getParsedBody()['berechtigung_einkauf'], PDO::PARAM_INT);
						$sth->bindParam(':berechtigung_auswertung', $request->getParsedBody()['berechtigung_auswertung'], PDO::PARAM_INT);
						$sth->bindParam(':einschraenkung_aktiv_von_bis', $request->getParsedBody()['einschraenkung_aktiv_von_bis'], PDO::PARAM_STR);
						$sth->bindParam(':einschraenkung_filialen', $request->getParsedBody()['einschraenkung_filialen'], PDO::PARAM_STR);
						$sth->bindParam(':einschraenkung_berufsfelder', $request->getParsedBody()['einschraenkung_berufsfelder'], PDO::PARAM_STR);
						$sth->bindParam(':einschraenkung_suchgruppen', $request->getParsedBody()['einschraenkung_suchgruppen'], PDO::PARAM_STR);

						$sth->execute();

						if ($insert_user_result){

							$user_id = $db->lastInsertId();
							add_user_meta($insert_user_result, 'staqq_id', $user_id);

							$sth = $db->prepare("UPDATE dienstleister SET anzahl_user = anzahl_user - 1 WHERE id = :id");
							$sth->bindParam(':id', $args['dienstleister_id'], PDO::PARAM_INT);
							$sth->execute();

							foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
								$sth = $db->prepare("INSERT INTO relation_dienstleister_user_berufsfelder (dienstleister_user_id, berufsfelder_id) VALUES (:dienstleister_user_id, :berufsfelder_id)");
								$sth->bindParam(':dienstleister_user_id', $user_id, PDO::PARAM_INT);
								$sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
								$sth->execute();
							}

							foreach (json_decode($request->getParsedBody()['suchgruppen']) as $f){
								$sth = $db->prepare("INSERT INTO relation_dienstleister_user_suchgruppen (dienstleister_user_id, berufsgruppen_id) VALUES (:dienstleister_user_id, :berufsgruppen_id)");
								$sth->bindParam(':dienstleister_user_id', $user_id, PDO::PARAM_INT);
								$sth->bindParam(':berufsgruppen_id', $f, PDO::PARAM_INT);
								$sth->execute();
							}

							foreach (json_decode($request->getParsedBody()['filialen']) as $f){
								$sth = $db->prepare("INSERT INTO relation_dienstleister_user_filialen (filialen_id, dienstleister_user_id) VALUES (:filialen_id, :dienstleister_user_id)");
								$sth->bindParam(':filialen_id', $f, PDO::PARAM_INT);
								$sth->bindParam(':dienstleister_user_id', $user_id, PDO::PARAM_INT);
								$sth->execute();
							}

							$body = json_encode(['status' => true, 'id' => $user_id]);
						}

					} catch(PDOException $e){
						$response->withStatus(400);
						$body = json_encode(['status' => false, 'msg' => $e]);
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


    $app->put('/dienstleister/user/{id}', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true, 'fields' => $request->getParsedBody()]);
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
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['titel'].' '.$request->getParsedBody()['vorname'].' '.$request->getParsedBody()['nachname'],
                "first_name"    => $request->getParsedBody()['vorname'],
                "last_name"     => $request->getParsedBody()['nachname'],
                "role"          => "dienstleister_u"
            );

            if ((email_exists($email) && (!$updateEmail)) || ((!email_exists($email)) && $updateEmail)) {

                $insert_user_result = wp_update_user($user_info);
                
                try{
                    $db = getDB();
                    $sth = $db->prepare("
                        UPDATE 
                            dienstleister_user 
                        SET
                            `dienstleister_id`=:dienstleister_id, 
                            `anrede`=:anrede, 
                            `titel`=:titel, 
                            `vorname`=:vorname, 
                            `nachname`=:nachname, 
                            `position`=:position, 
                            `telefon`=:telefon, 
                            `email`=:email, 
                            `aktiv_von`=:aktiv_von, 
                            `aktiv_bis`=:aktiv_bis, 
                            `berechtigung_joborders_schalten`=:berechtigung_joborders_schalten, 
                            `berechtigung_einkauf`=:berechtigung_einkauf, 
                            `berechtigung_auswertung`=:berechtigung_auswertung, 
                            `einschraenkung_aktiv_von_bis`=:einschraenkung_aktiv_von_bis, 
                            `einschraenkung_filialen`=:einschraenkung_filialen, 
                            `einschraenkung_berufsfelder`=:einschraenkung_berufsfelder, 
                            `einschraenkung_suchgruppen`=:einschraenkung_suchgruppen
                        WHERE
                            id=:id");

                    $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
                    $sth->bindParam(':titel', $request->getParsedBody()['titel'], PDO::PARAM_STR);
                    $sth->bindParam(':anrede', $request->getParsedBody()['anrede'], PDO::PARAM_STR);
                    $sth->bindParam(':vorname', $request->getParsedBody()['vorname'], PDO::PARAM_STR);
                    $sth->bindParam(':nachname', $request->getParsedBody()['nachname'], PDO::PARAM_STR);
                    $sth->bindParam(':position', $request->getParsedBody()['position'], PDO::PARAM_STR);
                    $sth->bindParam(':telefon', $request->getParsedBody()['telefon'], PDO::PARAM_STR);
                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':aktiv_von', $request->getParsedBody()['aktiv_von'], PDO::PARAM_STR);
                    $sth->bindParam(':aktiv_bis', $request->getParsedBody()['aktiv_bis'], PDO::PARAM_STR);
                    $sth->bindParam(':berechtigung_joborders_schalten', $request->getParsedBody()['berechtigung_joborders_schalten'], PDO::PARAM_INT);
                    $sth->bindParam(':berechtigung_einkauf', $request->getParsedBody()['berechtigung_einkauf'], PDO::PARAM_INT);
                    $sth->bindParam(':berechtigung_auswertung', $request->getParsedBody()['berechtigung_auswertung'], PDO::PARAM_INT);
                    $sth->bindParam(':einschraenkung_aktiv_von_bis', $request->getParsedBody()['einschraenkung_aktiv_von_bis'], PDO::PARAM_STR);
                    $sth->bindParam(':einschraenkung_filialen', $request->getParsedBody()['einschraenkung_filialen'], PDO::PARAM_STR);
                    $sth->bindParam(':einschraenkung_berufsfelder', $request->getParsedBody()['einschraenkung_berufsfelder'], PDO::PARAM_STR);
                    $sth->bindParam(':einschraenkung_suchgruppen', $request->getParsedBody()['einschraenkung_suchgruppen'], PDO::PARAM_STR);
                    $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);

                    $sth->execute();

                    if ($insert_user_result){
                        
                        $sth = $db->prepare("DELETE FROM relation_dienstleister_user_berufsfelder WHERE dienstleister_user_id=:dienstleister_user_id");
                        $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_dienstleister_user_berufsfelder (dienstleister_user_id, berufsfelder_id) VALUES (:dienstleister_user_id, :berufsfelder_id)");
                            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $sth = $db->prepare("DELETE FROM relation_dienstleister_user_suchgruppen WHERE dienstleister_user_id=:dienstleister_user_id");
                        $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['suchgruppen']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_dienstleister_user_suchgruppen (dienstleister_user_id, berufsgruppen_id) VALUES (:dienstleister_user_id, :berufsgruppen_id)");
                            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->bindParam(':berufsgruppen_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $sth = $db->prepare("DELETE FROM relation_dienstleister_user_filialen WHERE dienstleister_user_id=:dienstleister_user_id");
                        $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['filialen']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_dienstleister_user_filialen (filialen_id, dienstleister_user_id) VALUES (:filialen_id, :dienstleister_user_id)");
                            $sth->bindParam(':filialen_id', $f, PDO::PARAM_INT);
                            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $body = json_encode(['status' => true]);
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

    $app->put('/dienstleister/user/{id}/notificationSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					dienstleister_user 
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

	$app->get('/dienstleister/{dienstleister_id}/user/{id}/joborders', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    kunden.firmenwortlaut AS kunden_firmenwortlaut
                FROM 
                    joborders 
                LEFT JOIN 
                    bewerbungen ON bewerbungen.joborders_id = joborders.id 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = joborders.dienstleister_id 
                LEFT JOIN 
                    kunden ON joborders.publisher_id = kunden.id 
                LEFT JOIN 
                    joborders_dienstleister_user_delegation ON joborders_dienstleister_user_delegation.joborders_id = bewerbungen.joborders_id
				LEFT JOIN 
                    dienstleister_joborders_abgelehnt ON (dienstleister_joborders_abgelehnt.dienstleister_id=:dienstleister_id AND dienstleister_joborders_abgelehnt.joborders_id = joborders.id) 
                WHERE 
                    ((publisher_type='dienstleister' AND publisher_id=:dienstleister_id AND creator_type='dienstleister_user' AND creator_id=:creator_id)
                    OR (publisher_type='kunde' AND bewerbungen.dienstleister_id = :dienstleister_id AND joborders_dienstleister_user_delegation.dienstleister_user_id=:creator_id)) 
					AND (dienstleister_joborders_abgelehnt.joborders_id IS NULL)
                GROUP BY 
                    joborders.id
            ");
            
            $sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':creator_id', $args['id'], PDO::PARAM_INT);
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
				
                $sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='einsatz_bestaetigt'");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_einsatz_bestaetigt'] = $r['anz'];
				
                $sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='einsatz_bestaetigt' AND dienstleister_einsatz_bestaetigt=1 AND ressource_einsatz_bestaetigt=1");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
                $joborders[$i]['anzahl_bewerbungen_erfolgter_einsatz_bestaetigt'] = $r['anz'];
                
                $sth = $db->prepare("SELECT berufsfelder.* FROM relation_joborders_berufsfelder LEFT JOIN 
            berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $joborders[$i]['berufsfelder'] = $sth->fetchAll(PDO::FETCH_ASSOC);
				
                $sth = $db->prepare("SELECT bewerbungen.ressources_id FROM bewerbungen WHERE joborders_id=:id");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $r = $sth->fetchAll(PDO::FETCH_ASSOC);
				
                $joborders[$i]['anzahl_bewerbungen_nicht_mehr_verfuegbar'] = 0;
				
				foreach ($r as $ressource){
				
					$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen 
						LEFT JOIN 
							joborders ON joborders.id = bewerbungen.joborders_id 
						WHERE 
							joborders.arbeitsbeginn <= :ae 
							AND joborders.arbeitsende >= :ab 
							AND bewerbungen.ressources_id=:id 
							AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt') 
							AND (bewerbungen.joborders_id NOT IN (:joborders_id))
					");

					$sth->bindParam(':id', $ressource['ressources_id'], PDO::PARAM_INT);
					$sth->bindParam(':joborders_id', $joborders[$i]['id'], PDO::PARAM_INT);
					$sth->bindParam(':ab', $joborders[$i]['ab'], PDO::PARAM_STR);
					$sth->bindParam(':ae', $joborders[$i]['ae'], PDO::PARAM_STR);
					$sth->execute();
				
					if (intval($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz']) > 0) $joborders[$i]['anzahl_bewerbungen_nicht_mehr_verfuegbar']++;
					
				}
				
				$joborders[$i]['anzahl_bewerbungen_noch_verfuegbar'] = $joborders[$i]['anzahl_bewerbungen_gesamt'] - $joborders[$i]['anzahl_bewerbungen_nicht_mehr_verfuegbar'];
            }
            
            $body = json_encode($joborders);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->get('/dienstleister/{dienstleister_id}/user/{id}/castings', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    ressources.vorname,
                    ressources.nachname,
                    ressources.email,
                    ressources.telefon,
                    ressources.id,
                    castings.dienstleister_verify,
                    castings.ressources_verify,
                    castings.empfehlung,
                    DATE_FORMAT(castings.dienstleister_datetime,'%d.%m.%Y') AS dienstleister_datetime,
                    DATE_FORMAT(castings.ressources_datetime,'%d.%m.%Y') AS ressources_datetime 
                FROM 
                    castings 
                LEFT JOIN 
                    ressources ON ressources.id = castings.ressources_id 
                WHERE 
                    castings.dienstleister_id = :dienstleister_id AND
					castings.dienstleister_user_id = :dienstleister_user_id
            ");
            
            $sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $castings = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($castings);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });


    $app->get('/dienstleister/user/{id}/zahlen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
            $sth = $db->prepare("
                SELECT 
                    dienstleister_id 
                FROM 
                    dienstleister_user
                WHERE 
					id=:id
            ");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
			$dl_id = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['dienstleister_id'];
			
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    bewertungen
				LEFT JOIN
					dienstleister_user ON dienstleister_user.id = bewertungen.von_id
                WHERE 
					von_type = 'dienstleister_user' AND
                    von_id=:id AND 
					status = 0
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
			
			$anzahlen = array();
			$res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
            $anzahlen['bewertungen']['offen'] = $res['offen'];
            
            $sth = $db->prepare("
                SELECT 
                    anzahl_joborders, 
					anzahl_user
                FROM 
                    dienstleister
                WHERE 
					id=:id
            ");
            
            $sth->bindParam(':id', $dl_id, PDO::PARAM_INT);
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

?>