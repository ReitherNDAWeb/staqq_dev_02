<?php
    
    $app->get('/berufsbezeichnungen', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT berufsbezeichnungen.id AS id, berufsbezeichnungen.name AS name, berufsbezeichnungen.berufsgruppen_id, berufsgruppen.name AS berufsgruppen_name, berufsbezeichnungen.verrechnungs_kategorien_id, berufsgruppen.berufsfelder_id FROM berufsbezeichnungen LEFT JOIN berufsgruppen ON berufsbezeichnungen.berufsgruppen_id = berufsgruppen.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/berufsbezeichnungen/{id}', function($request, $response, $args) {
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