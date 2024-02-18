<?php
    
    $app->get('/skills/items', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT skills_items.id AS id, skills_items.name AS name, skills_kategorien.id AS skills_kategorien_id, skills_kategorien.name AS skills_kategorien_name FROM skills_items LEFT JOIN skills_kategorien ON skills_items.skills_kategorien_id = skills_kategorien.id");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => "Unbekannter Fehler!"]);
        }
        
        
        $response->write($body);
        return $response;
    });
    
    $app->get('/skills/nested', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM skills_kategorien");
            $sth->execute();
            $k = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            
            for($i=0;$i<count($k);$i++){
                $sth = $db->prepare("SELECT * FROM skills_items WHERE skills_kategorien_id=".$k[$i]['id']);
                $sth->execute();
                $k[$i]['items'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            }
            
            $body = json_encode($k);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/skills/items/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT skills_items.id AS id, skills_items.name AS name, skills_kategorien.id AS skills_kategorien_id, skills_kategorien.name AS skills_kategorien_name FROM skills_items LEFT JOIN skills_kategorien ON skills_items.skills_kategorien_id = skills_kategorien.id WHERE skills_items.id=:id");
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