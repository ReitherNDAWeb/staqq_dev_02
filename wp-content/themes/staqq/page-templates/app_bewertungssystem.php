<?php

    /**
     *   Template Name: STAQQ / App / Bewertungssystem
     */

    get_header();

	$showError = false;
	$showInfo = false;

	if ($wpUserSTAQQUser && $wpUserState){
		
		if ($_POST['action'] == "update"){

			$response = $api->put("bewertungen", [
				'bewertet_type' => $_POST['bewertet_type'],
				'bewertet_id' 	=> $_POST['bewertet_id'],
				'von_type' 		=> $_POST['von_type'],
				'von_id' 		=> $_POST['von_id'],
				'bewertung' 	=> $_POST['bewertung'],
				'joborders_id'  => $_POST['joborders_id']
			])->decode_response();

		}
		
		$bw = $api->get("bewertungen/$wpUserRole/$wpUserSTAQQId", [])->decode_response();
		
		
		$offen = new stdClass();
		$offen->dienstleister = array();
		$offen->kunden = array();
		$offen->ressources = array();
		
		$bewertet = new stdClass();
		$bewertet->dienstleister = array();
		$bewertet->kunden = array();
		$bewertet->ressources = array();
		
		for ($i=0;$i<count($bw->bewertungen->dienstleister);$i++){
			
			if ($bw->bewertungen->dienstleister[$i]->status == '0'){
				array_push ($offen->dienstleister, $bw->bewertungen->dienstleister[$i]);
			}else{
				array_push ($bewertet->dienstleister, $bw->bewertungen->dienstleister[$i]);
			}
		}
		
		for ($i=0;$i<count($bw->bewertungen->kunden);$i++){
			
			if ($bw->bewertungen->kunden[$i]->status == '0'){
				array_push ($offen->kunden, $bw->bewertungen->kunden[$i]);
			}else{
				array_push ($bewertet->kunden, $bw->bewertungen->kunden[$i]);
			}
		}
		
		for ($i=0;$i<count($bw->bewertungen->ressources);$i++){
			
			if ($bw->bewertungen->ressources[$i]->status == '0'){
				array_push ($offen->ressources, $bw->bewertungen->ressources[$i]);
			}else{
				array_push ($bewertet->ressources, $bw->bewertungen->ressources[$i]);
			}
		}
		
		$meineBewertungen = $api->get("bewertungen/$wpUserRole/$wpUserSTAQQId/bekommen", [])->decode_response();
?>
	
	
	<nav class="section section--full-width section--sub-nav">
		<div class="section__overlay">
			<div class="section__wrapper">
				<ul class="menu menu--sub tab-links">
					<li class="current-item" data-tab="offen">Bewertungen abgeben</li>
					<li data-tab="bewertet">bereits Bewertet</li>
					<li data-tab="erhalten">Erhaltene Bewertungen</li>
					<li data-tab="rating">Rating</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<section class="sectionn">
		<div class="section__overlay">
			<div class="section__wrapper">
			
				<article class="gd gd--12 tab tab--offen tab--active">
					<?php if (count($offen->dienstleister) > 0) { ?>
					<h2>Dienstleister</h2>
					<p>Möchten Sie in Zukunft mit diesem Dienstleister zusammenarbeiten?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Dienstleister</th>
								<?php
									if ($wpUserRole == "ressource"){
										echo "<th>bei Kunde</th>";
									} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
										echo "<th>Ressourcen</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($offen->dienstleister as $item){
							?>

								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
									<td><?php echo $item->bewertet_name; ?></td>
									<?php if ($wpUserRole == "ressource"){ ?>
										<td><?php echo $item->kunde->firmenwortlaut; ?></td>
									<?php } ?>
									<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
										<td><?php echo implode(', ', $item->ressources); ?></td>
									<?php } ?>
									<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Speichern</button>
										</td>
									</tr>
								</form>

						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($offen->ressources) > 0) { ?>
					<br><br>
					<h2>Ressourcen</h2>
					<p>Würden Sie diese Ressource wieder einsetzen?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Ressource</th>
								<?php
									if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										echo "<th>bei Kunde</th>";
									} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
										echo "<th>über Dienstleister</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($offen->ressources as $item){
							?>
								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
										<td><?php echo $item->bewertet_name; ?></td>
										<?php if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){ ?>
											<td><?php echo $item->kunde->firmenwortlaut; ?></td>
										<?php } ?>
										<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
											<td><?php echo $item->dienstleister->firmenwortlaut; ?></td>
										<?php } ?>
										<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Speichern</button>
										</td>
									</tr>
								</form>
						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($offen->kunden) > 0) { ?>
					<br><br>
					<h2>Kunden</h2>
					<p>Würden Sie mit diesen Kunden wieder arbeiten?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Kunde</th>
								<?php
									if ($wpUserRole == "ressource"){
										echo "<th>über Dienstleister</th>";
									} elseif ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										echo "<th>Ressourcen</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($offen->kunden as $item){
							?>

								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
										<td><?php echo $item->bewertet_name; ?></td>
										<?php if ($wpUserRole == "ressource"){ ?>
											<td><?php echo $item->dienstleister->firmenwortlaut; ?></td>
										<?php
											}

											if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										?>
											<td><?php echo implode(', ', $item->ressources); ?></td>
										<?php } ?>
										<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Speichern</button>
										</td>
									</tr>
								</form>

						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($offen->kunden) == 0 && count($offen->dienstleister) == 0 && count($offen->ressources) == 0) { ?>
						<p>Derzeit keine offenen Bewertungen verfügbar.</p>
					<?php } ?>		

				</article>
				
				<article class="gd gd--12 tab tab--bewertet">
					<?php if (count($bewertet->dienstleister) > 0) { ?>
					<h2>Dienstleister</h2>
					<p>Möchten Sie in Zukunft mit diesem Dienstleister zusammenarbeiten?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Dienstleister</th>
								<?php
									if ($wpUserRole == "ressource"){
										echo "<th>bei Kunde</th>";
									} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
										echo "<th>Ressourcen</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertet->dienstleister as $item){
							?>

								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
									<td><?php echo $item->bewertet_name; ?></td>
									<?php if ($wpUserRole == "ressource"){ ?>
										<td><?php echo $item->kunde->firmenwortlaut; ?></td>
									<?php } ?>
									<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
										<td><?php echo implode(', ', $item->ressources); ?></td>
									<?php } ?>
									<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Aktualisieren</button>
										</td>
									</tr>
								</form>

						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($bewertet->ressources) > 0) { ?>
					<br><br>
					<h2>Ressourcen</h2>
					<p>Würden Sie diese Ressource wieder einsetzen?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Ressource</th>
								<?php
									if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										echo "<th>bei Kunde</th>";
									} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
										echo "<th>über Dienstleister</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertet->ressources as $item){
							?>
								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
										<td><?php echo $item->bewertet_name; ?></td>
										<?php if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){ ?>
											<td><?php echo $item->kunde->firmenwortlaut; ?></td>
										<?php } ?>
										<?php if ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){ ?>
											<td><?php echo $item->dienstleister->firmenwortlaut; ?></td>
										<?php } ?>
										<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Aktualisieren</button>
										</td>
									</tr>
								</form>
						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($bewertet->kunden) > 0) { ?>
					<br><br>
					<h2>Kunden</h2>
					<p>Würden Sie mit diesen Kunden wieder arbeiten?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Kunde</th>
								<?php
									if ($wpUserRole == "ressource"){
										echo "<th>über Dienstleister</th>";
									} elseif ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										echo "<th>Ressourcen</th>";
									}
								?>
								<th>Einsatz</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertet->kunden as $item){
							?>

								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="bewertet_type" value="<?php echo $item->bewertet_type; ?>">
									<input type="hidden" name="bewertet_id" value="<?php echo $item->bewertet_id; ?>">
									<input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
									<input type="hidden" name="von_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="von_id" value="<?php echo $wpUserSTAQQId; ?>">

									<tr class="joborder">
										<td><?php echo $item->bewertet_name; ?></td>
										<?php if ($wpUserRole == "ressource"){ ?>
											<td><?php echo $item->dienstleister->firmenwortlaut; ?></td>
										<?php
											}

											if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
										?>
											<td><?php echo implode(', ', $item->ressources); ?></td>
										<?php } ?>
										<td><?php echo $item->joborders_arbeitsbeginn; ?> - <?php echo $item->joborders_arbeitsende; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button">Aktualisieren</button>
										</td>
									</tr>
								</form>

						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>

					<?php if (count($bewertet->kunden) == 0 && count($bewertet->dienstleister) == 0 && count($bewertet->ressources) == 0) { ?>
						<p>Noch keine bereits bewerteten Einsätze.</p>
					<?php } ?>		

				</article>

				<article class="gd gd--12 tab tab--erhalten">
					<?php if ($wpUserRole != "dienstleister" && $wpUserRole != "dienstleister_user"){ ?>
					<h2>Dienstleister</h2>
					<?php if (count($meineBewertungen->dienstleister) > 0){ ?>
						<table class="table joborder-table">
							<thead>
								<tr>
									<th>Bewertet von</th>
									<th>bei/mit</th>
									<th>Job</th>
									<th>Einsatz</th>
									<th>Bewertung</th>
								</tr>
							</thead>
							<tbody class="joborders">
								<?php foreach ($meineBewertungen->dienstleister as $item){ ?>
								<tr>
									<td><?php echo $item->von_name; ?></td>
									<td>
										<?php
																				 
											if ($wpUserRole == "ressource"){

												if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}

											} elseif ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){

												if ($item->von_type == "ressource"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo implode(', ', $item->ressources);
												}

											} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
												if ($item->von_type == "ressource"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}else if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo implode(', ', $item->ressources);
												}
											}

										?>
									</td>
									<td><?php echo $item->jobtitel; ?></td>
									<td><?php echo $item->joborders_arbeitsbeginn . " - " . $item->joborders_arbeitsende; ?></td>
									<td><?php echo $item->bewertung; ?> von 4</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
						<p>Sie haben noch keine Bewertung von einem Dienstleister erhalten.</p>
					<?php } ?>
					<?php } ?>
					
					<?php if ($wpUserRole != "ressource"){ ?>
					<br><br>
					<h2>Bewerber</h2>
					<?php if (count($meineBewertungen->ressources) > 0){ ?>
						<table class="table joborder-table">
							<thead>
								<tr>
									<th>Bewertet von</th>
									<th>bei/mit</th>
									<th>Job</th>
									<th>Einsatz</th>
									<th>Bewertung</th>
								</tr>
							</thead>
							<tbody class="joborders">
								<?php foreach ($meineBewertungen->ressources as $item){ ?>
								<tr>
									<td><?php echo $item->von_name; ?></td>
									<td>
										<?php
																				 
											if ($wpUserRole == "ressource"){

												if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}

											} elseif ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){

												if ($item->von_type == "ressource"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo implode(', ', $item->ressources);
												}

											} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
												if ($item->von_type == "ressource"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}else if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo implode(', ', $item->ressources);
												}
											}

										?>
									</td>
									<td><?php echo $item->jobtitel; ?></td>
									<td><?php echo $item->joborders_arbeitsbeginn . " - " . $item->joborders_arbeitsende; ?></td>
									<td><?php echo $item->bewertung; ?> von 4</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
						<p>Sie haben noch keine Bewertung eines Bewerbers erhalten.</p>
					<?php } ?>
					<?php } ?>
					
					
					<?php if ($wpUserRole != "kunde" && $wpUserRole != "kunde_user"){ ?>
					<br><br>
					<h2>Kunden</h2>
					<?php if (count($meineBewertungen->kunden) > 0){ ?>
						<table class="table joborder-table">
							<thead>
								<tr>
									<th>Bewertet von</th>
									<th>bei/mit</th>
									<th>Job</th>
									<th>Einsatz</th>
									<th>Bewertung</th>
								</tr>
							</thead>
							<tbody class="joborders">
								<?php foreach ($meineBewertungen->kunden as $item){ ?>
								<tr>
									<td><?php echo $item->von_name; ?></td>
									<td>
										<?php
																				 
											if ($wpUserRole == "ressource"){

												if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}

											} elseif ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){

												if ($item->von_type == "ressource"){
													echo "bei " . $item->kunde->firmenwortlaut;
												}else if ($item->von_type == "kunde" || $item->von_type == "kunde_user"){
													echo implode(', ', $item->ressources);
												}

											} elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
												if ($item->von_type == "ressource"){
													echo "über " . $item->dienstleister->firmenwortlaut;
												}else if ($item->von_type == "dienstleister" || $item->von_type == "dienstleister_user"){
													echo implode(', ', $item->ressources);
												}
											}

										?>
									</td>
									<td><?php echo $item->jobtitel; ?></td>
									<td><?php echo $item->joborders_arbeitsbeginn . " - " . $item->joborders_arbeitsende; ?></td>
									<td><?php echo $item->bewertung; ?> von 4</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } else { ?>
						<p>Sie haben noch keine Bewertung von einem Dienstleister erhalten.</p>
					<?php } ?>
				<?php } ?>
				
				</article>

			
				<article class="gd gd--12 tab tab--rating">
					<h2>Ihr Rating</h2>
					<h1 class="rating"><?php echo $bw->durchschnitt; ?> <span>/ <?php echo $bw->anzahl_bewertungen; ?> Bewertungen</span></h1>
				</article>
			</div>
		</div>
	</section>
	
<?php
		
	}

    get_footer();
?>				