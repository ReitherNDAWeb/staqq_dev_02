<?php

    $app->post('/castings', function($request, $response, $args) {
        try{
    
            $db = getDB();
			
			$sql = "INSERT INTO `castings` (`ressources_id`, `dienstleister_id`, `ressources_verify`, `dienstleister_verify`, `empfehlung`, `ressources_datetime`, `dienstleister_datetime`, `dienstleister_user_id`) VALUES (:ressources_id, :dienstleister_id, :ressources_verify, :dienstleister_verify, :empfehlung, :ressources_datetime, :dienstleister_datetime, :dienstleister_user_id) ON DUPLICATE KEY UPDATE ";
			
			$ressources_verify = $request->getParsedBody()['ressources_verify'] ? 1 : 0;
			$dienstleister_verify = $request->getParsedBody()['dienstleister_verify'] ? 1 : 0;
			
			if (isset($request->getParsedBody()['ressources_verify'])){
				
				$sql .= "ressources_verify=$ressources_verify";
				
			}
			
			if (isset($request->getParsedBody()['dienstleister_verify'])){
				
				if (isset($request->getParsedBody()['ressources_verify'])) $sql .= ", ";
				$sql .= "dienstleister_verify=$dienstleister_verify";
				
			}
			
			$sth = $db->prepare($sql);
			
			$empfehlung = $request->getParsedBody()['empfehlung'] ? 1 : 0;
			$ressources_datetime = $request->getParsedBody()['ressources_verify'] ? date('Y-m-d H:i:s') : NULL;
			$dienstleister_datetime = $request->getParsedBody()['dienstleister_verify'] ? date('Y-m-d H:i:s') : NULL;
			
			$dienstleister_user_id = ($request->getParsedBody()['creator_type'] == "dienstleister_user") ? $request->getParsedBody()['creator_id'] : null;
			
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_verify', $ressources_verify, PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_verify', $dienstleister_verify, PDO::PARAM_INT);
            $sth->bindParam(':empfehlung', $empfehlung, PDO::PARAM_INT);
            $sth->bindParam(':ressources_datetime', $ressources_datetime, PDO::PARAM_STR);
            $sth->bindParam(':dienstleister_datetime', $dienstleister_datetime, PDO::PARAM_STR);
            $sth->bindParam(':dienstleister_user_id', $dienstleister_user_id, PDO::PARAM_INT);
            $sth->execute();
			
			$tabHash = ($request->getParsedBody()['dienstleister_verify'] == 1 && $request->getParsedBody()['ressources_verify'] == 1) ? '#erledigt' : '#offen';
			
			if ($request->getParsedBody()['ressources_verify'] == '1'){
				
				$receiver_type = ($dienstleister_user_id) ? "dienstleister_user" : "dienstleister";
				$receiver_id = ($dienstleister_user_id) ? $dienstleister_user_id : $request->getParsedBody()['dienstleister_id'];
							
				$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
				$sth->bindParam(':id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressource = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				fireNotification (array(
					'receiver_type'	=> $receiver_type, 
					'receiver_id' 	=> $receiver_id, 
					'titel' 		=> 'Vorstellungsgespräch bestätigt',
					'subtitle'		=> "{$ressource['vorname']} {$ressource['nachname']} hat das Vorstellungsgespräch bestätigt!",
					'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat das Vorstellungsgespräch bestätigt!",
					'kategorie' 	=> 'castings', 
					'link_web' 		=> "/app/castings/$tabHash", 
					'link_mobile' 	=> "/dienstleister/castings", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));	
			}
			
			if ($request->getParsedBody()['dienstleister_verify'] == '1'){
				
				$sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
				$sth->bindParam(':id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
				$sth->execute();
				$dienstleister = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				fireNotification (array(
					'receiver_type'	=> 'ressource', 
					'receiver_id' 	=> $request->getParsedBody()['ressources_id'], 
					'titel' 		=> 'Vorstellungsgespräch bestätigt',
					'subtitle'		=> $dienstleister['firmenwortlaut'] . ' hat das Vorstellungsgespräch bestätigt!',
					'nachricht' 	=> "<strong>{$dienstleister['firmenwortlaut']}</strong> hat das Vorstellungsgespräch bestätigt!",
					'kategorie' 	=> 'castings', 
					'link_web' 		=> "/app/castings/$tabHash", 
					'link_mobile' 	=> "/ressource/castings", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));	
			}
            
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/castings', function($request, $response, $args) {
        try{
    
            $db = getDB();
			
			$ressources_datetime = $request->getParsedBody()['ressources_verify'] ? date('Y-m-d H:i:s') : NULL;
			$dienstleister_datetime = $request->getParsedBody()['dienstleister_verify'] ? date('Y-m-d H:i:s') : NULL;
			
			$sth = $db->prepare("
				UPDATE 
					`castings` 
				SET 
					`ressources_verify`=:ressources_verify, 
					`dienstleister_verify`=:dienstleister_verify,
					`ressources_datetime`=:ressources_datetime
				WHERE
					`ressources_id`=:ressources_id AND 
					`dienstleister_id`=:dienstleister_id 
			");

            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_verify', $request->getParsedBody()['ressources_verify'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_verify', $request->getParsedBody()['dienstleister_verify'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_datetime', $ressources_datetime, PDO::PARAM_STR);
            $sth->execute();
			
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
			$sth->bindParam(':id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
			$sth->execute();
			$ressource = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$sth = $db->prepare("SELECT * FROM castings WHERE `ressources_id`=:ressources_id AND  `dienstleister_id`=:dienstleister_id");
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
			$sth->execute();
			$c = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$tabHash = ($request->getParsedBody()['dienstleister_verify'] == 1 && $request->getParsedBody()['ressources_verify'] == 1) ? '#erledigt' : '#offen';
			
			if ($request->getParsedBody()['creator_type'] == "ressource"){
			
				$creator_type = ($c['dienstleister_user_id'] == null) ? "dienstleister" : "dienstleister_user";
				$creator_id = ($creator_type == "dienstleister") ? $c['dienstleister_id'] : $c['dienstleister_user_id'];

				fireNotification(array(
					'receiver_type'	=> $creator_type, 
					'receiver_id' 	=> $creator_id, 
					'titel' 		=> 'Vorstellungsgespräch bestätigt',
					'subtitle'		=> "{$ressource['vorname']} {$ressource['nachname']} hat das Vorstellungsgespräch bestätigt!",
					'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat das Vorstellungsgespräch bestätigt!",
					'kategorie' 	=> 'castings', 
					'link_web' 		=> "/app/castings/$tabHash", 
					'link_mobile' 	=> "/dienstleister/castings", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));
				
			}else{
				
				$sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
				$sth->bindParam(':id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
				$sth->execute();
				$dienstleister = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
				
				fireNotification (array(
					'receiver_type'	=> 'ressource', 
					'receiver_id' 	=> $request->getParsedBody()['ressources_id'], 
					'titel' 		=> 'Vorstellungsgespräch bestätigt',
					'subtitle'		=> $dienstleister['firmenwortlaut'] . ' hat das Vorstellungsgespräch bestätigt!',
					'nachricht' 	=> "<strong>{$dienstleister['firmenwortlaut']}</strong> hat das Vorstellungsgespräch bestätigt!",
					'kategorie' 	=> 'castings', 
					'link_web' 		=> "/app/castings/$tabHash", 
					'link_mobile' 	=> "/ressource/castings", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));	
			}
            
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

?>