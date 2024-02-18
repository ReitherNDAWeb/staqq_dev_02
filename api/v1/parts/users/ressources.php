<?php

    $app->get('/ressources', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM ressources");
            $sth->execute();
            $body = json_encode(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)));
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });
    
    $app->get('/ressources/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
            
            $sth = $db->prepare("SELECT berufsfelder.id, berufsfelder.name FROM relation_ressources_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_ressources_berufsfelder.berufsfelder_id WHERE relation_ressources_berufsfelder.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['berufsfelder'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT berufsgruppen.id, berufsgruppen.name FROM relation_ressources_berufsgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_ressources_berufsgruppen.berufsgruppen_id WHERE relation_ressources_berufsgruppen.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['berufsgruppen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT berufsbezeichnungen.id, berufsbezeichnungen.name FROM relation_ressources_berufsbezeichnungen LEFT JOIN berufsbezeichnungen ON berufsbezeichnungen.id = relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_ressources_berufsbezeichnungen.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['berufsbezeichnungen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT skills_items.id, skills_items.name FROM relation_ressources_skills LEFT JOIN skills_items ON skills_items.id = relation_ressources_skills.skills_items_id WHERE relation_ressources_skills.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['skills'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT bezirke.id, bezirke.name, bundeslaender.id AS bundeslaender_id, bundeslaender.name as bundeslaender_name FROM relation_ressources_bezirke LEFT JOIN bezirke ON bezirke.id = relation_ressources_bezirke.bezirke_id LEFT JOIN bundeslaender ON bezirke.bundeslaender_id = bundeslaender.id WHERE relation_ressources_bezirke.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['bezirke'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut, dienstleister.firmenwortlaut FROM castings LEFT JOIN dienstleister ON dienstleister.id = castings.dienstleister_id WHERE castings.ressources_id=:id AND castings.ressources_verify=1 AND castings.dienstleister_verify=1");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['dl_gecastet'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $sth = $db->prepare("SELECT dienstleister.id, dienstleister.firmenwortlaut FROM relation_ressources_dienstleister_blacklist LEFT JOIN dienstleister ON dienstleister.id = relation_ressources_dienstleister_blacklist.dienstleister_id WHERE relation_ressources_dienstleister_blacklist.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res['dl_blacklist'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($res);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->get('/ressources/{id}/joborders', function($request, $response, $args) use($app) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
            
            $sth = $db->prepare("SELECT berufsfelder.id FROM relation_ressources_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_ressources_berufsfelder.berufsfelder_id WHERE relation_ressources_berufsfelder.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['berufsfelder'] = array();
            foreach($arr as $a){array_push($res['berufsfelder'], $a['id']);}
            
            $sth = $db->prepare("SELECT berufsgruppen.id FROM relation_ressources_berufsgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_ressources_berufsgruppen.berufsgruppen_id WHERE relation_ressources_berufsgruppen.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['berufsgruppen'] = array();
            foreach($arr as $a){array_push($res['berufsgruppen'], $a['id']);}
            
            $sth = $db->prepare("SELECT berufsbezeichnungen.id FROM relation_ressources_berufsbezeichnungen LEFT JOIN berufsbezeichnungen ON berufsbezeichnungen.id = relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_ressources_berufsbezeichnungen.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['berufsbezeichnungen'] = array();
            foreach($arr as $a){array_push($res['berufsbezeichnungen'], $a['id']);}
            
            $sth = $db->prepare("SELECT skills_items.id FROM relation_ressources_skills LEFT JOIN skills_items ON skills_items.id = relation_ressources_skills.skills_items_id WHERE relation_ressources_skills.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['skills'] = array();
            foreach($arr as $a){array_push($res['skills'], $a['id']);}
            
            $sth = $db->prepare("SELECT bezirke.id FROM relation_ressources_bezirke LEFT JOIN bezirke ON bezirke.id = relation_ressources_bezirke.bezirke_id WHERE relation_ressources_bezirke.ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['bezirke'] = array();
            foreach($arr as $a){array_push($res['bezirke'], $a['id']);}
            
            $sth = $db->prepare("SELECT dienstleister_id FROM relation_ressources_dienstleister_blacklist WHERE ressources_id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            $res['dl_blacklist'] = array();
            foreach($arr as $a){array_push($res['dl_blacklist'], $a['dienstleister_id']);}
            
            $bezirke_ids = '(' . implode(',', array_map('intval', $res['bezirke'])) . ')';
            
            $sth = $db->prepare("
                SELECT 
                    joborders.*, 
                    joborders.id AS id, 
					joborders.arbeitsbeginn AS ab,
					joborders.arbeitsende AS ae,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    bezirke.name as bezirke_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut,
                    dienstleister.website AS dienstleister_website 
                FROM joborders 
                    LEFT JOIN relation_joborders_berufsgruppen ON relation_joborders_berufsgruppen.joborders_id = joborders.id 
                    LEFT JOIN bezirke ON bezirke.id = joborders.bezirke_id LEFT JOIN dienstleister ON dienstleister.id = joborders.dienstleister_id 
                    LEFT OUTER JOIN bewerbungen ON (bewerbungen.joborders_id = joborders.id AND bewerbungen.ressources_id =:id) 
                    LEFT OUTER JOIN joborders_gemerkt ON (joborders_gemerkt.joborders_id = joborders.id AND joborders_gemerkt.ressources_id =:id) 
                    LEFT OUTER JOIN joborders_abgelehnt ON (joborders_abgelehnt.joborders_id = joborders.id AND joborders_abgelehnt.ressources_id =:id) 
                WHERE 
                    (bewerbungen.id IS NULL) 
                    AND (joborders_gemerkt.joborders_id IS NULL) 
                    AND (joborders_abgelehnt.joborders_id IS NULL) 
                    AND (joborders.bezirke_id IN $bezirke_ids)
                    AND (joborders.bewerbungen_von <= CURDATE()) 
                    AND (joborders.bewerbungen_bis >= CURDATE()) 
                GROUP BY 
                    joborders.id
            ");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            //$berufsfelder_ids = '(' . implode(',', array_map('intval', $res['berufsfelder'])) . ')';
            $joborders_approved = array();
            
            for($i=0;$i<count($joborders);$i++){
                
                if (!(intval($joborders[$i]['dienstleister_vorgegeben']) == 1 && in_array($joborders[$i]['dienstleister_id'], $res['dl_blacklist']))){
          
                    if ((intval($joborders[$i]['skill_pkw']) <= intval($res['skill_pkw'])) && (intval($joborders[$i]['skill_fuehrerschein']) <= intval($res['skill_fuehrerschein'])) && (intval($joborders[$i]['skill_berufsabschluss']) <= intval($res['skill_berufsabschluss']))){


                        $sth = $db->prepare("SELECT berufsfelder.id FROM relation_joborders_berufsfelder LEFT JOIN 
                    berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                        $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                        $sth->execute();
                        $joborders[$i]['berufsfelder'] = array();
                        foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborders[$i]['berufsfelder'], $a['id']);}
						
						$machtedBerufsfelder = 0;
							
						foreach ($joborders[$i]['berufsfelder'] as $x){
							foreach($res['berufsfelder'] as $y){
								if ($y == $x){
									$machtedBerufsfelder++;
									break;
								}
							}
						}
						
						// Mind. 1 Berufsfeld
                        if ($machtedBerufsfelder > 0){

                            $sth = $db->prepare("SELECT berufsgruppen.id FROM relation_joborders_berufsgruppen LEFT JOIN 
                    berufsgruppen ON berufsgruppen.id = relation_joborders_berufsgruppen.berufsgruppen_id WHERE relation_joborders_berufsgruppen.joborders_id=:id");
                            $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                            $sth->execute();
                            $joborders[$i]['berufsgruppen'] = array();
                            foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborders[$i]['berufsgruppen'], $a['id']);}

                            $machtedBerufsgruppen = 0;
							
							foreach ($joborders[$i]['berufsgruppen'] as $x){
								foreach($res['berufsgruppen'] as $y){
									if ($y == $x){
										$machtedBerufsgruppen++;
										break;
									}
								}
							}

							// Mind. 1 Berufsgruppe
							if ($machtedBerufsgruppen > 0){

                                $sth = $db->prepare("SELECT skills_items.id FROM relation_joborders_skills LEFT JOIN 
                        skills_items ON skills_items.id = relation_joborders_skills.skills_items_id WHERE relation_joborders_skills.joborders_id=:id AND relation_joborders_skills.praedikat='muss'");
                                $sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
                                $sth->execute();

                                $joborders[$i]['skills_muss'] = array();
                                foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborders[$i]['skills_muss'], $a['id']);}

                                if (count(array_diff($joborders[$i]['skills_muss'], $res['skills'])) == 0){
									
									$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE joborders.arbeitsbeginn <= :ae AND joborders.arbeitsende >= :ab AND bewerbungen.ressources_id=:id AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt')");
									$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
									$sth->bindParam(':ab', $joborders[$i]['ab'], PDO::PARAM_STR);
									$sth->bindParam(':ae', $joborders[$i]['ae'], PDO::PARAM_STR);
									$sth->execute();
									
									if ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'] == 0){
										
										// Überprüfe, ob nicht schon besetzt
										
										$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen WHERE bewerbungen.joborders_id=:id AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt')");
										$sth->bindParam(':id', $joborders[$i]['id'], PDO::PARAM_INT);
										$sth->execute();

										if ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'] < $joborders[$i]['anzahl_ressourcen']){

											if ($joborders[$i]['publisher_type'] == "kunde"){
												$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
												$sth->bindParam(':id', $joborders[$i]['publisher_id'], PDO::PARAM_INT);
												$sth->execute();
												$joborders[$i]['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
					
												$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='kunde' AND bewertet_id=:bewertet_id AND status=1");
												$sth->bindParam(':bewertet_id', $joborders[$i]['publisher_id'], PDO::PARAM_INT);
												$sth->execute();

												$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];

												$joborders[$i]['kunde_name_inkl_bewertung'] = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

												$rating = number_format($joborders[$i]['kunde_name_inkl_bewertung'], 2, ",", "");

												$joborders[$i]['kunde_name_inkl_bewertung'] = $joborders[$i]['kunde_name'] . " (★ $rating)";
											}

											$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE joborders.arbeitsbeginn <= :ae AND joborders.arbeitsende >= :ab AND bewerbungen.ressources_id=:id");
											$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
											$sth->bindParam(':ab', $joborders[$i]['ab'], PDO::PARAM_STR);
											$sth->bindParam(':ae', $joborders[$i]['ae'], PDO::PARAM_STR);
											$sth->execute();

											$joborders[$i]['joborders_in_zeitraum'] = ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz']) ? 1 : 0;
											
											// DL Rating
											if ($joborders[$i]['dienstleister_single']){
											
												$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='dienstleister' AND bewertet_id=:bewertet_id AND status=1");
												$sth->bindParam(':bewertet_id', $joborders[$i]['dienstleister_id'], PDO::PARAM_INT);
												$sth->execute();

												$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
												$joborders[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = 
												($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;
												
												$rating = number_format($joborders[$i]['dienstleister_firmenwortlaut_inkl_bewertung'], 2, ",", "");
												
												$joborders[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = $joborders[$i]['dienstleister_firmenwortlaut'] . " (★ $rating)";
											}
											
											array_push($joborders_approved, $joborders[$i]);

										}
									}
                                }
                            }
                        }
                    }      
                }
            }
            
            $order = array();
            for($i=0;$i<count($joborders_approved);$i++){
                $joborders_approved[$i]['score'] = getSTAQQScore($res['id'], $joborders_approved[$i]['id']);
                $order[$i] = $joborders_approved[$i]['score']->score;
            }
            
            array_multisort($order, SORT_DESC, $joborders_approved);
            
            $body = json_encode($joborders_approved);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


    $app->get('/ressources/{id}/zahlen', function($request, $response, $args) use($app) {
        
        try{
            
            $anzahlen = array();
            
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    castings 
                WHERE 
                    castings.ressources_id=:id AND
                    castings.ressources_verify=0
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $anzahlen['castings']['offen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['offen'];
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS gesamt
                FROM 
                    castings 
                WHERE 
                    castings.ressources_id=:id
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $anzahlen['castings']['gesamt'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['gesamt'];
            
            $sth = $db->prepare("
                SELECT 
                    COUNT(*) AS offen
                FROM 
                    bewertungen
                WHERE 
					von_type = 'ressource' AND
                    von_id=:id AND 
					status = 0
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $anzahlen['bewertungen']['offen'] = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0]['offen'];
            
            $body = json_encode($anzahlen);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


    $app->get('/ressources/{id}/bewerbungen', function($request, $response, $args) use($app) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
					bewerbungen.joborders_id,
					dienstleister_joborders_abgelehnt.dienstleister_id AS dienstleister_joborder_abgelehnt,
                    bewerbungen.id AS id,
					bewerbungen.dienstleister_id AS dienstleister_id,
                    arbeitsbeginn AS ab,
                    arbeitsende AS ae,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
                    bezirke.name AS bezirke_name,
					joborders.publisher_type,
					joborders.publisher_id,
					joborders.kunde_name,
					joborders.anzahl_ressourcen, 
					joborders.dienstleister_single,
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut,
                    dienstleister.website AS dienstleister_website 
                FROM 
                    bewerbungen 
                LEFT JOIN 
                    joborders ON joborders.id = bewerbungen.joborders_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = bewerbungen.dienstleister_id 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
				LEFT JOIN 
					dienstleister_joborders_abgelehnt ON dienstleister_joborders_abgelehnt.dienstleister_id = bewerbungen.dienstleister_id AND dienstleister_joborders_abgelehnt.joborders_id=bewerbungen.joborders_id 
                WHERE 
                    bewerbungen.ressources_id=:id
				ORDER BY ae DESC
            ");
            
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $bewerbungen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            for($i=0;$i<count($bewerbungen);$i++){
                $sth = $db->prepare("SELECT berufsfelder.id FROM relation_joborders_berufsfelder LEFT JOIN 
                    berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                $sth->bindParam(':id', $bewerbungen[$i]['joborders_id'], PDO::PARAM_INT);
                $sth->execute();
                $bewerbungen[$i]['berufsfelder'] = array();
                foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($bewerbungen[$i]['berufsfelder'], $a['id']);}
								
				if ($bewerbungen[$i]['publisher_type'] == "kunde"){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
					$sth->bindParam(':id', $bewerbungen[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();
					$bewerbungen[$i]['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
					
					$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='kunde' AND bewertet_id=:bewertet_id AND status=1");
					$sth->bindParam(':bewertet_id', $bewerbungen[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();

					$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					
					$bewerbungen[$i]['kunde_name_inkl_bewertung'] = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

					$rating = number_format($bewerbungen[$i]['kunde_name_inkl_bewertung'], 2, ",", "");

					$bewerbungen[$i]['kunde_name_inkl_bewertung'] = $bewerbungen[$i]['kunde_name'] . " (★ $rating)";
				}

				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen WHERE (status = 'vergeben' OR status = 'einsatz_bestaetigt') AND joborders_id=:joborders_id");
				$sth->bindParam(':joborders_id', $bewerbungen[$i]['joborders_id'], PDO::PARAM_INT);
				$sth->execute();
				$bewerbungen[$i]['joborder_alle_ressourcen_vergeben'] = ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz'] == $bewerbungen[$i]['anzahl_ressourcen']) ? 1 : 0;
				
				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE joborders.arbeitsbeginn <= :ae AND joborders.arbeitsende >= :ab AND bewerbungen.ressources_id=:id");
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->bindParam(':ab', $bewerbungen[$i]['ab'], PDO::PARAM_STR);
				$sth->bindParam(':ae', $bewerbungen[$i]['ae'], PDO::PARAM_STR);
				$sth->execute();

				$bewerbungen[$i]['joborders_in_zeitraum'] = ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz']) ? 1 : 0;
				
				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE joborders.arbeitsbeginn <= :ae AND joborders.arbeitsende >= :ab AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt') AND bewerbungen.ressources_id=:id AND joborders_id NOT IN (:joborders_id)");
				$sth->bindParam(':joborders_id', $bewerbungen[$i]['joborders_id'], PDO::PARAM_INT);
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->bindParam(':ab', $bewerbungen[$i]['ab'], PDO::PARAM_STR);
				$sth->bindParam(':ae', $bewerbungen[$i]['ae'], PDO::PARAM_STR);
				$sth->execute();
				
				$bewerbungen[$i]['joborders_in_zeitraum_vergeben'] = (intval($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz']) > 0) ? 1 : 0;
											
				// DL Rating

				$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='dienstleister' AND bewertet_id=:bewertet_id AND status=1");
				$sth->bindParam(':bewertet_id', $bewerbungen[$i]['dienstleister_id'], PDO::PARAM_INT);
				$sth->execute();

				$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				$bewerbungen[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = 
				($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

				$rating = number_format($bewerbungen[$i]['dienstleister_firmenwortlaut_inkl_bewertung'], 2, ",", "");

				$bewerbungen[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = $bewerbungen[$i]['dienstleister_firmenwortlaut'] . " (★ $rating)";
				
				$bewerbungen[$i]['dienstleister_joborder_abgelehnt'] = ($bewerbungen[$i]['dienstleister_joborder_abgelehnt'] == null) ? false : true;
            }
            
            $body = json_encode($bewerbungen);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/ressources/{ressources_id}/bewerbungen/{bewerbungen_id}/einsatzBestaetigen', function($request, $response, $args) {
        try{
            $db = getDB();
			
            $sth = $db->prepare("UPDATE bewerbungen SET status='einsatz_bestaetigt' WHERE id=:bewerbungen_id AND ressources_id=:ressources_id");
            $sth->bindParam(':bewerbungen_id', $args['bewerbungen_id'], PDO::PARAM_INT);
            $sth->bindParam(':ressources_id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->execute();
			
			// Get Joborder
			$sth = $db->prepare("SELECT bewerbungen.dienstleister_id, joborders.publisher_id, joborders.publisher_type, joborders.creator_id, joborders.creator_type, bewerbungen.joborders_id, joborders.jobtitel FROM bewerbungen lEFT JOIN joborders ON bewerbungen.joborders_id = joborders.id WHERE bewerbungen.id=:id");
			$sth->bindParam(':id', $args['bewerbungen_id'], PDO::PARAM_INT);
			$sth->execute();
			
			$data = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			$rs_id = $args['ressources_id'];
			$jo_id = $data['joborders_id'];
			
			$kd_bool = ($data['creator_type'] == "kunde") ? true : false;
			$kd_user_bool = ($data['creator_type'] == "kunde_user") ? true : false;
			
			$kd_id = $data['creator_id'];
			$kd_user_id = $data['creator_id'];
			
			$dl_bool = ($data['creator_type'] == "dienstleister") ? true : false;
			$dl_user_bool = ($data['creator_type'] == "dienstleister_user") ? true : false;
			
			
			// Notification
			
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
            $sth->bindParam(':id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->execute();
            $ressource = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			$sth = $db->prepare("SELECT * FROM joborders_dienstleister_user_delegation WHERE joborders_id=:joborders_id AND dienstleister_id=:dienstleister_id");
			$sth->bindParam(':dienstleister_id', $data['dienstleister_id'], PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $data['joborders_id'], PDO::PARAM_INT);
			$sth->execute();
			$delegationen = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			if ($dl_bool) {
				$dl_id = $data['creator_id'];
				$dl_type = 'dienstleister';
			} elseif ($dl_user_bool) {
				$dl_id = $data['creator_id'];
				$dl_type = 'dienstleister_user';
			} else {
				
				if ((count($delegationen) > 0) && ($delegationen[0]['dienstleister_user_id'] != null)){

					$dl_type = "dienstleister_user";
					$dl_id = $delegationen[0]['dienstleister_user_id'];

				}else{

					$dl_type = "dienstleister";
					$dl_id = $data['dienstleister_id'];

				}
			}
			
			fireNotification (array(
				'receiver_type'	=> $dl_type, 
				'receiver_id' 	=> $dl_id, 
				'titel' 		=> 'Einsatz bestätigt',
				'subtitle'		=> 'Einsatz bestätigt beim Job ' . $data['jobtitel'],
				'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat den Einsatz für den Job <strong>{$data['jobtitel']}</strong> bestätigt!", 
				'kategorie' 	=> 'joborder', 
				'link_web' 		=> "/app/joborders/ressourcen/?id=" . hashId($data['joborders_id']), 
				'link_mobile' 	=> "/dienstleister/joborders/{$data['joborders_id']}/ressources",
				'send_web' 		=> true, 
				'send_mobile' 	=> true,
				'force' 		=> true
			));
			
			
			if ($data['publisher_type'] == "kunde"){
				fireNotification (array(
					'receiver_type'	=> $data['creator_type'], 
					'receiver_id' 	=> $data['creator_id'], 
					'titel' 		=> 'Einsatz bestätigt',
					'subtitle'		=> 'Einsatz bestätigt beim Job ' . $data['jobtitel'],
					'nachricht' 	=> "<strong>{$ressource['vorname']} {$ressource['nachname']}</strong> hat den Einsatz für den Job <strong>{$data['jobtitel']}</strong> bestätigt!", 
					'kategorie' 	=> 'joborder', 
					'link_web' 		=> "/app/joborders/#vergeben", 
					'link_mobile' 	=> "/kunde/joborders",
					'send_web' 		=> true, 
					'send_mobile' 	=> true,
					'force' 		=> true
				));
			}
			
			
			// Bewertungen erstellen
			
			// R
			$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('ressource', :bewertet_id, :von_type, :von_id, :joborders_id, 0, 0)");
            $sth->bindParam(':bewertet_id', $rs_id, PDO::PARAM_INT);
            $sth->bindParam(':von_type', $dl_type, PDO::PARAM_INT);
            $sth->bindParam(':von_id', $dl_id, PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
			$sth->execute();
			
			if ($kd_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('ressource', :bewertet_id, 'kunde', :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $rs_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $kd_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
			} elseif ($kd_user_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('ressource', :bewertet_id, 'kunde_user', :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $rs_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $kd_user_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
			}
			
			// DL
			$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES (:bewertet_type, :bewertet_id, 'ressource', :von_id, :joborders_id, 0, 0)");
            $sth->bindParam(':bewertet_type', $dl_type, PDO::PARAM_INT);
			$sth->bindParam(':bewertet_id', $dl_id, PDO::PARAM_INT);
			$sth->bindParam(':von_id', $rs_id, PDO::PARAM_INT);
			$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
			$sth->execute();
			
			if ($kd_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES (:bewertet_type, :bewertet_id, 'kunde', :von_id, :joborders_id, 0, 0)");
            	$sth->bindParam(':bewertet_type', $dl_type, PDO::PARAM_INT);
				$sth->bindParam(':bewertet_id', $dl_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $kd_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
			} elseif ($kd_user_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES (:bewertet_type, :bewertet_id, 'kunde_user', :von_id, :joborders_id, 0, 0)");
            	$sth->bindParam(':bewertet_type', $dl_type, PDO::PARAM_INT);
				$sth->bindParam(':bewertet_id', $dl_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $kd_user_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
			}
			
			// KU
			if ($kd_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('kunde', :bewertet_id, 'ressource', :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $kd_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $rs_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
				
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('kunde', :bewertet_id, :von_type, :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $kd_id, PDO::PARAM_INT);
				$sth->bindParam(':von_type', $dl_type, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $dl_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
				
			} elseif ($kd_user_bool){
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('kunde_user', :bewertet_id, 'ressource', :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $kd_user_id, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $rs_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
				
				$sth = $db->prepare("INSERT IGNORE bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES ('kunde_user', :bewertet_id, :von_type, :von_id, :joborders_id, 0, 0)");
				$sth->bindParam(':bewertet_id', $kd_user_id, PDO::PARAM_INT);
            	$sth->bindParam(':von_type', $dl_type, PDO::PARAM_INT);
				$sth->bindParam(':von_id', $dl_id, PDO::PARAM_INT);
				$sth->bindParam(':joborders_id', $jo_id, PDO::PARAM_INT);
				$sth->execute();
			}
			
            $body = json_encode(['status' => true]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/ressources/{ressources_id}/notificationSettings', function($request, $response, $args) {
        try{
            $db = getDB();
			
            $sth = $db->prepare("
				UPDATE 
					ressources 
				SET 
					push_bool=:push_bool, 
					job_reminder_bool=:job_reminder_bool, 
					job_reminder_intervall=:job_reminder_intervall, 
					job_alert=:job_alert 
				WHERE 
					ressources.id=:ressources_id
			");
			
			$job_alert = $request->getParsedBody()['job_alert'] ? $request->getParsedBody()['job_alert'] : 'instant';
			
            $sth->bindParam(':ressources_id', $args['ressources_id'], PDO::PARAM_INT);
            $sth->bindParam(':push_bool', $request->getParsedBody()['push_bool'], PDO::PARAM_INT);
            $sth->bindParam(':job_reminder_bool', $request->getParsedBody()['job_reminder_bool'], PDO::PARAM_INT);
            $sth->bindParam(':job_reminder_intervall', $request->getParsedBody()['job_reminder_intervall'], PDO::PARAM_STR);
            $sth->bindParam(':job_alert', $job_alert, PDO::PARAM_STR);
            
			$result = $sth->execute();
			
            $body = json_encode(['status' => $result]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });


    $app->get('/ressources/{id}/gemerkte', function($request, $response, $args) use($app) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    *, 
                    joborders.id AS id, 
                    bezirke.name AS bezirke_name,
                    DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn,
                    DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende,
                    DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von,
                    DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis,
					joborders.publisher_type,
					joborders.publisher_id,
					joborders.kunde_name, 
                    dienstleister.firmenwortlaut AS dienstleister_firmenwortlaut,
                    dienstleister.website AS dienstleister_website 
                FROM 
                    joborders_gemerkt
                LEFT JOIN 
                    joborders ON joborders.id = joborders_gemerkt.joborders_id 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = joborders.dienstleister_id 
                LEFT JOIN 
                    bezirke ON bezirke.id = joborders.bezirke_id 
                WHERE 
                    joborders_gemerkt.ressources_id=:id
            ");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $gemerkte = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            for($i=0;$i<count($gemerkte);$i++){
                $sth = $db->prepare("SELECT berufsfelder.id FROM relation_joborders_berufsfelder LEFT JOIN 
                    berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
                $sth->bindParam(':id', $gemerkte[$i]['id'], PDO::PARAM_INT);
                $sth->execute();
                $gemerkte[$i]['berufsfelder'] = array();
                foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($gemerkte[$i]['berufsfelder'], $a['id']);}
										
				if ($gemerkte[$i]['publisher_type'] == "kunde"){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
					$sth->bindParam(':id', $gemerkte[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();
					$gemerkte[$i]['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
					
					$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='kunde' AND bewertet_id=:bewertet_id AND status=1");
					$sth->bindParam(':bewertet_id', $gemerkte[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();

					$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					
					$gemerkte[$i]['kunde_name_inkl_bewertung'] = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

					$rating = number_format($gemerkte[$i]['kunde_name_inkl_bewertung'], 2, ",", "");

					$gemerkte[$i]['kunde_name_inkl_bewertung'] = $gemerkte[$i]['kunde_name'] . " (★ $rating)";
				}
				if ($gemerkte[$i]['publisher_type'] == "kunde"){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
					$sth->bindParam(':id', $gemerkte[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();
					$gemerkte[$i]['kunde_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];

					$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='kunde' AND bewertet_id=:bewertet_id AND status=1");
					$sth->bindParam(':bewertet_id', $gemerkte[$i]['publisher_id'], PDO::PARAM_INT);
					$sth->execute();

					$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];

					$gemerkte[$i]['kunde_name_inkl_bewertung'] = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

					$rating = number_format($gemerkte[$i]['kunde_name_inkl_bewertung'], 2, ",", "");

					$gemerkte[$i]['kunde_name_inkl_bewertung'] = $gemerkte[$i]['kunde_name'] . " (★ $rating)";
				}

				$sth = $db->prepare("SELECT COUNT(*) AS anz FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id WHERE joborders.arbeitsbeginn <= :ae AND joborders.arbeitsende >= :ab AND bewerbungen.ressources_id=:id");
				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->bindParam(':ab', $gemerkte[$i]['ab'], PDO::PARAM_STR);
				$sth->bindParam(':ae', $gemerkte[$i]['ae'], PDO::PARAM_STR);
				$sth->execute();

				$gemerkte[$i]['joborders_in_zeitraum'] = ($sth->fetchAll(PDO::FETCH_ASSOC)[0]['anz']) ? 1 : 0;

				// DL Rating
				if ($gemerkte[$i]['dienstleister_single']){

					$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type='dienstleister' AND bewertet_id=:bewertet_id AND status=1");
					$sth->bindParam(':bewertet_id', $gemerkte[$i]['dienstleister_id'], PDO::PARAM_INT);
					$sth->execute();

					$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					$gemerkte[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = 
					($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;

					$rating = number_format($gemerkte[$i]['dienstleister_firmenwortlaut_inkl_bewertung'], 2, ",", "");

					$gemerkte[$i]['dienstleister_firmenwortlaut_inkl_bewertung'] = $gemerkte[$i]['dienstleister_firmenwortlaut'] . " (★ $rating)";
				}
            }
            
            $body = json_encode($gemerkte);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });


    $app->post('/ressources', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true]);
        }else{

            include("../../wp-load.php");

            $email = $request->getParsedBody()['email'];
            $passwort = $request->getParsedBody()['passwort'];

            $user_info = array(
                "user_pass"     => $passwort,
                "user_login"    => 'ressource_'.$request->getParsedBody()['vorname'].'_'.$request->getParsedBody()['nachname'].'_'.time(),
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['vorname'].' '.$request->getParsedBody()['nachname'],
                "first_name"    => $request->getParsedBody()['vorname'],
                "last_name"     => $request->getParsedBody()['nachname'],
                "role"          => "ressource"
            );
            
            if (!username_exists($email) && !email_exists($email)) {

                $insert_user_result = wp_insert_user($user_info);

                try{
                    $db = getDB();
                    $sth = $db->prepare("INSERT INTO ressources (email, telefon, vorname, nachname, adresse_strasse_hn, adresse_plz, adresse_ort, skill_fuehrerschein, skill_pkw, skill_berufsabschluss, skill_hoechster_schulabschluss, skill_eu_buerger, skill_rwr_karte, registrations_id) VALUES (:email, :telefon, :vorname, :nachname, :adresse_strasse_hn, :adresse_plz, :adresse_ort, :skill_fuehrerschein, :skill_pkw, :skill_berufsabschluss, :skill_hoechster_schulabschluss, :skill_eu_buerger, :skill_rwr_karte, :registrations_id)");

                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':telefon', $request->getParsedBody()['telefon'], PDO::PARAM_STR);
                    $sth->bindParam(':vorname', $request->getParsedBody()['vorname'], PDO::PARAM_STR);
                    $sth->bindParam(':nachname', $request->getParsedBody()['nachname'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_strasse_hn', $request->getParsedBody()['adresse_strasse_hn'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_plz', $request->getParsedBody()['adresse_plz'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_ort', $request->getParsedBody()['adresse_ort'], PDO::PARAM_STR);
                    $sth->bindParam(':skill_fuehrerschein', $request->getParsedBody()['skill_fuehrerschein'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_pkw', $request->getParsedBody()['skill_pkw'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_berufsabschluss', $request->getParsedBody()['skill_berufsabschluss'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_hoechster_schulabschluss', $request->getParsedBody()['skill_hoechster_schulabschluss'], PDO::PARAM_STR);
                    $sth->bindParam(':skill_eu_buerger', $request->getParsedBody()['skill_eu_buerger'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_rwr_karte', $request->getParsedBody()['skill_rwr_karte'], PDO::PARAM_INT);
                    $sth->bindParam(':registrations_id', $request->getParsedBody()['registrations_id'], PDO::PARAM_INT);

                    $sth->execute();

                    if ($insert_user_result){
                        $user_id = $db->lastInsertId();
                        add_user_meta($insert_user_result, 'staqq_id', $user_id);

                        foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                            $sth = $db->prepare("INSERT INTO relation_ressources_berufsfelder (ressources_id, berufsfelder_id) VALUES (:ressources_id, :berufsfelder_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['berufsgruppen']) as $b){
                            $sth = $db->prepare("INSERT INTO relation_ressources_berufsgruppen (ressources_id, berufsgruppen_id) VALUES (:ressources_id, :berufsgruppen_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':berufsgruppen_id', $b, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['berufsbezeichnungen']) as $z){
                            $sth = $db->prepare("INSERT INTO relation_ressources_berufsbezeichnungen (ressources_id, berufsbezeichnungen_id) VALUES (:ressources_id, :berufsbezeichnungen_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':berufsbezeichnungen_id', $z, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['skills']) as $s){
                            $sth = $db->prepare("INSERT INTO relation_ressources_skills (ressources_id, skills_items_id) VALUES (:ressources_id, :skills_items_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':skills_items_id', $s, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['regionen']) as $r){
                            $sth = $db->prepare("INSERT INTO relation_ressources_bezirke (ressources_id, bezirke_id) VALUES (:ressources_id, :bezirke_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':bezirke_id', $r, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['dl_gecastet']) as $c){
                            $sth = $db->prepare("INSERT INTO castings (ressources_id, dienstleister_id, ressources_verify, dienstleister_verify) VALUES (:ressources_id, :dienstleister_id, 1, 0)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':dienstleister_id', $c, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        foreach (json_decode($request->getParsedBody()['dl_blacklist']) as $l){
                            $sth = $db->prepare("INSERT INTO relation_ressources_dienstleister_blacklist (ressources_id, dienstleister_id) VALUES (:ressources_id, :dienstleister_id)");
                            $sth->bindParam(':ressources_id', $user_id, PDO::PARAM_INT);
                            $sth->bindParam(':dienstleister_id', $l, PDO::PARAM_INT);
                            $sth->execute();
                        }

                        $body = json_encode(['status' => true, 'id' => $user_id]);
                    }

                } catch(PDOException $e){
                    $response->withStatus(400);
                    $body = json_encode(['status' => false, 'msg' => $e]);//"Unbekannter Fehler!"]);
                }
            } else {
                $response->withStatus(400);
                $body = json_encode(['status' => false, 'msg' => "Benutzer existiert bereits"]);
            }
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/ressources/{id}', function($request, $response, $args) {
        
        if(filter_var($request->getParsedBody()['debug'], FILTER_VALIDATE_BOOLEAN)){
            $body = json_encode(['status' => true, 'body' => $request->getParsedBody()]);
        }else{

            include("../../wp-load.php");
            
            $email_old = $request->getParsedBody()['old_email'];
            $email = $request->getParsedBody()['email'];
            
            if (($email_old == $email) || (!isset($request->getParsedBody()['old_email']))) {
                $updateEmail = false;
                $user_id = email_exists($email);
            }else{
                $updateEmail = true;
                $user_id = email_exists($email_old);
            }

            $user_info = array(
                "ID"            => $user_id,
                "user_nicename" => "",
                "user_email"    => $email,
                "display_name"  => $request->getParsedBody()['vorname'].' '.$request->getParsedBody()['nachname'],
                "first_name"    => $request->getParsedBody()['vorname'],
                "last_name"     => $request->getParsedBody()['nachname'],
                "role"          => "ressource"
            );

            if ((email_exists($email) && (!$updateEmail)) || ((!email_exists($email)) && $updateEmail)) {

                $insert_user_result = wp_update_user($user_info);

                try{
                    $db = getDB();
                    $sth = $db->prepare("UPDATE ressources SET email=:email, telefon=:telefon, vorname=:vorname, nachname=:nachname, adresse_strasse_hn=:adresse_strasse_hn, adresse_plz=:adresse_plz, adresse_ort=:adresse_ort, skill_fuehrerschein=:skill_fuehrerschein, skill_pkw=:skill_pkw, skill_berufsabschluss=:skill_berufsabschluss, skill_hoechster_schulabschluss=:skill_hoechster_schulabschluss, skill_eu_buerger=:skill_eu_buerger, skill_rwr_karte=:skill_rwr_karte WHERE id=:id");

                    $sth->bindParam(':email', $request->getParsedBody()['email'], PDO::PARAM_STR);
                    $sth->bindParam(':telefon', $request->getParsedBody()['telefon'], PDO::PARAM_STR);
                    $sth->bindParam(':vorname', $request->getParsedBody()['vorname'], PDO::PARAM_STR);
                    $sth->bindParam(':nachname', $request->getParsedBody()['nachname'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_strasse_hn', $request->getParsedBody()['adresse_strasse_hn'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_plz', $request->getParsedBody()['adresse_plz'], PDO::PARAM_STR);
                    $sth->bindParam(':adresse_ort', $request->getParsedBody()['adresse_ort'], PDO::PARAM_STR);
                    $sth->bindParam(':skill_fuehrerschein', $request->getParsedBody()['skill_fuehrerschein'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_pkw', $request->getParsedBody()['skill_pkw'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_berufsabschluss', $request->getParsedBody()['skill_berufsabschluss'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_hoechster_schulabschluss', $request->getParsedBody()['skill_hoechster_schulabschluss'], PDO::PARAM_STR);
                    $sth->bindParam(':skill_eu_buerger', $request->getParsedBody()['skill_eu_buerger'], PDO::PARAM_INT);
                    $sth->bindParam(':skill_rwr_karte', $request->getParsedBody()['skill_rwr_karte'], PDO::PARAM_INT);
                    $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    $sth = $db->prepare("DELETE FROM relation_ressources_berufsfelder WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();
                    
                    foreach (json_decode($request->getParsedBody()['berufsfelder']) as $f){
                        $sth = $db->prepare("INSERT INTO relation_ressources_berufsfelder (ressources_id, berufsfelder_id) VALUES (:ressources_id, :berufsfelder_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':berufsfelder_id', $f, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    $sth = $db->prepare("DELETE FROM relation_ressources_berufsgruppen WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['berufsgruppen']) as $b){
                        $sth = $db->prepare("INSERT INTO relation_ressources_berufsgruppen (ressources_id, berufsgruppen_id) VALUES (:ressources_id, :berufsgruppen_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':berufsgruppen_id', $b, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    $sth = $db->prepare("DELETE FROM relation_ressources_berufsbezeichnungen WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['berufsbezeichnungen']) as $z){
                        $sth = $db->prepare("INSERT INTO relation_ressources_berufsbezeichnungen (ressources_id, berufsbezeichnungen_id) VALUES (:ressources_id, :berufsbezeichnungen_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':berufsbezeichnungen_id', $z, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    $sth = $db->prepare("DELETE FROM relation_ressources_skills WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['skills']) as $s){
                        $sth = $db->prepare("INSERT INTO relation_ressources_skills (ressources_id, skills_items_id) VALUES (:ressources_id, :skills_items_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':skills_items_id', $s, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    $sth = $db->prepare("DELETE FROM relation_ressources_bezirke WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['regionen']) as $r){
                        $sth = $db->prepare("INSERT INTO relation_ressources_bezirke (ressources_id, bezirke_id) VALUES (:ressources_id, :bezirke_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':bezirke_id', $r, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    foreach (json_decode($request->getParsedBody()['dl_gecastet']) as $c){
                        
                        $sth = $db->prepare("INSERT INTO castings (ressources_id, dienstleister_id, ressources_verify, dienstleister_verify) VALUES(:ressources_id, :dienstleister_id, 1, 0) ON DUPLICATE KEY UPDATE    
ressources_verify=1");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':dienstleister_id', $c, PDO::PARAM_INT);
                        $sth->execute();
                    }
                    
                    $sth = $db->prepare("DELETE FROM relation_ressources_dienstleister_blacklist WHERE ressources_id=:ressources_id");
                    $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                    $sth->execute();

                    foreach (json_decode($request->getParsedBody()['dl_blacklist']) as $l){
                        $sth = $db->prepare("INSERT INTO relation_ressources_dienstleister_blacklist (ressources_id, dienstleister_id) VALUES (:ressources_id, :dienstleister_id)");
                        $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
                        $sth->bindParam(':dienstleister_id', $l, PDO::PARAM_INT);
                        $sth->execute();
                    }

                    $body = json_encode(['status' => true]);
                    
                } catch(PDOException $e){
                    $response->withStatus(400);
                    $body = json_encode(['status' => false, 'msg' => $e]);
                }
            } else {
                $response->withStatus(400);
                $body = json_encode(['status' => false, 'msg' => "Die E-Mail-Adresse wird schon von einem anderen Benutzer verwendet!"]);
            }
        }
        
        $response->write($body);
        return $response;
        
    });
    
    $app->get('/ressources/{id}/castings', function($request, $response, $args) {
        
        try{
            $db = getDB();
            $sth = $db->prepare("
                SELECT 
                    dienstleister.firmenwortlaut,
                    dienstleister.id,
					dienstleister.ansprechpartner_vorname as dienstleister_vorname,
					dienstleister.ansprechpartner_nachname as dienstleister_nachname,
                    castings.dienstleister_verify,
                    castings.ressources_verify,
                    DATE_FORMAT(castings.dienstleister_datetime,'%d.%m.%Y') AS dienstleister_datetime,
                    DATE_FORMAT(castings.ressources_datetime,'%d.%m.%Y') AS ressources_datetime,
					dienstleister_user.vorname as dienstleister_user_vorname,
					dienstleister_user.nachname as dienstleister_user_nachname
                FROM 
                    castings 
                LEFT JOIN 
                    dienstleister ON dienstleister.id = castings.dienstleister_id 
                LEFT JOIN 
                    dienstleister_user ON dienstleister_user.id = castings.dienstleister_user_id 
                WHERE 
                    castings.ressources_id = :ressources_id
            ");
            
            $sth->bindParam(':ressources_id', $args['id'], PDO::PARAM_INT);
            $sth->execute();
            $castings = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
            
            $body = json_encode($castings);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
    });

    $app->put('/ressources/{id}/acceptAGB', function($request, $response, $args) {
        try{
            $db = getDB();
            $sth = $db->prepare("UPDATE ressources SET agb_accept=1 WHERE id=:id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();

            $body = json_encode(['status' => true]);

        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/ressources/{id}/changePasswort', function($request, $response, $args) {
        
        include("../../wp-load.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        $passwort_neu = $request->getParsedBody()['passwort_neu'];
        $passwort_alt = $request->getParsedBody()['passwort_alt'];
        
        $res = wp_signon(array('user_login' => $email, 'user_password' => $passwort_alt, 'remember' => false));
        
        if ($passwort_neu != "" && $passwort_alt != ""){
                        
            if (gettype($res->data) == "object"){
                wp_set_password($passwort_neu, $user_id);
                $body = json_encode(['status' => true]);
            }else{
                $body = json_encode(['status' => false, 'msg' => 'Das alte Passwort stimmt nicht.']);
            }
            
        }else{
            $body = json_encode(['status' => false, 'msg' => 'Das alte und neue Passwort darf nicht leer sein!']);
        }
            
        $response->write($body);
        return $response;
        
    });

    $app->post('/ressources/{id}/requestDelete', function($request, $response, $args) {
        
        $db = getDB();
        $sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");
        $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $sth->execute();
        $res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)[0]);
        
        $html  = "<p>Hallo STAQQ-Team!</p>";
        $html .= "<p>Anfrage zur Account-Löschung einer <strong>Ressource:</strong></p>";
        $html .= "<table>";
        $html .= "<tr><th>ID</th><td>".$res['id']."</td></tr>";
        $html .= "<tr><th>Vorname</th><td>".$res['vorname']."</td></tr>";
        $html .= "<tr><th>Nachname</th><td>".$res['nachname']."</td></tr>";
        $html .= "<tr><th>E-Mail</th><td>".$res['email']."</td></tr>";
        $html .= "</table>";
        
        $body = json_encode(['status' => sendMail(API_STAQQ_EMAIL, "Account löschen", $html, '')]);
        $response->write($body);
        return $response;
    });

    $app->delete('/ressources/{id}', function($request, $response, $args) {
        
        include("../../wp-load.php");
		include("../../wp-admin/includes/user.php");
        
        $email        = $request->getParsedBody()['email'];
        $user_id      = email_exists($email);
        		
		if (wp_delete_user($user_id)){
			try{
				$db = getDB();
				$sth = $db->prepare("DELETE FROM ressources WHERE id=:id LIMIT 1");

				$sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
				$sth->execute();
				$body = json_encode(['status' => true]);

			} catch(PDOException $e){
				$response->withStatus(400);
				$body = json_encode(['status' => false, 'msg' => $e]);
			}
		}else{
        	$body = json_encode(['status' => false, 'msg' => 'WP-User konnte nicht gelöscht werden!']);
		}
		
        $response->write($body);
        return $response;
    });


?>