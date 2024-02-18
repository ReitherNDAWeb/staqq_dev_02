<?php
    
    $app->get('/berufsgruppen', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT berufsgruppen.id AS id, berufsgruppen.name AS name, berufsgruppen.berufsfelder_id, berufsfelder.name AS berufsfelder_name, berufsgruppen.verrechnungs_kategorien_id FROM berufsgruppen LEFT JOIN berufsfelder ON berufsgruppen.berufsfelder_id = berufsfelder.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/berufsgruppen/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM berufsgruppen WHERE id=:id");
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