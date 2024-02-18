<?php

    require_once get_template_directory().'/vendor/restclient.php';
    
    if ($_POST['action'] == "ressource_bewerben"){
        
        $info_dl_vorgegeben = true;
		$info_dl_single = true;
        
        if (isset($_POST['from_list'])){
            if (intval($_POST['dienstleister_vorgegeben']) == 0){
                $info_dl_vorgegeben = false;
            }
            if (intval($_POST['dienstleister_single']) == 0){
                $info_dl_single = false;
            }
        }
        
        if ($info_dl_vorgegeben && $info_dl_single){
            
            $response = $api->post("bewerbungen", [
                'ressources_id' => $_POST['ressources_id'],
                'joborders_id' => $_POST['joborders_id'],
                'dienstleister_id' => $_POST['dienstleister_id']
            ])->decode_response();
			
            wp_redirect('app/joborders'); exit;
            
        }
        
    } elseif ($_POST['action'] == "ressource_merken"){
        
        $id = $_POST['joborders_id'];
        $response = $api->post("joborders/$id/merken", [
            'ressources_id' => $_POST['ressources_id']
        ])->decode_response();
        
        wp_redirect('app/joborders'); exit;
        
    } elseif ($_POST['action'] == "ressource_ablehnen"){
        
        $id = $_POST['joborders_id'];
        $response = $api->post("joborders/$id/ablehnen", [
            'ressources_id' => $_POST['ressources_id']
        ])->decode_response();
        
        wp_redirect('app/joborders'); exit;
        
    }


    /**
     *   Template Name: STAQQ / App / Joborders / Detail
     */

    get_header();

    //if (!($wpUserSTAQQUser && $wpUserState)) wp_redirect('Location: /', 302);
        
    $id = decodeId($_GET['id']);
    $joborder = $api->get("joborders/$id", [])->decode_response();
    $bewerbungsCheck = $api->get("joborders/$id/bewerbungsCheck/$wpUserSTAQQId", [])->decode_response();
    $dienstleister = $api->get("dienstleister", [])->decode_response();

    $skills = array();
    if ($joborder->skill_fuehrerschein == "1") array_push($skills, "Führerschein");
    if ($joborder->skill_pkw == "1") array_push($skills, "Eigener PKW");
    if ($joborder->skill_berufsabschluss == "1") array_push($skills, "Berufsabschluss");
    foreach($joborder->skills as $s){array_push($skills, $s->name . " (".$s->praedikat.")");}
    $berufsfelder = array();
    foreach($joborder->berufsfelder as $b){array_push($berufsfelder, $b->name);}
    $berufsgruppen = array();
    foreach($joborder->berufsgruppen as $b){array_push($berufsgruppen, $b->name);}
    
    $dienstleister_auswahl = $joborder->dienstleister_auswahl;

    
