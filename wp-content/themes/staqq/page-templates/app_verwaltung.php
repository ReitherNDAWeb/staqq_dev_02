<?php

    /**
     *   Template Name: STAQQ / App / Verwaltung (Dienstleister und Kunden)
     */

    get_header();

    
    if ($wpUserRole == "dienstleister" || $wpUserRole == "kunde" || (($wpUserRole == "dienstleister_user" || $wpUserRole == "kunde_user") && $userBerechtigungen->berechtigung_einkauf)){
		
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
		
?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--6">
                    <div class="verwaltung-info">
                        <i class="icon verwaltung-info__icon icon--joborders"></i>
                        <div class="verwaltung-info__content">
                            <h2><?php echo $anzahl_j; ?> Joborders</h2>
                            <p>verfügbar</p>
                        </div>
                    </div>
                    <div class="verwaltung-info">
                        <i class="icon verwaltung-info__icon icon--verwaltung"></i>
                        <div class="verwaltung-info__content">
                            <h2><?php echo $anzahl_u; ?> Benutzer</h2>
                            <p>verfügbar</p>
                        </div>
                    </div>
                </article>
                <article class="gd gd--6">
                    <a href="/app/verwaltung/pakete" class="button">Joborders- und Benutzer-Pakete</a>
                </article>
            </div>
                
<?php      
      if ($wpUserRole == "dienstleister"){
        
        $users = $api->get("dienstleister/$wpUserSTAQQId/user", [])->decode_response();

?>
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h2>Meine Benutzer</h2>
                    <?php if ($anzahl_u <= 0): ?>
                    	<p>Sie haben Ihre verfügbaren Benutzer aufgebraucht!</p>
                    	<a href="/app/verwaltung/pakete" class="button">Zu den Paketen</a>
                    <?php else: ?>
                    	<a href="/app/verwaltung/benutzer/details/?id=new" class="button">Neuen Benutzer anlegen</a>
                    <?php endif; ?>
                </article>
                <article class="gd gd--12">
                    <?php if(count($users) > 0){ ?>
                        <table class="table benutzer-table">
                            <thead>
                                <tr>
                                    <th>Vorname</th>
                                    <th>Nachname</th>
                                    <th>E-Mail</th>
                                    <th>Filialen</th>
                                    <th>Bearbeiten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){ ?>
                                <tr>
                                    <td><?php echo $user->vorname; ?></td>
                                    <td><?php echo $user->nachname; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo ($user->einschraenkung_filialen == 1) ? implode(", ", $user->filialen) : "keine Filialen zugewiesen"; ?></td>
                                    <td><a class="button" href="/app/verwaltung/benutzer/details/?id=<?php echo $user->id; ?>">bearbeiten</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Es sind noch keine Benutzer angelegt!</p>
                    <?php } ?>
                </article>
            </div>
        </div>
    </seciton>

<?php
        
    } elseif ($wpUserRole == "kunde"){
        
        $users = $api->get("kunden/$wpUserSTAQQId/user", [])->decode_response();

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <?php if ($anzahl_u <= 0): ?><a href="/app/verwaltung/pakete" class="button">Zu den Paketen</a><?php else: ?><a href="/app/verwaltung/benutzer/details/?id=new" class="button">Neuen Benutzer anlegen</a><?php endif; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h2>Meine Benutzer</h2>
                </article>
			</div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <?php if(count($users) > 0){ ?>
                        <table class="table benutzer-table">
                            <thead>
                                <tr>
                                    <th>Vorname</th>
                                    <th>Nachname</th>
                                    <th>E-Mail</th>
                                    <th>Arbeitsstätten</th>
                                    <th>Bearbeiten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){ ?>
                                <tr>
                                    <td><?php echo $user->vorname; ?></td>
                                    <td><?php echo $user->nachname; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo ($user->einschraenkung_arbeitsstaetten == 1) ? implode(", ", $user->arbeitsstaetten) : "keine Arbeitsstätten zugewiesen"; ?></td>
                                    <td><a class="button" href="/app/verwaltung/benutzer/details/?id=<?php echo $user->id; ?>">bearbeiten</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Es sind noch keine Benutzer angelegt!</p>
                    <?php } ?>
                </article>
            </div>
        </div>
    </seciton>

<?php
        
    }
        
?>
   
    
    <script>
		jQuery(document).ready(function(){
			jQuery('.benutzer-table').DataTable({
				//'searching': false,
				'paging': false,
				'language': {
					'lengthMenu': "Zeige _MENU_ Eintragungen pro Seite",
					'zeroRecords': "Filterung - keine Ergebnisse",
					'info': "Seite _PAGE_ von _PAGES_",
					'infoEmpty': "Kein Übereinstimmung gefunden",
					'infoFiltered': "(filtered from _MAX_ total records)",
					'search': "Tabelle filtern: ",
					'searchPlaceholder': "Suchtext"
				}
			});
		});
	</script>
   
<!--
    <section class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h2>Meine Bestellungen/Rechnungen</h2>
                </article>
                <article class="gd gd--12">
                    <?php do_shortcode('[woocommerce_edit_address]'); ?>
                </article>
            </div>
        </div>
    </section>
-->
<?php
    
    }

    get_footer();

?>                     