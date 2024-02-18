<?php

    /**
     *   Template Name: STAQQ / App / Joborders / New
     */

    require_once get_template_directory().'/vendor/restclient.php';
    
    if ($_POST['action'] == "save"){

        $post_skills = array();        
        if (isset($_POST['skills']) && is_array($_POST['skills'])){
            
			foreach ($_POST['skills'] as $b){
				array_push($post_skills, array(
                    'id' => $b,
                    'praedikat' => $_POST['skills_praedikat_'.$b]
                ));
            }
        }
        
        $response = $api->post("joborders", [
            'jobtitel' => $_POST['jobtitel'],
            'arbeitszeitmodell' => $_POST['arbeitszeitmodell'],
            'arbeitsbeginn' => date('Y-m-d', strtotime($_POST['arbeitsbeginn'])),
            'arbeitsende' => date('Y-m-d', strtotime($_POST['arbeitsende'])),

            'bezirke_id' => $_POST['bezirke'],
            'adresse_strasse_hn' => $_POST['adresse_strasse_hn'],
            'adresse_plz' => $_POST['adresse_plz'],
            'adresse_ort' => $_POST['adresse_ort'],

            'berufsfelder' => json_encode($_POST['berufsfelder']),
            'berufsgruppen' => json_encode($_POST['berufsgruppen']),
            'berufsbezeichnungen' => json_encode($_POST['berufsbezeichnungen']),

            'skills' => json_encode($post_skills),

            'skill_fuehrerschein' => ($_POST['skill_fuehrerschein'] == "on") ? 1 : 0,
            'skill_berufsabschluss' => ($_POST['skill_berufsabschluss'] == "on") ? 1 : 0,
            'skill_pkw' => ($_POST['skill_pkw'] == "on") ? 1 : 0,

            'taetigkeitsbeschreibung' => preg_replace( "/\r|\n/", "", nl2br($_POST['taetigkeitsbeschreibung'])),

            'kollektivvertrag' => $_POST['kollektivvertrag'],
            'brutto_bezug' => '€ ' . $_POST['brutto_bezug'],
            'brutto_bezug_einheit' => $_POST['brutto_bezug_einheit'],
            'brutto_bezug_ueberzahlung' => ($_POST['brutto_bezug_ueberzahlung'] == "on") ? 1 : 0,
			
            'beschaeftigungsarten_id' => $_POST['beschaeftigungsarten_id'],
            'beschaeftigungsausmasse_id' => $_POST['beschaeftigungsausmasse_id'],

            'bewerbungen_von' => date('Y-m-d', strtotime($_POST['bewerbungen_von'])),
            'bewerbungen_bis' => date('Y-m-d', strtotime($_POST['bewerbungen_bis'])),
            'anzahl_ressourcen' => $_POST['anzahl_ressourcen'],

            'casting' => ($_POST['casting'] == "on") ? 1 : 0,
            'vorlage' => ($_POST['vorlage'] == "on") ? 1 : 0,
            'vorlage_name' => $_POST['vorlage_name'],

            'publisher_type' => $_POST['publisher_type'],
            'publisher_id' => $_POST['publisher_id'],

            'creator_type' => $_POST['creator_type'],
            'creator_id' => $_POST['creator_id'],

            'kunde_anzeigen' => ($_POST['kunde_anzeigen'] == "on") ? 1 : 0,
            'kunde_name' => $_POST['kunde_name'],

            'dienstleister_vorgegeben' => $_POST['dienstleister_vorgegeben'],
            'dienstleister_single' => (intval($_POST['dienstleister_vorgegeben']) == 1) ? $_POST['dienstleister_single'] : "0",
            'dienstleister_id' => $_POST['dienstleister_id'],
            'dienstleister_auswahl' => json_encode($_POST['dienstleister_auswahl'])

        ])->decode_response();
        
        if ($response->status) wp_redirect('app/joborders'); exit;
    }

	if ($_GET['template'] == "true" && isset($_GET['id'])){
		$id = $_GET['id'];
		$template = true;
		$template_data = $api->get("templates/$id", [])->decode_response();
	}else{
		$template = false;
		$template_data = new stdClass();
		$template_data->skills = array();
	}

    get_header();

    if (($wpUserSTAQQUser && $wpUserState)){
        
        if (($wpUserRole == "dienstleister") || ($wpUserRole == "kunde") || ($wpUserRole == "dienstleister_user" && $userBerechtigungen->berechtigung_joborders_schalten) || ($wpUserRole == "kunde_user" && $userBerechtigungen->berechtigung_joborders_schalten)){
            
            $berufsfelder = $api->get("berufsfelder", [])->decode_response();
            $berufsgruppen = $api->get("berufsgruppen", [])->decode_response();
            $berufsbezeichnungen = $api->get("berufsbezeichnungen", [])->decode_response();
            $skills_items = $api->get("skills/items", [])->decode_response();
            $skills_kategorien = $api->get("skills/kategorien", [])->decode_response();
            $bezirke = $api->get("bezirke", [])->decode_response();
            $bundeslaender = $api->get("bundeslaender", [])->decode_response();
            $dienstleister = $api->get("dienstleister", [])->decode_response();

            $beschaeftigungsausmasse = $api->get("beschaeftigungsausmasse", [])->decode_response();
            $beschaeftigungsarten = $api->get("beschaeftigungsarten", [])->decode_response();

            if (($wpUserRole == "dienstleister") || ($wpUserRole == "kunde")){
                $publisher_type = $wpUserRole;
                $publisher_id = $wpUserSTAQQId;
				$table = ($publisher_type == "kunde") ? "kunden" : $wpUserRole;
            }else if($wpUserRole == "dienstleister_user"){
                $publisher_type = "dienstleister";
                $publisher_id = $wpUserSTAQQDienstleisterId;
				$table = "dienstleister";
				
				$dl_u = $api->get("dienstleister/$publisher_id/user/$wpUserSTAQQId)", [])->decode_response();
				
				if ($dl_u->einschraenkung_berufsfelder == "1"){
					$berufsfelder = $dl_u->berufsfelder_full;
				}else{
					$berufsfelder = $api->get("dienstleister/$publisher_id)", [])->decode_response()->berufsfelder;
				}
				
				if ($dl_u->einschraenkung_suchgruppen == "1") $berufsgruppen = $dl_u->suchgruppen_full;
				
				
            }else if($wpUserRole == "kunde_user"){
                $publisher_type = "kunde";
                $publisher_id = $wpUserSTAQQKundeId;
				$table = "kunden";
				
				$kuuser = $api->get("kunden/$publisher_id/user/$wpUserSTAQQId)", [])->decode_response();
				
				if ($kuuser->einschraenkung_berufsfelder) $berufsfelder = $kuuser->berufsfelder_full;
				if ($kuuser->einschraenkung_suchgruppen) $berufsgruppen = $kuuser->suchgruppen_full;
            }
			
			$zahlen = $api->get("$table/$publisher_id", [])->decode_response();
			
			if ((($wpUserRole == "kunden" || $wpUserRole == "kunde") && ($zahlen->uid != "" && $zahlen->website != "" && $zahlen->firmensitz_plz > 0 && $zahlen->firmensitz_adresse != "" && $zahlen->firmensitz_ort != "")) || ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user")){
				
				if (intval($zahlen->anzahl_joborders) > 0){
?>
    <seciton class="section joborder-detail">
        <div class="section__overlay">
           
            <form method="post" action="/app/joborders/neu">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
                <input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
                
                <input type="hidden" name="publisher_type" value="<?php echo $publisher_type; ?>">
                <input type="hidden" name="publisher_id" value="<?php echo $publisher_id; ?>">
           
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h1>Neue Joborder</h1>
                </article>
                <article class="gd gd--6">
                    <h2 class="form-headline">Grundinformationen</h2>
                    <input type="text" name="jobtitel" id="jobtitel" placeholder="Jobtitel (pflicht)" value="<?php echo $template_data->jobtitel; ?>" required>
                    <input type="text" name="arbeitszeitmodell" id="arbeitszeitmodell" placeholder="Arbeitszeitmodell (pflicht)" value="<?php echo $template_data->arbeitszeitmodell; ?>" required>
                    <input type="text" name="arbeitsbeginn" id="arbeitsbeginn" placeholder="Arbeitsbeginn (pflicht)" class="datepicker" required>
                    <input type="text" name="arbeitsende" id="arbeitsende" placeholder="Arbeitsende (pflicht)" class="datepicker" required>
                </article>
                <article class="gd gd--6">
                    <h2 class="form-headline">Einsatzort: Matchingkriterium für Bewerber</h2>
                    <div class="select-wrapper">
                        <select name="bundeslaender" id="bundeslaender">
                        	<option value="" disabled selected>Bundesland (pflicht)</option>
							<?php
								foreach ($bundeslaender as $b){
									$selected = ($template_data->bundeslaender_id == $b->id) ? "selected" : "";
									echo '<option value="'.$b->id.'" '.$selected.'>'.$b->name.'</option>';
								}
							?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                       
                        <select name="bezirke" id="bezirke" placeholder="Einsatzort">
                        	<option value="" disabled selected>Bezirk (pflicht)</option>
							<?php
								foreach ($bezirke as $b){
									$selected = ($template_data->bezirke_id == $b->id) ? "selected" : "";
									echo '<option data-bundesland="'.$b->bundeslaender_id.'" value="'.$b->id.'" '.$selected.'>'.$b->name.'</option>';
								}
							?>
                        </select>
                    </div>
                    
                    <br>
                    <h3>Detailinfo zu Einsatzort</h3>
                    <input type="text" name="adresse_strasse_hn" id="adresse_strasse_hn" placeholder="Straße und Hausnummer (pflicht)" value="<?php echo $template_data->adresse_strasse_hn; ?>" required>
                    <input type="text" name="adresse_plz" id="adresse_plz" placeholder="PLZ (pflicht)" value="<?php echo $template_data->adresse_plz; ?>" required>
                    <input type="text" name="adresse_ort" id="adresse_ort" placeholder="Ort (pflicht)" value="<?php echo $template_data->adresse_ort; ?>" required>
                    
                    <?php
                    	if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
							$kunde = $api->get("kunden/$publisher_id)", [])->decode_response();
					?>
                    
                    	<button type="button" class="button" onclick="einsatzortTakeover('<?php echo $kunde->firmensitz_adresse; ?>', '<?php echo $kunde->firmensitz_plz; ?>', '<?php echo $kunde->firmensitz_ort; ?>');">Einsatzort aus Stammdaten übernehmen</button>

                    <?php 
						} 
					?>
                </article>
                <article class="gd gd--12">
                    <h2 class="form-headline">Berufsfelder, -gruppen und -bezeichnungen</h2>
                </article>
                <article class="gd gd--4 berufswahl" id="berufsfelder-wrapper">
                    <h3>Felder (mind. 1)</h3>
                    <div class="berufswahl__items">
                        <?php
							if ($template){
								$template_data->berufsfelder_ids = array();
								foreach ($template_data->berufsfelder as $b){array_push($template_data->berufsfelder_ids, $b->id);}
							}
													   
                            foreach ($berufsfelder as $f){
								if ($template) $check = (in_array($f->id, $template_data->berufsfelder_ids)) ?  "checked" : "";
                                echo '<p><input class="berufsfelder" name="berufsfelder[]" type="checkbox" value="'.$f->id.'" '.$check.'><i class="icon icon--berufswahl icon--berufsfeld-'.$f->id.'"></i>'.$f->name.'</p>';
                            }
                        ?>
                    </div>
                </article>
                <article class="gd gd--4 berufswahl" id="berufsgruppen-wrapper">
                    <h3>Gruppen (mind. 1)</h3>
                    <div class="berufswahl__items">
                        <?php
							if ($template){
								$template_data->berufsgruppen_ids = array();
								foreach ($template_data->berufsgruppen as $b){array_push($template_data->berufsgruppen_ids, $b->id);}
							}
													   
                            foreach ($berufsgruppen as $g){
								if ($template) {
									$check = (in_array($g->id, $template_data->berufsgruppen_ids)) ?  "checked" : "";
									$style = (in_array($g->berufsfelder_id, $template_data->berufsfelder_ids)) ? "block" : "none"; 
								}else{
									$style = "none";
								}
                                echo '<p data-berufsfeld="'.$g->berufsfelder_id.'" style="display: '.$style.';"><input class="berufsgruppen" type="checkbox" name="berufsgruppen[]" value="'.$g->id.'" '.$check.'><i class="icon icon--berufswahl icon--berufsfeld-'.$g->berufsfelder_id.'"></i>'.$g->name;
								if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user") echo '<i class="verrechnungskategorie">'.$g->verrechnungs_kategorien_id.'</i>';
								echo '</p>';
                            }
                        ?>
                    </div>
                </article>
                <article class="gd gd--4 berufswahl" id="berufsbezeichnungen-wrapper">
                    <h3>Bezeichnungen (optional)</h3>
                    <div class="berufswahl__items">
                        <?php
							if ($template){
								$template_data->berufsbezeichnungen_ids = array();
								foreach ($template_data->berufsbezeichnungen as $b){array_push($template_data->berufsbezeichnungen_ids, $b->id);}
							}
												
                            foreach ($berufsbezeichnungen as $z){
								if ($template) {
									$check = (in_array($z->id, $template_data->berufsbezeichnungen_ids)) ?  "checked" : "";
									$style = (in_array($z->berufsgruppen_id, $template_data->berufsgruppen_ids)) ? "block" : "none";
								}else{
									$style = "none";
								}
                                echo '<p data-berufsgruppe="'.$z->berufsgruppen_id.'" style="display: '.$style.';"><input class="berufsbezeichnungen" type="checkbox" name="berufsbezeichnungen[]" value="'.$z->id.'"'.$check.'><i class="icon icon--berufswahl icon--berufsfeld-'.$z->berufsfelder_id.'"></i>'.$z->name;
								if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user") echo '<i class="verrechnungskategorie">'.$z->verrechnungs_kategorien_id.'</i>';
								echo '</p>';
                            }
                        ?>
                    </div>
                </article>
                <article class="gd gd--12">
                    <h2 class="form-headline">Skills (optional)</h2>
                    <p style="font-size:0.9rem;color:#555;">
                    	<strong>muss</strong> = k.o. Kriterium nur jene Beweber die den Skill in ihren Stammdaten hinterlegt haben erhalten diese Joborder
						<br><strong>soll</strong> = kein k.o. Kriterium aber jene Bewerber die diesen Skill in ihren Stammdaten hinterlegt haben werden in der Ansicht der Bewerber vorgereiht.
               			<br><strong>kann</strong> = kein k.o Kriterium
               		</p>
                </article>
                <article class="gd gd--4 skill-chooser">
                    <div class="select-wrapper">
                        <select id="skill-chooser__kategorie">
                            <?php foreach($skills_kategorien as $k){ ?>    
                                <option data-kategorie="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </article>
                <article class="gd gd--4 skill-chooser">
                    <div class="select-wrapper">
                        <select id="skill-chooser__items">
                            <?php foreach($skills_items as $i){ ?>    
                                <option data-kategorie="<?php echo $i->skills_kategorien_id; ?>" value="<?php echo $i->id; ?>" data-name="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </article>
                <article class="gd gd--4">
                    <button type="button" class="button" id="skill-chooser__add">Hinzufügen</button>
                </article>
                <article class="gd gd--12">
                   
                   <div class="selected-skills">
                   	
                   		<?php
							foreach($template_data->skills as $s){
								echo '<p class="selected-skills__item" data-id="'.$s->id.'"><input type="hidden" name="skills[]" value="'.$s->id.'"><span class="name">'.$s->name.'</span><span class="select-wrapper"><select name="skills_praedikat_'.$s->id.'"><option value="kann">kann</option><option value="soll">soll</option><option value="muss">muss</option></select></span><button type="button" onclick="removeSkillFromList('.$s->id.')">X</button></p>';
							}
						?>
                   	
                   </div>
                    
                </article>
                <article class="gd gd--6">
                    <input type="checkbox" name="skill_fuehrerschein" id="skill_fuehrerschein" class="switchable" data-label="Führerschein" <?php echo ($template_data->skill_fuehrerschein) ? "checked" : ""; ?>>
                    <input type="checkbox" name="skill_pkw" id="skill_pkw" class="switchable" data-label="Eigener PKW" <?php echo ($template_data->skill_pkw) ? "checked" : ""; ?>>
                    <input type="checkbox" name="skill_berufsabschluss" id="skill_berufsabschluss" class="switchable" data-label="Berufsabschluss im ausgewählten Berufsfeld" <?php echo ($template_data->skill_berufsabschluss) ? "checked" : ""; ?>>
                </article>
                <article class="gd gd--6">
                    <textarea onkeypress="return event.keyCode;" name="taetigkeitsbeschreibung" id="taetigkeitsbeschreibung" cols="30" rows="10" placeholder="Tätigkeitbeschreibung (pflicht)" required><?php echo str_replace("<br />","\n", $template_data->taetigkeitsbeschreibung); ?></textarea>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--6">
                    <input type="text" name="kollektivvertrag" id="kollektivvertrag" placeholder="Kollektivvertrag (pflicht)" value="<?php echo $template_data->kollektivvertrag; ?>" required>
                    <div  class="input-currency-wrapper">
                        <input type="text" name="brutto_bezug" id="brutto_bezug" placeholder="Brutto-Bezug (pflicht)" value="<?php echo str_replace("€ ", "", $template_data->brutto_bezug); ?>" required>
                    </div>
                    <div class="select-wrapper">
                        <select name="brutto_bezug_einheit" id="brutto_bezug_einheit">
                            <option value="Stunde" <?php if ($template_data->brutto_bezug_einheit == "Stunde") echo "selected"; ?>>Brutto-Bezug pro Stunde</option>
                            <option value="Monat" <?php if ($template_data->brutto_bezug_einheit == "Monat") echo "selected"; ?>>Brutto-Bezug pro Monat</option>
                            <option value="Jahr" <?php if ($template_data->brutto_bezug_einheit == "Jahr") echo "selected"; ?>>Brutto-Bezug pro Jahr</option>
                        </select>
                    </div>
                    
                    
                    <input type="checkbox" name="brutto_bezug_ueberzahlung" id="brutto_bezug_ueberzahlung" class="switchable" data-label="Überzahlung möglich" <?php echo ($template_data->brutto_bezug_ueberzahlung) ? "checked" : ""; ?>>
                    
                    <div class="select-wrapper">
                        <select name="beschaeftigungsausmasse_id" id="beschaeftigungsausmasse_id" placeholder="Beschäftigungsausmaß">
                        <?php
                            foreach ($beschaeftigungsausmasse as $b){
								$selected = ($template_data->beschaeftigungsausmasse_id == $b->id) ? "selected" : "";
                                echo '<option value="'.$b->id.'" '.$selected.'>'.$b->name.'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <select name="beschaeftigungsarten_id" id="beschaeftigungsarten_id" placeholder="Beschäftigungsart">
                        <?php
                            foreach ($beschaeftigungsarten as $b){
								$selected = ($template_data->beschaeftigungsarten_id == $b->id) ? "selected" : "";
                                echo '<option value="'.$b->id.'" '.$selected.'>'.$b->name.'</option>';
                            }
                        ?>
                        </select>
                    </div>
                </article>
                <article class="gd gd--6">
                    <input type="text" name="bewerbungen_von" id="bewerbungen_von" placeholder="Bewerbungen von (pflicht)" class="datepicker" value="<?php echo date('d.m.Y'); ?>" required>
                    <input type="text" name="bewerbungen_bis" id="bewerbungen_bis" placeholder="Bewerbungen bis (pflicht)" class="datepicker" required>
                    <input type="text" name="anzahl_ressourcen" id="anzahl_ressourcen" value="1" placeholder="Anzahl der gesuchten Ressourcen (pflicht)" value="<?php echo $template_data->anzahl_ressourcen; ?>" required>
                    
                    <input type="checkbox" name="casting" class="switchable" id="casting" data-label="Kunde wünscht ein Vorstellungsgespräch vor dem Einsatz" <?php echo ($template_data->casting) ? "checked" : ""; ?>>
                    <input type="checkbox" name="vorlage" id="vorlage" data-label="Joborder als Vorlage speichern">
                    <input type="text" name="vorlage_name" id="vorlage_name" value="" placeholder="Name der Vorlage" style="display:none;">
                </article>
                
                <?php
                    if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){

                        if ($wpUserRole == "kunde_user"){
                            $kunde = $api->get("kunden/$wpUserSTAQQKundeId/user/$wpUserSTAQQId", [])->decode_response();
                            $kunde->dienstleister = $kunde->bevorzugte_dienstleister;
                        }else{
                            $kunde = $api->get("kunden/$wpUserSTAQQId", [])->decode_response();
                        }
                    
                ?>
                	<article class="gd gd--12 joborder-detail__dl-article">
                  		<h2>Dienstleister</h2>
					</article>
                   	<article class="gd gd--12 joborder-detail__dl-article">
						<article class="gd gd--4">
							<div class="select-wrapper">
								<select name="dienstleister_vorgegeben" id="dienstleister_vorgegeben">
									<option value="1" <?php if ($template_data->dienstleister_vorgegeben == "1") echo "selected"; ?>>Dienstleister vorgeben</option>
									<option value="0" <?php if ($template_data->dienstleister_vorgegeben == "0") echo "selected"; ?>>Dienstleister nicht vorgeben</option>
								</select>
							</div>
						</article>
					   <article class="gd gd--8">
							<p>1) vorgeben: Die Bewerber die Ihren Anforderungen entsprechen, erhalten die Information, dass dieser Job ausschließlich über den/die Dienstleister erfolgen kann, den/die Sie in Ihrer Auswahl gewählt haben.</p>
							<p>2) nicht vorgeben: Die Bewerber die Ihren Anforderungen entsprechen, erhalten Ihre Joborder. Der Bewerber informiert bzw. bewirbt sich bei einem Dienstleister seiner Wahl. Der vom Bewerber gewählte Dienstleister wird sich mit Ihnen in Verbindung setzten und Sie informieren, dass sich ein Bewerber der Ihren Anforderungen entspricht beworben hat.</p>
						</article>
                	</article>
                   	<article class="gd gd--12 joborder-detail__dl-article" id="dienstleister_single-wrapper">
					   	<article class="gd gd--4">
					   		<div class="select-wrapper">
                                <select name="dienstleister_single" id="dienstleister_single">
                                    <option value="1" <?php if ($template_data->dienstleister_single == "1") echo "selected"; ?>>Einen einzigen Dienstleister vorgeben</option>
                                    <option value="0" <?php if ($template_data->dienstleister_single == "0") echo "selected"; ?>>Auswahl aus mehreren Dienstleistern vorgeben</option>
                                </select>
                            </div>
						</article>
					   	<article class="gd gd--8">
					   		<p>Sie haben die Möglichkeit einen oder mehrere Dienstleister auszuwählen, über den/die Sie diesen Job besetzten möchten.</p>
						</article>
                	</article>
                   	<article class="gd gd--12 joborder-detail__dl-article" id="dienstleister_auswahl_stamm-wrapper">
					   	<article class="gd gd--4">
					   		<div class="select-wrapper">
                                <select name="dienstleister_auswahl_stamm" id="dienstleister_auswahl_stamm">
                                    <option value="0" <?php if ($template_data->dienstleister_auswahl_stamm == "0") echo "selected"; ?>>Auswahl aus allen Dienstleistern</option>
                                    <option value="1" <?php if ($template_data->dienstleister_auswahl_stamm == "1") echo "selected"; ?>>Auswahl aus Stammdaten</option>
                                </select>
                            </div>
					   		<div class="select-wrapper" id="dienstleister_id-wrapper">
                            
                                <select name="dienstleister_id" id="dienstleister_id">
                                    <?php
                                        foreach ($dienstleister as $d){
                                            echo '<option data-stamm="0" value="'.$d->id.'" >'.$d->firmenwortlaut_inkl_bewertung.'</option>';
                                        }
                        
                                        foreach ($kunde->dienstleister as $d){
                                            echo '<option data-stamm="1" value="'.$d->id.'" >'.$d->firmenwortlaut_inkl_bewertung.'</option>';
                                        }
                                    ?>
                                </select>
                                
                            </div>
                            <div id="dienstleister_auswahl-wrapper" style="display: none;">
                                <select name="dienstleister_auswahl[]" id="dienstleister_auswahl" multiple="multiple">
                                    <?php
                                        foreach ($dienstleister as $d){
                                            echo '<option data-stamm="0" value="'.$d->id.'" >'.$d->firmenwortlaut_inkl_bewertung.'</option>';
                                        }
                        
                                        foreach ($kunde->dienstleister as $d){
                                            echo '<option data-stamm="1" value="'.$d->id.'" >'.$d->firmenwortlaut_inkl_bewertung.'</option>';
                                        }
                        
                                    ?>
                                </select>
                            </div>
						</article>
					   	<article class="gd gd--8">
					   		<p>Sie können zwischen Dienstleistern die bei STAQQ bereits registriert sind und Dienstleistern aus Ihren Stammdaten wählen.</p>
						</article>
                	</article>
                   	<article class="gd gd--12 joborder-detail__dl-article">
					   	<article class="gd gd--4">
                            <input type="hidden" name="kunde_name" id="kunde_name" value="">
                            <input type="checkbox" name="kunde_anzeigen" class="switchable" id="kunde_anzeigen" data-label="Kunde anzeigen" <?php echo ($template_data->kunde_anzeigen) ? "checked" : ""; ?>>
						</article>
					   	<article class="gd gd--8">
					   		<p>Sie haben die Möglichkeit Joborder für Bewerber anonym zu publizieren.</p>
						</article>
                	</article>
                <?php
                    }else{
                ?>
                    <article class="gd gd--12" style="text-align: center;">
                        <div class="form-center">
                            <input type="checkbox" name="kunde_anzeigen" class="switchable" id="kunde_anzeigen" data-label="Kunde anzeigen" <?php echo ($template_data->kunde_anzeigen) ? "checked" : ""; ?>>
                            <input type="text" name="kunde_name" id="kunde_name" placeholder="Kunde (pflicht)" value="<?php echo $template_data->kunde_name; ?>">
                            <input type="hidden" name="dienstleister_vorgegeben" value="1">
                            <input type="hidden" name="dienstleister_single" value="1">
                            <input type="hidden" name="dienstleister_id" value="<?php echo $publisher_id; ?>" />
                        </div>
                        
                    </article>
                
                <?php      
                    }
                ?>
                
                <article class="gd gd--12">
                    <button class="button" type="submit">Joborder publizieren</button>
                </article>
            </div>
            
            </form>
            
        </div>
    </seciton>
    
<?php 

				}else{

?>
		<seciton class="section joborder-detail">
			<div class="section__overlay">
				<div class="section__wrapper">
					<article class="gd gd--12">
						<h1>Sie haben alle Ihre Joborders aufgebraucht!</h1>
						<p>Um neue Jobs schalten zu können müssen Sie ein Joborder-Paket kaufen.</p>
						<a href="/app/verwaltung/pakete/" class="button">Zu den Paketen</a>
					</article>
				</div>
			</div>
		</seciton>
             
<?php			
				}
				
			}else{		
?>
				<seciton class="section joborder-detail">
					<div class="section__overlay">
						<div class="section__wrapper">
							<article class="gd gd--12">
								<h1>Sie müssen Ihre Stammdaten aktualisieren!</h1>
								<p>Um neue Jobs schalten zu können müssen Sie folgende Felder eingetragen haben: UID, Adresse, PLZ, Ort und Website.</p>
								<a href="/app/stammdaten/" class="button">Zu den Stammdaten</a>
							</article>
						</div>
					</div>
				</seciton>
<?php
			}
        
        } else{
        
?>
    <seciton class="section joborder-detail">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
       Keine Erlaubnis
                </article>
            </div>
        </div>
    </seciton>
             
<?php
        }
        
    }else{
        // Not logged in
    }                             
