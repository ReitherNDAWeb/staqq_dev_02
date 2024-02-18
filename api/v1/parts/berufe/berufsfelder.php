<?php
    
    $app->get('/berufsfelder', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM berufsfelder");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->get('/berufsfelder/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM berufsfelder WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        $response->write($body);
        return $response;
    });

?>