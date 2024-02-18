<?php

    /**
     *   Template Name: STAQQ / App / Bestätigungen
     */

    get_header();
    
    if (($wpUserSTAQQUser && $wpUserState)){
        
        if ($wpUserRole == "ressource"){
            
            if ($_POST['action'] == "casting"){

                $response = $api->put("castings", [
                    'ressources_id' => $wpUserSTAQQId,
                    'dienstleister_id' => $_POST['dienstleister_id'],
                    'ressources_verify' => 1,
                    'dienstleister_verify' => $_POST['dienstleister_verify'],
					'creator_type' => 'ressource',
					'creator_id' => $wpUserSTAQQId
                ]);
        
            }
            
            $offen = array();
            $erledigt = array();
            
            $castings = $api->get("ressources/$wpUserSTAQQId/castings", [])->decode_response();
            
            foreach ($castings as $item){
									
				if ($item->dienstleister_user_vorname != null){
					$item->vorname = $item->dienstleister_user_vorname;
					$item->nachname = $item->dienstleister_user_nachname;
				}else{
					$item->vorname = $item->dienstleister_vorname;
					$item->nachname = $item->dienstleister_nachname;
				}
				
                if ((intval($item->ressources_verify) == 1) && (intval($item->dienstleister_verify) == 1)){
                    array_push($erledigt, $item);
                }else{
                    array_push($offen, $item);
                }
            }

?>
   <nav class="section section--full-width section--sub-nav">
        <div class="section__overlay">
            <div class="section__wrapper">
                <ul class="menu menu--sub tab-links">
                    <li class="current-item" data-tab="offen">Vorstellungsgespräch bestätigen <span class="anzahl<?php if(count($offen) == 0) echo ' anzahl--0'; ?>"><?php echo count($offen); ?></span></li>
                    <li data-tab="erledigt">Erfolgte Vorstellungsgespräche <span class="anzahl<?php if(count($erledigt) == 0) echo ' anzahl--0'; ?>"><?php echo count($erledigt); ?></span></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <seciton class="section section--full-width">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12 tab tab--offen tab--active">
                    <?php if (count($offen) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dienstleister</th>
                                <th>Datum der Bestätigung</th>
                                <th>von Ressource<br>bestätigt</th>
                                <th>von Dienstleister<br>bestätigt</th>
                                <th>Bestätigen</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                foreach($offen as $item){
                            ?>
                                <tr>
                                    <td><?php echo "$item->firmenwortlaut ($item->vorname $item->nachname)"; ?></td>
                                    <td><?php echo $item->dienstleister_datetime; ?></td>
                                    <td><?php echo (intval($item->ressources_verify) == 1) ? "Ja" : "Nein"; ?></td>
                                    <td><?php echo (intval($item->dienstleister_verify) == 1) ? "Ja" : "Nein"; ?></td>
                                    <td>
                                        <?php if(intval($item->ressources_verify) == 0){ ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="action" value="casting">
                                                <input type="hidden" name="dienstleister_id" value="<?php echo $item->id; ?>">
                                                <input type="hidden" name="dienstleister_verify" value="<?php echo $item->dienstleister_verify; ?>">
                                                <button class="button" type="submit">Vorstellungsgespräch bestätigen</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    
                        Keine Vorstellungsgespräche zum Bestätigen!
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--neu tab--erledigt">
                    <?php if (count($erledigt) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dienstleister</th>
                                <th>Datum der Bestätigung</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                foreach($erledigt as $item){
                            ?>
                                <tr>
                                    <td><?php echo "$item->firmenwortlaut ($item->vorname $item->nachname)"; ?></td>
                                    <td><?php echo $item->dienstleister_datetime; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    
                        Keine bestätigten Vorstellungsgespräche gefunden!
               
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </seciton>

        
<?php     
        } else if ($wpUserRole == "dienstleister" || ($wpUserRole == "dienstleister_user" && $userBerechtigungen->berechtigung_joborders_schalten)){
            
            if ($_POST['action'] == "casting"){

                $response = $api->put("castings", [
                    'ressources_id' => $_POST['ressources_id'],
                    'dienstleister_id' => $wpUserSTAQQId,
                    'ressources_verify' => $_POST['ressources_verify'],
                    'dienstleister_verify' => 1,
					'creator_type' => $wpUserRole,
					'creator_id' => $wpUserSTAQQId
                ])->decode_response();
        
            } else if ($_POST['action'] == "casting_empfehlung"){

                $response = $api->put("castings", [
                    'ressources_id' => $_POST['ressources_id'],
                    'dienstleister_id' => $wpUserSTAQQId,
                    'ressources_verify' => $_POST['ressources_verify'],
                    'dienstleister_verify' => 1,
                    'empfehlung' => $_POST['empfehlung'],
					'creator_type' => $wpUserRole,
					'creator_id' => $wpUserSTAQQId
                ])->decode_response();
				
            }
            
            $offen = array();
            $erledigt = array();
            
            if ($wpUserRole == "dienstleister"){
				$castings = $api->get("dienstleister/$wpUserSTAQQId/castings", [])->decode_response();
			} elseif ($wpUserRole == "dienstleister_user"){
				$castings = $api->get("dienstleister/$wpUserSTAQQDienstleisterId/user/$wpUserSTAQQId/castings", [])->decode_response();
			}
            
            foreach ($castings as $item){
                if ((intval($item->ressources_verify) == 1) && (intval($item->dienstleister_verify) == 1)){
                    array_push($erledigt, $item);
                }else{
                    array_push($offen, $item);
                }
            }
?>

   <nav class="section section--full-width section--sub-nav">
        <div class="section__overlay">
            <div class="section__wrapper">
                <ul class="menu menu--sub tab-links">
                    <li data-tab="offen" class="current-item">Vorstellungsgespräch bestätigen <span class="anzahl<?php if(count($offen) == 0) echo ' anzahl--0'; ?>"><?php echo count($offen); ?></span></li>
                    <li data-tab="erledigt">Erfolgte Vorstellungsgespräche <span class="anzahl<?php if(count($erledigt) == 0) echo ' anzahl--0'; ?>"><?php echo count($erledigt); ?></span></li>
                </ul>
            </div>
        </div>
    </nav>
    <seciton class="section section--full-width">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12 tab tab--offen tab--active">
                    <?php if (count($offen) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>E-Mail</th>
                                <th>Telefon</th>
                                <th>Datum der Bestätigung</th>
                                <th>Bestätigung mit Empfehlung</th>
                                <th>Bestätigen</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                foreach($offen as $item){
                            ?>
                                <tr>
                                    <td><?php echo $item->vorname; ?></td>
                                    <td><?php echo $item->nachname; ?></td>
                                    <td><?php echo $item->email; ?></td>
                                    <td class="no-wrap"><?php echo $item->telefon; ?></td>
                                    <td><?php echo $item->ressources_datetime; ?></td>
                                    <td>
                                    	<?php if(intval($item->dienstleister_verify) == 0){ ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="action" value="casting_empfehlung">
                                                <input type="hidden" name="ressources_verify" value="<?php echo $item->ressources_verify; ?>">
                                                <input type="hidden" name="ressources_id" value="<?php echo $item->id; ?>">
                                                <input type="hidden" name="empfehlung" value="1">
                                                <button class="button" type="submit">Vorstellungsgespräch bestätigen und für Einsatz empfohlen</button>
                                            </form>
                                        <?php }else{
												  echo (intval($item->empfehlung) == 1) ? "Ja" : "Nein";
											  }
                                   		?>
                                    </td>
                                    <td>
                                        <?php if(intval($item->dienstleister_verify) == 0){ ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="action" value="casting_empfehlung">
                                                <input type="hidden" name="ressources_verify" value="<?php echo $item->ressources_verify; ?>">
                                                <input type="hidden" name="ressources_id" value="<?php echo $item->id; ?>">
                                                <input type="hidden" name="empfehlung" value="0">
                                                <button class="button" type="submit">Vorstellungsgespräch bestätigen</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    
                        Keine Vorstellungsgespräche zum Bestätigen!
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--neu tab--erledigt">
                    <?php if (count($erledigt) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>E-Mail</th>
                                <th>Telefon</th>
                                <th>Datum der Bestätigung</th>
                                <th>Empfehlung</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                foreach($erledigt as $item){
                            ?>
                                <tr>
                                    <td><?php echo $item->vorname; ?></td>
                                    <td><?php echo $item->nachname; ?></td>
                                    <td><?php echo $item->email; ?></td>
                                    <td class="no-wrap"><?php echo $item->telefon; ?></td>
                                    <td><?php echo $item->ressources_datetime; ?></td>
                                    <td><?php echo (intval($item->empfehlung) == 1) ? "Ja" : "Nein"; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    
                        Keine bestätigten Vorstellungsgespräche gefunden!
               
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </seciton>


<?php 
    
        }
        
    }

    get_footer();

?>