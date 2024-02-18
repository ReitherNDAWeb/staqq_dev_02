<?php

    require_once get_template_directory().'/vendor/restclient.php';
    
    if ($_POST['action'] == "update"){
        
        
       // if (isset($_POST['user_type']) && isset($_POST['user_id']) && isset($_POST['creator_type']) && isset($_POST['creator_id'] && isset($_POST['bewertung'])){
			
		$response = $api->put("bewertungen", [
			'user_type' => $_POST['user_type'],
			'user_id' => $_POST['user_id'],
			'creator_type' => $_POST['creator_type'],
			'creator_id' => $_POST['creator_id'],
			'bewertung' => $_POST['bewertung']
		])->decode_response();
        
    }

    /**
     *   Template Name: STAQQ / App / Joborders / Bewertungen
     */

    get_header();
    
    $bewertungen = $api->get("bewertungen/alle/$wpUserRole/$wpUserSTAQQId", [])->decode_response();
	
?>
   
    <seciton class="section joborder-detail">
        <div class="section__overlay">
            
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h1>Bewertungen</h1>
                	
                	<?php if (count($bewertungen->dienstleister) > 0) { ?>
                	<h2>Dienstleister</h2>
                	<p>Möchten Sie in Zukunft mit diesem Dienstleister zusammenarbeiten?</p>
                	<table class="table joborder-table">
						<thead>
							<tr>
								<th>Dienstleister</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertungen->dienstleister as $item){
							?>
							
								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="user_type" value="dienstleister">
									<input type="hidden" name="user_id" value="<?php echo $item->dienstleister_id; ?>">
									<input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
									
									<tr class="joborder">
									<td><?php echo $item->firmenwortlaut; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button"><?php if($item->status == "1"){ ?>Aktualisieren<?php }else{ ?>Speichern<?php } ?></button>
										</td>
									</tr>
								</form>
								
						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>
					
					<?php if (count($bewertungen->ressources) > 0) { ?>
					<br><br>
                	<h2>Ressourcen</h2>
                	<p>Würden Sie diese Ressource wieder einsetzen?</p>
					<table class="table joborder-table">
						<thead>
							<tr>
								<th>Ressource</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertungen->ressources as $item){
							?>
								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="user_type" value="ressources">
									<input type="hidden" name="user_id" value="<?php echo $item->ressources_id; ?>">
									<input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
									
									<tr class="joborder">
										<td><?php echo $item->vorname; ?> <?php echo $item->nachname; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button"><?php if($item->status == "1"){ ?>Aktualisieren<?php }else{ ?>Speichern<?php } ?></button>
										</td>
									</tr>
								</form>
						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>
					
					<?php if (count($bewertungen->kunden) > 0) { ?>
					<br><br>
                	<h2>Kunden</h2>
                	<p>Würden Sie mit diesen Kunden wieder arbeiten?</p>
                	<table class="table joborder-table">
						<thead>
							<tr>
								<th>Kunde</th>
								<th>Bewertung vorhanden</th>
								<th>Meine Bewertung</th>
								<th>Speichern</th>
							</tr>
						</thead>
						<tbody class="joborders">

							<?php
								foreach($bewertungen->kunden as $item){
							?>
							
								<form action="" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="user_type" value="kunden">
									<input type="hidden" name="user_id" value="<?php echo $item->kunden_id; ?>">
									<input type="hidden" name="creator_type" value="<?php echo $wpUserRole; ?>">
									<input type="hidden" name="creator_id" value="<?php echo $wpUserSTAQQId; ?>">
									
									<tr class="joborder">
									<td><?php echo $item->firmenwortlaut; ?></td>
										<td><?php echo ($item->status == "1") ? "bewertet" : "offen"; ?></td>
										<td>
											<div class="select-wrapper">
												<select name="bewertung" id="bewertung">
													<option value="1" <?php if ($item->bewertung == "1") echo "selected"; ?>>auf keinen Fall</option>
													<option value="2" <?php if ($item->bewertung == "2") echo "selected"; ?>>wenn es sein muss</option>
													<option value="3" <?php if ($item->bewertung == "3") echo "selected"; ?>>gerne</option>
													<option value="4" <?php if ($item->bewertung == "4") echo "selected"; ?>>unbedingt</option>
												</select>
											</div>
										</td>
										<td>
											<button type="submit" class="button"><?php if($item->status == "1"){ ?>Aktualisieren<?php }else{ ?>Speichern<?php } ?></button>
										</td>
									</tr>
								</form>
								
						   <?php
								}
							?>
						</tbody>
					</table>
					<?php } ?>
               
               
                </article>
            </div>
        </div>
    </seciton>
    
<?php

    get_footer();

?>