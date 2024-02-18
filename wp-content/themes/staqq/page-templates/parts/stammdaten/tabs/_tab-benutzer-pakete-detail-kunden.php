<?php

	$kunde = $api->get("kunden/$wpUserSTAQQId", [])->decode_response();
	$berufsfelder = $api->get("berufsfelder", [])->decode_response();

	$id = $_GET['id'];

	if ($id != "new"){
		$user = $api->get("kunden/$wpUserSTAQQId/user/$id", [])->decode_response();
		$action = "update_user";
		$ausreichend_user = true;
	}else{
		$action = "new_user";

		$user = new stdClass();
		$user->titel = "";
		$user->anrede = "Herr";
		$user->vorname = "";
		$user->nachname = "";
		$user->position = "";
		$user->telefon = "";
		$user->email = "";
		$user->berechtigung_einkauf = 0;
		$user->berechtigung_joborders_schalten = 0;
		$user->berechtigung_auswertung = 0;

		$user->einschraenkung_aktiv_von_bis = 0;
		$user->aktiv_von = "";
		$user->aktiv_bis = "";

		$user->einschraenkung_berufsfelder = 0;
		$user->einschraenkung_suchgruppen = 0;
		$user->einschraenkung_arbeitsstaetten = 0;

		$user->arbeitsstaetten = array();
		$user->berufsfelder = array();
		$user->suchgruppen = array();
		$user->bevorzugte_dienstleister = array();

		$a = str_split("abcdefghijklmnopqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXY0123456789"); 
		$user->passwort = "";

		$ausreichend_user = (intval($kunde->anzahl_user) > 0) ? true : false;
	}

	if ($ausreichend_user){

		$user->berechtigung_einkauf = ($user->berechtigung_einkauf == 1) ? "checked" : "";
		$user->berechtigung_joborders_schalten = ($user->berechtigung_joborders_schalten == 1) ? "checked" : "";
		$user->berechtigung_auswertung = ($user->berechtigung_auswertung == 1) ? "checked" : "";

		$user->einschraenkung_aktiv_von_bis = ($user->einschraenkung_aktiv_von_bis == 1) ? "checked" : "";
		$user->einschraenkung_berufsfelder = ($user->einschraenkung_berufsfelder == 1) ? "checked" : "";
		$user->einschraenkung_suchgruppen = ($user->einschraenkung_suchgruppen == 1) ? "checked" : "";
		$user->einschraenkung_arbeitsstaetten = ($user->einschraenkung_arbeitsstaetten == 1) ? "checked" : "";
?>


<form action="/app/stammdaten/#benutzer-pakete" method="post">
	<input type="hidden" name="action" value="<?php echo $action; ?>">
	<input type="hidden" name="id" value="<?php echo $id; ?>">

	<div class="section__wrapper">
		<article class="gd gd--12">
			<h1><?php echo ($id == "new") ? "Neuen Benutzer anlegen" : "Benutzer bearbeiten"; ?></h1>
		</article>
		<article class="gd gd--6">
			<div class="select-wrapper">
				<select name="anrede" id="anrede">
					<option value="Herr" <?php if ($user->anrede == "Herr") echo "selected"; ?>>Herr</option>
					<option value="Frau" <?php if ($user->anrede == "Frau") echo "selected"; ?>>Frau</option>
				</select>
			</div>
			<input type="text" name="titel" id="titel" placeholder="Titel" value="<?php echo $user->titel; ?>">
			<input type="text" name="vorname" id="vorname" placeholder="Vorname" value="<?php echo $user->vorname; ?>">
			<input type="text" name="nachname" id="nachname" placeholder="Nachname" value="<?php echo $user->nachname; ?>">
			<input type="text" name="position" id="position" placeholder="Position" value="<?php echo $user->position; ?>">
			<input type="text" name="telefon" id="telefon" placeholder="Telefon" value="<?php echo $user->telefon; ?>">
			<input type="text" name="email" id="email" placeholder="E-Mail" value="<?php echo $user->email; ?>">
			<input type="hidden" name="old_email" id="old_email" value="<?php echo $user->email; ?>">
		</article>
		<article class="gd gd--6">
			<input type="checkbox" name="berechtigung_joborders_schalten" id="berechtigung_joborders_schalten" class="switchable" data-label="Joborders schalten" <?php echo $user->berechtigung_joborders_schalten; ?>>
			<input type="checkbox" name="berechtigung_einkauf" id="berechtigung_einkauf" class="switchable" data-label="Einkauf von Paketen" <?php echo $user->berechtigung_einkauf; ?>>
			<input type="checkbox" name="berechtigung_auswertung" id="berechtigung_auswertung" class="switchable" data-label="Auswertung" <?php echo $user->berechtigung_auswertung; ?>>
			<?php if ($id == "new"): ?>
			<br>
			<h3>Passwort frei wählbar</h3>
			<p>Der User hat nachträglich die Möglichkeit sein Passwort zu ändern.</p>
			<input type="text" name="passwort" id="passwort" placeholder="Passwort" value="<?php echo $user->passwort; ?>">
			<br>
			<h3>Bevorzugte Dienstleister</h3>
			<div style="position: relative;" class="select-wrapper">
				<select multiple="multiple" name="bevorzugte_dienstleister[]" id="bevorzugte_dienstleister">
					<?php
						foreach ($alle_dienstleister as $f){
							$sel = (in_array_by_id($f, $user->bevorzugte_dienstleister)) ? "selected" : "";
							echo '<option value="'.$f->id.'" '.$sel.'>'.$f->firmenwortlaut.'</option>';
						}
					?>
				</select>
			</div>
			<?php endif; ?>
		</article>
		<article class="gd gd--12"></article>
		<article class="gd gd--12">
			<h3>Zeitliche Einschränkung</h3>
		</article>
		<article class="gd gd--4">
			<input type="checkbox" name="einschraenkung_aktiv_von_bis" id="einschraenkung_aktiv_von_bis" data-label="Einschränken" <?php echo $user->einschraenkung_aktiv_von_bis; ?>>
		</article>
		<article class="gd gd--4">
			<input type="text" class="datepicker" name="aktiv_von" id="aktiv_von" placeholder="Aktiv von" value="<?php echo $user->aktiv_von; ?>">
		</article>
		<article class="gd gd--4">
			<input type="text" class="datepicker" name="aktiv_bis" id="aktiv_bis" placeholder="Aktiv bis" value="<?php echo $user->aktiv_bis; ?>">
		</article>
		<article class="gd gd--12"></article>
		<article class="gd gd--12">
			<h3>Weitere Einschränkungen</h3>
		</article>
		<article class="gd gd--4">
			<input type="checkbox" name="einschraenkung_berufsfelder" id="einschraenkung_berufsfelder" class="switchable" data-label="Berufsfelder" <?php echo $user->einschraenkung_berufsfelder; ?>>
			<div id="berufsfelder-wrapper" style="position: relative;" class="select-wrapper">
				<select name="berufsfelder[]" id="berufsfelder" multiple="multiple">
					<?php
						foreach ($berufsfelder as $f){
							$sel = (in_array($f->id, $user->berufsfelder)) ? "selected" : "";
							echo '<option value="'.$f->id.'" '.$sel.'>'.$f->name.'</option>';
						}
					?>
				</select>
			</div>
		</article>
		<article class="gd gd--4">
			<input type="checkbox" name="einschraenkung_suchgruppen" id="einschraenkung_suchgruppen" class="switchable" data-label="Suchgruppen" <?php echo $user->einschraenkung_suchgruppen; ?>>
			<div id="suchgruppen-wrapper" style="position: relative;" class="select-wrapper">
				<select name="suchgruppen[]" id="suchgruppen" multiple="multiple">
					<?php
						foreach ($suchgruppen as $f){
							$sel = (in_array($f->id, $user->suchgruppen)) ? "selected" : "";
							echo '<option data-berufsfeld="'.$f->berufsfelder_id.'" value="'.$f->id.'" '.$sel.'>'.$f->name.'</option>';
						}
					?>
				</select>
			</div>
		</article>

		<?php if(count($kunde->arbeitsstaetten) > 0): ?>
		<article class="gd gd--4">
			<input type="checkbox" name="einschraenkung_arbeitsstaetten" id="einschraenkung_arbeitsstaetten" class="switchable" data-label="Arbeitsstätten" <?php echo $user->einschraenkung_arbeitsstaetten; ?>>
			<div id="arbeitsstaetten-wrapper" style="position: relative;" class="select-wrapper">
				<select multiple="multiple" name="arbeitsstaetten[]" id="arbeitsstaetten">
					<?php
						foreach ($kunde->arbeitsstaetten as $f){
							$sel = (in_array($f->id, $user->arbeitsstaetten)) ? "selected" : "";
							echo '<option value="'.$f->id.'" '.$sel.'>'.$f->name.'</option>';
						}
					?>
				</select>
			</div>
		</article>
		<?php endif; ?>
		<article class="gd gd--12">
			<button type="submit" class="button"><?php echo ($id == "new") ? "Neuen Benutzer hinzufügen" : "speichern"; ?></button>
		</article>
	</div>
</form>

<?php 
		if ($action == "update_user"){
?>
			<section class="section section--delete">
				<div class="section__wrapper">
					<article class="gd gd--12">
						<h2>Konto löschen</h2>
						<form action="" method="post">
							<input type="hidden" name="action" value="delete_user">
							<input type="hidden" name="id" value="<?php echo $user->id; ?>">
							<input type="hidden" name="email" value="<?php echo $user->email; ?>">
							<button type="submit" class="button">Löschen</button>
						</form>
					</article>
				</div>
			</section>
<?php
		 }
	}else{
?>
			<h1>Sie haben alle Ihre Benutzer aufgebraucht!</h1>
			<p>Um neue Benutzer anlegen zu können müssen Sie ein Benutzer-Paket kaufen.</p>
			<a href="/app/stammdaten#ordering" target="_self" class="button">Zu den Paketen</a>
<?php
	}
?>