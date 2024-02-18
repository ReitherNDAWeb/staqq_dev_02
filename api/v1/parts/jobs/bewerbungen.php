<?php
    
    $app->get('/bewerbungen', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM bewerbungen");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->get('/bewerbungen/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM bewerbungen WHERE bewerbungen.id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            
            $bewerbung = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
            
            $bewerbung['score'] = getSTAQQScore($bewerbung['ressources_id'], $bewerbung['joborders_id']);
            
            $body = json_encode($bewerbung);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->post('/bewerbungen', function($request, $response, $args) {
        try{
    
            $db = getDB();
            $sth = $db->prepare("DELETE FROM `joborders_gemerkt` WHERE ressources_id=:ressources_id AND joborders_id=:joborders_id");
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->execute();
            
            $sth = $db->prepare("INSERT INTO `bewerbungen` (`status`, `changed`, `ressources_id`, `joborders_id`, `dienstleister_id`) VALUES (:status, :changed, :ressources_id, :joborders_id, :dienstleister_id)");
            $status= "beworben";
            $sth->bindParam(':status', $status, PDO::PARAM_STR);
            $sth->bindParam(':changed', strval(time()), PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            $sth->execute();
			
            $id = $db->lastInsertId();
			
			// Notification
			
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
            $sth->bindParam(':id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->execute();
            $ressource = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$sth = $db->prepare("SELECT * FROM joborders WHERE id=:id");
            $sth->bindParam(':id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			if ($joborder['dienstleister_vorgegeben'] == '1' && $joborder['dienstleister_single'] == '1'){
				$dlid = $joborder['dienstleister_id'];
			}else{
				$dlid = $request->getParsedBody()['dienstleister_id'];
			}
			
			$sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
            $sth->bindParam(':id', $dlid, PDO::PARAM_INT);
            $sth->execute();
            $dl = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			if ($dl['joborder_empfaenger_user'] != null && $joborder['publisher_type'] == 'kunde'){
				
				$sth = $db->prepare("INSERT IGNORE joborders_dienstleister_user_delegation (joborders_id, dienstleister_id, dienstleister_user_id) VALUES (:joborders_id, :dienstleister_id, :dienstleister_user_id)");

				$sth->bindParam(':dienstleister_id', $dlid, PDO::PARAM_INT);
				$sth->bindParam(':dienstleister_user_id', $dl['joborder_empfaenger_user'], PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
				$sth->execute();
				
				$receiver_type = "dienstleister_user";
				$receiver_id = $dl['joborder_empfaenger_user'];
				
			}elseif ($joborder['creator_type'] == 'dienstleister_user'){
				
				$receiver_type = "dienstleister_user";
				$receiver_id = $joborder['creator_id'];
				
			}else{
				
				$receiver_type = "dienstleister";
				$receiver_id = $dlid;
				
			}
			
			if ($joborder['publisher_type'] == "kunde"){
				$link_web = "/app/joborders/";
				$link_mobile = "/dienstleister/joborders";
			}else{
				$link_web = "/app/joborders/ressourcen/?id=" . hashId($request->getParsedBody()['joborders_id']);
				$link_mobile = "/dienstleister/joborders/{$request->getParsedBody()['joborders_id']}/ressources";
			}
			
			fireNotification (array(
				'receiver_type'	=> $receiver_type, 
				'receiver_id' 	=> $receiver_id, 
				'titel' 		=> 'Neue Bewerbung',
				'subtitle'		=> 'Neue Bewerbung beim Job ' . $joborder['jobtitel'],
				'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> sich auf den Job <strong>{$joborder['jobtitel']}</strong> beworben!", 
				'kategorie' 	=> 'joborder', 
				'link_web' 		=> $link_web, 
				'link_mobile' 	=> $link_mobile, 
				'send_web' 		=> true, 
				'send_mobile' 	=> true,
				'force' 		=> true
			));
            
            $body = json_encode(['status' => true, 'id' => $id]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/bewerbungen/einsatzVerify/{type}', function($request, $response, $args) {
        try{
			
			$rechnung = false;
			$rechnungslink = "";
			
            $db = getDB();
            $sth = $db->prepare("UPDATE bewerbungen SET ".$args['type']."_einsatz_bestaetigt = 1 WHERE (ressources_id=:ressources_id AND joborders_id=:joborders_id)");
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->execute();
			
			
			// Notification & Rechnung
			
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
			$sth->bindParam(':id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
			$sth->execute();
			$ressource = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];

			$sth = $db->prepare("SELECT *, bewerbungen.dienstleister_id AS bewerbungen_dienstleister_id, joborders.dienstleister_id AS joborders_dienstleister_id FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE (ressources_id=:ressources_id AND joborders_id=:joborders_id)");
			$sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$bewerbung = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$dlid = $bewerbung['bewerbungen_dienstleister_id'];
			
			$sth = $db->prepare("SELECT * FROM joborders_dienstleister_user_delegation WHERE joborders_id=:joborders_id AND dienstleister_id=:dienstleister_id");
			$sth->bindParam(':dienstleister_id', $dlid, PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$delegationen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			if ((count($delegationen) > 0) && ($delegationen[0]['dienstleister_user_id'] != null)){
				
				$receiver_type = "dienstleister_user";
				$receiver_id = $delegationen[0]['dienstleister_user_id'];
				
			}elseif ($bewerbung['creator_type'] == 'dienstleister_user'){
				
				$receiver_type = "dienstleister_user";
				$receiver_id = $bewerbung['creator_id'];
				
			}else{
				
				$receiver_type = "dienstleister";
				$receiver_id = $dlid;
				
			}
			
			
			if ($args['type'] == "ressource"){
				
				fireNotification (array(
					'receiver_type'	=> $receiver_type, 
					'receiver_id' 	=> $receiver_id,
					'titel' 		=> 'Arbeitsbeginn bestätigt',
					'subtitle'		=> 'Arbeitsbeginn bestätigt beim Job ' . $bewerbung['jobtitel'],
					'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat den Arbeitsbeginn für den Job <strong>{$bewerbung['jobtitel']}</strong> bestätigt!", 
					'kategorie' 	=> 'joborder', 
					'link_web' 		=> "/app/joborders/ressourcen/?id=" . hashId($request->getParsedBody()['joborders_id']), 
					'link_mobile' 	=> "/dienstleister/joborders/{$request->getParsedBody()['joborders_id']}/ressources", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));
			
			
				if ($bewerbung['publisher_type'] == "kunde"){
					fireNotification (array(
						'receiver_type'	=> $bewerbung['creator_type'], 
						'receiver_id' 	=> $bewerbung['creator_id'], 
						'titel' 		=> 'Arbeitsbeginn bestätigt',
						'subtitle'		=> 'Arbeitsbeginn bestätigt beim Job ' . $bewerbung['jobtitel'],
						'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat den Arbeitsbeginn für den Job <strong>{$bewerbung['jobtitel']}</strong> bestätigt!", 
						'kategorie' 	=> 'joborder', 
						'link_web' 		=> "/app/joborders/ressourcen/?id=" . hashId($request->getParsedBody()['joborders_id']), 
						'link_mobile' 	=> "/dienstleister/joborders/{$request->getParsedBody()['joborders_id']}/ressources", 
						'send_web' 		=> true, 
						'send_mobile' 	=> true,
						'force' 		=> true
					));
				}
				
			} elseif ($args['type'] == "dienstleister"){
				
				$sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
				$sth->bindParam(':id', $dlid, PDO::PARAM_INT);
				$sth->execute();
				$dienstleister = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				$rechnung = (filter_var($dienstleister['sammelrechnungen'], FILTER_VALIDATE_BOOLEAN) == false) && ($dienstleister['rechnungs_empfaenger_user'] == NULL);
				
				fireNotification (array(
					'receiver_type'	=> 'ressource', 
					'receiver_id' 	=> $request->getParsedBody()['ressources_id'], 
					'titel' 		=> 'Arbeitsbeginn bestätigt',
					'subtitle'		=> 'Arbeitsbeginn bestätigt beim Job ' . $bewerbung['jobtitel'],
					'nachricht' 	=> "<strong>{$dienstleister['firmenwortlaut']}</strong> hat den Arbeitsbeginn für den Job <strong>{$bewerbung['jobtitel']}</strong> bestätigt!", 
					'kategorie' 	=> 'joborder', 
					'link_web' 		=> "/app/joborders/#erhalten", 
					'link_mobile' 	=> "/ressource/joborders/{$request->getParsedBody()['joborders_id']}", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));
				
				ob_clean();
			
				if ($rechnung){
					$rechnungslink = verrechneJoboorder(array($request->getParsedBody()['joborders_id']), 'dienstleister', $dlid);
				}
			}
			
            $body = json_encode(['status' => true, 'rechnung' => $rechnung, 'rechnungslink' => $rechnungslink]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    

?>