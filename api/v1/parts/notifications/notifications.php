<?php


	$app->get('/notifications', function($request, $response, $args) {
        
		try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM `notifications`");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


	$app->get('/notifications/{id}', function($request, $response, $args) {
        
		try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM `notifications` WHERE `id`=:id");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


	$app->post('/notifications', function($request, $response, $args) {
        
        try{
    
            $db = getDB();
			
			$sth = $db->prepare("INSERT INTO `notifications` (`kategorie`, `link_web`, `link_mobile`, `titel`, `nachricht`, `receiver_type`, `receiver_id`, `gelesen_timestamp`, `timestamp`) VALUES (:kategorie, :link_web, :link_mobile, :titel, :nachricht, :receiver_type, :receiver_id, null, null)");
				
			$sth->bindParam(':kategorie', $request->getParsedBody()['kategorie'], PDO::PARAM_INT);
			$sth->bindParam(':link_web', $request->getParsedBody()['link_web'], PDO::PARAM_STR);
			$sth->bindParam(':link_mobile', $request->getParsedBody()['link_mobile'], PDO::PARAM_STR);
			$sth->bindParam(':titel', $request->getParsedBody()['titel'], PDO::PARAM_STR);
			$sth->bindParam(':nachricht', $request->getParsedBody()['nachricht'], PDO::PARAM_STR);
			$sth->bindParam(':receiver_type', $request->getParsedBody()['receiver_type'], PDO::PARAM_STR);
            $sth->bindParam(':receiver_id', $request->getParsedBody()['receiver_id'], PDO::PARAM_INT);
            $sth->execute();
            
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


	// Checking

	$app->get('/checkNotifications/{receiver_type}/{receiver_id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM `notifications` WHERE (`receiver_type`=:receiver_type AND `receiver_id`=:receiver_id AND `gelesen`= 0) ORDER BY `timestamp` DESC");
			$sth->bindParam(':receiver_type', $args['receiver_type'], PDO::PARAM_STR);
            $sth->bindParam(':receiver_id', $args['receiver_id'], PDO::PARAM_INT);
            $sth->execute();
			
			$ungelesen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			$sth = $db->prepare("SELECT * FROM `notifications` WHERE (`receiver_type`=:receiver_type AND `receiver_id`=:receiver_id AND `gelesen`= 1) ORDER BY `timestamp` DESC LIMIT 10");
			$sth->bindParam(':receiver_type', $args['receiver_type'], PDO::PARAM_STR);
            $sth->bindParam(':receiver_id', $args['receiver_id'], PDO::PARAM_INT);
            $sth->execute();
			
            $body = json_encode(['ungelesen' => $ungelesen, 'gelesen' => utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


	// Mark as read
	
	$app->put('/readNotifications/{receiver_type}/{receiver_id}', function($request, $response, $args) {
        
		try{
			
			$jetzt = date('Y-m-d H:i:s');
			
            $db = getDB();
            $sth = $db->prepare("UPDATE `notifications` SET `gelesen` = 1, `gelesen_timestamp` = :gelesen_timestamp WHERE (`receiver_type`=:receiver_type AND `receiver_id`=:receiver_id)");
            $sth->bindParam(':receiver_type', $args['receiver_type'], PDO::PARAM_STR);
            $sth->bindParam(':receiver_id', $args['receiver_id'], PDO::PARAM_INT);
            $sth->bindParam(':gelesen_timestamp', $jetzt, PDO::PARAM_STR);
            $sth->execute();
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


?>