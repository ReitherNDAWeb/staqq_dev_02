<?php

    /**
     *   Template Name: STAQQ / App / Joborders / Ressources
     */

    require_once get_template_directory().'/inc/funktionen.php';
    require_once get_template_directory().'/vendor/restclient.php';
    
    if ($_POST['action'] == "casting"){

        $response = $api->post("castings", [
            'ressources_id' => $_POST['ressources_id'],
            'dienstleister_id' => $_POST['dienstleister_id'],
            'dienstleister_verify' => 1,
            'empfehlung' => $_POST['empfehlung'],
			'creator_id' => $_POST['creator_id'],
			'creator_type' => $_POST['creator_type']
        ])->decode_response();
		
		if ($response->status){
			wp_redirect('app/joborders/ressourcen/?id='.hashId($_GET['id']));
			exit;
		}
        
    } else if ($_POST['action'] == "vergeben"){
        
        $jid = $_POST['joborders_id'];
        $rid = $_POST['ressources_id'];
        
        $response = $api->put("joborders/$jid/bewerbungen/ressources/$rid/vergeben", [
            'dienstleister_id' => $_POST['dienstleister_id']
        ])->decode_response();
		
		if ($response->status){
			wp_redirect('app/joborders/ressourcen/?id='.hashId($_GET['id']));
			exit;
		}
        
    }  else if ($_POST['action'] == "ablehnen"){
        
        $jid = $_POST['joborders_id'];
        $rid = $_POST['ressources_id'];
        
        $response = $api->put("joborders/$jid/bewerbungen/ressources/$rid/ablehnen", [
            'dienstleister_id' => $_POST['dienstleister_id']
        ])->decode_response();
		
		if ($response->status){
			wp_redirect('app/joborders/ressourcen/?id='.hashId($_GET['id']));
			exit;
		}
        
    } else if ($_POST['action'] == "einsatz_verify"){
        
        $response = $api->put("/bewerbungen/einsatzVerify/dienstleister", [
            'ressources_id' => $_POST['ressources_id'],
            'joborders_id' => $_POST['joborders_id']
        ])->decode_response();
		
		if ($response->status){
			
			if ($response->rechnung){
				wp_redirect($response->rechnungslink);
			} else {
				wp_redirect('app/joborders/ressourcen/?id='.hashId($_GET['id']));
			}
			exit;
		}
        
    } else if ($_GET['action'] == "csv_export"){
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=staqq_export.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
        
        $ressourcen = $api->get("joborders/{$_GET['id']}/bewerbungen/ressources", [])->decode_response();
		
        $outputBuffer = fopen("php://output", 'w');
		$delimiter = ";";
		
		fputcsv($outputBuffer, array(
			'ressources_id', 
			'vorname', 
			'nachname', 
			'status',
			'telefon', 
			'email',
			'adresse_strasse_hn',
			'adresse_plz',
			'adresse_ort',
			'bewerbungen_id',
			'casting_intern',
			'casting_extern',
			'dienstleister_einsatz_bestaetigt',
			'ressource_einsatz_bestaetigt',
			'skill_fuehrerschein',
			'skill_pkw',
			'skill_berufsabschluss',
			'skill_hoechster_schulabschluss',
			'berufsfelder',
			'berufsgruppen',
			'berufsbezeichnungen',
			'skills',
			'einsatzorte_namen',
			'bewertung_anzahl_bewertungen',
			'bewertung_summe_punkte',
			'bewertung_durchschnitt'
		), $delimiter);
		
		foreach($ressourcen as $r){
			fputcsv($outputBuffer, array(
				$r->ressources_id, 
				$r->vorname, 
				$r->nachname, 
				$r->status,
				$r->telefon, 
				$r->email,
				$r->adresse_strasse_hn,
				$r->adresse_plz,
				$r->adresse_ort,
				$r->bewerbungen_id,
				$r->casting_intern,
				$r->casting_extern,
				$r->dienstleister_einsatz_bestaetigt,
				$r->ressource_einsatz_bestaetigt,
				$r->skill_fuehrerschein,
				$r->skill_pkw,
				$r->skill_berufsabschluss,
				$r->skill_hoechster_schulabschluss,
				implode(", ", $r->berufsfelder),
				implode(", ", $r->berufsgruppen),
				implode(", ", $r->berufsbezeichnungen),
				implode(", ", $r->skills),
				implode(", ", $r->einsatzorte_namen),
				$r->bewertung->anzahl_bewertungen,
				$r->bewertung->summe_punkte,
				$r->bewertung->durchschnitt
			), $delimiter);
		}
        fclose($outputBuffer);
		
		exit;
        
    }



    get_header();

    $id = decodeId($_GET['id']);
    $joborder = $api->get("joborders/$id", [])->decode_response();
    $ressources = $api->get("joborders/$id/bewerbungen/ressources", [])->decode_response();

	$job_bereits_vergeben = (intval($joborder->anzahl_bewerbungen_einsatz_bestaetigt) + intval($joborder->anzahl_bewerbungen_vergeben)) == intval($joborder->anzahl_ressourcen);
    
