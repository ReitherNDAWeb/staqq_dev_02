<form id="stammdaten_form" method="post" action="">
	<input type="hidden" name="action" value="save">
	<article class="gd gd--12">
		<input type="hidden" name="user_type" value="kunde">
		<input type="hidden" name="old_email" value="<?php echo $email; ?>">

		<article class="gd gd--6">
			<h2>Stammdaten</h2>
			<input type="text" name="firmenwortlaut" id="firmenwortlaut" placeholder="Firmenwortlaut" value="<?php echo $firmenwortlaut; ?>">
			<input type="text" name="gesellschaftsform" id="gesellschaftsform" placeholder="Gesellschaftsform" value="<?php echo $gesellschaftsform; ?>">
			<input type="text" name="email" id="email" placeholder="E-Mail" value="<?php echo $email; ?>">
			<input type="text" name="ansprechpartner_telefon" id="ansprechpartner_telefon" placeholder="Ansprechpartner Telefon" value="<?php echo $ansprechpartner_telefon; ?>">
			<select name="ansprechpartner_anrede" id="ansprechpartner_anrede">
				<option value="Herr" <?php if ($ansprechpartner_anrede == "Herr") echo "selected"; ?>>Herr</option>
				<option value="Frau" <?php if ($ansprechpartner_anrede == "Frau") echo "selected"; ?>>Frau</option>
			</select>
			<input type="text" name="ansprechpartner_titel" id="ansprechpartner_titel" placeholder="Ansprechpartner Titel" value="<?php echo $ansprechpartner_titel; ?>">
			<input type="text" name="ansprechpartner_vorname" id="ansprechpartner_vorname" placeholder="Ansprechpartner Vorname" value="<?php echo $ansprechpartner_vorname; ?>">
			<input type="text" name="ansprechpartner_nachname" id="ansprechpartner_nachname" placeholder="Ansprechpartner Nachname" value="<?php echo $ansprechpartner_nachname; ?>">
			<input type="text" name="ansprechpartner_position" id="ansprechpartner_position" placeholder="Ansprechpartner Position" value="<?php echo $ansprechpartner_position; ?>">
			<input type="text" name="uid" id="uid" placeholder="Umsatzsteuer ID" value="<?php echo $uid; ?>">
			<input type="text" name="fn" id="fn" placeholder="Firmenbuchnummer" value="<?php echo $fn; ?>">
			<input type="text" name="website" id="website" placeholder="Website" value="<?php echo $website; ?>">
			<input type="text" name="firmensitz_adresse" id="firmensitz_adresse" placeholder="Firmensitz Straße und Hausnummer" value="<?php echo $firmensitz_adresse; ?>">
			<input type="text" name="firmensitz_plz" id="firmensitz_plz" placeholder="Firmensitz PLZ" value="<?php echo $firmensitz_plz; ?>">
			<input type="text" name="firmensitz_ort" id="firmensitz_ort" placeholder="Firmensitz Ort" value="<?php echo $firmensitz_ort; ?>">
		</article>
		<article class="gd gd--6">
			<h2>Optional</h2>
			<div class="arbeitsstaetten_wrapper">
				<?php
					foreach ($kunde->arbeitsstaetten as $a){
						echo '<input type="text" name="arbeitsstaetten[]" class="arbeitsstaetten" placeholder="Arbeitsstätte" value="'.$a->name.'">';
					}
				?>

				<button class="button arbeitsstaetten_wrapper__add" onclick="addNewInputByName('arbeitsstaetten', 'Arbeitsstätte', '.arbeitsstaetten_wrapper__add');">Weitere Arbeitsstätte hinzufügen</button>
			</div>

			<div style="position: relative;">
				<label for="dienstleister">Ausgewählte Dienstleister  <i class="icon icon--tooltip tooltip" title="Hier können Sie bevorzugte Dienstleister erfassen."></i></label>
				<select multiple="multiple" name="dienstleister[]" id="dienstleister">
					<?php
						foreach ($dienstleister as $d){
							$sel = (in_array_by_id($d, $kunde->dienstleister)) ? "selected" : "";
							echo '<option value="'.$d->id.'" '.$sel.'>'.$d->firmenwortlaut.'</option>';
						}
					?>
				</select>
			</div>
		</article>
	</article>
	<article class="gd gd--12">
		<button class="button" type="submit">Speichern</button>
	</article>
</form>

<script>

	var checkFields = [
		{
			name: "Firmenwortlaut",
			selector: "#firmenwortlaut",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Gesellschaftsform",
			selector: "#gesellschaftsform",
			type: "single_input",
			check: "empty"
		},
		{
			name: "E-Mail",
			selector: "#email",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Website",
			selector: "#website",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Ansprechpartner Vorname",
			selector: "#ansprechpartner_vorname",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Ansprechpartner Nachname",
			selector: "#ansprechpartner_nachname",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Firmensitz Adress",
			selector: "#firmensitz_adresse",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Firmensitz PLZ",
			selector: "#firmensitz_plz",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Firmensitz Ort",
			selector: "#firmensitz_ort",
			type: "single_input",
			check: "empty"
		}
	];
</script>