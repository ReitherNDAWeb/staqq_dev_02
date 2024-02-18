<?php
    
    $app->get('/skills/kategorien', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM skills_kategorien");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/skills/kategorien/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM skills_kategorien WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        $response->write($body);
        return $response;
    });

?>