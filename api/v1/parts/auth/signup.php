<?php

    $app->post('/signup', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
			
			try{
				
				$db = getDB();
				$re = $db->prepare("SELECt email FROM ressources WHERE email=:email");
				$re->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
				$re->execute();
				
				$dl = $db->prepare("SELECt email FROM dienstleister WHERE email=:email");
				$dl->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
				$dl->execute();
				
				$kd = $db->prepare("SELECt email FROM kunden WHERE email=:email");
				$kd->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
				$kd->execute();
				
				$dlu = $db->prepare("SELECt email FROM dienstleister_user WHERE email=:email");
				$dlu->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
				$dlu->execute();
				
				$kdu = $db->prepare("SELECt email FROM kunden_user WHERE email=:email");
				$kdu->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
				$kdu->execute();
				
				if (($re->rowCount() > 0) || ($dl->rowCount() > 0) || ($kd->rowCount() > 0) || ($dlu->rowCount() > 0) || ($kdu->rowCount() > 0)){
					$body = json_encode(['status' => false, 'msg' => "Die E-Mail-Adresse wird bereits verwendet!"]);
				}else{
					$code = rand (1000, 9999);

					$sms = sendSMS($request->getParsedBody()['telefon'], strval($code));

					if ($sms->recipients->items[0]->status == "sent"){

						try{
							$db = getDB();
							$sth = $db->prepare("INSERT INTO registrations (user_type, telephone, email, firstname, lastname, activation_code) VALUES (:user_type, :telefon, :email, :vorname, :nachname, :code) ON DUPLICATE KEY UPDATE user_type=:user_type, telephone=:telefon, email=:email, firstname=:vorname, lastname=:nachname, activation_code=:code");
							$sth->bindParam(':user_type', $request->getParsedBody()['user_type'], PDO::PARAM_STR);
							$sth->bindParam(':telefon', $request->getParsedBody()['telefon'], PDO::PARAM_STR);
							$sth->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
							$sth->bindParam(':vorname', $request->getParsedBody()['vorname'], PDO::PARAM_STR);
							$sth->bindParam(':nachname', $request->getParsedBody()['nachname'], PDO::PARAM_STR);
							$sth->bindParam(':code', $code, PDO::PARAM_INT);

							$sth->execute();
							$body = json_encode(['status' => true, 'id' => $db->lastInsertId()]);

						} catch(PDOException $e){
							$response->withStatus(401);
							$body = json_encode($e);
						}
					} else{
						$body = json_encode(['status' => false, 'msg' => "SMS Konnte nicht gesendet werden!"]);
					}
				}
			} catch(PDOException $e){
				$response->withStatus(401);
				$body = json_encode($e);
			}
			
			
            
        }
           
        $response->write($body);
        return $response;
        
    });

    $app->post('/signup/activation', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{
        
            try{

                $db = getDB();
                $sth = $db->prepare("SELECT * FROM registrations WHERE email=:email AND activation_code=:code");
                $sth->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
                $sth->bindParam(':code', $request->getParsedBody()['code'], PDO::PARAM_INT);

                $sth->execute();

                if ($sth->rowCount() > 0){
                    $body = json_encode(['status' => true]);  
                }else{
                    $response->withStatus(404);
                    $body = json_encode(['status' => false, 'msg' => "Der Code konnte nicht verifiziert werden!"]);
                }

            } catch(PDOException $e){
                $response->withStatus(401);
                $body = json_encode(['status' => false, 'msg' => "Der Code konnte nicht verifiziert werden!"]);
            }
        }
        
        $response->write($body);
        return $response;
            
    });

?>