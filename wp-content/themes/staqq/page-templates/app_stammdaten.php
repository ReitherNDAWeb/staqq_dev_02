<?php

    /**
     *   Template Name: STAQQ / App / Stammdaten
     */

    get_header();

	$showError = false;
	$showInfo = false;

	if ($wpUserSTAQQUser && $wpUserState){

		if ($_POST['action'] == "save"){

			if ($_POST['user_type'] == "ressource"){

				$response = $api->put("ressources/$wpUserSTAQQId", [
					'vorname' => $_POST['vorname'],
					'nachname' => $_POST['nachname'],
					'email' => $_POST['email'],
					'old_email' => $_POST['old_email'],
					'telefon' => $_POST['telefon'],
					'skill_fuehrerschein' => ($_POST['skill_fuehrerschein'] == "on") ? 1 : 0,
					'skill_berufsabschluss' => ($_POST['skill_berufsabschluss'] == "on") ? 1 : 0,
					'skill_pkw' => ($_POST['skill_pkw'] == "on") ? 1 : 0,
					'skill_eu_buerger' => ($_POST['skill_eu_buerger'] == "on") ? 1 : 0,
					'skill_rwr_karte' => ($_POST['skill_rwr_karte'] == "on") ? 1 : 0,
					'skill_hoechster_schulabschluss' => $_POST['skill_hoechster_schulabschluss'],

					'berufsfelder' => json_encode($_POST['berufsfelder']),
					'berufsgruppen' => json_encode($_POST['berufsgruppen']),
					'berufsbezeichnungen' => json_encode($_POST['berufsbezeichnungen']),

					'skills' => json_encode($_POST['skills']),
					'regionen' => json_encode($_POST['regionen']),

					'dl_gecastet' => json_encode($_POST['dl_gecastet']),
					'dl_blacklist' => json_encode($_POST['dl_blacklist']),
				])->decode_response();

			} else if ($_POST['user_type'] == "dienstleister"){

				$response = $api->put("dienstleister/$wpUserSTAQQId", [
					'firmenwortlaut' => $_POST['firmenwortlaut'],
					'gesellschaftsform' => $_POST['gesellschaftsform'],
					'email' => $_POST['email'],
					'old_email' => $_POST['old_email'],
					'ansprechpartner_telefon' => $_POST['ansprechpartner_telefon'],
					'ansprechpartner_anrede' => $_POST['ansprechpartner_anrede'],
					'ansprechpartner_titel' => $_POST['ansprechpartner_titel'],
					'ansprechpartner_vorname' => $_POST['ansprechpartner_vorname'],
					'ansprechpartner_nachname' => $_POST['ansprechpartner_nachname'],
					'ansprechpartner_position' => $_POST['ansprechpartner_position'],
					'uid' => $_POST['uid'],
					'fn' => $_POST['fn'],
					'website' => $_POST['website'],
					'firmensitz_adresse' => $_POST['firmensitz_adresse'],
					'firmensitz_plz' => $_POST['firmensitz_plz'],
					'firmensitz_ort' => $_POST['firmensitz_ort'],
					'filialen' => json_encode($_POST['filialen']),
					'berufsfelder' => json_encode($_POST['berufsfelder'])
				])->decode_response();
				
				$_REQUEST = $_POST = $_GET = NULL;

			} else if ($_POST['user_type'] == "kunde"){

				$response = $api->put("kunden/$wpUserSTAQQId", [
					'firmenwortlaut' => $_POST['firmenwortlaut'],
					'gesellschaftsform' => $_POST['gesellschaftsform'],
					'email' => $_POST['email'],
					'old_email' => $_POST['old_email'],
					'ansprechpartner_telefon' => $_POST['ansprechpartner_telefon'],
					'ansprechpartner_anrede' => $_POST['ansprechpartner_anrede'],
					'ansprechpartner_titel' => $_POST['ansprechpartner_titel'],
					'ansprechpartner_vorname' => $_POST['ansprechpartner_vorname'],
					'ansprechpartner_nachname' => $_POST['ansprechpartner_nachname'],
					'ansprechpartner_position' => $_POST['ansprechpartner_position'],
					'uid' => $_POST['uid'],
					'fn' => $_POST['fn'],
					'website' => $_POST['website'],
					'firmensitz_adresse' => $_POST['firmensitz_adresse'],
					'firmensitz_plz' => $_POST['firmensitz_plz'],
					'firmensitz_ort' => $_POST['firmensitz_ort'],
					'arbeitsstaetten' => json_encode($_POST['arbeitsstaetten']),
					'dienstleister' => json_encode($_POST['dienstleister'])
				])->decode_response();
			}

			if ($response->status){
				$showError = false;
				$showInfo = true;
				$msg = "Erfolgreich gespeichert!";
			}else{
				$showError = true;
				$showInfo = false;
				$msg = $response->msg;
			}
			
		} elseif ($_POST['action'] == "requestDelete"){


			if ($wpUserRole == "ressource"){
				$role = "ressources";
			}elseif ($wpUserRole == "kunde"){
				$role = "kunden";
			}elseif ($wpUserRole == "dienstleister"){
				$role = "dienstleister";
			}

			$response = $api->post("$role/$wpUserSTAQQId/requestDelete", [])->decode_response();

			if ($response->status){
				$showError = false;
				$showInfo = true;
				$msg = "Erfolgreich beantragt!";
			}else{
				$showError = true;
				$showInfo = false;
				$msg = $response->msg;
			}

		} elseif ($_POST['action'] == "changePasswort"){


			if ($wpUserRole == "ressource"){
				$role = "ressources";
			}elseif ($wpUserRole == "kunde"){
				$role = "kunden";
			}elseif ($wpUserRole == "dienstleister"){
				$role = "dienstleister";
			}
			
			$response = $api->put("$role/$wpUserSTAQQId/changePasswort", [
				'email' => $_POST['email'],
				'passwort_neu' => $_POST['passwort_neu_1'],
				'passwort_alt' => $_POST['passwort_alt']
			])->decode_response();

			if ($response->status){
				$showError = false;
				$showInfo = true;
				$msg = "Erfolgreich geändert!";
			}else{
				$showError = true;
				$showInfo = false;
				$msg = $response->msg;
			}

		}elseif ($_POST['action'] == "new_user"){
			
			if ($wpUserRole == "dienstleister"){
				
				$res = $api->post("dienstleister/$wpUserSTAQQId/user", [
					'anrede' => $_POST['anrede'],
					'titel' => $_POST['titel'],
					'vorname' => $_POST['vorname'],
					'nachname' => $_POST['nachname'],
					'position' => $_POST['position'],
					'telefon' => $_POST['telefon'],
					'email' => $_POST['email'],
					'passwort' => $_POST['passwort'],
					'aktiv_von' => ($_POST['aktiv_von'] == "") ? date('Y-m-d', time()) : date('Y-m-d', strtotime($_POST['aktiv_von'])),
					'aktiv_bis' => ($_POST['aktiv_bis'] == "") ? date('Y-m-d', time()) : date('Y-m-d', strtotime($_POST['aktiv_bis'])),
					'debug' => 0,
					'berechtigung_joborders_schalten' => ($_POST['berechtigung_joborders_schalten'] == "on") ? 1 : 0,
					'berechtigung_einkauf' => ($_POST['berechtigung_einkauf'] == "on") ? 1 : 0,
					'berechtigung_auswertung' => ($_POST['berechtigung_auswertung'] == "on") ? 1 : 0,
					'einschraenkung_aktiv_von_bis' => ($_POST['einschraenkung_aktiv_von_bis'] == "on") ? 1 : 0,
					'einschraenkung_filialen' => ($_POST['einschraenkung_filialen'] == "on") ? 1 : 0,
					'einschraenkung_berufsfelder' => ($_POST['einschraenkung_berufsfelder'] == "on") ? 1 : 0,
					'einschraenkung_suchgruppen' => ($_POST['einschraenkung_suchgruppen'] == "on") ? 1 : 0,
					'berufsfelder' => isset($_POST['berufsfelder']) ? json_encode($_POST['berufsfelder']) : "[]",
					'suchgruppen' => isset($_POST['suchgruppen']) ? json_encode($_POST['suchgruppen']) : "[]",
					'filialen' => isset($_POST['filialen']) ? json_encode($_POST['filialen']) : "[]"
				])->decode_response();

			}else if ($wpUserRole == "kunde"){

				$res = $api->post("kunden/$wpUserSTAQQId/user", [
					'anrede' => $_POST['anrede'],
					'titel' => $_POST['titel'],
					'vorname' => $_POST['vorname'],
					'nachname' => $_POST['nachname'],
					'position' => $_POST['position'],
					'telefon' => $_POST['telefon'],
					'email' => $_POST['email'],
					'passwort' => $_POST['passwort'],
					'aktiv_von' => ($_POST['aktiv_von'] == "") ? date('Y-m-d', time()) : date('Y-m-d', strtotime($_POST['aktiv_von'])),
					'aktiv_bis' => ($_POST['aktiv_bis'] == "") ? date('Y-m-d', time()) : date('Y-m-d', strtotime($_POST['aktiv_bis'])),
					'debug' => 0,
					'berechtigung_joborders_schalten' => ($_POST['berechtigung_joborders_schalten'] == "on") ? 1 : 0,
					'berechtigung_einkauf' => ($_POST['berechtigung_einkauf'] == "on") ? 1 : 0,
					'berechtigung_auswertung' => ($_POST['berechtigung_auswertung'] == "on") ? 1 : 0,
					'einschraenkung_aktiv_von_bis' => ($_POST['einschraenkung_aktiv_von_bis'] == "on") ? 1 : 0,
					'einschraenkung_arbeitsstaetten' => ($_POST['einschraenkung_arbeitsstaetten'] == "on") ? 1 : 0,
					'einschraenkung_berufsfelder' => ($_POST['einschraenkung_berufsfelder'] == "on") ? 1 : 0,
					'einschraenkung_suchgruppen' => ($_POST['einschraenkung_suchgruppen'] == "on") ? 1 : 0,
					'berufsfelder' => isset($_POST['berufsfelder']) ? json_encode($_POST['berufsfelder']) : "[]",
					'suchgruppen' => isset($_POST['suchgruppen']) ? json_encode($_POST['suchgruppen']) : "[]",
					'bevorzugte_dienstleister' => isset($_POST['bevorzugte_dienstleister']) ? json_encode($_POST['bevorzugte_dienstleister']) : "[]",
					'arbeitsstaetten' => isset($_POST['arbeitsstaetten']) ? json_encode($_POST['arbeitsstaetten']) : "[]"
				])->decode_response();
			}
			
        }elseif ($_POST['action'] == "update_user"){
			
			if ($wpUserRole == "dienstleister"){
				
				$res = $api->put("dienstleister/user/".$_POST['id'], [
					'dienstleister_id' => $wpUserSTAQQId,
					'anrede' => $_POST['anrede'],
					'titel' => $_POST['titel'],
					'vorname' => $_POST['vorname'],
					'nachname' => $_POST['nachname'],
					'position' => $_POST['position'],
					'telefon' => $_POST['telefon'],
					'email' => $_POST['email'],
					'old_email' => $_POST['old_email'],
					'aktiv_von' => date('Y-m-d', strtotime($_POST['aktiv_von'])),
					'aktiv_bis' => date('Y-m-d', strtotime($_POST['aktiv_bis'])),
					'debug' => 0,
					'berechtigung_joborders_schalten' => ($_POST['berechtigung_joborders_schalten'] == "on") ? 1 : 0,
					'berechtigung_einkauf' => ($_POST['berechtigung_einkauf'] == "on") ? 1 : 0,
					'berechtigung_auswertung' => ($_POST['berechtigung_auswertung'] == "on") ? 1 : 0,
					'einschraenkung_aktiv_von_bis' => ($_POST['einschraenkung_aktiv_von_bis'] == "on") ? 1 : 0,
					'einschraenkung_filialen' => ($_POST['einschraenkung_filialen'] == "on") ? 1 : 0,
					'einschraenkung_berufsfelder' => ($_POST['einschraenkung_berufsfelder'] == "on") ? 1 : 0,
					'einschraenkung_suchgruppen' => ($_POST['einschraenkung_suchgruppen'] == "on") ? 1 : 0,
					'berufsfelder' => isset($_POST['berufsfelder']) ? json_encode($_POST['berufsfelder']) : "[]",
					'suchgruppen' => isset($_POST['suchgruppen']) ? json_encode($_POST['suchgruppen']) : "[]",
					'filialen' => isset($_POST['filialen']) ? json_encode($_POST['filialen']) : "[]"
				])->decode_response();
				
			}else if ($wpUserRole == "kunde"){
				
				$res = $api->put("kunden/user/".$_POST['id'], [
					'kunden_id' => $wpUserSTAQQId,
					'anrede' => $_POST['anrede'],
					'titel' => $_POST['titel'],
					'vorname' => $_POST['vorname'],
					'nachname' => $_POST['nachname'],
					'position' => $_POST['position'],
					'telefon' => $_POST['telefon'],
					'email' => $_POST['email'],
					'old_email' => $_POST['old_email'],
					'aktiv_von' => date('Y-m-d', strtotime($_POST['aktiv_von'])),
					'aktiv_bis' => date('Y-m-d', strtotime($_POST['aktiv_bis'])),
					'debug' => 0,
					'berechtigung_joborders_schalten' => ($_POST['berechtigung_joborders_schalten'] == "on") ? 1 : 0,
					'berechtigung_einkauf' => ($_POST['berechtigung_einkauf'] == "on") ? 1 : 0,
					'berechtigung_auswertung' => ($_POST['berechtigung_auswertung'] == "on") ? 1 : 0,
					'einschraenkung_aktiv_von_bis' => ($_POST['einschraenkung_aktiv_von_bis'] == "on") ? 1 : 0,
					'einschraenkung_arbeitsstaetten' => ($_POST['einschraenkung_arbeitsstaetten'] == "on") ? 1 : 0,
					'einschraenkung_berufsfelder' => ($_POST['einschraenkung_berufsfelder'] == "on") ? 1 : 0,
					'einschraenkung_suchgruppen' => ($_POST['einschraenkung_suchgruppen'] == "on") ? 1 : 0,
					'berufsfelder' => isset($_POST['berufsfelder']) ? json_encode($_POST['berufsfelder']) : "[]",
					'suchgruppen' => isset($_POST['suchgruppen']) ? json_encode($_POST['suchgruppen']) : "[]",
					'bevorzugte_dienstleister' => isset($_POST['bevorzugte_dienstleister']) ? json_encode($_POST['bevorzugte_dienstleister']) : "[]",
					'arbeitsstaetten' => isset($_POST['arbeitsstaetten']) ? json_encode($_POST['arbeitsstaetten']) : "[]"
				])->decode_response();
				
			}
			
        }else if ($_POST['action'] == "dienstleisterEinladen"){
				
			$res = $api->post("kunden/".$_POST['id']."/dienstleisterEinladen", [
				'dl_anforderung_name' => $_POST['dl_anforderung_name'],
				'dl_anforderung_ansprechpartner_titel' => $_POST['dl_anforderung_ansprechpartner_titel'],
				'dl_anforderung_ansprechpartner_vorname' => $_POST['dl_anforderung_ansprechpartner_vorname'],
				'dl_anforderung_ansprechpartner_nachname' => $_POST['dl_anforderung_ansprechpartner_nachname'],
				'dl_anforderung_ansprechpartner_email' => $_POST['dl_anforderung_ansprechpartner_email'],
				'dl_anforderung_infotext' => $_POST['dl_anforderung_infotext'],
				'firmenwortlaut' => $_POST['firmenwortlaut'],
				'email' => $_POST['email']
			])->decode_response();
			
		}else{

			$showInfo = false;
			$showError = false;
		}

		$berufsfelder = $api->get("berufsfelder", [])->decode_response();
		$berufsgruppen = $api->get("berufsgruppen", [])->decode_response();
		$berufsbezeichnungen = $api->get("berufsbezeichnungen", [])->decode_response();
		$skills_items = $api->get("skills/items", [])->decode_response();
		$skills_kategorien = $api->get("skills/kategorien", [])->decode_response();
		$bezirke = $api->get("bezirke", [])->decode_response();
		$bundeslaender = $api->get("bundeslaender", [])->decode_response();
		$dienstleister = $api->get("dienstleister", [])->decode_response();
?>
	
	
		<nav class="section section--full-width section--sub-nav">
			<div class="section__overlay">
				<div class="section__wrapper">
					<ul class="menu menu--sub tab-links">
						<?php
							if($wpUserRole == "ressource"){
								require_once('parts/stammdaten/submenu/_submenu-ressources.php');
							}else if($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
								require_once('parts/stammdaten/submenu/_submenu-dienstleister.php');
							}else if($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
								require_once('parts/stammdaten/submenu/_submenu-kunden.php');
							}
						?>
					</ul>
				</div>
			</div>
		</nav>

		<section class="section skill-chooser-stammdaten">
			<div class="section__overlay">
				<div class="section__wrapper">
				
					<article class="gd gd--12 tab tab--stammdaten tab--active">
						<?php 
							if($wpUserRole == "ressource"){

								$ressource = ($api->get("ressources/$wpUserSTAQQId", [])->decode_response());

								$vorname = $ressource->vorname;
								$nachname = $ressource->nachname;
								$email = $ressource->email;
								$telefon = $ressource->telefon;
								$skill_fuehrerschein = ($ressource->skill_fuehrerschein == 1) ? "checked" : "";
								$skill_pkw = ($ressource->skill_pkw == 1) ? "checked": "";
								$skill_berufsabschluss = ($ressource->skill_berufsabschluss == 1) ? "checked" : "";
								$skill_eu_buerger = ($ressource->skill_eu_buerger == 1) ? "checked" : "";
								$skill_rwr_karte = ($ressource->skill_rwr_karte == 1) ? "checked" : "";
								$skill_hoechster_schulabschluss = $ressource->skill_hoechster_schulabschluss;

								require_once('parts/stammdaten/tabs/_tab-stammdaten-ressources.php');

							}else if($wpUserRole == "dienstleister"){

								$dienstleister = ($api->get("dienstleister/$wpUserSTAQQId", [])->decode_response());

								$firmenwortlaut = $dienstleister->firmenwortlaut;
								$gesellschaftsform = $dienstleister->gesellschaftsform;
								$email = $dienstleister->email;
								$ansprechpartner_telefon = $dienstleister->ansprechpartner_telefon;
								$ansprechpartner_anrede = $dienstleister->ansprechpartner_anrede;
								$ansprechpartner_titel = $dienstleister->ansprechpartner_titel;
								$ansprechpartner_vorname = $dienstleister->ansprechpartner_vorname;
								$ansprechpartner_nachname = $dienstleister->ansprechpartner_nachname;
								$ansprechpartner_position = $dienstleister->ansprechpartner_position;
								$uid = $dienstleister->uid;
								$fn = $dienstleister->fn;
								$website = $dienstleister->website;
								$firmensitz_adresse = $dienstleister->firmensitz_adresse;
								$firmensitz_plz = $dienstleister->firmensitz_plz;
								$firmensitz_ort = $dienstleister->firmensitz_ort;

								require_once('parts/stammdaten/tabs/_tab-stammdaten-dienstleister.php');

							}else if($wpUserRole == "kunde"){

								$kunde = ($api->get("kunden/$wpUserSTAQQId", [])->decode_response());

								$firmenwortlaut = $kunde->firmenwortlaut;
								$gesellschaftsform = $kunde->gesellschaftsform;
								$email = $kunde->email;
								$ansprechpartner_telefon = $kunde->ansprechpartner_telefon;
								$ansprechpartner_anrede = $kunde->ansprechpartner_anrede;
								$ansprechpartner_titel = $kunde->ansprechpartner_titel;
								$ansprechpartner_vorname = $kunde->ansprechpartner_vorname;
								$ansprechpartner_nachname = $kunde->ansprechpartner_nachname;
								$ansprechpartner_position = $kunde->ansprechpartner_position;
								$uid = $kunde->uid;
								$fn = $kunde->fn;
								$website = $kunde->website;
								$firmensitz_adresse = $kunde->firmensitz_adresse;
								$firmensitz_plz = $kunde->firmensitz_plz;
								$firmensitz_ort = $kunde->firmensitz_ort;

								require_once('parts/stammdaten/tabs/_tab-stammdaten-kunden.php');
							}
						?>
					</article>
					
					<article class="gd gd--12 tab tab--passwort">
						<?php
							require_once('parts/stammdaten/tabs/_tab-passwort.php');
						?>
					</article>
					
					<article class="gd gd--12 tab tab--delete">
						<?php
							require_once('parts/stammdaten/tabs/_tab-konto-loeschung.php');
						?>
					</article>
					
					<?php if($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
					<article class="gd gd--12 tab tab--dienstleister-einladen">
						<?php
							require_once('parts/stammdaten/tabs/_tab-dienstleister-einladen-kunden.php');
						?>
					</article>
					<?php } ?>
					
					<?php if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user" || $wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
					<article class="gd gd--12 tab tab--benutzer-pakete">
						<?php
							if ($wpUserRole == "dienstleister"){
								$user = $api->get("dienstleister/$wpUserSTAQQId", [])->decode_response();
							} else if ($wpUserRole == "dienstleister_user"){
								$user = $api->get("dienstleister/$wpUserSTAQQDienstleisterId", [])->decode_response();
							} else if ($wpUserRole == "kunde"){
								$user = $api->get("kunden/$wpUserSTAQQId", [])->decode_response();
							} else if ($wpUserRole == "kunde_user"){
								$user = $api->get("kunden/$wpUserSTAQQKundeId", [])->decode_response();
							}

							$anzahl_j = $user->anzahl_joborders;
							$anzahl_u = $user->anzahl_user;
							
							if (isset($_GET['id'])){
								$id = $_GET['id'];
								if ($wpUserRole == "dienstleister"){
									require_once('parts/stammdaten/tabs/_tab-benutzer-pakete-detail-dienstleister.php');
								} elseif ($wpUserRole == "kunde"){
									require_once('parts/stammdaten/tabs/_tab-benutzer-pakete-detail-kunden.php');
								}
							}else{
								require_once('parts/stammdaten/tabs/_tab-benutzer-pakete.php');
							}
							
						?>
					</article>
					<?php } ?>
					<?php if ($wpUserRole != "ressource"){ ?>
					<article class="gd gd--12 tab tab--rechnungen">
						<?php
							require_once('parts/stammdaten/tabs/_tab-rechnungen.php');
						?>
					</article>
					<?php } ?>
					
					<?php if ($wpUserRole == "dienstleister" || ($wpUserRole == "dienstleister_user" && $userBerechtigungen->berechtigung_einkauf)){ ?>
					<article class="gd gd--12 tab tab--ordering">
						<?php
							require_once('parts/stammdaten/tabs/_tab-pakete-ordering-dienstleister.php');
						?>
					</article>
					<?php } ?>
					
					<?php if ($wpUserRole == "kunde" || ($wpUserRole == "kunde_user" && $userBerechtigungen->berechtigung_einkauf)){ ?>
					<article class="gd gd--12 tab tab--ordering">
						<?php
							require_once('parts/stammdaten/tabs/_tab-pakete-ordering-kunden.php');
						?>
					</article>
					<?php } ?>
				</div>
			</div>
		</section>
    
		<script>

			function passwortCheck(){

				var pw_a  = jQuery('#passwort_alt').val();
				var pw_n1 = jQuery('#passwort_neu_1').val();
				var pw_n2 = jQuery('#passwort_neu_2').val();

				if (pw_a != "" && pw_n1 != "" && pw_n2 != ""){
					if (pw_n1 == pw_n2){
						return true;
					}else{
						showNotification("Fehler", "Die beiden neuen Passwörter müssen übereinstimmen.", true, "staqq-notification--info");
						return false;
					}
				}else{
					showNotification("Fehler", "Es darf kein Passwort leer sein!", true, "staqq-notification--info");
					return false;
				}

			}

			jQuery(document).ready(function(){
				<?php if ($showInfo && !$showError) echo 'showNotification("Gespeichert", "'.$msg.'", true, "staqq-notification--info");'; ?>
				<?php if (!$showInfo && $showError) echo "error('$msg', 0);"; ?>
			});


			jQuery("form#stammdaten_form").submit(function(e) {
				self = this;
				e.preventDefault();

				if(checkForm(checkFields, true)){
					self.submit();
				}

			});

			jQuery("form#password_form").submit(function(e) {
				self = this;
				e.preventDefault();

				if(checkForm([
						{
							name: "Altes Passwort",
							selector: "#passwort_alt",
							type: "single_input",
							check: "empty"
						},
						{
							name: "Neues Passwort",
							selector: "#passwort_neu_1",
							type: "single_input",
							check: "empty"
						},
						{
							name: "Neues Passwort Wiederholung",
							selector: "#passwort_neu_2",
							type: "single_input",
							check: "empty"
						}
					], 
					true))
				{
					self.submit();
				}

			});

		</script>
   
		<script>

			var sg_removed_auswahl = [];

			function filterSuchgruppen(init){

				var ids = jQuery('.tab--benutzer-pakete #berufsfelder').multipleSelect('getSelects');
				var ids_to_remove = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'];

				jQuery('.tab--benutzer-pakete #suchgruppen').append(sg_removed_auswahl);
				sg_removed_auswahl = [];

				for (var i=0;i<ids.length;i++){
					var choosen = ids[i];
					ids_to_remove.splice(ids_to_remove.indexOf(choosen), 1);
				}

				for (var i=0;i<ids_to_remove.length;i++){
					sg_removed_auswahl.push(jQuery('.tab--benutzer-pakete #suchgruppen option[data-berufsfeld="'+ids_to_remove[i]+'"]'));
					jQuery('.tab--benutzer-pakete #suchgruppen option[data-berufsfeld="'+ids_to_remove[i]+'"]').remove();
				}

				jQuery('.tab--benutzer-pakete #suchgruppen').multipleSelect({placeholder: "Suchgruppen wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});
			}

			jQuery('.tab--benutzer-pakete select#berufsfelder').change(function(){

				filterSuchgruppen(false);

			});

			// Init
			jQuery(document).ready(function(){
				jQuery('.tab--benutzer-pakete #berufsfelder').multipleSelect({placeholder: "Berufsfelder wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

				jQuery('.tab--benutzer-pakete #suchgruppen').multipleSelect({placeholder: "Suchgruppen wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

				jQuery('.tab--benutzer-pakete #arbeitsstaetten').multipleSelect({placeholder: "Arbeitsstätten wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

				jQuery('.tab--benutzer-pakete #filialen').multipleSelect({placeholder: "Filialen wählen", selectAllText: "Alle auswählen", allSelected: "Alle ausgewählt", countSelected: "# von % ausgewählt"});

				<?php if ($_GET['id'] == "new") echo "jQuery('.tab--benutzer-pakete #berufsfelder, .tab--benutzer-pakete #suchgruppen, .tab--benutzer-pakete #arbeitsstaetten, .tab--benutzer-pakete #filialen').multipleSelect('uncheckAll');"; ?>
			});

		</script>
    
<?php
		
	}

    get_footer();
?>   