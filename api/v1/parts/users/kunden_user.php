<?php

    $app->get('/kunden/{kunden_id}/user', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT kunden_user.*, DATE_FORMAT(kunden_user.aktiv_von,'%d.%m.%Y') AS aktiv_von, DATE_FORMAT(kunden_user.aktiv_bis,'%d.%m.%Y') AS aktiv_bis FROM kunden_user WHERE kunden_id=:kunden_id");
            $sth->bindParam(':kunden_id', $args['kunden_id'], PDO::PARAM_INT);
            $sth->execute();
            $users = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			for ($i=0;$i<count($users);$i++){
				$users[$i]['arbeitsstaetten'] = array();
				if ($users[$i]['einschraenkung_arbeitsstaetten'] == 1){
					$sth = $db->prepare("SELECT arbeitsstaetten.name FROM relation_kunden_user_arbeitsstaetten LEFT JOIN arbeitsstaetten ON arbeitsstaetten.id = relation_kunden_user_arbeitsstaetten.arbeitsstaetten_id WHERE kunden_user_id=:kunden_user_id");
					$sth->bindParam(':kunden_user_id', $users[$i]['id'], PDO::PARAM_INT);
					$sth->execute();
					foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
						array_push($users[$i]['arbeitsstaetten'], $b['name']);
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

    $app->get('/kunden/{kunden_id}/user/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT kunden_user.*, DATE_FORMAT(kunden_user.aktiv_von,'%d.%m.%Y') AS aktiv_von, DATE_FORMAT(kunden_user.aktiv_bis,'%d.%m.%Y') AS aktiv_bis FROM kunden_user WHERE kunden_id=:kunden_id AND id=:id");
            $sth->bindParam(':kunden_id', $args['kunden_id'], PDO::PARAM_INT);
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];			
			
            $sth = $db->prepare("SELECT berufsfelder_id AS id, berufsfelder.name AS name FROM relation_kunden_user_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_kunden_user_berufsfelder.berufsfelder_id WHERE kunden_user_id=:kunden_user_id");
            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['berufsfelder'] = array();
            $user['berufsfelder_full'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['berufsfelder'], $b['id']);
                array_push($user['berufsfelder_full'], $b);
            }
            
            $sth = $db->prepare("SELECT berufsgruppen_id AS id, berufsgruppen.name AS name, berufsgruppen.berufsfelder_id AS berufsfelder_id FROM relation_kunden_user_suchgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_kunden_user_suchgruppen.berufsgruppen_id WHERE kunden_user_id=:kunden_user_id");
            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['suchgruppen'] = array();
            $user['suchgruppen_full'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['suchgruppen'], $b['id']);
                array_push($user['suchgruppen_full'], $b);
            }
			
            $sth = $db->prepare("SELECT arbeitsstaetten_id FROM relation_kunden_user_arbeitsstaetten WHERE kunden_user_id=:kunden_user_id");
            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['arbeitsstaetten'] = array();
            foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){
                array_push($user['arbeitsstaetten'], $b['arbeitsstaetten_id']);
            }
			
			$sth = $db->prepare("
				SELECT 
					dienstleister.id, 
					dienstleister.firmenwortlaut, 
					CONCAT(dienstleister.firmenwortlaut, ' (★ ', IFNULL(AVG(bewertungen.bewertung), 0), ')') AS firmenwortlaut_inkl_bewertung 
				FROM 
					relation_kunden_user_bevorzugte_dienstleister 
				LEFT JOIN 
					dienstleister ON dienstleister.id = relation_kunden_user_bevorzugte_dienstleister.dienstleister_id 
				LEFT JOIN 
					bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1
				WHERE 
					relation_kunden_user_bevorzugte_dienstleister.kunden_user_id=:kunden_user_id
				GROUP BY 
					dienstleister.id
			");
			
            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $user['bevorzugte_dienstleister'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($user);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->get('/kunden/user/{id}/berechtigungen', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    kunden_id,
                    berechtigung_joborders_schalten,
                    berechtigung_einkauf,
                    berechtigung_auswertung,
                    einschraenkung_aktiv_von_bis,
                    einschraenkung_arbeitsstaetten,
                    einschraenkung_berufsfelder,
					einschraenkung_suchgruppen,
                    aktiv_von,
                    aktiv_bis
                FROM 
                    kunden_user 
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

    $app->post('/kunden/{kunden_id}/user', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true, 'fields' => $request->getParsedBody()]);
        }else{
            
            include("../../wp-load.php");

            $email = $request->getParsedBody()['email'];
            $passwort = $request->getParsedBody()['passwort'];

            $user_info = array(
                "user_pass"     => $passwort,
                "user_login"    => 'kunde_u_'.$request->getParsedBody()['vorname'].'_'.$request->getParsedBody()['nachname'].'_'.time(),
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['titel'].' '.$request->getParsedBody()['vorname'].' '.$request->getParsedBody()['nachname'],
                "first_name"    => $request->getParsedBody()['vorname'],
                "last_name"     => $request->getParsedBody()['nachname'],
                "role"          => "kunde_u"
            );
            
            if (!username_exists($email) && !email_exists($email)) {
				
				try{	

					$insert_user_result = wp_insert_user($user_info);
					
					$db = getDB();
                    $sth = $db->prepare("SELECT * FROM kunden WHERE id=:id");
                    $sth->bindParam(':id', $args['kunden_id'], PDO::PARAM_INT);
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
						$sth = $db->prepare("INSERT INTO kunden_user (`kunden_id`, `anrede`, `titel`, `vorname`, `nachname`, `position`, `telefon`, `email`, `aktiv_von`, `aktiv_bis`, `berechtigung_joborders_schalten`, `berechtigung_einkauf`, `berechtigung_auswertung`, `einschraenkung_aktiv_von_bis`, `einschraenkung_arbeitsstaetten`, `einschraenkung_berufsfelder`, `einschraenkung_suchgruppen`) VALUES (:kunden_id, :anrede, :titel, :vorname, :nachname, :position, :telefon, :email, :aktiv_von, :aktiv_bis, :berechtigung_joborders_schalten, :berechtigung_einkauf, :berechtigung_auswertung, :einschraenkung_aktiv_von_bis, :einschraenkung_arbeitsstaetten, :einschraenkung_berufsfelder, :einschraenkung_suchgruppen)");

						$sth->bindParam(':kunden_id', $args['kunden_id'], PDO::PARAM_INT);
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
						$sth->bindParam(':einschraenkung_arbeitsstaetten', $request->getParsedBody()['einschraenkung_arbeitsstaetten'], PDO::PARAM_STR);
						$sth->bindParam(':einschraenkung_berufsfelder', $request->getParsedBody()['einschraenkung_berufsfelder'], PDO::PARAM_STR);
						$sth->bindParam(':einschraenkung_suchgruppen', $request->getParsedBody()['einschraenkung_suchgruppen'], PDO::PARAM_STR);

						$sth->execute();

						if ($insert_user_result){

							$user_id = $db->lastInsertId();
							add_user_meta($insert_user_result, 'staqq_id', $user_id);

							$sth = $db->prepare("UPDATE kunden SET anzahl_user = anzahl_user - 1 WHERE id = :id");
							$sth->bindParam(':id', $args['kunden_id'], PDO::PARAM_INT);
							$sth->execute();

							foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
								$sth = $db->prepare("INSERT INTO relation_kunden_user_berufsfelder (kunden_user_id, berufsfelder_id) VALUES (:kunden_user_id, :berufsfelder_id)");
								$sth->bindParam(':kunden_user_id', $user_id, PDO::PARAM_INT);
								$sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
								$sth->execute();
							}

							foreach (json_decode($request->getParsedBody()['suchgruppen']) as $f){
								$sth = $db->prepare("INSERT INTO relation_kunden_user_suchgruppen (kunden_user_id, berufsgruppen_id) VALUES (:kunden_user_id, :berufsgruppen_id)");
								$sth->bindParam(':kunden_user_id', $user_id, PDO::PARAM_INT);
								$sth->bindParam(':berufsgruppen_id', $f, PDO::PARAM_INT);
								$sth->execute();
							}

							foreach (json_decode($request->getParsedBody()['arbeitsstaetten']) as $f){
								$sth = $db->prepare("INSERT INTO relation_kunden_user_arbeitsstaetten (arbeitsstaetten_id, kunden_user_id) VALUES (:arbeitsstaetten_id, :kunden_user_id)");
								$sth->bindParam(':arbeitsstaetten_id', $f, PDO::PARAM_INT);
								$sth->bindParam(':kunden_user_id', $user_id, PDO::PARAM_INT);
								$sth->execute();
							}

							foreach (json_decode($request->getParsedBody()['bevorzugte_dienstleister']) as $f){
								$sth = $db->prepare("INSERT INTO relation_kunden_user_bevorzugte_dienstleister (dienstleister_id, kunden_user_id) VALUES (:dienstleister_id, :kunden_user_id)");
								$sth->bindParam(':dienstleister_id', $f, PDO::PARAM_INT);
								$sth->bindParam(':kunden_user_id', $user_id, PDO::PARAM_INT);
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


    $app->put('/kunden/user/{id}', function($request, $response, $args) {
        
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
                "role"          => "kunde_u"
            );

            if ((email_exists($email) && (!$updateEmail)) || ((!email_exists($email)) && $updateEmail)) {

                $insert_user_result = wp_update_user($user_info);
                
                try{
                    $db = getDB();
                    $sth = $db->prepare("
                        UPDATE 
                            kunden_user 
                        SET
                            `kunden_id`=:kunden_id, 
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
                            `einschraenkung_arbeitsstaetten`=:einschraenkung_arbeitsstaetten, 
                            `einschraenkung_berufsfelder`=:einschraenkung_berufsfelder, 
                            `einschraenkung_suchgruppen`=:einschraenkung_suchgruppen
                        WHERE
                            id=:id");

                    $sth->bindParam(':kunden_id', $request->getParsedBody()['kunden_id'], PDO::PARAM_INT);
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
                    $sth->bindParam(':einschraenkung_arbeitsstaetten', $request->getParsedBody()['einschraenkung_arbeitsstaetten'], PDO::PARAM_STR);
                    $sth->bindParam(':einschraenkung_berufsfelder', $request->getParsedBody()['einschraenkung_berufsfelder'], PDO::PARAM_STR);
					$sth->bindParam(':einschraenkung_suchgruppen', $request->getParsedBody()['einschraenkung_suchgruppen'], PDO::PARAM_STR);
                    $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);

                    $sth->execute();

                    if ($insert_user_result){
                        
                        $sth = $db->prepare("DELETE FROM relation_kunden_user_berufsfelder WHERE kunden_user_id=:kunden_user_id");
                        $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_kunden_user_berufsfelder (kunden_user_id, berufsfelder_id) VALUES (:kunden_user_id, :berufsfelder_id)");
                            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $sth = $db->prepare("DELETE FROM relation_kunden_user_suchgruppen WHERE kunden_user_id=:kunden_user_id");
                        $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['suchgruppen']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_kunden_user_suchgruppen (kunden_user_id, berufsgruppen_id) VALUES (:kunden_user_id, :berufsgruppen_id)");
                            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->bindParam(':berufsgruppen_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $sth = $db->prepare("DELETE FROM relation_kunden_user_arbeitsstaetten WHERE kunden_user_id=:kunden_user_id");
                        $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['arbeitsstaetten']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_kunden_user_arbeitsstaetten (arbeitsstaetten_id, kunden_user_id) VALUES (:arbeitsstaetten_id, :kunden_user_id)");
                            $sth->bindParam(':arbeitsstaetten_id', $f, PDO::PARAM_INT);
                            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                            $sth->execute();
                        }
                        
                        $sth = $db->prepare("DELETE FROM relation_kunden_user_bevorzugte_dienstleister WHERE kunden_user_id=:kunden_user_id");
                        $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();

                        foreach (json_decode($request->getParsedBody()['bevorzugte_dienstleister']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_kunden_user_bevorzugte_dienstleister (dienstleister_id, kunden_user_id) VALUES (:dienstleister_id, :kunden_user_id)");
                            $sth->bindParam(':dienstleister_id', $f, PDO::PARAM_INT);
                            $sth->bindParam(':kunden_user_id', $args['id'], PDO::PARAM_INT);
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

    $app->put('/kunden/user/{id}/notificationSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					kunden_user 
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

	$app->get('/kunden/{kunden_id}/user/{id}/joborders', function($request, $response, $args) {
        
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
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis 
                FROM 
                    joborders 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = joborders.dienstleister_id 
                WHERE 
                    publisher_type='kunde' 
                    AND publisher_id=:kunden_id
					AND creator_type='kunde_user' 
					AND creator_id=:creator_id
            ");
            
            $sth->bindParam(':kunden_id', $args['kunden_id'], PDO::PARAM_INT);
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
					$sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut FROM relation_joborders_dienstleister_auswahl
 LEFT JOIN dienstleister ON dienstleister.id = relation_joborders_dienstleister_auswahl.dienstleister_id WHERE relation_joborders_dienstleister_auswahl.joborders_id=:id");
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


    $app->get('/kunden/user/{id}/zahlen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
			$sth = $db->prepare("
                SELECT 
                    kunden_id 
                FROM 
                    kunden_user 
                WHERE 
					id=:id
            ");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
			$kd_id = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['kunden_id'];
			
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    bewertungen
				LEFT JOIN
					kunden_user ON kunden_user.id = bewertungen.von_id
                WHERE 
					von_type = 'kunde_user' AND
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
                    kunden
                WHERE 
					id=:id
            ");
            
            $sth->bindParam(':id', $kd_id, PDO::PARAM_INT);
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
/*
    $app->delete('/kunden/{kunden_id}/user/{id}', function($request, $response, $args) {
        
        include("../../wp-load.php");
		include("../../wp-admin/includes/user.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        		
		if (wp_delete_user($user_id)){
			try{
				$db = getDB();
				$sth = $db->prepare("DELETE FROM kunden_user WHERE kunden_id=:kunden_id AND id=:id LIMIT 1");

				$sth->bindParam(':kunden_id', $args['kunden_id'], PDO::PARAM_INT);
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->execute();

				$sth = $db->prepare("UPDATE kunden SET anzahl_user = anzahl_user + 1 WHERE id = :id");
				$sth->bindParam(':id', $args['kunden_id'], PDO::PARAM_INT);
				$sth->execute();
				
				$body = json_encode(['status' => true]);

			} catch(PDOException $e){
				$response->withStatus(400);
				$body = json_encode(['status' => false, 'msg' => $e]);
			}
		}else{
        	$body = json_encode(['status' => false, 'msg' => 'WP-User konnte nicht gelöscht werden! (ID: '.$email.')']);
		}
		
        $response->write($body);
        return $response;
    });
*/
?>