?>
    
    <div id="submit-confirm">
        <table class="table">
            <tbody>
            </tbody>
        </table>
        
        <div class="submit-confirm-kosten" style="display: none;">
        	<div class="submit-confirm-kosten__preis">
        		<h3></h3>
        		<p>Wird ein dem Jobangebot entsprechenden Bewerber von Ihnen an einen Kunden überlassen und wird die Überlassung vom Bewerber und Ihnen bestätigt, wird Ihnen der angeführte €-Betrag in Rechnung gestellt.</p>
        	</div>
        	<div class="submit-confirm-kosten__rechnung">
        		<p class="submit-confirm-kosten__rechnung-laufzeit"></p>
        		<p class="submit-confirm-kosten__rechnung-kategorie"></p>
        	</div>
        </div>
        <p>Nachträgliche Änderungen sind nach dem Publizieren nicht mehr möglich!</p>
        
        <button class="button" style="display: none;" onclick="modalClose();">Weiter bearbeiten</button><span>&nbsp;</span>
        <button class="button" style="display: none;" onclick="submit();">Publizieren</button>
    </div>
    
    <script>
        var remodal = null;
        var self = null;
        
        jQuery(document).ready(function(){
            remodal = jQuery('#submit-confirm').remodal(); 
			
			jQuery('#arbeitsbeginn').change(function(){
				var from = jQuery('#arbeitsbeginn').val().split(".");
				var f = new Date(from[2], from[1] - 1, from[0]);
				jQuery("#arbeitsende").datepicker("destroy");
				jQuery("#arbeitsende").datepicker({
					prevText: '&#x3c;zurück', prevStatus: '',
					prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
					nextText: 'Vor&#x3e;', nextStatus: '',
					nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
					currentText: 'heute', currentStatus: '',
					todayText: 'heute', todayStatus: '',
					clearText: '-', clearStatus: '',
					closeText: 'schließen', closeStatus: '',
					monthNames: ['Januar','Februar','März','April','Mai','Juni',
					'Juli','August','September','Oktober','November','Dezember'],
					monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
					'Jul','Aug','Sep','Okt','Nov','Dez'],
					dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
					dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
					dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
					dateFormat:'dd.mm.yy',
					firstDay: 1,
					defaultDate: f
				});
			});
        });
