<?php
    
    $app->get('/bezirke', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT bezirke.id AS id, bezirke.name AS name, bundeslaender.id AS bundeslaender_id, bundeslaender.name AS bundeslaender_name FROM bezirke LEFT JOIN bundeslaender ON bezirke.bundeslaender_id = bundeslaender.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/bezirke/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT bezirke.id AS id, bezirke.name AS name, bundeslaender.id AS bundeslaender_id, bundeslaender.name AS bundeslaender_name FROM bezirke LEFT JOIN bundeslaender ON bezirke.bundeslaender_id = bundeslaender.id WHERE bezirke.id=:id");
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