?>
   
    <seciton class="section joborder-ressources">
        <div class="section__overlay">
            <div class="section__wrapper section__wrapper--full-width">
                <article class="gd gd--12">
                  	<?php $back = isset($_GET['from']) ? ($_GET['from']."#".$_GET['from_hash']) : "/app/joborders/detail/?id=".hashId($id); ?>
                    <a href="<?php echo $back; ?>" class="button">Zurück</a>
                </article>
                
                <?php if($job_bereits_vergeben){ ?>
                <article class="gd gd--12 joborder-detail__bewerbungs-status">
                	<p style="margin:0px;">Alle Ressourcen (<?php echo $joborder->anzahl_ressourcen; ?>) wurden besetzt!</p>
				</article>
               	<?php } ?>
                
                <?php if($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){ ?>
                <article class="gd gd--12">
                	<a href="/app/joborders/ressourcen/?id=<?php echo $id; ?>&action=csv_export" class="button">CSV Export</a>
				</article>
               	<?php } ?>
               	
                <article class="gd gd--12">
                    
                    <table class="table ressources-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Rating <i class="icon icon--tooltip tooltip" title="Durchschnitt / Anzahl an Bewertungen"></i></th>
                                <th>Status</th>
                                <?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user") echo '<th>Dienstleister</th>'; ?>
                                <?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user") echo '<th>Vorstellungsgespräch</th>'; ?>
                                <th>Ressource Details</th>
                                <?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user") echo '<th>Vorstellungsgespräch bestätigen</th>'; ?>
                                <?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user") echo '<th>Job vergeben</th>'; ?>
                                
                                <?php if(!$job_bereits_vergeben){ ?>
                                <th>ablehnen</th>
                                <? } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;
                                foreach($ressources as $r){
                                    
										$i++;
                            ?>
                            <tr>
                               
                                <td><?php echo $r->vorname . " " . $r->nachname; ?></td>
                                <td>
                                	<?php echo $r->bewertung->durchschnitt; ?> / <?php echo $r->bewertung->anzahl_bewertungen; ?>
                                </td>
                                <td><?php 
									if ($r->status == "beworben") echo "Beworben"; 
									if ($r->status == "vergeben") echo "An Ressource vergeben"; 
									if ($r->status == "einsatz_bestaetigt"){
										if(intval($r->ressource_einsatz_bestaetigt) == 0 || intval($r->dienstleister_einsatz_bestaetigt) == 0){
											echo "Bewerber hat Einsatz zugestimmt (Erfolgter Einsatz noch nicht bestätigt)";
										}else{
											echo "Erfolgter Einsatz bestätigt";
										}
									}
								?></td>
                              
                              	<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"): ?>
                              	<td>
                              		<?php echo $r->dienstleister_firmenwortlaut; ?>
                              	</td>
                              	<?php endif; ?>
                              
                               
                                <?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user") { ?>
                                <td><?php echo (intval($r->casting_intern) == 1 || intval($r->casting_extern) == 1) ? "Ja" : "Nein"; if (intval($r->casting_intern) == 1 || intval($r->casting_extern) == 1) echo (intval($r->casting_intern) == 1) ? " (selbst gecastet)" : " (von einem anderem Dienstleister)"; ?></td>
                                <?php } ?>
                                
                                <td>
                                    <button class="button" onclick="openRemodal(<?php echo $r->id; ?>);">Informationen</button>
                                    <div id="ressources-id--<?php echo $r->id; ?>" class="remodal-ressource-details">
                                        
                                        <h2>Matching</h2>
                                        <p>N = nicht zu bewerten, da nicht angegeben</p>
                                        
                                        <table class="table">
                                            <tbody class="remodal-ressource-details__matching">
                                                <tr>
                                                    <th>Berufsfelder</th>
                                                    <td colspan="3"><?php echo $r->score->parts->BF->any ? $r->score->parts->BF->relation."%" : "N"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Berufsgruppen</th>
                                                    <td colspan="3"><?php echo $r->score->parts->BG->any ? $r->score->parts->BG->relation."%" : "N"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Berufsbezeichnungen</th>
                                                    <td colspan="3"><?php echo $r->score->parts->BB->any ? $r->score->parts->BB->relation."%" : "N"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>muss</th>
                                                    <th>soll</th>
                                                    <th>kann</th>
                                                </tr>
                                                <tr>
                                                    <th>Skills</th>
                                                    <td><?php echo $r->score->parts->SK_MUSS->any ? $r->score->parts->SK_MUSS->relation."%" : "N"; ?></td>
                                                    <td><?php echo $r->score->parts->SK_SOLL->any ? $r->score->parts->SK_SOLL->relation."%" : "N"; ?></td>
                                                    <td><?php echo $r->score->parts->SK_KANN->any ? $r->score->parts->SK_KANN->relation."%" : "N"; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <p>&nbsp;</p>
                                        <h2>Informationen</h2>
                                        <table class="table remodal-ressource-details__infos">
                                            <tbody>
                                                <tr>
                                                    <th>Vorname</th>
                                                    <td><?php echo $r->vorname; ?></td>
                                                    <th>E-Mail</th>
                                					<td><a href="mailto:<?php echo $r->email; ?>"><?php echo $r->email; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Nachname</th>
                                                    <td><?php echo $r->nachname; ?></td>
                                                    <th>Telefon</th>
                                                    <td><?php echo $r->telefon; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Führerschein</th>
                                                    <td><?php echo ($r->skill_fuehrerschein == "1") ? "Ja" : "Nein"; ?></td>
                                                    <th>Eigener PKW</th>
                                                    <td><?php echo ($r->skill_pkw == "1") ? "Ja" : "Nein"; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Berufsabschluss</th>
                                                    <td><?php echo ($r->skill_berufsabschluss == "1") ? "Ja" : "Nein"; ?></td>
                                                    <th>Höchster Schulabschluss</th>
                                                    <td><?php echo $r->skill_hoechster_schulabschluss; ?></td>
                                                </tr>
                                                <tr>
                                                	<th>Berufsfelder</th>
                                                	<td colspan="3"><?php echo implode(", ", $r->berufsfelder); ?></td>
                                                </tr>
                                                <tr>
                                                	<th>Berufsgruppen</th>
                                                	<td colspan="3"><?php echo implode(", ", $r->berufsgruppen); ?></td>
                                                </tr>
                                                <tr>
                                                	<th>Berufsbezeichnungen</th>
                                                	<td colspan="3"><?php echo implode(", ", $r->berufsbezeichnungen); ?></td>
                                                </tr>
                                                <tr>
                                                	<th>Skills</th>
                                                	<td colspan="3"><?php echo implode(", ", $r->skills); ?></td>
                                                </tr>
                                                <tr>
                                                	<th>Gewünschte Einsatzorte</th>
                                                	<td colspan="3"><?php echo implode(", ", $r->einsatzorte_namen); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
										<p>&nbsp;</p>
										<h2>Bewertung</h2>
                                        <table class="table remodal-ressource-details__infos">
                                            <tbody>
                                                <tr>
                                                    <td><strong><?php echo $r->bewertung->durchschnitt; ?></strong> Punkte im Durchschnitt aus insgesamt <srong><?php echo $r->bewertung->anzahl_bewertungen; ?></srong> Bewertungen</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        
                                        <?php if (count($r->castings) > 0): ?>
										<p>&nbsp;</p>
										<h2>Vorstellungsgespräche</h2>
                                        <table class="table remodal-ressource-details__infos">
                                            <tbody>
                                      			<?php foreach($r->castings as $item){ ?>
                                                <tr>
                                                    <td><?php 
														echo $item->firmenwortlaut;
														echo (intval($item->empfehlung) && ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user")) == 1 ? ' (mit Empfehlung)' : '';							 
													?>
                                               		</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user") { ?>
                                <td>
                                    <?php if (intval($r->casting_intern) == 0 && intval($r->casting_intern_not_verified) == 0){ ?>
                                       
                                    	<?php if ($wpUserRole == "ressource") { ?>
                                       
                                        <form action="" method="post">
                                            <input type="hidden" name="action" value="casting">
                                            <input type="hidden" name="dienstleister_id" value="<?php echo $r->dienstleister_id; ?>">
                                            <input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                            
                                            <button class="button" type="submit">Vorstellungsgespräch bestätigen</button>
                                        </form>
                                        
                                        <?php }else{ ?>
                                        
                                        <form action="" method="post" style="margin-bottom: 10px;">
                                            <input type="hidden" name="action" value="casting">
                                            <input type="hidden" name="dienstleister_id" value="<?php echo $r->dienstleister_id; ?>">
                                            <input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                            <input type="hidden" name="empfehlung" value="0">
                                            <input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
                                            <input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
                                            <!-- als DL -->
                                            <button class="button" type="submit">Vorstellungsgespräch bestätigen</button>
                                        </form>
                                        
                                        <form action="" method="post">
                                            <input type="hidden" name="action" value="casting">
                                            <input type="hidden" name="dienstleister_id" value="<?php echo $r->dienstleister_id; ?>">
                                            <input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                            <input type="hidden" name="empfehlung" value="1">
                                            <input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
                                            <input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
                                            <!-- als DL -->
                                            <button class="button" type="submit">Vorstellungsgespräch bestätigen und für Einsatz empfohlen</button>
                                        </form>
                                        
                                        <?php } ?>
                                    <?php }elseif(intval($r->casting_intern_not_verified) == 1){ ?>
                                        Vorstellungsgespräch von Bewerber noch nicht bestätigt
                                    <?php }else{ ?>
                                        Vorstellungsgespräch bestätigt
                                    <?php } ?>
                                </td>
                                
                                <td>
                                    <?php if (intval($r->casting_intern) == 0 && intval($r->casting_extern) == 0) { ?>
										Bewerber ist noch nicht gecastet
									<?php }elseif($r->status == "beworben"){ ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="action" value="vergeben">
                                        <input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
                                        <input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                        <input type="hidden" name="dienstleister_id" value="<?php echo $r->dienstleister_id; ?>">
                                        <?php if (!$job_bereits_vergeben) { ?><button class="button" type="submit">Job vergeben</button><?php } ?>
                                    </form>
                                    <?php
										}else{ 
											if (($r->status == "einsatz_bestaetigt") && ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user")){
									
												if(intval($r->dienstleister_einsatz_bestaetigt) == 0){
									?>
										<form action="" method="post">
											<input type="hidden" name="action" value="einsatz_verify">
											<input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
											<input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                   			<button class="button" type="submit">Arbeitsbeginn bestätigen</button>
                                    	</form>
									<?php
												}else{
													if (intval($r->ressource_einsatz_bestaetigt) == 1){
														echo "Der erfolgte Einsatz wurde beidseitig bestätigt";
													}else{
														echo "Erfolgter Einsatz bestätigt / Warten auf Bestätigung des Bewerbers";
													}
												}
											}else{
												echo "Job an diesen Bewerber vergeben";
											}
										} 
									?>
                                </td>
                                <?php } ?>
                                
                                <td>
                                    <?php if($r->status == "beworben" && !$job_bereits_vergeben){ ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="action" value="ablehnen">
                                        <input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
                                        <input type="hidden" name="ressources_id" value="<?php echo $r->id; ?>">
                                        <input type="hidden" name="dienstleister_id" value="<?php echo $r->dienstleister_id; ?>">
                                        <button class="button" type="submit">ablehnen</button>
                                    </form>
                                    <?php } elseif($r->status == "abgelehnt"){
											echo "Bewerber wurde abgelehnt";
										}
									 ?>
								</td>
                            </tr>
                            <?php 
								}
							?>
                        </tbody>
                    </table>
                </article>
            </div>
        </div>
    </seciton>
    
    <script>
        
        jQuery(document).ready(function(){
            jQuery('.remodal-ressource-details').remodal();
        });
        
        function openRemodal (id){
            jQuery('#ressources-id--'+id).remodal().open();
        }
        
		jQuery(document).ready(function(){
			jQuery('.ressources-table').DataTable({
				'paging': false,
				'language': {
					'lengthMenu': "Zeige _MENU_ Eintragungen pro Seite",
					'zeroRecords': "Filterung - keine Ergebnisse",
					'info': "Seite _PAGE_ von _PAGES_",
					'infoEmpty': "Kein Übereinstimmung gefunden",
					'infoFiltered': "(filtered from _MAX_ total records)",
					'search': "Tabelle filtern: ",
					'searchPlaceholder': "Suchtext"
				}
			});
		});
	</script>
    
    
    
<?php

    get_footer();

?>
               
                    