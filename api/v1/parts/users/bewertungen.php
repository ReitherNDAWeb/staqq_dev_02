<?php

    $app->get('/bewertungen/{user_type}/{id}', function($request, $response, $args) {
        
        try{
            $db = getDB();
			
			$table = $args['user_type'];
			$id = $args['id'];
			
			$sth = $db->prepare("
				SELECT 
					bewertungen.*, 
					bewertungen.status, 
					bewertungen.bewertung, 
					bewertungen.von_type, 
					bewertungen.von_id, 
					bewertungen.von_id, 
					joborders.jobtitel,
					joborders.kunde_name, 
					joborders.publisher_id,
					joborders.publisher_type,
					DATE_FORMAT(joborders.arbeitsbeginn, '%d.%m.%Y') AS joborders_arbeitsbeginn, 
					DATE_FORMAT(joborders.arbeitsende, '%d.%m.%Y') AS joborders_arbeitsende
				FROM 
					bewertungen 
				LEFT JOIN
					joborders ON joborders.id = bewertungen.joborders_id 
				WHERE 
					von_type=:bewertet_type AND von_id=:bewertet_id 
				ORDER BY
					joborders.arbeitsende DESC
			");
			$sth->bindParam(':bewertet_id', $args['id'], PDO::PARAM_INT);
			$sth->bindParam(':bewertet_type', $args['user_type'], PDO::PARAM_INT);
            $sth->execute();
			$bewertungen = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$ressources = array();
			$dienstleister = array();
			$kunden = array();
			
			for($i=0;$i<count($bewertungen);$i++){
				
				// Name
				if ($bewertungen[$i]['bewertet_type'] == 'ressource'){
					$sth = $db->prepare("SELECT CONCAT (vorname, ' ', nachname) AS name FROM ressources WHERE id=".$bewertungen[$i]['bewertet_id']);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister'){
					$sth = $db->prepare("SELECT firmenwortlaut AS name FROM dienstleister WHERE id=".$bewertungen[$i]['bewertet_id']);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister_user'){
					$sth = $db->prepare("SELECT dienstleister.firmenwortlaut AS name FROM dienstleister_user LEFT JOIN dienstleister ON dienstleister.id = dienstleister_user.dienstleister_id WHERE dienstleister_user.id=".$bewertungen[$i]['bewertet_id']);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'kunde'){
					$sth = $db->prepare("SELECT firmenwortlaut AS name FROM kunden WHERE id=".$bewertungen[$i]['bewertet_id']);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'kunde_user'){
					$sth = $db->prepare("SELECT kunden.firmenwortlaut AS name FROM kunden_user LEFT JOIN kunden ON kunden.id = kunden_user.kunden_id WHERE kunden_user.id=".$bewertungen[$i]['bewertet_id']);
				}
				
				$sth->execute();
				$bewertungen[$i]['bewertet_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['name'];
				
				// Ressourcen
				$bewertungen[$i]['ressources'] = array();
				
				if ($bewertungen[$i]['von_type'] != 'ressource' && $bewertungen[$i]['bewertet_type'] != 'ressource'){
					
					if ($bewertungen[$i]['von_type'] == 'dienstleister'){
						$dienstleister_id = $bewertungen[$i]['von_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister'){
						$dienstleister_id = $bewertungen[$i]['bewertet_id'];
					} elseif ($bewertungen[$i]['von_type'] == 'dienstleister_user'){
						$sth = $db->prepare("SELECT dienstleister_id FROM dienstleister_user WHERE id=".$bewertungen[$i]['von_id']);
						$sth->execute();
						$dienstleister_id = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['dienstleister_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister_user'){
						$sth = $db->prepare("SELECT dienstleister_id FROM dienstleister_user WHERE id=".$bewertungen[$i]['bewertet_id']);
						$sth->execute();
						$dienstleister_id = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['dienstleister_id'];
					}
					
					$sth = $db->prepare("
						SELECT 
							CONCAT(ressources.vorname, ' ', ressources.nachname) AS name 
						FROM 
							bewerbungen 
						LEFT JOIN 
							ressources ON ressources.id = bewerbungen.ressources_id 
						WHERE 
							bewerbungen.joborders_id=:joborders_id AND 
							bewerbungen.dienstleister_id=:dienstleister_id AND 
							bewerbungen.status = 'einsatz_bestaetigt'
					");
					$sth->bindParam(':joborders_id', $bewertungen[$i]['joborders_id'], PDO::PARAM_INT);
					$sth->bindParam(':dienstleister_id', $dienstleister_id, PDO::PARAM_INT);
					$sth->execute();
					foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $r){
						array_push($bewertungen[$i]['ressources'], $r['name']);
					}
				}
				
				
				// Dienstleister
				$bewertungen[$i]['dienstleister'] = new stdClass();
				
				if (($bewertungen[$i]['von_type'] == 'ressource') || ($bewertungen[$i]['bewertet_type'] == 'ressource')){
					
					if ($bewertungen[$i]['von_type'] == 'ressource'){
						$ressources_id = $bewertungen[$i]['von_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'ressource'){
						$ressources_id = $bewertungen[$i]['bewertet_id'];
					}
					
					$sth = $db->prepare("
						SELECT 
							dienstleister.id, 
							dienstleister.firmenwortlaut 
						FROM 
							bewerbungen 
						LEFT JOIN 
							dienstleister ON dienstleister.id = bewerbungen.dienstleister_id 
						WHERE 
							bewerbungen.ressources_id=:ressources_id AND bewerbungen.joborders_id=:joborders_id
					");
					$sth->bindParam(':joborders_id', $bewertungen[$i]['joborders_id'], PDO::PARAM_INT);
					$sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
					$sth->execute();
					$bewertungen[$i]['dienstleister'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				}
				
				
				// Kunde
				$bewertungen[$i]['kunde'] = array(
					'id' => null,
					'firmenwortlaut' => $bewertungen[$i]['kunde_name'],
					'staqq_database' => false
				);
				
				if ($bewertungen[$i]['publisher_type'] == 'kunde'){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=".$bewertungen[$i]['publisher_id']);
					$sth->execute();
					$bewertungen[$i]['kunde']['firmenwortlaut'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
					$bewertungen[$i]['kunde']['id'] = $bewertungen[$i]['publisher_id'];
					$bewertungen[$i]['kunde']['staqq_database'] = true;
				}
				
				// Aufteilen
				if ($bewertungen[$i]['bewertet_type'] == 'ressource'){
					array_push($ressources, $bewertungen[$i]);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister' || $bewertungen[$i]['bewertet_type'] == 'dienstleister_user'){
					array_push($dienstleister, $bewertungen[$i]);
				} elseif ($bewertungen[$i]['bewertet_type'] == 'kunde' || $bewertungen[$i]['bewertet_type'] == 'kunde_user'){
					array_push($kunden, $bewertungen[$i]);
				}
				
				
			}
			
			$sth = $db->prepare("SELECT COUNT(*) AS anzahl, COALESCE(SUM(bewertung), 0) AS punkte FROM bewertungen WHERE bewertet_type=:bewertet_type AND bewertet_id=:bewertet_id AND status=1");
			$sth->bindParam(':bewertet_id', $args['id'], PDO::PARAM_INT);
			$sth->bindParam(':bewertet_type', $args['user_type'], PDO::PARAM_INT);
            $sth->execute();
			
			$gesamt = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			$durchschnitt = ($gesamt['punkte']/$gesamt['anzahl']) ? ($gesamt['punkte']/$gesamt['anzahl']) : 0;
			
			$body = json_encode(['anzahl_bewertungen' => $gesamt['anzahl'], 'summe_punkte' => $gesamt['punkte'], 'durchschnitt' => $durchschnitt, 'bewertungen' => ['alle' => $bewertungen, 'ressources' => $ressources, 'dienstleister' => $dienstleister, 'kunden' => $kunden]]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
		
        $response->write($body);
        return $response;
        
    });

	$app->get('/bewertungen/{user_type}/{id}/bekommen', function($request, $response, $args) {
        
        try{
            $db = getDB();
			
			$table = $args['user_type'];
			$id = $args['id'];
			
			$sth = $db->prepare("
				SELECT 
					bewertungen.*, 
					bewertungen.status, 
					bewertungen.bewertung, 
					bewertungen.von_type, 
					bewertungen.von_id, 
					bewertungen.von_id, 
					joborders.jobtitel,
					joborders.kunde_name, 
					joborders.publisher_id,
					joborders.publisher_type,
					DATE_FORMAT(joborders.arbeitsbeginn, '%d.%m.%Y') AS joborders_arbeitsbeginn, 
					DATE_FORMAT(joborders.arbeitsende, '%d.%m.%Y') AS joborders_arbeitsende
				FROM 
					bewertungen 
				LEFT JOIN
					joborders ON joborders.id = bewertungen.joborders_id 
				WHERE 
					bewertet_type=:bewertet_type AND bewertet_id=:bewertet_id AND bewertungen.status=1
				ORDER BY
					joborders.arbeitsende DESC
			");
			$sth->bindParam(':bewertet_id', $args['id'], PDO::PARAM_INT);
			$sth->bindParam(':bewertet_type', $args['user_type'], PDO::PARAM_INT);
            $sth->execute();
			$bewertungen = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$ressources = array();
			$dienstleister = array();
			$kunden = array();
			
			for($i=0;$i<count($bewertungen);$i++){
				
				// Name
				if ($bewertungen[$i]['von_type'] == 'ressource'){
					$sth = $db->prepare("SELECT CONCAT (vorname, ' ', nachname) AS name FROM ressources WHERE id=".$bewertungen[$i]['von_id']);
				} elseif ($bewertungen[$i]['von_type'] == 'dienstleister'){
					$sth = $db->prepare("SELECT firmenwortlaut AS name FROM dienstleister WHERE id=".$bewertungen[$i]['von_id']);
				} elseif ($bewertungen[$i]['von_type'] == 'dienstleister_user'){
					$sth = $db->prepare("SELECT dienstleister.firmenwortlaut AS name FROM dienstleister_user LEFT JOIN dienstleister ON dienstleister.id = dienstleister_user.dienstleister_id WHERE dienstleister_user.id=".$bewertungen[$i]['von_id']);
				} elseif ($bewertungen[$i]['von_type'] == 'kunde'){
					$sth = $db->prepare("SELECT firmenwortlaut AS name FROM kunden WHERE id=".$bewertungen[$i]['von_id']);
				} elseif ($bewertungen[$i]['von_type'] == 'kunde_user'){
					$sth = $db->prepare("SELECT kunden.firmenwortlaut AS name FROM kunden_user LEFT JOIN kunden ON kunden.id = kunden_user.kunden_id WHERE kunden_user.id=".$bewertungen[$i]['von_id']);
				}
				
				$sth->execute();
				$bewertungen[$i]['von_name'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['name'];
				
				// Ressourcen
				$bewertungen[$i]['ressources'] = array();
				
				if ($bewertungen[$i]['von_type'] != 'ressource' && $bewertungen[$i]['bewertet_type'] != 'ressource'){
					
					if ($bewertungen[$i]['von_type'] == 'dienstleister'){
						$dienstleister_id = $bewertungen[$i]['von_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister'){
						$dienstleister_id = $bewertungen[$i]['bewertet_id'];
					} elseif ($bewertungen[$i]['von_type'] == 'dienstleister_user'){
						$sth = $db->prepare("SELECT dienstleister_id FROM dienstleister_user WHERE id=".$bewertungen[$i]['von_id']);
						$sth->execute();
						$dienstleister_id = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['dienstleister_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'dienstleister_user'){
						$sth = $db->prepare("SELECT dienstleister_id FROM dienstleister_user WHERE id=".$bewertungen[$i]['bewertet_id']);
						$sth->execute();
						$dienstleister_id = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['dienstleister_id'];
					}
					
					$sth = $db->prepare("
						SELECT 
							CONCAT(ressources.vorname, ' ', ressources.nachname) AS name 
						FROM 
							bewerbungen 
						LEFT JOIN 
							ressources ON ressources.id = bewerbungen.ressources_id 
						WHERE 
							bewerbungen.joborders_id=:joborders_id AND 
							bewerbungen.dienstleister_id=:dienstleister_id AND 
							bewerbungen.status = 'einsatz_bestaetigt'
					");
					$sth->bindParam(':joborders_id', $bewertungen[$i]['joborders_id'], PDO::PARAM_INT);
					$sth->bindParam(':dienstleister_id', $dienstleister_id, PDO::PARAM_INT);
					$sth->execute();
					foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $r){
						array_push($bewertungen[$i]['ressources'], $r['name']);
					}
				}
				
				
				// Dienstleister
				$bewertungen[$i]['dienstleister'] = new stdClass();
				
				if (($bewertungen[$i]['von_type'] == 'ressource') || ($bewertungen[$i]['bewertet_type'] == 'ressource')){
					
					if ($bewertungen[$i]['von_type'] == 'ressource'){
						$ressources_id = $bewertungen[$i]['von_id'];
					} elseif ($bewertungen[$i]['bewertet_type'] == 'ressource'){
						$ressources_id = $bewertungen[$i]['bewertet_id'];
					}
					
					$sth = $db->prepare("
						SELECT 
							dienstleister.id, 
							dienstleister.firmenwortlaut 
						FROM 
							bewerbungen 
						LEFT JOIN 
							dienstleister ON dienstleister.id = bewerbungen.dienstleister_id 
						WHERE 
							bewerbungen.ressources_id=:ressources_id AND bewerbungen.joborders_id=:joborders_id
					");
					$sth->bindParam(':joborders_id', $bewertungen[$i]['joborders_id'], PDO::PARAM_INT);
					$sth->bindParam(':ressources_id', $ressources_id, PDO::PARAM_INT);
					$sth->execute();
					$bewertungen[$i]['dienstleister'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				}
				
				
				// Kunde
				$bewertungen[$i]['kunde'] = array(
					'id' => null,
					'firmenwortlaut' => $bewertungen[$i]['kunde_name'],
					'staqq_database' => false
				);
				
				if ($bewertungen[$i]['publisher_type'] == 'kunde'){
					$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=".$bewertungen[$i]['publisher_id']);
					$sth->execute();
					$bewertungen[$i]['kunde']['firmenwortlaut'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
					$bewertungen[$i]['kunde']['id'] = $bewertungen[$i]['publisher_id'];
					$bewertungen[$i]['kunde']['staqq_database'] = true;
				}
				
				
				
				
				
				
				
				
				
				
				
				// Aufteilen
				if ($bewertungen[$i]['von_type'] == 'ressource'){
					array_push($ressources, $bewertungen[$i]);
				} elseif ($bewertungen[$i]['von_type'] == 'dienstleister' || $bewertungen[$i]['von_type'] == 'dienstleister_user'){
					array_push($dienstleister, $bewertungen[$i]);
				} elseif ($bewertungen[$i]['von_type'] == 'kunde' || $bewertungen[$i]['von_type'] == 'kunde_user'){
					array_push($kunden, $bewertungen[$i]);
				}
			}
			
			$body = json_encode(['alle' => $bewertungen, 'ressources' => $ressources, 'dienstleister' => $dienstleister, 'kunden' => $kunden]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
		
        $response->write($body);
        return $response;
        
    });

    $app->post('/bewertungen', function($request, $response, $args) {
        
        try{
            $db = getDB();
			
            $sth = $db->prepare("INSERT INTO bewertungen (bewertet_type, bewertet_id, von_type, von_id, joborders_id, bewertung, status) VALUES (:bewertet_type, :bewertet_id, :von_type, :von_id, :joborders_id, 0, 0)");
            $sth->bindParam(':bewertet_type', $request->getParsedBody()['bewertet_type'], PDO::PARAM_STR);
            $sth->bindParam(':bewertet_id', $request->getParsedBody()['bewertet_id'], PDO::PARAM_INT);
            $sth->bindParam(':von_type', $request->getParsedBody()['von_type'], PDO::PARAM_STR);
            $sth->bindParam(':von_id', $request->getParsedBody()['von_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->execute();
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

    $app->put('/bewertungen', function($request, $response, $args) {
        
        try{
            $db = getDB();
			
            $sth = $db->prepare("UPDATE bewertungen SET bewertung=:bewertung, status=1 WHERE bewertet_type=:bewertet_type AND bewertet_id=:bewertet_id AND von_type=:von_type AND von_id=:von_id AND joborders_id=:joborders_id");
			
            $sth->bindParam(':bewertung', $request->getParsedBody()['bewertung'], PDO::PARAM_INT);
            $sth->bindParam(':bewertet_type', $request->getParsedBody()['bewertet_type'], PDO::PARAM_STR);
            $sth->bindParam(':bewertet_id', $request->getParsedBody()['bewertet_id'], PDO::PARAM_INT);
            $sth->bindParam(':von_type', $request->getParsedBody()['von_type'], PDO::PARAM_STR);
            $sth->bindParam(':von_id', $request->getParsedBody()['von_id'], PDO::PARAM_INT);
            $sth->bindParam(':joborders_id', $request->getParsedBody()['joborders_id'], PDO::PARAM_INT);
            $sth->execute();
            $body = json_encode(['status' => true]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['status' => false, 'msg' => $e]);
        }
        
        $response->write($body);
        return $response;
        
    });

?>