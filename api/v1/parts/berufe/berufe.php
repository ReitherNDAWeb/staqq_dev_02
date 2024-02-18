<?php
    
    $app->get('/berufe', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM berufsfelder");
            $sth->execute();
            $berufe = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            for ($i=0;$i<count($berufe);$i++){
                $sth = $db->prepare("SELECT * FROM berufsgruppen WHERE berufsfelder_id = ".$berufe[$i]['id']);
                $sth->execute();
                $berufe[$i]['berufsgruppen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
                
                for ($j=0;$j<count($berufe[$i]['berufsfelder']);$j++){
                    $sth = $db->prepare("SELECT * FROM berufsbezeichnungen WHERE berufsgruppen_id = ".$berufe[$i]['berufsfelder'][$j]['id']);
                    $sth->execute();
                    $berufe[$i]['berufsgruppen'][$j]['berufsbzeichnungen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
                }
            }
             
            $body = json_encode($berufe);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

?>