<?php
    
    $app->get('/beschaeftigungsarten', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM beschaeftigungsarten");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

?>