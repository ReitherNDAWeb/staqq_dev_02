<?php
    
    $app->get('/templates', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM templates WHERE creator_type=:creator_type AND creator_id=:creator_id");
            $sth->bindParam(':creator_type', $request->getQueryParams()['creator_type'], PDO::PARAM_INT);
            $sth->bindParam(':creator_id', $request->getQueryParams()['creator_id'], PDO::PARAM_INT);
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/templates/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    templates.*, 
                    DATE_FORMAT(templates.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(templates.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(templates.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(templates.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    beschaeftigungsausmasse.name as beschaeftigungsausmasse_name, 
                    beschaeftigungsarten.name AS beschaeftigungsarten_name, 
                    bezirke.name AS bezirke_name,
					bezirke.bundeslaender_id AS bundeslaender_id 
                FROM templates 
                LEFT JOIN beschaeftigungsausmasse 
                    ON templates.beschaeftigungsausmasse_id = beschaeftigungsausmasse.id 
                LEFT JOIN beschaeftigungsarten 
                    ON templates.beschaeftigungsarten_id = beschaeftigungsarten.id 
                LEFT JOIN bezirke 
                    ON bezirke.id = templates.bezirke_id 
                LEFT JOIN dienstleister 
                    ON dienstleister.id = templates.dienstleister_id 
                WHERE templates.id=:id
            ");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
            
            $sth = $db->prepare("SELECT berufsfelder.* FROM relation_templates_berufsfelder LEFT JOIN 
            berufsfelder ON berufsfelder.id = relation_templates_berufsfelder.berufsfelder_id WHERE relation_templates_berufsfelder.templates_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template['berufsfelder'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT berufsgruppen.* FROM relation_templates_berufsgruppen LEFT JOIN 
            berufsgruppen ON berufsgruppen.id = relation_templates_berufsgruppen.berufsgruppen_id WHERE relation_templates_berufsgruppen.templates_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template['berufsgruppen'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT berufsbezeichnungen.* FROM relation_templates_berufsbezeichnungen LEFT JOIN 
            berufsbezeichnungen ON berufsbezeichnungen.id = relation_templates_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_templates_berufsbezeichnungen.templates_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template['berufsbezeichnungen'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT skills_items.*, relation_templates_skills.praedikat FROM relation_templates_skills LEFT JOIN 
            skills_items ON relation_templates_skills.skills_items_id = skills_items.id WHERE relation_templates_skills.templates_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template['skills'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT dienstleister.* FROM relation_templates_dienstleister_auswahl LEFT JOIN dienstleister ON relation_templates_dienstleister_auswahl.dienstleister_id = dienstleister.id WHERE relation_templates_dienstleister_auswahl.templates_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $template['dienstleister_auswahl'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $body = json_encode(utf8_converter($template));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->post('/templates', function($request, $response, $args) {
        try{
            
            $db = getDB();
            $sth = $db->prepare("INSERT INTO `templates` (`name`, `jobtitel`, `arbeitszeitmodell`, `arbeitsbeginn`, `arbeitsende`, `bezirke_id`, `beschaeftigungsarten_id`, `beschaeftigungsausmasse_id`, `adresse_strasse_hn`, `adresse_plz`, `adresse_ort`, `kollektivvertrag`, `brutto_bezug`, `brutto_bezug_einheit`, `taetigkeitsbeschreibung`, `skill_fuehrerschein`, `skill_pkw`, `skill_berufsabschluss`, `bewerbungen_von`, `bewerbungen_bis`, `anzahl_ressourcen`, `casting`, `vorlage`, `kunde_anzeigen`, `kunde_name`, `dienstleister_vorgegeben`, `dienstleister_single`, `dienstleister_id`, `creator_type`, `creator_id`) VALUES (:name, :jobtitel, :arbeitszeitmodell, :arbeitsbeginn, :arbeitsende, :bezirke_id, :beschaeftigungsarten_id, :beschaeftigungsausmasse_id, :adresse_strasse_hn, :adresse_plz, :adresse_ort, :kollektivvertrag, :brutto_bezug, :brutto_bezug_einheit, :taetigkeitsbeschreibung, :skill_fuehrerschein, :skill_pkw, :skill_berufsabschluss, :bewerbungen_von, :bewerbungen_bis, :anzahl_ressourcen, :casting, :vorlage, :kunde_anzeigen, :kunde_name, :dienstleister_vorgegeben, :dienstleister_single, :dienstleister_id, :creator_type, :creator_id)");
			
            $sth->bindParam(':name', $request->getParsedBody()['name'], PDO::PARAM_STR);
            
            $sth->bindParam(':jobtitel', $request->getParsedBody()['jobtitel'], PDO::PARAM_STR);
            $sth->bindParam(':arbeitszeitmodell', $request->getParsedBody()['arbeitszeitmodell'], PDO::PARAM_STR);
            $sth->bindParam(':arbeitsbeginn', $request->getParsedBody()['arbeitsbeginn'], PDO::PARAM_STR);
            $sth->bindParam(':arbeitsende', $request->getParsedBody()['arbeitsende'], PDO::PARAM_STR);
            $sth->bindParam(':beschaeftigungsarten_id', $request->getParsedBody()['beschaeftigungsarten_id'], PDO::PARAM_INT);
            $sth->bindParam(':beschaeftigungsausmasse_id', $request->getParsedBody()['beschaeftigungsausmasse_id'], PDO::PARAM_INT);
            $sth->bindParam(':bezirke_id', $request->getParsedBody()['bezirke_id'], PDO::PARAM_INT);
            $sth->bindParam(':adresse_strasse_hn', $request->getParsedBody()['adresse_strasse_hn'], PDO::PARAM_STR);
            $sth->bindParam(':adresse_plz', $request->getParsedBody()['adresse_plz'], PDO::PARAM_STR);
            $sth->bindParam(':adresse_ort', $request->getParsedBody()['adresse_ort'], PDO::PARAM_STR);
            $sth->bindParam(':kollektivvertrag', $request->getParsedBody()['kollektivvertrag'], PDO::PARAM_STR);
            $sth->bindParam(':brutto_bezug', $request->getParsedBody()['brutto_bezug'], PDO::PARAM_STR);
            $sth->bindParam(':brutto_bezug_einheit', $request->getParsedBody()['brutto_bezug_einheit'], PDO::PARAM_STR);
            $sth->bindParam(':taetigkeitsbeschreibung', $request->getParsedBody()['taetigkeitsbeschreibung'], PDO::PARAM_STR);
            $sth->bindParam(':skill_fuehrerschein', $request->getParsedBody()['skill_fuehrerschein'], PDO::PARAM_INT);
            $sth->bindParam(':skill_pkw', $request->getParsedBody()['skill_pkw'], PDO::PARAM_INT);
            $sth->bindParam(':skill_berufsabschluss', $request->getParsedBody()['skill_berufsabschluss'], PDO::PARAM_INT);
            $sth->bindParam(':bewerbungen_von', $request->getParsedBody()['bewerbungen_von'], PDO::PARAM_STR);
            $sth->bindParam(':bewerbungen_bis', $request->getParsedBody()['bewerbungen_bis'], PDO::PARAM_STR);
            $sth->bindParam(':anzahl_ressourcen', $request->getParsedBody()['anzahl_ressourcen'], PDO::PARAM_INT);
            $sth->bindParam(':casting', $request->getParsedBody()['casting'], PDO::PARAM_INT);
            $sth->bindParam(':vorlage', $request->getParsedBody()['vorlage'], PDO::PARAM_INT);
            $sth->bindParam(':kunde_anzeigen', $request->getParsedBody()['kunde_anzeigen'], PDO::PARAM_INT);
            $sth->bindParam(':kunde_name', $request->getParsedBody()['kunde_name'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_vorgegeben', $request->getParsedBody()['dienstleister_vorgegeben'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_single', $request->getParsedBody()['dienstleister_single'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            $sth->bindParam(':creator_type', $request->getParsedBody()['creator_type'], PDO::PARAM_INT);
            $sth->bindParam(':creator_id', $request->getParsedBody()['creator_id'], PDO::PARAM_INT);
            $sth->execute();
            
            $templates_id = $db->lastInsertId();

            $sth = $db->prepare("DELETE FROM relation_templates_berufsfelder WHERE templates_id=:templates_id");
            $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
            $sth->execute();

            foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                $sth = $db->prepare("INSERT INTO relation_templates_berufsfelder (templates_id, berufsfelder_id) VALUES (:templates_id, :berufsfelder_id)");
                $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
                $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                $sth->execute();
            }

            $sth = $db->prepare("DELETE FROM relation_templates_berufsgruppen WHERE templates_id=:templates_id");
            $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
            $sth->execute();

            foreach (json_decode($request->getParsedBody()['berufsgruppen']) as $b){
                $sth = $db->prepare("INSERT INTO relation_templates_berufsgruppen (templates_id, berufsgruppen_id) VALUES (:templates_id, :berufsgruppen_id)");
                $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
                $sth->bindParam(':berufsgruppen_id', $b, PDO::PARAM_INT);
                $sth->execute();
            }

            $sth = $db->prepare("DELETE FROM relation_templates_berufsbezeichnungen WHERE templates_id=:templates_id");
            $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
            $sth->execute();

            foreach (json_decode($request->getParsedBody()['berufsbezeichnungen']) as $b){
                $sth = $db->prepare("INSERT INTO relation_templates_berufsbezeichnungen (templates_id, berufsbezeichnungen_id) VALUES (:templates_id, :berufsbezeichnungen_id)");
                $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
                $sth->bindParam(':berufsbezeichnungen_id', $b, PDO::PARAM_INT);
                $sth->execute();
            }

            $sth = $db->prepare("DELETE FROM relation_templates_dienstleister_auswahl WHERE templates_id=:templates_id");
            $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
            $sth->execute();

            foreach (json_decode($request->getParsedBody()['dienstleister_auswahl']) as $d){
                $sth = $db->prepare("INSERT INTO relation_templates_dienstleister_auswahl (templates_id, dienstleister_id) VALUES (:templates_id, :dienstleister_id)");
                $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
                $sth->bindParam(':dienstleister_id', $d, PDO::PARAM_INT);
                $sth->execute();
            }

            $sth = $db->prepare("DELETE FROM relation_templates_skills WHERE templates_id=:templates_id");
            $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
            $sth->execute();

            foreach (json_decode($request->getParsedBody()['skills']) as $b){
                $sth = $db->prepare("INSERT INTO relation_templates_skills (templates_id, skills_items_id, praedikat) VALUES (:templates_id, :skills_items_id, :praedikat)");
                $sth->bindParam(':templates_id', $templates_id, PDO::PARAM_INT);
                $sth->bindParam(':skills_items_id', $b->id, PDO::PARAM_INT);
                $sth->bindParam(':praedikat', $b->praedikat, PDO::PARAM_STR);
                $sth->execute();
            }
            
            // berufsbezeichnungen und skills
            
            $body = json_encode(['status' => true, 'id' => $templates_id]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });
?>