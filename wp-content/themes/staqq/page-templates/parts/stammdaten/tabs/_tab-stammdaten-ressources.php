<form id="stammdaten_form" method="post" action="">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="user_type" value="ressource">
	<input type="hidden" name="old_email" value="<?php echo $email; ?>">

	<article class="gd gd--12">
		<h2>Berufe</h2>
	</article>
	<article class="gd gd--4 berufswahl" id="berufsfelder-wrapper">
		<h3>Felder (mind. 1)</h3>
		<div class="berufswahl__items">
		<?php
			foreach ($berufsfelder as $f){
				$checked = (in_array_by_id($f, $ressource->berufsfelder)) ? "checked" : "";
				echo '<p><input class="berufsfelder" name="berufsfelder[]" type="checkbox" value="'.$f->id.'" '.$checked.'><i class="icon icon--berufswahl icon--berufsfeld-'.$f->id.'"></i>'.$f->name.'</p>';
			}
		?>
		</div>
	</article>
	<article class="gd gd--4 berufswahl" id="berufsgruppen-wrapper">
		<h3>Gruppen (mind. 1)</h3>  
		<div class="berufswahl__items">
		<?php
			foreach ($berufsgruppen as $g){
				$checked = (in_array_by_id($g, $ressource->berufsgruppen)) ? "checked" : "";
				$parent = (in_array_by_id_2($g->berufsfelder_id, $ressource->berufsfelder)) ? "block" : "none";
				echo '<p data-berufsfeld="'.$g->berufsfelder_id.'" style="display: '.$parent.';"><input class="berufsgruppen" type="checkbox" name="berufsgruppen[]" value="'.$g->id.'" '.$checked.'><i class="icon icon--berufswahl icon--berufsfeld-'.$g->berufsfelder_id.'"></i>'.$g->name.'</p>';
			}
		?>
		</div>
	</article>
	<article class="gd gd--4 berufswahl" id="berufsbezeichnungen-wrapper">
		<h3>Bezeichnungen (optional)</h3>
		<div class="berufswahl__items">
		<?php
			foreach ($berufsbezeichnungen as $z){
				$checked = (in_array_by_id($z, $ressource->berufsbezeichnungen)) ? "checked" : "";
				$parent = (in_array_by_id_2($z->berufsgruppen_id, $ressource->berufsgruppen)) ? "block" : "none";
				echo '<p data-berufsgruppe="'.$z->berufsgruppen_id.'" style="display: '.$parent.';"><input class="berufsbezeichnungen" type="checkbox" name="berufsbezeichnungen[]" value="'.$z->id.'" '.$checked.'><i class="icon icon--berufswahl icon--berufsfeld-'.$z->berufsfelder_id.'"></i>'.$z->name.'</p>';
			}
		?>
		</div>
	</article>

	<article class="gd gd--6">

		<h2>Stammdaten</h2>

		<input type="text" name="vorname" id="vorname" placeholder="Vorname" value="<?php echo $vorname; ?>" required>
		<input type="text" name="nachname" id="nachname" placeholder="Nachname" value="<?php echo $nachname; ?>" required>
		<input type="email" name="email" id="email" placeholder="E-Mail" value="<?php echo $email; ?>" required>
		<input type="text" name="telefon" id="telefon" placeholder="Telefon" value="<?php echo $telefon; ?>">

		<h3>Optionale Angaben</h3>

		<div style="position: relative;">
			<label for="dl_gecastet">Gecastete Dienstleister <i class="icon icon--tooltip tooltip" title="Wählen Sie all jene Zeitarbeitsfirmen aus bei denen Sie bereits ein Vorstellungsgespräch hatten. Um Jobangebote annehmen zu können muss ein erfolgtes Vorstellungsgespräch in Ihren Stammdaten eingetragen und von einer Zeitarbeitsfirme bestätigt sein."></i></label>
			<select multiple="multiple" name="dl_gecastet[]" id="dl_gecastet">
				<?php
					foreach ($dienstleister as $d){
						$sel = (in_array_by_id($d, $ressource->dl_gecastet)) ? "selected" : "";
						echo '<option value="'.$d->id.'"" '.$sel.'>'.$d->firmenwortlaut.'</option>';
					}
				?>
			</select>
		</div>

		<div style="position: relative;">
			<label for="dl_blacklist">Dienstleister Blacklist <i class="icon icon--tooltip tooltip" title="Wenn Sie von einzelnen Zeitarbeitsfirmen keine Jobangebote erhalten wollen, markieren Sie diese hier."></i></label>
			<select multiple="multiple" name="dl_blacklist[]" id="dl_blacklist">
				<?php
					foreach ($dienstleister as $d){
						$sel = (in_array_by_id($d, $ressource->dl_blacklist)) ? "selected" : "";
						echo '<option value="'.$d->id.'"" '.$sel.'>'.$d->firmenwortlaut.'</option>';
					}
				?>
			</select>
		</div>
	</article>
	<article class="gd gd--6">
		<h2>Basic Skills</h2>

		<input type="checkbox" name="skill_fuehrerschein" id="skill_fuehrerschein" class="switchable" data-label="Führerschein" <?php echo $skill_fuehrerschein; ?>>
		<input type="checkbox" name="skill_pkw" id="skill_pkw" class="switchable" data-label="Eigener PKW" <?php echo $skill_pkw; ?>>
		<input type="checkbox" name="skill_berufsabschluss" id="skill_berufsabschluss" class="switchable" data-label="Berufsabschluss im ausgewählten Berufsfeld" <?php echo $skill_berufsabschluss; ?>>
		<input type="checkbox" name="skill_eu_buerger" id="skill_eu_buerger" class="switchable" data-label="EU Bürger" <?php echo $skill_eu_buerger; ?>>
		<input type="checkbox" name="skill_rwr_karte" id="skill_rwr_karte" class="switchable" data-label="RWR-Karte" <?php echo $skill_rwr_karte; ?>>
		<input type="text" name="skill_hoechster_schulabschluss" placeholder="Höchster Schulabschluss" value="<?php echo $skill_hoechster_schulabschluss; ?>">
	</article>

	<div style="clear: both;"></div>
	<article class="gd gd--12">
		<h2 class="form-headline">Skills (mind. 1)</h2>
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

				if($wpUserRole == "ressource"){

					foreach($ressource->skills as $s){
						echo '<p class="selected-skills__item" data-id="'.$s->id.'"><input type="hidden" class="skills" name="skills[]" value="'.$s->id.'"><span class="name">'.$s->name.'</span><button type="button" onclick="removeSkillFromList('.$s->id.')">X</button></p>';
					}
				}
			?>

		</div>
	</article>


	<article class="gd gd--12">
		<h2 class="form-headline">Regionen Jobannahme (mind. 1)</h2>
	</article>
	<article class="gd gd--4 region-chooser">
		<div class="select-wrapper">
			<select id="region-chooser__kategorie">
				<?php foreach($bundeslaender as $k){ ?>    
					<option data-kategorie="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
				<?php } ?>
			</select>
		</div>
	</article>
	<article class="gd gd--4 region-chooser">
		<div class="select-wrapper">
			<select id="region-chooser__items">
				<?php foreach($bezirke as $i){ ?>    
					<option data-kategorie="<?php echo $i->bundeslaender_id; ?>" value="<?php echo $i->id; ?>" data-name="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
				<?php } ?>
			</select>
		</div>
	</article>
	<article class="gd gd--4">
		<button type="button" class="button" id="region-chooser__add">Hinzufügen</button>
	</article>
	<article class="gd gd--12">
		<div class="selected-regionen">
			<?php

				if($wpUserRole == "ressource"){
					
					$wien_summe = 23;
					$wien_id = 9;
					$wien_count = 0;
					$wien_selected = array();
					$wien_print_all_as_one = false;
					
					foreach($ressource->bezirke as $s){
						if (intval($s->bundeslaender_id) == $wien_id){
							$wien_count++;
							array_push($wien_selected, intval($s->id));
						}
					}
					
					$wien_print_all_as_one = ($wien_count == $wien_summe);
					if ($wien_print_all_as_one) echo '<p class="selected-regionen__item selected-regionen__item--wien"><span class="name">Alle Wiener Bezirke</span><button type="button" onclick="removeAlleRegionenWien(['.implode(', ', $wien_selected).'])">X</button></p>';
					
					foreach($ressource->bezirke as $s){
						
						$class = ($wien_print_all_as_one && intval($s->bundeslaender_id) == $wien_id) ? "selected-regionen__item selected-regionen__item--hidden" : "selected-regionen__item";
							
						echo '<p class="'.$class.'" data-id="'.$s->id.'"><input type="hidden" class="regionen" name="regionen[]" value="'.$s->id.'"><span class="name">'.$s->name.'</span><button type="button" onclick="removeRegionFromList('.$s->id.')">X</button></p>';
					}
				}
			?>
		</div>
	</article>
	<article class="gd gd--12">
		<button class="button" type="submit">Speichern</button>
	</article>
</form>

<script>

	var checkFields = [
		{
			name: "Vorname",
			selector: "#vorname",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Nachname",
			selector: "#nachname",
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
			name: "Telefon",
			selector: "#telefon",
			type: "single_input",
			check: "empty"
		},
		{
			name: "Berufsfeld",
			selector: ".berufsfelder",
			type: "multipleCheckboxes",
			check: "lengthMind1"
		},
		{
			name: "Berugsgruppe",
			selector: ".berufsgruppen",
			type: "multipleCheckboxes",
			check: "lengthMind1"
		},
		{
			name: "Skill",
			selector: ".skills",
			type: "multipleInputs",
			check: "lengthMind1"
		},
		{
			name: "Region",
			selector: ".regionen",
			type: "multipleInputs",
			check: "lengthMind1"
		}
	];
</script>