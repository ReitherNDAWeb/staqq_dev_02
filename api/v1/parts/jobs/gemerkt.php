<?php
    $app->post('/joborders/{id}/merken', function($request, $response, $args) {
        try{
    
            $db = getDB();
            $sth = $db->prepare("INSERT INTO `joborders_gemerkt` (`ressources_id`, `joborders_id`) VALUES (:ressources_id, :joborders_id)");
            $sth->bindParam(':ressources_id', $request->getParsedBody()['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $args['id'], PDO::PARAM_INT);
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