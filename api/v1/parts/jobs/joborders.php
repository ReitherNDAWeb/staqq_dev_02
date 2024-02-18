<?php
    
    $app->get('/joborders', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM views_joborders");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        
        $response->write($body);
        return $response;
    });

    $app->get('/joborders/{id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    joborders.*, 
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, 
                    dienstleister.website AS dienstleister_website, 
                    beschaeftigungsausmasse.name as beschaeftigungsausmasse_name, 
                    beschaeftigungsarten.name AS beschaeftigungsarten_name, 
                    bezirke.name AS bezirke_name,
					verrechnungs_kategorien.name AS verrechnungs_kategorien_name
                FROM joborders 
                LEFT JOIN beschaeftigungsausmasse 
                    ON joborders.beschaeftigungsausmasse_id = beschaeftigungsausmasse.id 
                LEFT JOIN beschaeftigungsarten 
                    ON joborders.beschaeftigungsarten_id = beschaeftigungsarten.id 
                LEFT JOIN bezirke 
                    ON bezirke.id = joborders.bezirke_id 
                LEFT JOIN dienstleister 
                    ON dienstleister.id = joborders.dienstleister_id 
                LEFT JOIN verrechnungs_kategorien 
                    ON joborders.verrechnungs_kategorien_id = verrechnungs_kategorien.id 
                WHERE joborders.id=:id
            ");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
            
            if ($joborder['publisher_type'] == "kunde"){
                $sth = $db->prepare("SELECT *, CONCAT(kunden.firmenwortlaut, kunden.website, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM kunden LEFT JOIN bewertungen ON kunden.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'kunde' AND bewertungen.status = 1 WHERE id=:id");
                $sth->bindParam(':id', $joborder['publisher_id'], PDO::PARAM_INT);
                $sth->execute();
                $joborder['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
                $joborder['kunde_website'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['website'];
            }
            
            $sth = $db->prepare("SELECT berufsfelder.* FROM relation_joborders_berufsfelder LEFT JOIN 
            berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder['berufsfelder'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT berufsgruppen.* FROM relation_joborders_berufsgruppen LEFT JOIN 
            berufsgruppen ON berufsgruppen.id = relation_joborders_berufsgruppen.berufsgruppen_id WHERE relation_joborders_berufsgruppen.joborders_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder['berufsgruppen'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT skills_items.*, relation_joborders_skills.praedikat FROM relation_joborders_skills LEFT JOIN 
            skills_items ON relation_joborders_skills.skills_items_id = skills_items.id WHERE relation_joborders_skills.joborders_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder['skills'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            $sth = $db->prepare("SELECT dienstleister.*, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM relation_joborders_dienstleister_auswahl LEFT JOIN dienstleister ON relation_joborders_dienstleister_auswahl.dienstleister_id = dienstleister.id LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE relation_joborders_dienstleister_auswahl.joborders_id=:id GROUP BY dienstleister.id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder['dienstleister_auswahl'] = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
			$sth->execute();
			$r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			$joborder['anzahl_bewerbungen_gesamt'] = $r['anz'];

			$sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='vergeben'");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
			$sth->execute();
			$r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			$joborder['anzahl_bewerbungen_vergeben'] = $r['anz'];

			$sth = $db->prepare("SELECT *, COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND status='einsatz_bestaetigt'");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
			$sth->execute();
			$bewerbung_bestaetigt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			$joborder['anzahl_bewerbungen_einsatz_bestaetigt'] = $bewerbung_bestaetigt['anz'];
            
			$joborder['kunde_rating'] = array(
				'bool' => false,
				'durchschnitt' => 0.0,
				'anzahl_bewertungen' => 0,
				'summe_punkte' => 0
			);
			
			if ($joborder['publisher_type'] == "kunde"){
				$joborder['kunde_rating']['bool'] = true;
				
				$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_id = ".$joborder['publisher_id']." AND bewertet_type='kunde' AND status=1");
				$sth->execute();
				$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				$durchschnitt = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;
				$joborder['kunde_rating']['anzahl_bewertungen'] = $gesamt['anzahl'];
				$joborder['kunde_rating']['summe_punkte'] = $gesamt['punkte'];
				$joborder['kunde_rating']['durchschnitt'] = number_format($durchschnitt, 2, ",", "");
				
				if (intval($joborder['anzahl_bewerbungen_einsatz_bestaetigt']) > 0){
					
					$sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut, dienstleister.website, CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM dienstleister LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE id=:id GROUP BY dienstleister.id");
					$sth->bindParam(':id', $bewerbung_bestaetigt['dienstleister_id'], PDO::PARAM_INT);
					$sth->execute();
					$joborder['eingesetzter_dienstleister'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
				}
				
			}
			
			// DL Rating
			if ($joborder['dienstleister_single']){

				$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='dienstleister' AND bewertet_id=:bewertet_id AND status=1");
				$sth->bindParam(':bewertet_id', $joborder['dienstleister_id'], PDO::PARAM_INT);
				$sth->execute();

				$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				$joborder['dienstleister_firmenwortlaut_inkl_bewertung'] = 
				($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

				$rating = number_format($joborder['dienstleister_firmenwortlaut_inkl_bewertung'], 2, ",", "");

				$joborder['dienstleister_firmenwortlaut_inkl_bewertung'] = $joborder['dienstleister_firmenwortlaut'] . " (★ $rating)";
			}
            
            $body = json_encode(utf8_converter($joborder));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->get('/joborders/{joborders_id}/bewerbungsCheck/{ressources_id}', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("SELECT joborders.anzahl_ressourcen, bewerbungen.*, dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut, dienstleister.website AS dienstleister_website FROM bewerbungen LEFT JOIN dienstleister ON bewerbungen.dienstleister_id = dienstleister.id LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE bewerbungen.joborders_id=:joborders_id AND ressources_id=:ressources_id");
            $sth->bindParam(':joborders_id', $args['joborders_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->execute();
            $bewerbung = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
            
            if ($bewerbung){
				
				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen WHERE (status = 'vergeben' OR status = 'einsatz_bestaetigt') AND joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $args['joborders_id'], PDO::PARAM_INT);
				$sth->execute();
				$joborder_alle_ressourcen_vergeben = ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'] == $bewerbung['anzahl_ressourcen']) ? 1 : 0;
				
				$sth = $db->prepare("SELECT CONCAT(dienstleister.firmenwortlaut, ' (★ ', REPLACE(ROUND(IFNULL(AVG(bewertungen.bewertung), 0), 2), '.', ','), ')') AS firmenwortlaut_inkl_bewertung FROM dienstleister LEFT JOIN bewertungen ON dienstleister.id = bewertungen.bewertet_id AND bewertungen.bewertet_type = 'dienstleister' AND bewertungen.status = 1 WHERE id=:id GROUP BY dienstleister.id");
				$sth->bindParam(':id', $bewerbung['dienstleister_id'], PDO::PARAM_INT);
				$sth->execute();
				$dl = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
				
				$bewerbung['dienstleister_firmenwortlaut_inkl_bewertung'] = $dl['firmenwortlaut_inkl_bewertung'];
				
                $body = json_encode(['status' => true, 'bewerbung' => $bewerbung, 'joborder_alle_ressourcen_vergeben' => $joborder_alle_ressourcen_vergeben]);
            }else{
                $body = json_encode(['status' => false]);
            }
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->get('/joborders/{id}/bewerbungen/ressources', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    ressources.*, 
					bewerbungen.id AS bewerbungen_id,
                    bewerbungen.status AS status, 
                    bewerbungen.joborders_id, 
                    bewerbungen.ressources_id,
                    bewerbungen.dienstleister_id,
                    bewerbungen.dienstleister_einsatz_bestaetigt,
                    bewerbungen.ressource_einsatz_bestaetigt,
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut,
                    IF(castings.dienstleister_id IS NOT NULL AND castings.ressources_verify = 1, TRUE, FALSE) AS casting_intern,
                    IF(castings.dienstleister_id IS NOT NULL AND castings.ressources_verify = 0, TRUE, FALSE) AS casting_intern_not_verified 
                FROM 
                    bewerbungen 
                LEFT JOIN 
                    ressources ON ressources.id = bewerbungen.ressources_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = bewerbungen.dienstleister_id 
                LEFT JOIN 
                    castings ON (castings.ressources_id = ressources.id AND castings.dienstleister_id = bewerbungen.dienstleister_id AND castings.dienstleister_verify=1)
                WHERE 
                    bewerbungen.joborders_id=:id
                GROUP BY
                    ressources.id
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $ressources = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
			$ressources_push = array();
			
            for ($i=0;$i<count($ressources);$i++){
                $ressources[$i]['score'] = getSTAQQScore($ressources[$i]['id'], $ressources[$i]['joborders_id']);
                
                // Externes Casting true/false
                
                $sth = $db->prepare("
                    SELECT 
                        IF(COUNT(*) > 0, TRUE, FALSE) AS casting_verify
                    FROM
                        castings
                    WHERE
                        ressources_id=:ressources_id AND dienstleister_id<>:dienstleister_id AND dienstleister_verify=1 AND ressources_verify=1
                ");
                
                $sth->bindParam(':ressources_id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
                $sth->bindParam(':dienstleister_id', $ressources[$i]['dienstleister_id'], PDO::PARAM_INT);
                $sth->execute();
                $ressources[$i]['casting_extern'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['casting_verify'];
				
				$sth = $db->prepare("SELECT berufsfelder.id, berufsfelder.name FROM relation_ressources_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_ressources_berufsfelder.berufsfelder_id WHERE relation_ressources_berufsfelder.ressources_id=:id");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['berufsfelder'] = array();
				foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){array_push($ressources[$i]['berufsfelder'], $b['name']);}

				$sth = $db->prepare("SELECT berufsgruppen.id, berufsgruppen.name FROM relation_ressources_berufsgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_ressources_berufsgruppen.berufsgruppen_id WHERE relation_ressources_berufsgruppen.ressources_id=:id");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['berufsgruppen'] = array();
				foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){array_push($ressources[$i]['berufsgruppen'], $b['name']);}

				$sth = $db->prepare("SELECT berufsbezeichnungen.id, berufsbezeichnungen.name FROM relation_ressources_berufsbezeichnungen LEFT JOIN berufsbezeichnungen ON berufsbezeichnungen.id = relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_ressources_berufsbezeichnungen.ressources_id=:id");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['berufsbezeichnungen'] = array();
				foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){array_push($ressources[$i]['berufsbezeichnungen'], $b['name']);}

				$sth = $db->prepare("SELECT skills_items.id, skills_items.name FROM relation_ressources_skills LEFT JOIN skills_items ON skills_items.id = relation_ressources_skills.skills_items_id WHERE relation_ressources_skills.ressources_id=:id");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['skills'] = array();
				foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){array_push($ressources[$i]['skills'], $b['name']);}
				
				$sth = $db->prepare("SELECT dienstleister.firmenwortlaut, dienstleister.id, castings.empfehlung FROM castings LEFT JOIN dienstleister ON dienstleister.id = castings.dienstleister_id WHERE castings.ressources_id=:id AND ressources_verify=1 AND dienstleister_verify=1");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['castings'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
				
				$sth = $db->prepare("SELECT bezirke.name AS bezirke_name, bundeslaender.name AS bundeslaender_name FROM relation_ressources_bezirke LEFT JOIN bezirke ON bezirke.id = relation_ressources_bezirke.bezirke_id LEFT JOIN bundeslaender ON bundeslaender.id = bezirke.bundeslaender_id WHERE relation_ressources_bezirke.ressources_id=:id");
				$sth->bindParam(':id', $ressources[$i]['ressources_id'], PDO::PARAM_INT);
				$sth->execute();
				$ressources[$i]['einsatzorte'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
				$ressources[$i]['einsatzorte_namen'] = array();
				foreach($ressources[$i]['einsatzorte'] as $e){array_push($ressources[$i]['einsatzorte_namen'], ($e['bezirke_name'] . " (".$e['bundeslaender_name'].")"));}
				
				$sth = $db->prepare("SELECT * FROM joborders WHERE id=:id");
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->execute();
				$joborder = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
						
				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen 
					LEFT JOIN 
						joborders ON joborders.id = bewerbungen.joborders_id 
					WHERE 
						joborders.arbeitsbeginn <= :ae 
						AND joborders.arbeitsende >= :ab 
						AND bewerbungen.ressources_id=:id 
						AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt') 
						AND (bewerbungen.joborders_id NOT IN (:joborders_id))
				");
				
				$sth->bindParam(':id', $ressources[$i]['id'], PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $args['id'], PDO::PARAM_INT);
				$sth->bindParam(':ab', $joborder['arbeitsbeginn'], PDO::PARAM_STR);
				$sth->bindParam(':ae', $joborder['arbeitsende'], PDO::PARAM_STR);
				$sth->execute();
				$testing = $sth->fetchAll(PDO::FETCH_ASSOC);
				$anz = intval($testing[0]['anz']);
				
				$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='ressource' AND bewertet_id=:id AND status=1");
				$sth->bindParam(':id', $ressources[$i]['id'], PDO::PARAM_INT);
				$sth->execute();
				$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];

				$durchschnitt = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;
				$ressources[$i]['bewertung'] = array(
					'anzahl_bewertungen' => $gesamt['anzahl'],
					'summe_punkte' => $gesamt['punkte'],
					'durchschnitt' => number_format($durchschnitt, 2, ",", "")
				);
				
				if ($anz == 0){
					array_push ($ressources_push, $ressources[$i]);
				}
					
            }
            
            $body = json_encode($ressources_push);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->get('/joborders/{id}/kosten', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende 
                FROM 
                    joborders 
                WHERE 
                    id=:id
            ");
			$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborder = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			$tag1 = strtotime($joborder['arbeitsbeginn']);
			$tag2 = strtotime($joborder['arbeitsende']);
			$diff = $tag2 - $tag1;
			
			$tage = floor($diff / (60 * 60 * 24)) + 1;
			if ($tage > 183) $tage = 183;
			
            $sth = $db->prepare("SELECT berufsbezeichnungen.name, berufsbezeichnungen.verrechnungs_kategorien_id, verrechnungs_kategorien.preis, verrechnungs_kategorien.name AS verrechnungs_kategorien_name FROM relation_joborders_berufsbezeichnungen LEFT JOIN 
            berufsbezeichnungen ON berufsbezeichnungen.id = relation_joborders_berufsbezeichnungen.berufsbezeichnungen_id LEFT JOIN verrechnungs_kategorien ON berufsbezeichnungen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE relation_joborders_berufsbezeichnungen.joborders_id=:id ORDER BY verrechnungs_kategorien_id ASC");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $berufsbezeichnungen = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			if (count($berufsbezeichnungen) > 0){
				$kat = $berufsbezeichnungen[0];
			}else{
				$sth = $db->prepare("SELECT berufsgruppen.name, berufsgruppen.verrechnungs_kategorien_id, verrechnungs_kategorien.preis, verrechnungs_kategorien.name AS verrechnungs_kategorien_name FROM relation_joborders_berufsgruppen LEFT JOIN 
				berufsgruppen ON berufsgruppen.id = relation_joborders_berufsgruppen.berufsgruppen_id LEFT JOIN verrechnungs_kategorien ON berufsgruppen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE relation_joborders_berufsgruppen.joborders_id=:id ORDER BY berufsgruppen.verrechnungs_kategorien_id ASC");
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->execute();
				$kat = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			}
			
			$gesamtkosten = $tage * $kat['preis'];
            
            $body = json_encode(['verrechnungs_kategorien_id' => $kat['verrechnungs_kategorien_id'], 'verrechnungs_kategorien_preis' => $kat['preis'], 'verrechnungs_kategorien_name' => $kat['verrechnungs_kategorien_name'], 'tage' => $tage, 'gesamtkosten' => $gesamtkosten]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->get('/kosten', function($request, $response, $args) {
        try{
			
        	$db = getDB();
			
			$tag1 = strtotime($request->getQueryParams()['arbeitsbeginn']);
			$tag2 = strtotime($request->getQueryParams()['arbeitsende']);
			$diff = $tag2 - $tag1;
			
			$tage = floor($diff / (60 * 60 * 24)) + 1;
			if ($tage > 183) $tage = 183;
            $berufsbezeichnungen = json_decode($request->getQueryParams()['berufsbezeichnungen']);
			
			if (count($berufsbezeichnungen) > 0){
				$k = implode(",", $berufsbezeichnungen);
				
				$sth = $db->prepare("SELECT verrechnungs_kategorien.* FROM berufsbezeichnungen LEFT JOIN 
				verrechnungs_kategorien ON berufsbezeichnungen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE berufsbezeichnungen.id IN ($k) ORDER BY berufsbezeichnungen.verrechnungs_kategorien_id DESC");
			}else{
				$k = implode(",", json_decode($request->getQueryParams()['berufsgruppen']));
				$sth = $db->prepare("SELECT verrechnungs_kategorien.* FROM berufsgruppen LEFT JOIN 
				verrechnungs_kategorien ON berufsgruppen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE berufsgruppen.id IN ($k) ORDER BY berufsgruppen.verrechnungs_kategorien_id DESC");
			}
			$sth->execute();
			$kat = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			$gesamtkosten = $tage * $kat['preis'];
            
            $body = json_encode(['verrechnungs_kategorien_id' => $kat['id'], 'verrechnungs_kategorien_preis' => $kat['preis'], 'verrechnungs_kategorien_name' => $kat['name'], 'tage' => $tage, 'gesamtkosten' => $gesamtkosten]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/joborders/{joborders_id}/bewerbungen/ressources/{ressources_id}/vergeben', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                UPDATE
                    bewerbungen
                SET
                    status = 'vergeben'
                WHERE 
                    joborders_id=:joborders_id AND ressources_id=:ressources_id AND dienstleister_id=:dienstleister_id
            ");
            
            $sth->bindParam(':joborders_id', $args['joborders_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            
            $sth->execute();
			
			$sth = $db->prepare("SELECT COUNT(*) as anz FROM bewerbungen WHERE joborders_id=:id AND (status='vergeben' OR status='einsatz_bestaetigt')");
			$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$r = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			$sth = $db->prepare("SELECT anzahl_ressourcen, jobtitel, arbeitsbeginn, arbeitsende FROM joborders WHERE id=:id");
			$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$j = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			// Notify Ressource
			$sth = $db->prepare("SELECT * FROM dienstleister WHERE id=:id");
			$sth->bindParam(':id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
			$sth->execute();
			$dienstleister = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			fireNotification (array(
				'receiver_type'	=> 'ressource', 
				'receiver_id' 	=> $args['ressources_id'], 
				'titel' 		=> 'Job erhalten',
				'subtitle'		=> 'Job ' . $j['jobtitel'] . ' erhalten',
				'nachricht' 	=> "<strong>{$dienstleister['firmenwortlaut']}</strong> hat Sie für den Job <strong>{$j['jobtitel']}</strong> ausgewählt!", 
				'kategorie' 	=> 'joborder', 
				'link_web' 		=> "/app/joborders/#erhalten", 
				'link_mobile' 	=> "/ressource/joborders/{$args['joborders_id']}", 
				'send_web' 		=> true, 
				'send_mobile' 	=> true,
				'force' 		=> true
			));
			
			// wenn alle ressourcen besetzt
			if ($j['anzahl_ressourcen'] <= $r['anz']){
				$sth = $db->prepare("SELECT ressources.*, bewerbungen.status FROM bewerbungen LEFT JOIN ressources ON bewerbungen.ressources_id = ressources.id WHERE status='beworben' AND bewerbungen.joborders_id=:id");
				$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
				$sth->execute();
				
				include("../../wp-load.php");
				
				foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){

					if (intval($b['email_benachrichtigungen']) && ($b['status'] == "beworben")) {

						$ab = date("d.m.Y", strtotime($j['arbeitsbeginn']));
						$ae = date("d.m.Y", strtotime($j['arbeitsende']));

						$html =  "Sehr geehrte(r) {$b['anrede']} {$b['vorname']} {$b['nachname']}!";
						$html .= "<br><br>";
						$html .= nl2br(utf8_decode(get_option('email_absage_anderwaertig_vergeben')));
						$html .= "<br><br>";
						$html .= "Job: {$j['jobtitel']} ($ab - $ae)";
						$html .= "<br><br>";
						$html .= nl2br(utf8_decode(get_option('grusszeile')));

						$betreff = utf8_decode(get_option('email_absage_anderwaertig_vergeben_betreff'));

						$ret = sendMail($b['email'], $betreff, $html, '');
					
					
						// SEND PUSH
					
						fireNotification (array(
							'receiver_type'	=> 'ressource', 
							'receiver_id' 	=> $b['id'], 
							'titel' 		=> $betreff,
							'subtitle'		=> 'Job ' . $j['jobtitel'] . ' wurde leider anderwärtig vergeben!',
							'nachricht' 	=> "Job <strong>{$j['jobtitel']}</strong> wurde leider anderwärtig vergeben!", 
							'kategorie' 	=> 'joborder', 
							'link_web' 		=> "/app/joborders/", 
							'link_mobile' 	=> "/ressource/joborders", 
							'send_web' 		=> true, 
							'send_mobile' 	=> true,
							'force' 		=> true
						));
						
					}

				}
				
			}
			
            $body = json_encode(['status' => $ret]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

	$app->put('/joborders/{joborders_id}/bewerbungen/ressources/{ressources_id}/ablehnen', function($request, $response, $args) {
        try{
        
            $db = getDB();
            $sth = $db->prepare("
                UPDATE
                    bewerbungen
                SET
                    status = 'abgelehnt'
                WHERE 
                    joborders_id=:joborders_id AND ressources_id=:ressources_id AND dienstleister_id=:dienstleister_id
            ");
            
            $sth->bindParam(':joborders_id', $args['joborders_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
            
            $sth->execute();
			
			$sth = $db->prepare("SELECT anzahl_ressourcen, jobtitel, arbeitsbeginn, arbeitsende FROM joborders WHERE id=:id");
			$sth->bindParam(':id', $args['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$j = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			include("../../wp-load.php");
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
			$sth->bindParam(':id', $args['ressources_id'], PDO::PARAM_INT);
			$sth->execute();
			$b = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];

			if (intval($b['email_benachrichtigungen'])) {

				$ab = date("d.m.Y", strtotime($j['arbeitsbeginn']));
				$ae = date("d.m.Y", strtotime($j['arbeitsende']));

				$html =  "Sehr geehrte(r) {$b['anrede']} {$b['vorname']} {$b['nachname']}!";
				$html .= "<br><br>";
				$html .= nl2br(utf8_decode(get_option('email_absage_anderwaertig_vergeben')));
				$html .= "<br><br>";
				$html .= "Job: {$j['jobtitel']} ($ab - $ae)";
				$html .= "<br><br>";
				$html .= nl2br(utf8_decode(get_option('grusszeile')));

				$betreff = utf8_decode(get_option('email_absage_anderwaertig_vergeben_betreff'));

				$ret = sendMail($b['email'], $betreff, $html, '');
					
					
				// SEND PUSH
					
				fireNotification (array(
					'receiver_type'	=> 'ressource', 
					'receiver_id' 	=> $b['id'], 
					'titel' 		=> $betreff,
					'subtitle'		=> 'Job ' . $j['jobtitel'] . ' wurde leider anderwärtig vergeben!',
					'nachricht' 	=> "Job <strong>{$j['jobtitel']}</strong> wurde leider anderwärtig vergeben!", 
					'kategorie' 	=> 'joborder', 
					'link_web' 		=> "/app/joborders/", 
					'link_mobile' 	=> "/ressource/joborders", 
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));
				
			}

            $body = json_encode(['status' => $ret]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->post('/joborders', function($request, $response, $args) {
        try{
            
            $db = getDB();
			$table = ($request->getParsedBody()['publisher_type'] == "kunde") ? "kunden" : "dienstleister";
			
			$sth = $db->prepare("SELECT * FROM $table WHERE id=:id");
			$sth->bindParam(':id', $request->getParsedBody()['publisher_id'], PDO::PARAM_INT);
			$sth->execute();
			$publisher = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			if ($publisher['anzahl_joborders'] > 0){

				// Kosten errechnen
				$tag1 = strtotime($request->getParsedBody()['arbeitsbeginn']);
				$tag2 = strtotime($request->getParsedBody()['arbeitsende']);
				$diff = $tag2 - $tag1;

				$tage = floor($diff / (60 * 60 * 24)) + 1;
				if ($tage > 183) $tage = 183;

				$berufsbezeichnungen_decoded = json_decode($request->getParsedBody()['berufsbezeichnungen']);
				$berufsgruppen_decoded = json_decode($request->getParsedBody()['berufsgruppen']);
				$bb = implode(",", $berufsbezeichnungen_decoded);

				if(count($berufsbezeichnungen_decoded) > 0){
					$sth = $db->prepare("SELECT berufsbezeichnungen.name, berufsbezeichnungen.verrechnungs_kategorien_id, verrechnungs_kategorien.preis, verrechnungs_kategorien.name AS verrechnungs_kategorien_name FROM berufsbezeichnungen LEFT JOIN verrechnungs_kategorien ON berufsbezeichnungen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE berufsbezeichnungen.id IN ($bb) ORDER BY berufsbezeichnungen.verrechnungs_kategorien_id ASC");
					$sth->execute();
					$berufsbezeichnungen = $sth->fetchAll(PDO::FETCH_ASSOC);
				}

				if (count($berufsbezeichnungen_decoded) > 0){
					$kat = $berufsbezeichnungen[0];
				}else{
					$bg = implode(",", $berufsgruppen_decoded);
					$sth = $db->prepare("SELECT berufsgruppen.name, berufsgruppen.verrechnungs_kategorien_id, verrechnungs_kategorien.preis, verrechnungs_kategorien.name AS verrechnungs_kategorien_name FROM berufsgruppen LEFT JOIN verrechnungs_kategorien ON berufsgruppen.verrechnungs_kategorien_id = verrechnungs_kategorien.id WHERE berufsgruppen.id IN ($bg) ORDER BY berufsgruppen.verrechnungs_kategorien_id ASC");
					$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
					$sth->execute();
					$kat = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				}
				$verrechnungs_kategorien_id = $kat['verrechnungs_kategorien_id'];
				$gesamtkosten = $tage * $kat['preis'];

				// JO einfügen
				$sth = $db->prepare("INSERT INTO `joborders` (`jobtitel`, `arbeitszeitmodell`, `arbeitsbeginn`, `arbeitsende`, `bezirke_id`, `beschaeftigungsarten_id`, `beschaeftigungsausmasse_id`, `adresse_strasse_hn`, `adresse_plz`, `adresse_ort`, `kollektivvertrag`, `brutto_bezug`, `brutto_bezug_einheit`, `brutto_bezug_ueberzahlung`, `taetigkeitsbeschreibung`, `skill_fuehrerschein`, `skill_pkw`, `skill_berufsabschluss`, `bewerbungen_von`, `bewerbungen_bis`, `anzahl_ressourcen`, `casting`, `vorlage`, `publisher_type`, `publisher_id`, `kunde_anzeigen`, `kunde_name`, `dienstleister_vorgegeben`, `dienstleister_single`, `dienstleister_id`, `creator_type`, `creator_id`, `tage`, `verrechnungs_kategorien_id`, `kosten`) VALUES (:jobtitel, :arbeitszeitmodell, :arbeitsbeginn, :arbeitsende, :bezirke_id, :beschaeftigungsarten_id, :beschaeftigungsausmasse_id, :adresse_strasse_hn, :adresse_plz, :adresse_ort, :kollektivvertrag, :brutto_bezug, :brutto_bezug_einheit, :brutto_bezug_ueberzahlung, :taetigkeitsbeschreibung, :skill_fuehrerschein, :skill_pkw, :skill_berufsabschluss, :bewerbungen_von, :bewerbungen_bis, :anzahl_ressourcen, :casting, :vorlage, :publisher_type, :publisher_id, :kunde_anzeigen, :kunde_name, :dienstleister_vorgegeben, :dienstleister_single, :dienstleister_id, :creator_type, :creator_id, :tage, :verrechnungs_kategorien_id, :kosten)");

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
				$sth->bindParam(':brutto_bezug_ueberzahlung', $request->getParsedBody()['brutto_bezug_ueberzahlung'], PDO::PARAM_INT);
				$sth->bindParam(':taetigkeitsbeschreibung', $request->getParsedBody()['taetigkeitsbeschreibung'], PDO::PARAM_STR);
				$sth->bindParam(':skill_fuehrerschein', $request->getParsedBody()['skill_fuehrerschein'], PDO::PARAM_INT);
				$sth->bindParam(':skill_pkw', $request->getParsedBody()['skill_pkw'], PDO::PARAM_INT);
				$sth->bindParam(':skill_berufsabschluss', $request->getParsedBody()['skill_berufsabschluss'], PDO::PARAM_INT);
				$sth->bindParam(':bewerbungen_von', $request->getParsedBody()['bewerbungen_von'], PDO::PARAM_STR);
				$sth->bindParam(':bewerbungen_bis', $request->getParsedBody()['bewerbungen_bis'], PDO::PARAM_STR);
				$sth->bindParam(':anzahl_ressourcen', $request->getParsedBody()['anzahl_ressourcen'], PDO::PARAM_INT);
				$sth->bindParam(':casting', $request->getParsedBody()['casting'], PDO::PARAM_INT);
				$sth->bindParam(':vorlage', $request->getParsedBody()['vorlage'], PDO::PARAM_INT);
				$sth->bindParam(':publisher_type', $request->getParsedBody()['publisher_type'], PDO::PARAM_INT);
				$sth->bindParam(':publisher_id', $request->getParsedBody()['publisher_id'], PDO::PARAM_INT);
				$sth->bindParam(':kunde_anzeigen', $request->getParsedBody()['kunde_anzeigen'], PDO::PARAM_INT);
				$sth->bindParam(':kunde_name', $request->getParsedBody()['kunde_name'], PDO::PARAM_INT);
				$sth->bindParam(':dienstleister_vorgegeben', $request->getParsedBody()['dienstleister_vorgegeben'], PDO::PARAM_INT);
				$sth->bindParam(':dienstleister_single', $request->getParsedBody()['dienstleister_single'], PDO::PARAM_INT);
				$sth->bindParam(':dienstleister_id', $request->getParsedBody()['dienstleister_id'], PDO::PARAM_INT);
				$sth->bindParam(':creator_type', $request->getParsedBody()['creator_type'], PDO::PARAM_INT);
				$sth->bindParam(':creator_id', $request->getParsedBody()['creator_id'], PDO::PARAM_INT);
				$sth->bindParam(':tage', $tage, PDO::PARAM_INT);
				$sth->bindParam(':verrechnungs_kategorien_id', $verrechnungs_kategorien_id, PDO::PARAM_INT);
				$sth->bindParam(':kosten', $gesamtkosten, PDO::PARAM_INT);
				$sth->execute();

				$joborders_id = $db->lastInsertId();

				$sth = $db->prepare("UPDATE $table SET anzahl_joborders = anzahl_joborders - 1 WHERE id = :id");
				$sth->bindParam(':id', $request->getParsedBody()['publisher_id'], PDO::PARAM_INT);
				$sth->execute();


				$sth = $db->prepare("DELETE FROM relation_joborders_berufsfelder WHERE joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
				$sth->execute();

				foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
					$sth = $db->prepare("INSERT INTO relation_joborders_berufsfelder (joborders_id, berufsfelder_id) VALUES (:joborders_id, :berufsfelder_id)");
					$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
					$sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
					$sth->execute();
				}

				$sth = $db->prepare("DELETE FROM relation_joborders_berufsgruppen WHERE joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
				$sth->execute();

				foreach (json_decode($request->getParsedBody()['berufsgruppen']) as $b){
					$sth = $db->prepare("INSERT INTO relation_joborders_berufsgruppen (joborders_id, berufsgruppen_id) VALUES (:joborders_id, :berufsgruppen_id)");
					$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
					$sth->bindParam(':berufsgruppen_id', $b, PDO::PARAM_INT);
					$sth->execute();
				}

				$sth = $db->prepare("DELETE FROM relation_joborders_berufsbezeichnungen WHERE joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
				$sth->execute();

				foreach (json_decode($request->getParsedBody()['berufsbezeichnungen']) as $b){
					$sth = $db->prepare("INSERT INTO relation_joborders_berufsbezeichnungen (joborders_id, berufsbezeichnungen_id) VALUES (:joborders_id, :berufsbezeichnungen_id)");
					$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
					$sth->bindParam(':berufsbezeichnungen_id', $b, PDO::PARAM_INT);
					$sth->execute();
				}

				$sth = $db->prepare("DELETE FROM relation_joborders_dienstleister_auswahl WHERE joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
				$sth->execute();

				foreach (json_decode($request->getParsedBody()['dienstleister_auswahl']) as $d){
					$sth = $db->prepare("INSERT INTO relation_joborders_dienstleister_auswahl (joborders_id, dienstleister_id) VALUES (:joborders_id, :dienstleister_id)");
					$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
					$sth->bindParam(':dienstleister_id', $d, PDO::PARAM_INT);
					$sth->execute();
				}

				$sth = $db->prepare("DELETE FROM relation_joborders_skills WHERE joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
				$sth->execute();

				foreach (json_decode($request->getParsedBody()['skills']) as $b){
					$sth = $db->prepare("INSERT INTO relation_joborders_skills (joborders_id, skills_items_id, praedikat) VALUES (:joborders_id, :skills_items_id, :praedikat)");
					$sth->bindParam(':joborders_id', $joborders_id, PDO::PARAM_INT);
					$sth->bindParam(':skills_items_id', $b->id, PDO::PARAM_INT);
					$sth->bindParam(':praedikat', $b->praedikat, PDO::PARAM_STR);
					$sth->execute();
				}

				if ($request->getParsedBody()['vorlage'] == 1){
					$sth = $db->prepare("INSERT INTO `templates` (`name`, `jobtitel`, `arbeitszeitmodell`, `arbeitsbeginn`, `arbeitsende`, `bezirke_id`, `beschaeftigungsarten_id`, `beschaeftigungsausmasse_id`, `adresse_strasse_hn`, `adresse_plz`, `adresse_ort`, `kollektivvertrag`, `brutto_bezug`, `brutto_bezug_einheit`, `brutto_bezug_ueberzahlung`, `taetigkeitsbeschreibung`, `skill_fuehrerschein`, `skill_pkw`, `skill_berufsabschluss`, `bewerbungen_von`, `bewerbungen_bis`, `anzahl_ressourcen`, `casting`, `vorlage`, `publisher_type`, `publisher_id`, `kunde_anzeigen`, `kunde_name`, `dienstleister_vorgegeben`, `dienstleister_single`, `dienstleister_id`, `creator_type`, `creator_id`) VALUES (:name, :jobtitel, :arbeitszeitmodell, :arbeitsbeginn, :arbeitsende, :bezirke_id, :beschaeftigungsarten_id, :beschaeftigungsausmasse_id, :adresse_strasse_hn, :adresse_plz, :adresse_ort, :kollektivvertrag, :brutto_bezug, :brutto_bezug_einheit, :brutto_bezug_ueberzahlung, :taetigkeitsbeschreibung, :skill_fuehrerschein, :skill_pkw, :skill_berufsabschluss, :bewerbungen_von, :bewerbungen_bis, :anzahl_ressourcen, :casting, :vorlage, :publisher_type, :publisher_id, :kunde_anzeigen, :kunde_name, :dienstleister_vorgegeben, :dienstleister_single, :dienstleister_id, :creator_type, :creator_id)");

					$sth->bindParam(':name', $request->getParsedBody()['vorlage_name'], PDO::PARAM_STR);

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
					$sth->bindParam(':brutto_bezug_ueberzahlung', $request->getParsedBody()['brutto_bezug_ueberzahlung'], PDO::PARAM_INT);
					$sth->bindParam(':taetigkeitsbeschreibung', $request->getParsedBody()['taetigkeitsbeschreibung'], PDO::PARAM_STR);
					$sth->bindParam(':skill_fuehrerschein', $request->getParsedBody()['skill_fuehrerschein'], PDO::PARAM_INT);
					$sth->bindParam(':skill_pkw', $request->getParsedBody()['skill_pkw'], PDO::PARAM_INT);
					$sth->bindParam(':skill_berufsabschluss', $request->getParsedBody()['skill_berufsabschluss'], PDO::PARAM_INT);
					$sth->bindParam(':bewerbungen_von', $request->getParsedBody()['bewerbungen_von'], PDO::PARAM_STR);
					$sth->bindParam(':bewerbungen_bis', $request->getParsedBody()['bewerbungen_bis'], PDO::PARAM_STR);
					$sth->bindParam(':anzahl_ressourcen', $request->getParsedBody()['anzahl_ressourcen'], PDO::PARAM_INT);
					$sth->bindParam(':casting', $request->getParsedBody()['casting'], PDO::PARAM_INT);
					$sth->bindParam(':vorlage', $request->getParsedBody()['vorlage'], PDO::PARAM_INT);
					$sth->bindParam(':publisher_type', $request->getParsedBody()['publisher_type'], PDO::PARAM_INT);
					$sth->bindParam(':publisher_id', $request->getParsedBody()['publisher_id'], PDO::PARAM_INT);
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
				}

				// Run Notification in Background
				$path = getcwd()."/parts/notifications/notifyRessourcesAboutNewJob.php";
				shell_exec(PHP_BINDIR . "/php $path '$joborders_id'");

				$body = json_encode(['status' => true, 'id' => $joborders_id]);
				
			}else{
				$body = json_encode(['status' => false, 'msg' => "Keine zu verbrauchende Joborders!"]);
			}
            
        } catch(PDOException $e){
            $response->withStatus(400);
            echo json_encode(['msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

?>