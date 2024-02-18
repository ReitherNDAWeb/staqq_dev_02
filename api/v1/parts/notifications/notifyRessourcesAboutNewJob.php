<?php

$jo_id = $_SERVER['argv'][1];

require_once (__DIR__) . '/../../../config.php';
require_once (__DIR__) . '/../../functions.php';

try{
	$db = getDB();
	$sth = $db->prepare("SELECT * FROM ressources WHERE job_alert = 'instant'");
	$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
	$sth->execute();
	$alle_res = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));

	foreach($alle_res as $res){

		$res_id = $res['id'];

		$sth = $db->prepare("SELECT berufsfelder.id FROM relation_ressources_berufsfelder LEFT JOIN berufsfelder ON berufsfelder.id = relation_ressources_berufsfelder.berufsfelder_id WHERE relation_ressources_berufsfelder.ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['berufsfelder'] = array();
		foreach($arr as $a){array_push($res['berufsfelder'], $a['id']);}

		$sth = $db->prepare("SELECT berufsgruppen.id FROM relation_ressources_berufsgruppen LEFT JOIN berufsgruppen ON berufsgruppen.id = relation_ressources_berufsgruppen.berufsgruppen_id WHERE relation_ressources_berufsgruppen.ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['berufsgruppen'] = array();
		foreach($arr as $a){array_push($res['berufsgruppen'], $a['id']);}

		$sth = $db->prepare("SELECT berufsbezeichnungen.id FROM relation_ressources_berufsbezeichnungen LEFT JOIN berufsbezeichnungen ON berufsbezeichnungen.id = relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id WHERE relation_ressources_berufsbezeichnungen.ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['berufsbezeichnungen'] = array();
		foreach($arr as $a){array_push($res['berufsbezeichnungen'], $a['id']);}

		$sth = $db->prepare("SELECT skills_items.id FROM relation_ressources_skills LEFT JOIN skills_items ON skills_items.id = relation_ressources_skills.skills_items_id WHERE relation_ressources_skills.ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['skills'] = array();
		foreach($arr as $a){array_push($res['skills'], $a['id']);}

		$sth = $db->prepare("SELECT bezirke.id FROM relation_ressources_bezirke LEFT JOIN bezirke ON bezirke.id = relation_ressources_bezirke.bezirke_id WHERE relation_ressources_bezirke.ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['bezirke'] = array();
		foreach($arr as $a){array_push($res['bezirke'], $a['id']);}

		$sth = $db->prepare("SELECT dienstleister_id FROM relation_ressources_dienstleister_blacklist WHERE ressources_id=:id");
		$sth->bindParam(':id', $res_id, PDO::PARAM_INT);
		$sth->execute();
		$arr = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
		$res['dl_blacklist'] = array();
		foreach($arr as $a){array_push($res['dl_blacklist'], $a['dienstleister_id']);}

		if(!is_null($res['bezirke']) && $res['bezirke'] !='' ){
			$bezirke_ids = "('" . implode('\',\'', array_map('intval', $res['bezirke']) ) . "')";
		}
		else  {$bezirke_ids = "('0')"; }

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
				WHERE 
				joborders.bezirke_id IN $bezirke_ids
				AND  joborders.id = :id
				");
			$sth->bindParam(':id', $jo_id, PDO::PARAM_INT);
			$sth->execute();
			$joborders = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC));
			
			if (count($joborders) > 0){
				$joborder = $joborders[0];

				if (!(intval($joborder['dienstleister_vorgegeben']) == 1 && in_array($joborder['dienstleister_id'], $res['dl_blacklist']))){

					if ((intval($joborder['skill_pkw']) <= intval($res['skill_pkw'])) && (intval($joborder['skill_fuehrerschein']) <= intval($res['skill_fuehrerschein'])) && (intval($joborder['skill_berufsabschluss']) <= intval($res['skill_berufsabschluss']))){

						$sth = $db->prepare("SELECT berufsfelder.id FROM relation_joborders_berufsfelder LEFT JOIN 
							berufsfelder ON berufsfelder.id = relation_joborders_berufsfelder.berufsfelder_id WHERE relation_joborders_berufsfelder.joborders_id=:id");
						$sth->bindParam(':id', $joborder['id'], PDO::PARAM_INT);
						$sth->execute();
						$joborder['berufsfelder'] = array();
						foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborder['berufsfelder'], $a['id']);}

						$machtedBerufsfelder = 0;

						foreach ($joborder['berufsfelder'] as $x){
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
							$sth->bindParam(':id', $joborder['id'], PDO::PARAM_INT);
							$sth->execute();
							$joborder['berufsgruppen'] = array();
							foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborder['berufsgruppen'], $a['id']);}

							$machtedBerufsgruppen = 0;

							foreach ($joborder['berufsgruppen'] as $x){
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
								$sth->bindParam(':id', $joborder['id'], PDO::PARAM_INT);
								$sth->execute();

								$joborder['skills_muss'] = array();
								foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $a){array_push($joborder['skills_muss'], $a['id']);}
								
								if (count(array_diff($joborder['skills_muss'], $res['skills'])) == 0){

									if($joborder['publisher_type'] == 'dienstleister'){
										$publisher = $joborder['dienstleister_firmenwortlaut'];
									}else{
										if (intval($joborder['kunde_anzeigen'])){
											$sth = $db->prepare("SELECT firmenwortlaut FROM kunden WHERE id=:id");
											$sth->bindParam(':id', $joborder['publisher_id'], PDO::PARAM_INT);
											$sth->execute();
											$publisher = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['firmenwortlaut'];
										}else{
											$publisher = "Kunde";
										}								}

										$text = "$publisher sucht {$joborder['jobtitel']} von {$joborder['arbeitsbeginn']} bis {$joborder['arbeitsende']}!";

										fireNotification(array(
											'receiver_type'	=> 'ressource', 
											'receiver_id' 	=> $res_id,
											'titel' 		=> 'Neues Jobangebot', 
											'subtitle'		=> $text,
											'nachricht' 	=> $text, 
											'kategorie' 	=> 'joborders', 
											'link_web' 		=> "/app/joborders/details/?id=".hashId($jo_id), 
											'link_mobile' 	=> "/ressource/joborders/$jo_id", 
											'send_web' 		=> true, 
											'send_mobile' 	=> true,
											'force' 		=> false
											));
									}
								}
							}
						}      
					}	
				}
			}
		} catch(PDOException $e){	

		}
?>