<?php if (($wpUserRole == "kunde" || $wpUserRole == "kunde_user")){ ?>  
        function writeDLId(){
            jQuery('input[name="dienstleister_id"]').val(jQuery('#dienstleister_id_select').val());
			console.log("writeDLId");
        }

        jQuery(document).ready(function(){
            jQuery('#dienstleister_id_select').change(function(){

                writeDLId();

            });

            writeDLId();
        });
        
<?php } ?>  
        
        function submit(){
			jQuery('#submit-confirm button').hide();
			self.submit();
		}
		
        function modalClose(){console.log("close");remodal.close();}
		
		function einsatzortTakeover(str, plz, ort){
			jQuery('#adresse_strasse_hn').val(str);
			jQuery('#adresse_plz').val(plz);
			jQuery('#adresse_ort').val(ort);
		}
        
        jQuery("form").submit(function(e) {
            self = this;
            e.preventDefault();
            
            var skills = "";
            jQuery('.selected-skills p').each(function(i, e){
                if (i>0) skills += ", ";
                skills += jQuery(this).children('.name').html();
            });
            
            var berufsfelder = "";
            var n=0;
            jQuery('#berufsfelder-wrapper .berufswahl__items p').each(function(i, e){
                if (jQuery(this).children('input').is(':checked')){
                    if (n>0) berufsfelder += ", ";
                    var x = jQuery(this).clone();
                    x.children('input, select').remove();
                    berufsfelder += x.text();
                    n++;
                }
            });
            
            var berufsgruppen = "";
            var berufsgruppen_ids = [];
            var n=0;
            jQuery('#berufsgruppen-wrapper .berufswahl__items p').each(function(i, e){
                if (jQuery(this).children('input').is(':checked')){
                    if (n>0) berufsgruppen += ", ";
                    var x = jQuery(this).clone();
                    x.children('input, select').remove();
                    berufsgruppen += x.text();
					berufsgruppen_ids.push(jQuery(this).children('input').val());
                    n++;
                }
            });
            
            var berufsbezeichnungen = "";
            var berufsbezeichnungen_ids = [];
            var n=0;
            jQuery('#berufsbezeichnungen-wrapper .berufswahl__items p').each(function(i, e){
                if (jQuery(this).children('input').is(':checked')){
                    if (n>0) berufsbezeichnungen += ", ";
                    var x = jQuery(this).clone();
                    x.children('input, select').remove();
                    berufsbezeichnungen += x.text();
					berufsbezeichnungen_ids.push(jQuery(this).children('input').val());
                    n++;
                }
            });
            				
			var checkFields = [
				{
					name: "Jobtitel",
					selector: "#jobtitel",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Arbeitszeitmodell",
					selector: "#arbeitszeitmodell",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Arbeitsbeginn",
					selector: "#arbeitsbeginn",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Arbeitsende",
					selector: "#arbeitsende",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Bundesland",
					selector: "#bundeslaender",
					type: "select",
					check: "notNullOrEmpty"
				},
				{
					name: "Bezirk",
					selector: "#bezirke",
					type: "select",
					check: "notNullOrEmpty"
				},
				{
					name: "Berufsfeld",
					selector: "#berufsfelder-wrapper .berufswahl__items input",
					type: "multipleCheckboxes",
					check: "lengthMind1"
				},
				{
					name: "Berufsgruppe",
					selector: "#berufsgruppen-wrapper .berufswahl__items input",
					type: "multipleCheckboxes",
					check: "lengthMind1"
				},
				{
					name: "Tätigkeitsbeschreibung",
					selector: "#taetigkeitsbeschreibung",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Kollektivvertrag",
					selector: "#kollektivvertrag",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Bewerbungen von",
					selector: "#bewerbungen_von",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Bewerbungen bis",
					selector: "#bewerbungen_bis",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Brutto Bezug",
					selector: "#brutto_bezug",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Adresse",
					selector: "#adresse_strasse_hn",
					type: "single_input",
					check: "empty"
				},
				{
					name: "PLZ",
					selector: "#adresse_plz",
					type: "single_input",
					check: "empty"
				},
				{
					name: "Ort",
					selector: "#adresse_ort",
					type: "single_input",
					check: "empty"
				},
				
				<?php if ($wpUserRole == "dienstleister"): ?>
				{
					name: "Kunde",
					selector: "#kunde_name",
					type: "single_input",
					check: "empty"
				},
				<?php endif; ?>
				
				{
					name: "Anzahl der Ressourcen",
					selector: "#anzahl_ressourcen",
					type: "single_input",
					check: "empty"
				}
			];
			
            if(checkForm(checkFields, true)){
                var rows = '<tr><th>Jobtitel</th><td>'+jQuery('#jobtitel').val()+'</td></tr>';
                rows += '<tr><th>Arbeitszeitmodell</th><td>'+jQuery('#arbeitszeitmodell').val()+'</td></tr>';
                rows += '<tr><th>Arbeitsbeginn</th><td>'+jQuery('#arbeitsbeginn').val()+'</td></tr>';
                rows += '<tr><th>Arbeitsende</th><td>'+jQuery('#arbeitsende').val()+'</td></tr>';
                rows += '<tr><th>Einsatzort</th><td>'+jQuery('#bezirke option:selected').html()+' ('+jQuery('#bundeslaender option:selected').html()+')</td></tr>';
                rows += '<tr><th>Adresse</th><td>'+jQuery('#adresse_strasse_hn').val()+'</td></tr>';
                rows += '<tr><th>PLZ</th><td>'+jQuery('#adresse_plz').val()+'</td></tr>';
                rows += '<tr><th>Ort</th><td>'+jQuery('#adresse_ort').val()+'</td></tr>';
                rows += '<tr><th>Berufsfelder</th><td>'+berufsfelder+'</td></tr>';
                rows += '<tr><th>Berufsgruppen</th><td>'+berufsgruppen+'</td></tr>';
                rows += '<tr><th>Berufsbezeichnungen</th><td>'+berufsbezeichnungen+'</td></tr>';
                rows += '<tr><th>Skills</th><td>'+skills+'</td></tr>';
                rows += '<tr><th>Führerschein</th><td>'+(jQuery('#skill_fuehrerschein').is(':checked') ? 'Ja' : 'Nein') +'</td></tr>';
                rows += '<tr><th>Eigener PKW</th><td>'+(jQuery('#skill_pkw').is(':checked') ? 'Ja' : 'Nein') +'</td></tr>';
                rows += '<tr><th>Berufsabschluss im ausgewählten Berufsfeld</th><td>'+(jQuery('#skill_berufsabschluss').is(':checked') ? 'Ja' : 'Nein' )+'</td></tr>';
                rows += '<tr><th>Tätigkeitsbeschreibung</th><td><pre>'+jQuery('#taetigkeitsbeschreibung').val()+'</pre></td></tr>';
                rows += '<tr><th>Kollektivvertrag</th><td>'+jQuery('#kollektivvertrag').val()+'</td></tr>';
                rows += '<tr><th>Brutto-Bezug</th><td>€ '+jQuery('#brutto_bezug').val()+' / '+jQuery('#brutto_bezug_einheit').val()+'</td></tr>';
                rows += '<tr><th>Überzahlung möglich</th><td>'+(jQuery('#brutto_bezug_ueberzahlung').is(':checked') ? 'Ja' : 'Nein') +'</td></tr>';
                rows += '<tr><th>Arbeitsausmaß</th><td>'+jQuery('#beschaeftigungsausmasse_id option:selected').html()+'</td></tr>';
                rows += '<tr><th>Beschäftigungsart</th><td>'+jQuery('#beschaeftigungsarten_id option:selected').html()+'</td></tr>';
                rows += '<tr><th>Bewerbungen von</th><td>'+jQuery('#bewerbungen_von').val()+'</td></tr>';
                rows += '<tr><th>Bewerbungen bis</th><td>'+jQuery('#bewerbungen_bis').val()+'</td></tr>';
                rows += '<tr><th>Anzahl der Ressourcen</th><td>'+jQuery('#anzahl_ressourcen').val()+'</td></tr>';
                rows += '<tr><th>Kunden casting</th><td>'+(jQuery('#casting').is(':checked') ? 'Ja' : 'Nein')+'</td></tr>';
                rows += '<tr><th>Als Vorlage gspeichern</th><td>'+(jQuery('#vorlage').is(':checked') ? 'Ja' : 'Nein')+'</td></tr>';
				
				<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user") { ?>
                var dl = "";
                if (jQuery('#dienstleister_vorgegeben').val() == 1){
					
					if (jQuery('#dienstleister_single').val() == 0){
                    	dl = jQuery('#dienstleister_auswahl').multipleSelect('getSelects', 'text');
					}else{
						dl = jQuery('#dienstleister_id option:selected').html();
					}
                    
                }else{
                    dl = "nicht vorgegeben";
                }

                rows += '<tr style="display: ? "block" : "none"; ?>;"><th>Dienstleister</th><td>'+dl+'</td></tr>';<?php } ?>
                jQuery('#submit-confirm tbody').html(rows);
                remodal.open();
				
				<?php if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user") { ?>
				jQuery.get('/api/v1/kosten',{
					arbeitsbeginn: jQuery('#arbeitsbeginn').val(),
					arbeitsende: jQuery('#arbeitsende').val(),
					berufsgruppen: JSON.stringify(berufsgruppen_ids),
					berufsbezeichnungen: JSON.stringify(berufsbezeichnungen_ids)
				}, function(data){
                
					var kosten = JSON.parse(data);
					jQuery('.submit-confirm-kosten__preis h3').html("€ " + kosten.gesamtkosten);
					jQuery('.submit-confirm-kosten__rechnung-laufzeit').html("Laufzeit: <strong>" + kosten.tage + " Tage</strong>");
					jQuery('.submit-confirm-kosten__rechnung-kategorie').html("Verrechnungskategorie: <strong>" + kosten.verrechnungs_kategorien_name + "</strong>");
					
					jQuery('.submit-confirm-kosten, #submit-confirm > .button').show();
					
				});
				<?php } else { ?>
					jQuery('#submit-confirm > .button').show();
				<?php } ?>
            }
            
            return false;
        });
        
    </script>
   
<?php
    get_footer();

?>