?>
   
    <seciton class="section joborder-detail">
        <div class="section__overlay">
            
            <div class="section__wrapper joborder-detail__section joborder-detail__section--1">
                <article class="gd gd--12">
                    <a href="/app/joborders/" class="button">Zurück zur Liste</a>
                </article>
                
                <?php if($info_dl_vorgegeben): ?>
                <article class="gd gd--12 joborder-detail__bewerbungs-status">
                    <h2>Es muss ein Dienstleister ausgewählt werden!</h2>
                </article>
                <?php endif; ?>
            	
               	<!-- Ressource -->
                <?php if($bewerbungsCheck->status && $wpUserRole == "ressource"): ?>
					<article class="gd gd--12 joborder-detail__bewerbungs-status">
						<h2>Joborder Status: <span><?php echo $bewerbungsCheck->bewerbung->status; ?></span></h2>
					</article>
                <?php endif; ?>
                           	
               	<!-- Dienstleister -->
                <?php if($wpUserRole == "dienstleister" || ($wpUserRole == "dienstleister_user" && $userBerechtigungen->berechtigung_joborders_schalten)): ?>
                <article class="gd gd--12 joborder-detail__bewerbungs-status">
                    <h2>Beworbene Ressourcen: <span><?php echo $joborder->anzahl_bewerbungen_gesamt; ?></span></h2>
                    <?php if ($joborder->anzahl_bewerbungen_gesamt > 0): ?><a style="float: right;" href="/app/joborders/ressourcen/?id=<?php echo hashId($id); ?>" class="button">Ressourcen anzeigen</a><?php endif; ?>
                </article>
                <?php endif; ?>
                           	
               	<!-- Kunde -->
				<?php if($wpUserRole == "kunde" || ($wpUserRole == "kunde_user" && $userBerechtigungen->berechtigung_joborders_schalten)): ?>
					<article class="gd gd--12 joborder-detail__bewerbungs-status">
					<?php if ($joborder->anzahl_bewerbungen_einsatz_bestaetigt == $joborder->anzahl_ressourcen){ ?>
						<h2>Die Ressourcen wurden vom Dienstleister für Sie ausgewählt:</h2>
						<a style="float: right;" href="/app/joborders/ressourcen/?id=<?php echo hash($id); ?>" class="button">Ressourcen anzeigen</a>
					<?php }else{ ?>
						<h2>Der Dienstleister sucht zurzeit nach passenden Ressourcen für Sie!</h2>
					<?php } ?>
					</article>
				<?php endif; ?>
                
                
                
                <article class="gd gd--12 joborder-detail__header">
                    <i class="icon icon--joborder-detail icon--berufsfeld-<?php echo $joborder->berufsfelder[0]->id; ?>"></i>
                    <h1><?php echo $joborder->jobtitel; ?></h1>
                    <p><strong>Berufsfelder:</strong> <?php echo implode("<span>&bull;</span>", $berufsfelder); ?></p>
                    <p><strong>Berufsgruppen:</strong> <?php echo implode("<span>&bull;</span>", $berufsgruppen); ?></p>
                </article>
                
                <?php if (($bewerbungsCheck->bewerbung->status == "einsatz_bestaetigt" && $wpUserRole == "ressource") || $wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
                <article class="gd gd--12 joborder-detail__einsatz_adresse">
                    <h2>Einsatzort</h2>
                    <p>
                    	<strong><?php echo $joborder->kunde_name; ?></strong><br />
                    	<?php echo $joborder->adresse_strasse_hn; ?><br />
                    	<?php echo $joborder->adresse_plz . " " . $joborder->adresse_ort; ?>
                    </p>
                </article>
                <?php } ?>
                
                <article class="gd gd--8">
                    <?php if(($joborder->kunde_anzeigen && ($wpUserRole != "kunde" && $wpUserRole != "kunde_user")) || ($wpUserRole == "dienstleister")){ ?>
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->kunde_website ? "<a href='$joborder->kunde_website' target='_blank'>$joborder->kunde_name</a>" : $joborder->kunde_name; ?></h3>
                        <p>Kunde</p>
                    </div>
                    <?php } ?>
                    
                    <?php if($joborder->kunde_rating->bool && $wpUserRole != "kunde" && $wpUserRole != "kunde_user"){ ?>
                    <div class="joborder-detail__item">
                        <h3><strong><?php echo $joborder->kunde_rating->durchschnitt; ?></strong> aus <?php echo $joborder->kunde_rating->anzahl_bewertungen; ?> Bewertungen</h3>
                        <p>Kunden-Rating</p>
                    </div>
                	<?php } ?>
                	
					<?php if (($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user") && ($joborder->publisher_type == "kunde")){ 
						
						if ($joborder->creator_type == "kunde"){
							$kunde = $api->get("kunden/$joborder->creator_id", [])->decode_response();
							
							$kontakt_name = $kunde->ansprechpartner_anrede . " ";
							$kontakt_name .= $kunde->ansprechpartner_titel ? $kunde->ansprechpartner_titel . " " : "";
							$kontakt_name .= $kunde->ansprechpartner_vorname . " " . $kunde->ansprechpartner_nachname;
							$kontakt_email = '<a href="mailto:'.$kunde->email.'">'.$kunde->email.'</a>';
							$kontakt_telefon = $kunde->ansprechpartner_telefon;
							$kontakt_website = '<a href="'.$kunde->website.'" target="_blank">'.$kunde->website.'</a>';
							
						}elseif($joborder->creator_type == "kunde_user"){
							$kid = $joborder->publisher_id;
							$kunde = $api->get("kunden/$kid/user/$joborder->creator_id", [])->decode_response();
							
							$kontakt_name = $kunde->anrede . " ";
							$kontakt_name .= $kunde->titel ? $kunde->titel . " " : "";
							$kontakt_name .= $kunde->vorname . " " . $kunde->nachname;
							$kontakt_email = '<a href="mailto:'.$kunde->email.'">'.$kunde->email.'</a>';
							$kontakt_telefon = $kunde->telefon;
							
							$web = $api->get("kunden/$kid", [])->decode_response()->website;
							$kontakt_website = '<a href="'.$web.'" target="_blank">'.$web.'</a>';
						}
					?>
					<div class="joborder-detail__item">
						<h3>
							<?php echo $kontakt_name; ?><br>
							<span style="font-weight: normal;"><?php echo $kontakt_telefon; ?></span><br>
							<span style="font-weight: normal;"><?php echo $kontakt_email; ?></span><br>
							<span style="font-weight: normal;"><?php echo $kontakt_website; ?></span>
						</h3>
						<p>Kunde Kontakt</p>
					</div>
					<?php } ?>
                    
                    <?php if($wpUserRole != "dienstleister"): ?>
                    <div class="joborder-detail__item">
                        <h3><?php 
							
							if (intval($joborder->anzahl_bewerbungen_einsatz_bestaetigt) > 0){
								
								echo "<a href='{$joborder->eingesetzter_dienstleister->website}' target='_blank'>{$joborder->eingesetzter_dienstleister->firmenwortlaut_inkl_bewertung}</a>";
								
							}else{


								if (intval($joborder->dienstleister_single)){
									echo "<a href='{$joborder->dienstleister_website}' target='_blank'>{$joborder->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
								}else{

									if ($wpUserRole == "ressource" && $bewerbungsCheck->status){
										echo "<a href='{$bewerbungsCheck->bewerbung->dienstleister_website}' target='_blank'>{$bewerbungsCheck->bewerbung->dienstleister_firmenwortlaut}</a>";
										if (!intval($joborder->dienstleister_vorgegeben)) echo " (nicht vorgegeben)";
										if (intval($joborder->dienstleister_vorgegeben) && !intval($joborder->dienstleister_single)) echo " (ausgewählt aus Vorgabe)";
									} else {
										if ($joborder->dienstleister_vorgegeben){
											echo "vorgegeben - muss gewählt werden";

											if($wpUserRole != "ressource"){
												echo "(";
												$dienstleister_auswahl_firmenwortlaute = array();
												foreach($dienstleister_auswahl as $dl){array_push($dienstleister_auswahl_firmenwortlaute, $dl->firmenwortlaut);}
												echo implode(", ", $dienstleister_auswahl_firmenwortlaute);
												echo ")";
											}
										}else{
											echo "nicht vorgegeben - muss gewählt werden";
										}
									}
								}

								echo '<input type="hidden" name="dienstleister_id" value="'.$joborder->dienstleister_id.'">';
							
							}
                        ?></h3>
                        <p>Dienstleister</p>
                    </div>
                    <?php endif; ?>
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->bezirke_name; ?><?php if ($joborder->kunde_anzeigen) echo "(".$joborder->adresse_strasse_hn. ", ".$joborder->adresse_plz. " " . $joborder->adresse_ort . ")"; ?></h3>
                        <p>Einsatzort</p>
                    </div>
                    <div class="joborder-detail__item">
                        <h3><?php echo ($joborder->casting == 1) ? 'Ja' : 'Nein'; ?></h3>
                        <p>Kunde wünscht ein Vorstellungsgespräch vor dem Einsatz</p>
                    </div>
                           	
					<!-- Kosten, wenn Dienstleister -->
					<?php if($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"): ?>
					<div class="joborder-detail__item">
						<h3><?php echo "{$joborder->tage} Tage x {$joborder->verrechnungs_kategorien_name} = € {$joborder->kosten}"; ?></h3>
						<p>Preis basierend auf Verrechnungskategorie</p>
					</div>
					<?php endif; ?>
                   
                    <?php if (!intval($joborder->dienstleister_single) && intval($joborder->dienstleister_vorgegeben) && $wpUserRole == "ressource" && $bewerbungsCheck->status == false){ ?>
                    <div class="joborder-detail__dientleister-waehlen">
                        <p>Hier können Sie einen Dienstleister Ihrer Wahl auswählen:</p>
                        <div class="select-wrapper">
                            <select name="dienstleister_id_select" id="dienstleister_id_select">
                        		<option value="" disabled selected>noch kein Dienstleister ausgewählt</option>
                                <?php foreach($dienstleister_auswahl as $dl){ ?>
                                    <option value="<?php echo $dl->id; ?>"><?php echo $dl->firmenwortlaut; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php }elseif(!intval($joborder->dienstleister_single) && !intval($joborder->dienstleister_vorgegeben) && $wpUserRole == "ressource" && $bewerbungsCheck->status == false){ ?>
                    <div class="joborder-detail__dientleister-waehlen">
                        <p>Hier können Sie einen Dienstleister Ihrer Wahl auswählen:</p>
                        <div class="select-wrapper">
                            <select name="dienstleister_id_select" id="dienstleister_id_select">
                        		<option value="" disabled selected>noch kein Dienstleister ausgewählt</option>
                                <?php foreach($dienstleister as $dl){ ?>
                                    <option value="<?php echo $dl->id; ?>"><?php echo $dl->firmenwortlaut; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                </article>
                
                <article class="gd gd--4 clearfix joborder-buttons">
                    
                    <?php if($bewerbungsCheck->status == false && $wpUserRole == "ressource"): ?>
                    
                    <form action="" method="post" id="form-bewerben">
                        <input type="hidden" name="action" value="ressource_bewerben">
                        <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                        <input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
                        <input type="hidden" name="dienstleister_id" value="<?php echo $joborder->dienstleister_id; ?>">
                        <button type="submit" class="tooltip-hover" title="Annehmen">
                            <div class="joborder-button joborder-button--annehmen"></div>
                        </button>
                    </form>
                    <form action="" method="post">
                        <input type="hidden" name="action" value="ressource_merken">
                        <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                        <input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
                        <button type="submit" class="tooltip-hover" title="Merken">
                            <div class="joborder-button joborder-button--merken"></div>
                        </button>
                    </form>
                    <form action="" method="post">
                        <input type="hidden" name="action" value="ressource_ablehnen">
                        <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                        <input type="hidden" name="joborders_id" value="<?php echo $joborder->id; ?>">
                        <button type="submit" class="tooltip-hover" title="Ablehnen">
                            <div class="joborder-button joborder-button--ablehnen"></div>
                        </button>
                    </form>
                
                    <?php endif; ?>
                    
                </article>
            </div>
            
            <div class="section__wrapper joborder-detail__section joborder-detail__section--2">
                <article class="gd gd--4">
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->arbeitsbeginn; ?> - <?php echo $joborder->arbeitsende; ?></h3>
                        <p>Zeitraum</p>
                    </div>
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->arbeitszeitmodell; ?></h3>
                        <p>Arbeitszeitmodell</p>
                    </div>
                </article>
                <article class="gd gd--4">
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->beschaeftigungsarten_name; ?></h3>
                        <p>Beschäftigungsart</p>
                    </div>
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->beschaeftigungsausmasse_name; ?></h3>
                        <p>Beschäftigungsausmaß</p>
                    </div>
                </article>
                <article class="gd gd--4">
                    <!--<div class="joborder-detail__dl-logo"></div>-->
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->brutto_bezug . " / " . $joborder->brutto_bezug_einheit; if ($joborder->brutto_bezug_ueberzahlung == 1) echo " (Überzahlung möglich)";?></h3>
                        <p>Brutto-Bezug</p>
                    </div>
                    <div class="joborder-detail__item">
                        <h3><?php echo $joborder->kollektivvertrag; ?></h3>
                        <p>Kollektivvertrag</p>
                    </div>
                </article>
                
                
            </div>
            
            <div class="section__wrapper">
                <article class="gd gd--4 joborder-detail__box joborder-detail__box--green">
                    <h2>Skills</h2>
                    <article>
                        <p>Sie bringen mit:</p>
                        <ul>
                            <?php
                                foreach($skills as $skill){
                                    echo "<li>$skill</li>";
                                }
                            ?>
                        </ul>
                    </article>
                </article>
                <article class="gd gd--4 joborder-detail__box joborder-detail__box--yellow">
                    <h2>Tätigkeitbeschreibung</h2>
                    <article>
                        <p><?php echo $joborder->taetigkeitsbeschreibung; ?></p>
                    </article>
                </article>
                <article class="gd gd--4 joborder-detail__box joborder-detail__box--orange">
                    <h2>Bewerbungsfrist</h2>
                    <article>
                        <p><?php echo $joborder->bewerbungen_von; ?> - <?php echo $joborder->bewerbungen_bis; ?></p>
                    </article>
                </article>
            </div>
        </div>
    </seciton>
    
    <script>
		
		function writeDLId(){
            jQuery('input[name="dienstleister_id"]').val(jQuery('#dienstleister_id_select').val());
			console.log("writeDLId");
        }

        jQuery(document).ready(function(){
            jQuery('#dienstleister_id_select').change(function(){
                writeDLId();
            });
			
			
			
			<?php if(!intval($joborder->dienstleister_single)){ ?>			
            	writeDLId();
			<?php } ?>
			
			jQuery("form#form-bewerben").submit(function(e) {
				
				if (jQuery('input[name="dienstleister_id"]').val() == ""){
					error("Es muss ein Dienstleister gewählt werden!");
					return false;
				}else{
					return true;
				}
				
			});
        });
	</script>
    
<?php

    get_footer();

?>