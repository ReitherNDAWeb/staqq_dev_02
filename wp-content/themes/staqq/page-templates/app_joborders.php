<?php

    /**
     *   Template Name: STAQQ / App / Joborders
     */

    require_once get_template_directory().'/vendor/restclient.php';
    
    if ($_POST['action'] == "einsatz_bestaetigen"){

        $rid = $_POST['ressources_id'];
        $bid = $_POST['bewerbung_id'];
            
        $response = $api->put("ressources/$rid/bewerbungen/$bid/einsatzBestaetigen", [])->decode_response();
        
        if ($response->status){
            wp_redirect('app/joborders/');
            exit;
        }
        
    } else if ($_POST['action'] == "einsatz_verify"){
        
        $response = $api->put("bewerbungen/einsatzVerify/ressource", [
            'ressources_id' => $_POST['ressources_id'],
            'joborders_id' => $_POST['joborders_id']
        ])->decode_response();
        
        if ($response->status){
            wp_redirect('app/joborders/');
            exit;
        }
        
    } else if ($_POST['action'] == "joborders_dienstleister_user_delegieren__post"){
        
        $response = $api->post("dienstleister/{$_POST['dienstleister_id']}/delegationen", [
            'joborders_id' => $_POST['joborders_id'],
            'dienstleister_user_id' => $_POST['dienstleister_user_id']
        ])->decode_response();
        
        if ($response->status){
            wp_redirect('app/joborders/');
            exit;
        }
        
    } else if ($_POST['action'] == "joborders_dienstleister_user_delegieren__delete"){
        
        $response = $api->delete("dienstleister/{$_POST['dienstleister_id']}/delegationen", [
            'joborders_id' => $_POST['joborders_id'],
            'dienstleister_user_id' => $_POST['dienstleister_user_id']
        ])->decode_response();
        
        if ($response->status){
            wp_redirect('app/joborders/');
            exit;
        }
        
    }

    get_header();

    if (($wpUserSTAQQUser && $wpUserState)){
        
        if ($wpUserRole == "ressource"){
            
            $joborders = $api->get("ressources/$wpUserSTAQQId/joborders", [])->decode_response();
            $gemerkte = $api->get("ressources/$wpUserSTAQQId/gemerkte", [])->decode_response();
            
            $bewerbungen = $api->get("ressources/$wpUserSTAQQId/bewerbungen", [])->decode_response(); 
            
            $angenommen = array();
            $anderwaertig_vergeben = array();
            $erhalten = array();
            $erledigt = array();
            
            foreach($bewerbungen as $item){
                if (strtotime($item->arbeitsbeginn) > time()){
                    if ($item->status == "beworben"){
                        if (intval($item->joborder_alle_ressourcen_vergeben)){
                            array_push($anderwaertig_vergeben, $item);
                        }else if (intval($item->joborders_in_zeitraum_vergeben)){
                            array_push($anderwaertig_vergeben, $item);
                        }else if (intval($item->dienstleister_joborder_abgelehnt)){
                            array_push($anderwaertig_vergeben, $item);
                        }else{
                            array_push($angenommen, $item);
                        }
                    } else if ($item->status == "abgelehnt"){
                        array_push($anderwaertig_vergeben, $item);
                    }else if ($item->status == "vergeben"){
                        array_push($erhalten, $item);
                    } else if($item->status == "einsatz_bestaetigt"){
                        if ((intval($item->dienstleister_einsatz_bestaetigt) == 1) && (intval($item->ressource_einsatz_bestaetigt) == 1)){
                            array_push($erledigt, $item);
                        }else{
                            array_push($erhalten, $item);
                        }
                    }
                }elseif ($item->status == "einsatz_bestaetigt"){
                    if ((intval($item->dienstleister_einsatz_bestaetigt) == 1) && (intval($item->ressource_einsatz_bestaetigt) == 1)){
                        array_push($erledigt, $item);
                    }else{
                        array_push($erhalten, $item);
                    }
                }
            }
?>
    <nav class="section section--full-width section--sub-nav">
        <div class="section__overlay">
            <div class="section__wrapper">
                <ul class="menu menu--sub tab-links">
                    <?php require_once('parts/joborders/submenu/_submenu-ressources.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <seciton class="section section--full-width">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12 tab tab--neu tab--active">
               
                    <?php if (count($joborders) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4-5">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($joborders as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php 
                                        
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />sucht für ".$tmp_kd;
                                                }else{
                                                    
                                                    echo $item->kunde_name_inkl_bewertung;
                                                                                            
                                                    if (intval($item->dienstleister_vorgegeben)){
                                                        if (intval($item->dienstleister_single)){
                                                            echo "<br />sucht über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                        }else{
                                                            echo "<br />sucht über mehrere Arbeitgeber";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td class="joborder__actions">
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button tooltip-hover" title="Details ansehen"><i class="icon icon--eye"></i></a>
                                            
                                            <form action="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" method="post" class="tooltip-hover" title="Annehmen">
                                                <input type="hidden" name="action" value="ressource_bewerben">
                                                <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                                                <input type="hidden" name="joborders_id" value="<?php echo $item->id; ?>">
                                                <input type="hidden" name="dienstleister_id" value="<?php echo $item->dienstleister_id; ?>">
                                                <input type="hidden" name="dienstleister_vorgegeben" value="<?php echo $item->dienstleister_vorgegeben; ?>">
                                                <input type="hidden" name="dienstleister_single" value="<?php echo $item->dienstleister_single; ?>">
                                                <input type="hidden" name="from_list" value="1">
                                                <button type="submit">
                                                    <div class="joborder-button joborder-button--annehmen"></div>
                                                </button>
                                            </form>
                                            
                                            <form action="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" method="post" class="tooltip-hover" title="Ablehnen">
                                                <input type="hidden" name="action" value="ressource_ablehnen">
                                                <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                                                <input type="hidden" name="joborders_id" value="<?php echo $item->id; ?>">
                                                <button type="submit">
                                                    <div class="joborder-button joborder-button--ablehnen"></div>
                                                </button>
                                            </form>
                                            
                                            <form action="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" method="post" class="tooltip-hover" title="Merken">
                                                <input type="hidden" name="action" value="ressource_merken">
                                                <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                                                <input type="hidden" name="joborders_id" value="<?php echo $item->id; ?>">
                                                <button type="submit">
                                                    <div class="joborder-button joborder-button--merken"></div>
                                                </button>
                                            </form>
                                            
                                            <?php 
                                                
                                                if ($item->joborders_in_zeitraum == "1") echo " Z"; 
                                            
                                            ?>
                                            
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                    Aktuell leider keine neuen Jobs für dich!
               
                    <?php endif; ?>
                    
                </article>
                <article class="gd gd--12 tab tab--gemerkt">
                    <?php if (count($gemerkte) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($gemerkte as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php 
                                        
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />sucht für ".$tmp_kd;
                                                }else{
                                                    
                                                    echo $item->kunde_name_inkl_bewertung;
                                                                                            
                                                    if (intval($item->dienstleister_vorgegeben)){
                                                        if (intval($item->dienstleister_single)){
                                                            echo "<br />sucht über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                        }else{
                                                            echo "<br />sucht über mehrere Arbeitgeber";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                            
                                            <?php 
                                                
                                                if ($item->joborders_in_zeitraum == "1") echo " Z"; 
                                            
                                            ?>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                        keine gemerkten Joborders
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--angenommen">
                    <?php if (count($angenommen) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($angenommen as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php
                                                
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />für ".$tmp_kd;
                                                }else{
                                                    echo $item->kunde_name_inkl_bewertung;
                                                    echo "<br />über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->joborders_id); ?>" class="button">Ansehen</a>
                                            
                                            <?php 
                                                if ($item->joborders_in_zeitraum == "1") echo " Z";
                                            ?>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                        keine angenommenen Joborders
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--anderwaertig-vergeben">
                    <?php if (count($anderwaertig_vergeben) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($anderwaertig_vergeben as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php
                                                
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />für ".$tmp_kd;
                                                }else{
                                                    echo $item->kunde_name_inkl_bewertung;
                                                    echo "<br />über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td>
                                            Der Job wurde leider schon anderwärtig vergeben!
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                        keine anderwärtig vergebene Joborders
               
                    <?php endif; ?>
                </article>
<!--                <article class="gd gd--12 tab tab--casting">Casting</article>-->
                <article class="gd gd--12 tab tab--erhalten">
                    <?php if (count($erhalten) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Anzeigen</th>
                                    <th>Annahme-Bestätigung</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($erhalten as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php
                                                
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />für ".$tmp_kd;
                                                }else{
                                                    echo $item->kunde_name_inkl_bewertung;
                                                    echo "<br />über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->joborders_id); ?>" class="button">Ansehen</a>
                                        </td>
                                        <td>
                                            <?php if ($item->status == "vergeben"){ ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="action" value="einsatz_bestaetigen">
                                                <input type="hidden" name="bewerbung_id" value="<?php echo $item->id; ?>">
                                                <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                                                <button class="button" type="submit">Einsatz bestätigen</button>
                                            </form>
                                            <?php }elseif($item->status == "einsatz_bestaetigt"){
                                                    
                                                    if (intval($item->ressource_einsatz_bestaetigt) == 1){
                                                        echo "Du hast den Job angenommen und den Einsatz bestätigt!";
                                                    }else{
                                            ?>      
                                            
                                                    <form action="" method="post">
                                                        <input type="hidden" name="action" value="einsatz_verify">
                                                        <input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
                                                        <input type="hidden" name="ressources_id" value="<?php echo $wpUserSTAQQId; ?>">
                                                        <button class="button" type="submit">Arbeitsbeginn bestätigen</button>
                                                    </form>
                                                                    
                                            <?php           
                                                    }
                                            
                                                }else{
                                                    echo "Du hast den Job angenommen!";
                                                } 
                                            ?>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    
                        keine bestätigten Jobs
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--erledigt">
                    <?php if (count($erledigt) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Arbeitgeber</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($erledigt as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php
                                                
                                                if ($item->publisher_type == "dienstleister"){
                                                    echo "<a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                    $tmp_kd = $item->kunde_name_inkl_bewertung ? $item->kunde_name_inkl_bewertung : $item->kunde_name;
                                                    if (intval($item->kunde_anzeigen)) echo " <br />für ".$tmp_kd;
                                                }else{
                                                    echo $item->kunde_name_inkl_bewertung;
                                                    echo "<br />über <a href='{$item->dienstleister_website}' target='_blank'>{$item->dienstleister_firmenwortlaut_inkl_bewertung}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->joborders_id); ?>" class="button">Ansehen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                        keine erledigten Jobs
               
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </seciton>
    
    
    
    
    
    
    
    
    
    
    
    
<?php     
        } else if ($wpUserRole == "dienstleister" || ($wpUserRole == "dienstleister_user" && $userBerechtigungen->berechtigung_joborders_schalten)){
            
            $delegation = false;
            
            if ($wpUserRole == "dienstleister"){
                $joborders = $api->get("dienstleister/$wpUserSTAQQId/joborders", [])->decode_response();
                $dlid = $wpUserSTAQQId;
                $delegation = ($dl->joborder_empfaenger_user == null) ? false : true;
            }else{
                $joborders = $api->get("dienstleister/$wpUserSTAQQDienstleisterId/user/$wpUserSTAQQId/joborders", [])->decode_response();
                $dlid = $wpUserSTAQQDienstleisterId;
                $dl = $api->get("dienstleister/$dlid", [])->decode_response();
                $delegation = ($dl->joborder_empfaenger_user == $wpUserSTAQQId) ? true : false;
            }
            
            $offen = array();
            $vergeben = array();
            $erledigt = array();
            
            foreach($joborders as $item){

                
                if ((intval($item->anzahl_bewerbungen_einsatz_bestaetigt) > 0) && (intval($item->anzahl_bewerbungen_einsatz_bestaetigt) == intval($item->anzahl_bewerbungen_erfolgter_einsatz_bestaetigt))){
                    array_push($erledigt, $item);
                } elseif (($item->anzahl_bewerbungen_vergeben + $item->anzahl_bewerbungen_einsatz_bestaetigt) == $item->anzahl_ressourcen){
                    array_push($vergeben, $item);
                } else{
                    array_push($offen, $item);
                }
            }
?>
   
    <nav class="section section--full-width section--sub-nav">
        <div class="section__overlay">
            <div class="section__wrapper">
                <ul class="menu menu--sub tab-links">
                    <li class="current-item" data-tab="offen">Offen <span class="anzahl<?php if(count($offen) == 0) echo ' anzahl--0'; ?>"><?php echo count($offen); ?></span></li>
                    <li data-tab="vergeben">Vergeben <span class="anzahl<?php if(count($vergeben) == 0) echo ' anzahl--0'; ?>"><?php echo count($vergeben); ?></span></li>
                    <li data-tab="erledigt">Erledigt <span class="anzahl<?php if(count($erledigt) == 0) echo ' anzahl--0'; ?>"><?php echo count($erledigt); ?></span></li>
                    
                    <?php if ($delegation) { ?>
                    <li data-tab="delegieren">Jobs an Sub-User delegieren</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
            
    <seciton class="section section--full-width">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <a href="/app/joborders/neu/" class="button">Neue Joborder</a>
                    <a href="/app/joborders/templates/" class="button">Neue Joborder aus Vorlage</a>
                </article>
                
                <!-- Tabs -->
                <article class="gd gd--12 tab tab--offen tab--active">
               
                    <?php if (count($offen) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Erstellt von</th>
                                    <th>Bewerber</th>
                                    <th>vergeben/bestätigt</th>
                                    <th>Anzeigen</th>
                                    <th>Als verloren markieren</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($offen as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($item->creator_type == $wpUserRole && $item->creator_id == $wpUserSTAQQId){
                                                    echo "Eigene (für ".$item->kunde_name.")";
                                                } else {
                                                    echo "<a href='{$item->kunden_website}' target='_blank'>{$item->kunden_firmenwortlaut}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                        
                                                if (intval($item->anzahl_bewerbungen_noch_verfuegbar) > 0) {
                                            ?>
                                                    <a href="/app/joborders/ressourcen/?id=<?php echo hashId($item->id); ?>&from=/app/joborders/&from_hash=offen" class="button"><?php echo $item->anzahl_bewerbungen_gesamt; ?></a>
                                            <?php 
                                        
                                                }else{
                                                    echo $item->anzahl_bewerbungen_noch_verfuegbar;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->anzahl_bewerbungen_vergeben + $item->anzahl_bewerbungen_einsatz_bestaetigt; ?> / <?php echo $item->anzahl_bewerbungen_einsatz_bestaetigt; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                        <td>
											<form action="/app/actions/" method="post">
												<input type="hidden" name="action" value="dienstleistter_joborders__joborder_ablehnen">
												<input type="hidden" name="joborders_id" value="<?php echo $item->id; ?>">
												<input type="hidden" name="dienstleister_id" value="<?php echo $wpUserSTAQQDienstleisterId; ?>">
												<button type="submit" class="button">Verloren</button>
											</form>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                       keine offenen Joborders
               
                    <?php endif; ?>
                    
                </article>
                <article class="gd gd--12 tab tab--vergeben">
                    <?php if (count($vergeben) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Erstellt von</th>
                                    <th>Bewerber</th>
                                    <th>vergeben/bestätigt</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($vergeben as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($item->creator_type == $wpUserRole && $item->creator_id == $wpUserSTAQQId){
                                                    echo "Eigene (für ".$item->kunde_name.")";
                                                } else {
                                                    echo "<a href='{$item->kunden_website}' target='_blank'>{$item->kunden_firmenwortlaut}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                        
                                                if (intval($item->anzahl_bewerbungen_noch_verfuegbar) > 0) {
                                            ?>
                                                    <a href="/app/joborders/ressourcen/?id=<?php echo hashId($item->id); ?>&from=/app/joborders/&from_hash=vergeben" class="button"><?php echo $item->anzahl_bewerbungen_gesamt; ?></a>
                                            <?php 
                                        
                                                }else{
                                                    echo $item->anzahl_bewerbungen_noch_verfuegbar;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->anzahl_bewerbungen_vergeben + $item->anzahl_bewerbungen_einsatz_bestaetigt; ?> / <?php echo $item->anzahl_bewerbungen_einsatz_bestaetigt; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    
                       keine vergebenen Joborders
               
                    <?php endif; ?>
                    
                </article>
                <article class="gd gd--12 tab tab--erledigt">
                    <?php if (count($erledigt) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Erstellt von</th>
                                    <th>Bewerber</th>
                                    <th>vergeben/bestätigt</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($erledigt as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($item->creator_type == $wpUserRole && $item->creator_id == $wpUserSTAQQId){
                                                    echo "Eigene (für ".$item->kunde_name.")";
                                                } else {
                                                    echo "<a href='{$item->kunden_website}' target='_blank'>{$item->kunden_firmenwortlaut}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                        
                                                if (intval($item->anzahl_bewerbungen_noch_verfuegbar) > 0) {
                                            ?>
                                                    <a href="/app/joborders/ressourcen/?id=<?php echo hashId($item->id); ?>&from=/app/joborders/&from_hash=erledigt" class="button"><?php echo $item->anzahl_bewerbungen_gesamt; ?></a>
                                            <?php 
                                        
                                                }else{
                                                    echo $item->anzahl_bewerbungen_noch_verfuegbar;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->anzahl_bewerbungen_vergeben + $item->anzahl_bewerbungen_einsatz_bestaetigt; ?> / <?php echo $item->anzahl_bewerbungen_einsatz_bestaetigt; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    
                       keine erledigten Joborders
               
                    <?php endif; ?>
                </article>
               
                <?php 
                        
                    if ($delegation){
                        
                        $users = $api->get("dienstleister/$dlid/user", [])->decode_response();
                        $delegationenAvailableJoborders = $api->get("dienstleister/$dlid/delegationen/availableJoborders", [])->decode_response();
                        $delegationen = $api->get("dienstleister/$dlid/delegationen", [])->decode_response();
                
                ?>
                <article class="gd gd--12 tab tab--delegieren">
                    <form action="/app/joborders/" method="post" class="tab--delegieren__post_delegieren_form">
                    
                        <input type="hidden" name="action" value="joborders_dienstleister_user_delegieren__post">
                        <input type="hidden" name="dienstleister_id" value="<?php echo $wpUserSTAQQId; ?>">

                        <div class="select-wrapper">
                            <select name="joborders_id" id="joborders_id">
                                 <?php foreach($delegationenAvailableJoborders as $joborder) { ?>
                                    <option value="<?php echo $joborder->id; ?>"><?php echo "{$joborder->jobtitel} ({$joborder->arbeitsbeginn} - {$joborder->arbeitsende})"; ?></option>
                                 <?php } ?>
                            </select>
                        </div>
                        <div class="select-wrapper">
                            <select name="dienstleister_user_id" id="dienstleister_user_id">
                                 <?php foreach($users as $user) { ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo "{$user->vorname} {$user->nachname}"; ?></option>
                                 <?php } ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="button">Joborder an User delegieren</button>
                    </form>
                
                    <?php if (count($delegationen) > 0): ?>
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Erstellt von</th>
                                    <th>Delegiert an</th>
                                    <th>Zurückziehen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($delegationen as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($item->creator_type == $wpUserRole && $item->creator_id == $wpUserSTAQQId){
                                                    echo "Eigene (für ".$item->kunde_name.")";
                                                } else {
                                                    echo "<a href='{$item->kunden_website}' target='_blank'>{$item->kunden_firmenwortlaut}</a>";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $item->dienstleister_user_vorname; ?> <?php echo $item->dienstleister_user_nachname; ?>
                                        </td>
                                        <td>
                                            <form action="/app/joborders/" method="post">
                                                <input type="hidden" name="action" value="joborders_dienstleister_user_delegieren__delete">
                                                <input type="hidden" name="joborders_id" value="<?php echo $item->joborders_id; ?>">
                                                <input type="hidden" name="dienstleister_id" value="<?php echo $item->dienstleister_id; ?>">
                                                <input type="hidden" name="dienstleister_user_id" value="<?php echo $item->dienstleister_user_id; ?>">
                                                <button type="submit" class="button">Delegation zurückziehen</button>
                                            </form>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    
                    <?php else: ?>
                    
                       <p>keine bereits delegierten Joborders verfügbar</p>
               
                    <?php endif; ?>
                </article>
                <?php } ?>
            </div>
        </div>
    </seciton>
    
    
    
    
    
    
    
    
    
    
    
    
<?php
        } else if ($wpUserRole == "kunde" || ($wpUserRole == "kunde_user" && $userBerechtigungen->berechtigung_joborders_schalten)){
            
            
            
            if ($wpUserRole == "kunde"){
                $joborders = $api->get("kunden/$wpUserSTAQQId/joborders", [])->decode_response();
            }else{
                $joborders = $api->get("kunden/$wpUserSTAQQKundeId/user/$wpUserSTAQQId/joborders", [])->decode_response();
            }
            
            $offen = array();
            $vergeben = array();
            $erledigt = array();
            
            
            
            foreach($joborders as $item){
                
                if ((intval($item->anzahl_bewerbungen_einsatz_bestaetigt) > 0) && (intval($item->anzahl_bewerbungen_einsatz_bestaetigt) == intval($item->anzahl_bewerbungen_erfolgter_einsatz_bestaetigt))){
                    array_push($erledigt, $item);
                } elseif (intval($item->anzahl_bewerbungen_einsatz_bestaetigt) == intval($item->anzahl_ressourcen)){
                    array_push($vergeben, $item);
                } else{
                    array_push($offen, $item);
                }
            }
 ?>
   
    <nav class="section section--full-width section--sub-nav">
        <div class="section__overlay">
            <div class="section__wrapper">
                <ul class="menu menu--sub tab-links">
                    <li class="current-item" data-tab="offen">Offen <span class="anzahl<?php if(count($offen) == 0) echo ' anzahl--0'; ?>"><?php echo count($offen); ?></span></li>
                    <li data-tab="vergeben">Vergeben <span class="anzahl<?php if(count($vergeben) == 0) echo ' anzahl--0'; ?>"><?php echo count($vergeben); ?></span></li>
                    <li data-tab="erledigt">Erledigt <span class="anzahl<?php if(count($erledigt) == 0) echo ' anzahl--0'; ?>"><?php echo count($erledigt); ?></span></li>
                </ul>
            </div>
        </div>
    </nav>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <a href="/app/joborders/neu/" class="button">Neue Joborder</a>
                    <a href="/app/joborders/templates/" class="button">Neue Joborder aus Vorlage</a>
                </article>
                <article class="gd gd--12 tab tab--offen tab--active">
               
                    <?php if (count($offen) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Arbeitgeber</th>
                                    <th>Anzeigen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($offen as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php
                                        
                                                if (intval($item->dienstleister_vorgegeben)){
                                                    if (intval($item->dienstleister_single)){
                                                        echo "<a href='{$joborder->dienstleister_website}' target='_blank'>$joborder->dienstleister_firmenwortlaut</a>";
                                                    }else{
                                                        echo "mehrere vorgegeben (";
                                                        echo implode(", ", $item->dienstleister_auswahl_firmenwortlaute);
                                                        echo ")";
                                                    }
                                                } else{
                                                    echo "keinen vorgegeben";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
               
                    <?php else: ?>
                    
                       keine offenen Joborders
               
                    <?php endif; ?>
                    
                </article>
                
                <article class="gd gd--12 tab tab--vergeben">
                    <?php if (count($vergeben) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Arbeitgeber</th>
                                    <th>Anzeigen</th>
                                    <th>Ressourcen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($vergeben as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php
                                        
                                                if (intval($item->dienstleister_vorgegeben)){
                                                    if (intval($item->dienstleister_single)){
                                                        echo "<a href='{$joborder->dienstleister_website}' target='_blank'>$joborder->dienstleister_firmenwortlaut</a>";
                                                    }else{
                                                        echo "mehrere vorgegeben (";
                                                        echo implode(", ", $item->dienstleister_auswahl_firmenwortlaute);
                                                        echo ")";
                                                    }
                                                } else{
                                                    echo "keinen vorgegeben";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/ressourcen/?id=<?php echo hashId($item->id); ?>&from=/app/joborders/&from_hash=vergeben" class="button">Ressourcen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    
                       keine vergebenen Joborders
               
                    <?php endif; ?>
                </article>
                <article class="gd gd--12 tab tab--erledigt">
                    <?php if (count($erledigt) > 0): ?>
                    <div class="joborder-list">
                        <table class="table joborder-table joborder-table--sort-datum" data-colsort="3-4">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Job</th>
                                    <th>Einsatzort</th>
                                    <th>Zeitraum</th>
                                    <th>Bewerbungsfrist</th>
                                    <th>Arbeitgeber</th>
                                    <th>Anzeigen</th>
                                    <th>Ressourcen</th>
                                </tr>
                            </thead>
                            <tbody class="joborders">
                                
                                <?php
                                    foreach($erledigt as $item){
                                ?>
                                    <tr class="joborder">
                                        <td class="joborder__icon">
                                            <i class="icon icon--joborder-table icon--berufsfeld-<?php echo $item->berufsfelder[0]->id; ?>"></i>
                                        </td>
                                        <td class="joborder__name"> 
                                            <?php echo $item->jobtitel; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->bezirke_name; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->arbeitsbeginn); ?>">
                                            <?php echo $item->arbeitsbeginn; ?> - <?php echo $item->arbeitsende; ?>
                                        </td>
                                        <td data-order="<?php echo strtotime($item->bewerbungen_von); ?>">
                                            <?php echo $item->bewerbungen_von; ?> - <?php echo $item->bewerbungen_bis; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->eingesetzter_dienstleister->firmenwortlaut; ?>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/details/?id=<?php echo hashId($item->id); ?>" class="button">Ansehen</a>
                                        </td>
                                        <td>
                                            <a href="/app/joborders/ressourcen/?id=<?php echo hashId($item->id); ?>&from=/app/joborders/&from_hash=erledigt" class="button">Ressourcen</a>
                                        </td>
                                    </tr>
                               <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    
                       keine erledigten Joborders
               
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </seciton>
    
<?php           
        }
    }
?>
    
    <script>
        jQuery(document).ready(function(){
            
            jQuery('.joborder-table').not('.joborder-table--sort-datum').DataTable({
                'paging': false,
                'language': {
                    'lengthMenu': "Display _MENU_ records per page",
                    'zeroRecords': "Nothing found - sorry",
                    'info': "Seite _PAGE_ von _PAGES_",
                    'infoEmpty': "Kein Übereinstimmung gefunden",
                    'infoFiltered': "(filtered from _MAX_ total records)",
                    'search': "Tabelle filtern: ",
                    'searchPlaceholder': "Suchtext"
                }
            });
            
            jQuery('.joborder-table--sort-datum[data-colsort="3-4"]').DataTable({
                'paging': false,
                'order': [[3, 'desc' ], [4, 'desc' ]],
                'language': {
                    'lengthMenu': "Display _MENU_ records per page",
                    'zeroRecords': "Nothing found - sorry",
                    'info': "Seite _PAGE_ von _PAGES_",
                    'infoEmpty': "Kein Übereinstimmung gefunden",
                    'infoFiltered': "(filtered from _MAX_ total records)",
                    'search': "Tabelle filtern: ",
                    'searchPlaceholder': "Suchtext"
                }
            });
            
            jQuery('.joborder-table--sort-datum[data-colsort="4"]').DataTable({
                'paging': false,
                'order': [[4, 'desc' ]],
                'language': {
                    'lengthMenu': "Display _MENU_ records per page",
                    'zeroRecords': "Nothing found - sorry",
                    'info': "Seite _PAGE_ von _PAGES_",
                    'infoEmpty': "Kein Übereinstimmung gefunden",
                    'infoFiltered': "(filtered from _MAX_ total records)",
                    'search': "Tabelle filtern: ",
                    'searchPlaceholder': "Suchtext"
                }
            });
            
            jQuery('.joborder-table--sort-datum[data-colsort="4-5"]').DataTable({
                'paging': false,
                'order': [[4, 'desc' ], [5, 'desc' ]],
                'language': {
                    'lengthMenu': "Display _MENU_ records per page",
                    'zeroRecords': "Nothing found - sorry",
                    'info': "Seite _PAGE_ von _PAGES_",
                    'infoEmpty': "Kein Übereinstimmung gefunden",
                    'infoFiltered': "(filtered from _MAX_ total records)",
                    'search': "Tabelle filtern: ",
                    'searchPlaceholder': "Suchtext"
                }
            });
            
            jQuery('li.tooltip-bottom').tooltipster({side: 'bottom'});
        });
    </script>

        
<?php

    get_footer();

?>