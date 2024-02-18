<?php

    $app->post('/signin/{email}/{passwort}', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
            
            include("../../wp-load.php");
            
            $res = wp_signon(array('user_login' => $args['email'], 'user_password' => $args['passwort'], 'remember' => false));
            
            if (gettype($res->data) == "object"){
                $ret = true;
                $meta = get_user_meta($res->data->ID, 'staqq_id')[0];
                $user_type = 'ressource';
				
				if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){
					
					$platform = $request->getParsedBody()['platform'];
					$token = $request->getParsedBody()['token'];
					
					try{
						$db = getDB();
						$re = $db->prepare("UPDATE ressources SET push_token_$platform = :token WHERE id=:id");
						$re->bindParam(':token', $token, PDO::PARAM_STR);
						$re->bindParam(':id', $meta, PDO::PARAM_INT);
						$re->execute();
					} catch(PDOException $e){
						$response->withStatus(401);
						$body = json_encode($e);
					}
				}
				
            }else{
                $ret = false;
            }
            $id = $meta;
            
            $body = json_encode(['status' => $ret, 'id' => $id, 'user_type' => $user_type]);
        }
           
        $response->write($body);
        return $response;
        
    });

    $app->post('/signin', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
            
            include("../../wp-load.php");
            
            $res = wp_signon(array('user_login' => $request->getParsedBody()['email'], 'user_password' => $request->getParsedBody()['passwort'], 'remember' => false));
            
            if (gettype($res->data) == "object"){
                $ret = true;
                $meta = get_user_meta($res->data->ID, 'staqq_id')[0];
				$wpUser = get_user_by('email', $request->getParsedBody()['email']);
				
				if (in_array("ressource", $wpUser->roles)) {
					
					$wpUserRole = "ressource";
				
					if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){

						$platform = $request->getParsedBody()['platform'];
						$token = $request->getParsedBody()['token'];

						try{
							$db = getDB();
							$re = $db->prepare("UPDATE ressources SET push_token_$platform = :token WHERE id=:id");
							$re->bindParam(':token', $token, PDO::PARAM_STR);
							$re->bindParam(':id', $meta, PDO::PARAM_INT);
							$re->execute();
						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					}
					
					$publisher_type = "ressource";
					$publisher_id = $meta;
					$berechtigungen = false;
					
				} else if (in_array("kunde", $wpUser->roles)) {
					$wpUserRole = "kunde";
				
					if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){

						$platform = $request->getParsedBody()['platform'];
						$token = $request->getParsedBody()['token'];

						try{
							$db = getDB();
							$re = $db->prepare("UPDATE kunden SET push_token_$platform = :token WHERE id=:id");
							$re->bindParam(':token', $token, PDO::PARAM_STR);
							$re->bindParam(':id', $meta, PDO::PARAM_INT);
							$re->execute();
						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					}
					
					$publisher_type = "kunde";
					$publisher_id = $meta;
					$berechtigungen = false;
				} else if (in_array("dienstleister", $wpUser->roles)) {
					$wpUserRole = "dienstleister";
				
					if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){

						$platform = $request->getParsedBody()['platform'];
						$token = $request->getParsedBody()['token'];

						try{
							$db = getDB();
							$re = $db->prepare("UPDATE dienstleister SET push_token_$platform = :token WHERE id=:id");
							$re->bindParam(':token', $token, PDO::PARAM_STR);
							$re->bindParam(':id', $meta, PDO::PARAM_INT);
							$re->execute();
						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					}
					
					$publisher_type = "dienstleister";
					$publisher_id = $meta;
					$berechtigungen = false;
				} else if (in_array("kunde_u", $wpUser->roles)) {
					$wpUserRole = "kunde_user";
				
					if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){

						$platform = $request->getParsedBody()['platform'];
						$token = $request->getParsedBody()['token'];

						try{
							$db = getDB();
							$re = $db->prepare("UPDATE kunden_user SET push_token_$platform = :token WHERE id=:id");
							$re->bindParam(':token', $token, PDO::PARAM_STR);
							$re->bindParam(':id', $meta, PDO::PARAM_INT);
							$re->execute();
						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					}
					
					$publisher_type = "kunde";
					
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
						$sth->bindParam(':id', $meta, PDO::PARAM_INT);
						$sth->execute();
						
						
						$result = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
						$publisher_id = $result['kunden_id'];
						
					
						$berechtigungen = new stdClass();
						$berechtigungen->berechtigung_joborders_schalten = filter_var($result['berechtigung_joborders_schalten'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->berechtigung_einkauf = filter_var($result['berechtigung_einkauf'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->berechtigung_auswertung = filter_var($result['berechtigung_auswertung'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->einschraenkung_aktiv_von_bis = filter_var($result['einschraenkung_aktiv_von_bis'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->aktiv_von = $result['aktiv_von'];
						$berechtigungen->aktiv_bis = $result['aktiv_bis'];

					} catch(PDOException $e){
						$response->withStatus(400);
					}
				} else if (in_array("dienstleister_u", $wpUser->roles)) {
					$wpUserRole = "dienstleister_user";
				
					if(isset($request->getParsedBody()['token']) && isset($request->getParsedBody()['platform'])){

						$platform = $request->getParsedBody()['platform'];
						$token = $request->getParsedBody()['token'];

						try{
							$db = getDB();
							$re = $db->prepare("UPDATE dienstleister_user SET push_token_$platform = :token WHERE id=:id");
							$re->bindParam(':token', $token, PDO::PARAM_STR);
							$re->bindParam(':id', $meta, PDO::PARAM_INT);
							$re->execute();
						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					}
					
					$publisher_type = "dienstleister";
					
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
						$sth->bindParam(':id', $meta, PDO::PARAM_INT);
						$sth->execute();
						
						
						$result = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
						$publisher_id = $result['dienstleister_id'];
						
					
						$berechtigungen = new stdClass();
						$berechtigungen->berechtigung_joborders_schalten = filter_var($result['berechtigung_joborders_schalten'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->berechtigung_einkauf = filter_var($result['berechtigung_einkauf'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->berechtigung_auswertung = filter_var($result['berechtigung_auswertung'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->einschraenkung_aktiv_von_bis = filter_var($result['einschraenkung_aktiv_von_bis'], FILTER_VALIDATE_BOOLEAN);
						$berechtigungen->aktiv_von = $result['aktiv_von'];
						$berechtigungen->aktiv_bis = $result['aktiv_bis'];

					} catch(PDOException $e){
						$response->withStatus(400);
					}
				}
				
            }else{
                $ret = false;
            }
            $id = $meta;
			
			try{
				$db = getDB();
				$sth = $db->prepare("SELECT * FROM `notifications` WHERE (`receiver_type`=:receiver_type AND `receiver_id`=:receiver_id AND `gelesen`= 0) ORDER BY `timestamp` DESC");
				$sth->bindParam(':receiver_type', $wpUserRole, PDO::PARAM_STR);
				$sth->bindParam(':receiver_id', $id, PDO::PARAM_INT);
				$sth->execute();
				$notifications_ungelesen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
				$notifications_ungelesen_bool = (count($notifications_ungelesen) > 0); 
			} catch(PDOException $e){
				$response->withStatus(401);
				$body = json_encode($e);
			}
			
            $body = json_encode(['status' => $ret, 'id' => $id, 'user_type' => $wpUserRole, 'publisher_type' => $publisher_type, 'publisher_id' => $publisher_id, 'berechtigungen' => $berechtigungen, 'new_notification' => $notifications_ungelesen_bool]);
        }
           
        $response->write($body);
        return $response;
        
    });

	$app->post('/signout', function($request, $response, $args) {
		
		
		$id = $request->getParsedBody()['user_id'];
		$platform = $request->getParsedBody()['platform'];
        
		if ($request->getParsedBody()['user_type'] == "ressource"){
			$table = "ressources";
		}elseif ($request->getParsedBody()['user_type'] == "dienstleister"){
			$table = "dienstleister";
		}elseif ($request->getParsedBody()['user_type'] == "dienstleister_user"){
			$table = "dienstleister_user";
		}elseif ($request->getParsedBody()['user_type'] == "kunde"){
			$table = "kunden";
		}elseif ($request->getParsedBody()['user_type'] == "kunde_user"){
			$table = "kunden_user";
		}
		
        try{
            $db = getDB();
			$sth = $db->prepare("UPDATE $table SET push_token_$platform = NULL WHERE id=:id");
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => $e]);
        }
		
        $response->write($body);
        return $response;
		
    });

?>