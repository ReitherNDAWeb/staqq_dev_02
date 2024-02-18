<?php

    $app->get('/dienstleister', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT dienstleister.*, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM dienstleister LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 GROUP BY dienstleister.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });
    
    $app->get('/dienstleister/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT *, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM dienstleister LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE id=:id GROUP BY dienstleister.id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
            
            $sth = $db->prepare("SELECT berufsfelder.id, berufsfelder.name FROM relation_dienstleister_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_dienstleister_berufsfelder.berufsfelder_id WHERE relation_dienstleister_berufsfelder.dienstleister_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['berufsfelder'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT * FROM filialen WHERE dienstleister_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['filialen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $body = json_encode($res);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });
    
    $app->get('/dienstleister/{id}/joborders', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    arbeitsbeginn AS ab,
                    arbeitsende AS ae,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    kunden.firmenwortlaut AS kunden_firmenwortlaut,
                    kunden.website AS kunden_website
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
                    joborders_dienstleister_user_delegation ON (joborders_dienstleister_user_delegation.joborders_id = bewerbungen.joborders_id AND joborders_dienstleister_user_delegation.dienstleister_id=:id)
				LEFT JOIN 
                    dienstleister_joborders_abgelehnt ON (dienstleister_joborders_abgelehnt.dienstleister_id=:id AND dienstleister_joborders_abgelehnt.joborders_id = joborders.id) 
                WHERE 
                    ((creator_type='dienstleister' AND creator_id=:id)
                    OR (publisher_type='kunde' AND bewerbungen.dienstleister_id = :id AND joborders_dienstleister_user_delegation.dienstleister_id IS NULL))
					AND (dienstleister_joborders_abgelehnt.joborders_id IS NULL)
                GROUP BY 
                    joborders.id
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
    
    $app->get('/dienstleister/{id}/ressources', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    ressources.vorname,
                    ressources.nachname,
                    ressources.email,
                    ressources.telefon,
                    ressources.id AS ressources_id,
                    joborders.jobtitel AS joborders_jobtitel
                FROM 
                    bewerbungen 
                LEFT JOIN 
                    ressources ON ressources.id = bewerbungen.ressources_id 
                LEFT JOIN 
                    joborders ON joborders.id = bewerbungen.joborders_id 
                WHERE 
                    bewerbungen.dienstleister_id = :dienstleister_id
                GROUP BY 
                    ressources.id
            ");
            
            $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $ressources = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($ressources);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });
    
    $app->get('/dienstleister/{id}/castings', function($request, $response, $args) {
        
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
                    castings.dienstleister_id = :dienstleister_id
					AND (castings.dienstleister_user_id IS NULL)
            ");
            
            $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
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

    $app->post('/dienstleister', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
            
            include("../../wp-load.php");

            $email = $request->getParsedBody()['email'];
            $passwort = $request->getParsedBody()['passwort'];

            $user_info = array(
                "user_pass"     => $passwort,
                "user_login"    => 'dienstleister_'.$request->getParsedBody()['ansprechpartner_vorname'].'_'.$request->getParsedBody()['ansprechpartner_nachname'].'_'.time(),
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['ansprechpartner_titel'].' '.$request->getParsedBody()['ansprechpartner_vorname'].' '.$request->getParsedBody()['ansprechpartner_nachname'],
                "first_name"    => $request->getParsedBody()['ansprechpartner_vorname'],
                "last_name"     => $request->getParsedBody()['ansprechpartner_nachname'],
                "role"          => "dienstleister"
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
                    $sth = $db->prepare("INSERT INTO dienstleister (email, firmenwortlaut, gesellschaftsform, ansprechpartner_anrede, ansprechpartner_titel, ansprechpartner_vorname, ansprechpartner_nachname, ansprechpartner_position, ansprechpartner_telefon, uid, fn, firmensitz_plz, firmensitz_adresse, firmensitz_ort, anzahl_user, anzahl_joborders, registrations_id, agb_accept, website) VALUES (:email, :firmenwortlaut, :gesellschaftsform, :ansprechpartner_anrede, :ansprechpartner_titel, :ansprechpartner_vorname, :ansprechpartner_nachname, :ansprechpartner_position, :ansprechpartner_telefon, :uid, :fn, :firmensitz_plz, :firmensitz_adresse, :firmensitz_ort, :anzahl_user, :anzahl_joborders, :registrations_id, :agb_accept, :website)");

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

                        foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_dienstleister_berufsfelder (dienstleister_id, berufsfelder_id) VALUES (:dienstleister_id, :berufsfelder_id)");
                            $sth->bindParam(':dienstleister_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['filialen']) as $f){
                            $sth = $db->prepare("INSERT INTO filialen (name, dienstleister_id) VALUES (:name, :dienstleister_id)");
                            $sth->bindParam(':name', $f, PDO::PARAM_STR);
                            $sth->bindParam(':dienstleister_id', $user_id, PDO::PARAM_INT);
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

    $app->put('/dienstleister/{id}', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true, 'body' => $request->getParsedBody()]);
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
                "role"          => "dienstleister"
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
                    $sth = $db->prepare("UPDATE dienstleister SET email=:email, firmenwortlaut=:firmenwortlaut, gesellschaftsform=:gesellschaftsform, ansprechpartner_anrede=:ansprechpartner_anrede, ansprechpartner_titel=:ansprechpartner_titel, ansprechpartner_vorname=:ansprechpartner_vorname, ansprechpartner_nachname=:ansprechpartner_nachname, ansprechpartner_position=:ansprechpartner_position, ansprechpartner_telefon=:ansprechpartner_telefon, uid=:uid, fn=:fn, firmensitz_plz=:firmensitz_plz, firmensitz_adresse=:firmensitz_adresse, firmensitz_ort=:firmensitz_ort, agb_accept=:agb_accept, website=:website WHERE id=:id");

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

                    $sth = $db->prepare("DELETE FROM relation_dienstleister_berufsfelder WHERE dienstleister_id=:dienstleister_id");
                    $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();
                    
                    foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                        $sth = $db->prepare("INSERT INTO relation_dienstleister_berufsfelder (dienstleister_id, berufsfelder_id) VALUES (:dienstleister_id, :berufsfelder_id)");
                        $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    
                    $sth = $db->prepare("DELETE FROM filialen WHERE dienstleister_id=:dienstleister_id");
                    $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();
                    
                    foreach (json_decode($request->getParsedBody()['filialen']) as $f){
                        $sth = $db->prepare("INSERT INTO filialen (name, dienstleister_id) VALUES (:name, :dienstleister_id)");
                        $sth->bindParam(':name', $f, PDO::PARAM_STR);
                        $sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
                        $sth->execute();
                    }

                    $body = json_encode(['status' => true]);
                    
                } catch(PDOException $e){
                    $response->withStatus(400);
                    $body = json_encode(['status' => false, 'msg' => $e]);
                }
            } else {
                $response->withStatus(400);
                $body = json_encode(['status' => false, 'msg' => "Die E-Mail-Adresse wird schon von einem anderen Benutzer verwendet!", 'ex' => $request->getParsedBody()]);
            }
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/dienstleister/{id}/notificationSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					dienstleister 
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

    $app->put('/dienstleister/{id}/backendSettings', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					dienstleister 
				SET 
					sammelrechnungen=:sammelrechnungen,
					anzahl_joborders=:anzahl_joborders,
					anzahl_user=:anzahl_user
				WHERE 
					id=:id
			");
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->bindParam(':sammelrechnungen', $request->getParsedBody()['sammelrechnungen'], PDO::PARAM_INT);
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

    $app->put('/dienstleister/{id}/acceptAGB', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("UPDATE dienstleister SET agb_accept=1 WHERE id=:id");
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

    $app->put('/dienstleister/{id}/changePasswort', function($request, $response, $args) {
        
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

    $app->post('/dienstleister/{id}/requestDelete', function($request, $response, $args) {
        
        $db = getDB();
        $sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
        $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $sth->execute();
        $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
        
        $html  = "<p>Hallo STAQQ-Team!</p>";
        $html .= "<p>Anfrage zur Account-Löschung eines <strong>Dienstleisters:</strong></p>";
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

    $app->delete('/dienstleister/{id}', function($request, $response, $args) {
        
        include("../../wp-load.php");
		include("../../wp-admin/includes/user.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        		
		if (wp_delete_user($user_id)){
			try{
				$db = getDB();
				$sth = $db->prepare("DELETE FROM dienstleister WHERE id=:id LIMIT 1");

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


    $app->get('/dienstleister/{id}/zahlen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    bewertungen
                WHERE 
					von_type = 'dienstleister' AND
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
                    dienstleister
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

	$app->get('/dienstleister/{id}/delegationen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    arbeitsbeginn AS ab,
                    arbeitsende AS ae,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    kunden.firmenwortlaut AS kunden_firmenwortlaut,
                    kunden.website AS kunden_website,
					dienstleister_user.vorname AS dienstleister_user_vorname,
					dienstleister_user.nachname AS dienstleister_user_nachname,
					dienstleister_user.id AS dienstleister_user_id
                FROM 
                    joborders_dienstleister_user_delegation 
                LEFT JOIN 
                    joborders ON joborders_dienstleister_user_delegation.joborders_id = joborders.id  
                LEFT JOIN 
                    bewerbungen ON bewerbungen.joborders_id = joborders.id 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = joborders.dienstleister_id 
                LEFT JOIN 
                    kunden ON joborders.publisher_id = kunden.id 
                LEFT JOIN 
                    dienstleister_user ON joborders_dienstleister_user_delegation.dienstleister_user_id = dienstleister_user.id 
                WHERE 
                    joborders_dienstleister_user_delegation.dienstleister_id=:id
                GROUP BY 
                    joborders.id
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            for($i=0;$i<count($joborders);$i++){
                
                $sth = $db->prepare("SELECT berufsfelder.* FROM relation_joborders_berufsfelder LEFT JOIN 
            berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $joborders[$i]['berufsfelder'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
            
            $body = json_encode($joborders);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
	});

	$app->get('/dienstleister/{id}/rechnungen', function($request, $response, $args) use($app) {
        
        try{
			$db = getDB();
            $sth = $db->prepare("
                SELECT 
                    joborders.*
                FROM 
                    joborders 
				LEFT JOIN 
					bewerbungen ON bewerbungen.joborders_id = joborders.id 
                WHERE 
                    joborders.rechnung_erstellt = 1 
					AND bewerbungen.status = 'einsatz_bestaetigt' 
					AND bewerbungen.dienstleister_id=:id 
                GROUP BY 
                    joborders.id
				ORDER BY  
					joborders.rechnung_bezahlt_datum DESC, joborders.rechnung_erstellt_datum DESC, rechnung_bezahlt ASC
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			
			include("../../wp-load.php");
			
			for($i=0;$i<count($joborders);$i++){
				
				if ($joborders[$i]['rechnung_bezahlt'] == 1){
					$woo_pdf_invoice_id = get_post_meta($joborders[$i]['rechnung_order_id'], '_woo_pdf_invoice_id', true);
					$woo_pdf_invoice_code = get_post_meta($joborders[$i]['rechnung_order_id'], '_woo_pdf_invoice_code', true);
					$woo_pdf_invoice_prefix = get_post_meta($joborders[$i]['rechnung_order_id'], '_woo_pdf_invoice_prefix', true);
					$woo_pdf_invoice_suffix = get_post_meta($joborders[$i]['rechnung_order_id'], '_woo_pdf_invoice_suffix', true);

					$data = $woo_pdf_invoice_id.'|'.$woo_pdf_invoice_prefix.'|'.$woo_pdf_invoice_code.'|'.$woo_pdf_invoice_suffix;
					$joborders[$i]['rechnung_url'] = '/?wpd_invoice=' . base64_encode($data);
				}else{
					$joborders[$i]['rechnung_url'] = false;
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

    $app->post('/dienstleister/{id}/delegationen', function($request, $response, $args) {
        
       try{
			$db = getDB();
			$sth = $db->prepare("INSERT INTO joborders_dienstleister_user_delegation (joborders_id, dienstleister_id, dienstleister_user_id) VALUES (:joborders_id, :dienstleister_id, :dienstleister_user_id) ON DUPLICATE KEY UPDATE dienstleister_user_id=:dienstleister_user_id");

			$sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
			$sth->bindParam(':dienstleister_user_id', $request->getParsedBody()['dienstleister_user_id'], PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			
			$body = json_encode(['status' => true]);

		} catch(PDOException $e){
			$response->withStatus(400);
			$body = json_encode(['status' => false, 'msg' => $e]);
		}
		
        $response->write($body);
        return $response;
    });

    $app->delete('/dienstleister/{id}/delegationen', function($request, $response, $args) {
        
		try{
			$db = getDB();
			$sth = $db->prepare("DELETE FROM joborders_dienstleister_user_delegation WHERE dienstleister_id=:dienstleister_id AND joborders_id=:joborders_id AND dienstleister_user_id=:dienstleister_user_id LIMIT 1");

			$sth->bindParam(':dienstleister_id', $args['id'], PDO::PARAM_INT);
			$sth->bindParam(':dienstleister_user_id', $request->getParsedBody()['dienstleister_user_id'], PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			
			$body = json_encode(['status' => true]);

		} catch(PDOException $e){
			$response->withStatus(400);
			$body = json_encode(['status' => false, 'msg' => $e]);
		}
		
        $response->write($body);
        return $response;
    });

    
    $app->get('/dienstleister/{id}/delegationen/availableJoborders', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    arbeitsbeginn AS ab,
                    arbeitsende AS ae,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    kunden.firmenwortlaut AS kunden_firmenwortlaut,
                    kunden.website AS kunden_website
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
                    joborders_dienstleister_user_delegation ON (joborders_dienstleister_user_delegation.joborders_id = bewerbungen.joborders_id AND joborders_dienstleister_user_delegation.dienstleister_id=:id)
                WHERE 
                    publisher_type='kunde' AND bewerbungen.dienstleister_id = :id 
                GROUP BY 
                    joborders.id
            ");
            
			// AND joborders_dienstleister_user_delegation.dienstleister_id IS NULL
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($joborders);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->put('/dienstleister/{id}/joborderEmpfaengerUser', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					dienstleister 
				SET 
					joborder_empfaenger_user=:dienstleister_user_id
				WHERE 
					id=:id
			");
			
			$dienstleister_user_id = ($request->getParsedBody()['dienstleister_user_id'] == "null") ? NULL : $request->getParsedBody()['dienstleister_user_id'];
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_user_id', $dienstleister_user_id, PDO::PARAM_INT);
			$result = $sth->execute();
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->put('/dienstleister/{id}/rechnungsEmpfaengerUser', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				UPDATE 
					dienstleister 
				SET 
					rechnungs_empfaenger_user=:dienstleister_user_id
				WHERE 
					id=:id
			");
			
			$dienstleister_user_id = ($request->getParsedBody()['dienstleister_user_id'] == "null") ? NULL : $request->getParsedBody()['dienstleister_user_id'];
			
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_user_id', $dienstleister_user_id, PDO::PARAM_INT);
			$result = $sth->execute();
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->post('/dienstleister/{dienstleister_id}/jobAblehnen/{joborders_id}', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("
				INSERT INTO 
					dienstleister_joborders_abgelehnt (dienstleister_id, joborders_id)
				VALUES 
					(:dienstleister_id, :joborders_id) 
			");
			
            $sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $args['joborders_id'], PDO::PARAM_INT);
			$result = $sth->execute();
			
			$sth = $db->prepare("SELECT anzahl_ressourcen, jobtitel, arbeitsbeginn, arbeitsende FROM joborders WHERE id=:id");
			$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$j = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$sth = $db->prepare("SELECT ressources.*, bewerbungen.status FROM bewerbungen LEFT JOIN ressources ON bewerbungen.ressources_id = ressources.id WHERE bewerbungen.joborders_id=:id AND bewerbungen.dienstleister_id=:dienstleister_id");
			$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
			$sth->bindParam(':dienstleister_id', $args['dienstleister_id'], PDO::PARAM_INT);
			$sth->execute();

			include("../../wp-load.php");

			foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){

				if (intval($b['email_benachrichtigungen']) && ($b['status'] == "beworben")) {

					$ab = date("d.m.Y", strtotime($j['arbeitsbeginn']));
					$ae = date("d.m.Y", strtotime($j['arbeitsende']));

					$html =  "Sehr geehrte(r) {$b['anrede']} {$b['vorname']} {$b['nachname']}!";
					$html .= "<br><br>";
					$html .= nl2br(utf8_decode(get_option('email_absage_anderwaertig_vergeben')));
					$html .= "<br><br>";
					$html .= "Job: {$j['jobtitel']} ($ab - $ae)";
					$html .= "<br><br>";
					$html .= nl2br(utf8_decode(get_option('grusszeile')));

					$betreff = utf8_decode(get_option('email_absage_anderwaertig_vergeben_betreff'));

					$ret = sendMail($b['email'], $betreff, $html, '');
					
					// SEND PUSH
					
					fireNotification (array(
						'receiver_type'	=> 'ressource', 
						'receiver_id' 	=> $b['id'], 
						'titel' 		=> $betreff,
						'subtitle'		=> 'Job ' . $j['jobtitel'] . ' wurde leider anderwärtig vergeben!',
						'nachricht' 	=> "Job <strong>{$j['jobtitel']}</strong> wurde leider anderwärtig vergeben!", 
						'kategorie' 	=> 'joborder', 
						'link_web' 		=> "/app/joborders/", 
						'link_mobile' 	=> "/ressource/joborders", 
						'send_web' 		=> true, 
						'send_mobile' 	=> true,
						'force' 		=> true
					));
					
				}

			}
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

?>