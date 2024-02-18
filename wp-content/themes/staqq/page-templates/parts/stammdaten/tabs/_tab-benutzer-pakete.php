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
	<a href="/app/stammdaten#ordering" target="_self" class="button">Joborders- und Benutzer-Pakete</a>
</article>
<article class="gd gd--12">
	<h2>Meine Benutzer</h2>
	<?php if ($anzahl_u <= 0): ?>
		<p>Sie haben Ihre verfügbaren Benutzer aufgebraucht!</p>
		<a href="/app/stammdaten#ordering" target="_self" class="button">Zu den Paketen</a>
	<?php else: ?>
		<a href="/app/stammdaten/?id=new#benutzer-pakete" class="button">Neuen Benutzer anlegen</a>
	<?php endif; ?>
</article>

<?php      
      if ($wpUserRole == "dienstleister"){
		  
		$dl 	= $api->get("dienstleister/$wpUserSTAQQId", [])->decode_response();
        $users 	= $api->get("dienstleister/$wpUserSTAQQId/user", [])->decode_response();
		  
		$user_joborder_empfaenger_id = $dl->joborder_empfaenger_user;
		$user_rechnungs_empfaenger_id = $dl->rechnungs_empfaenger_user;

?>
		<article class="gd gd--12 user-joborder-empfaenger">
			<h3>Benutzer, der Kunden-Joborders zum verteilen erhalten soll</h3>
			<form action="/app/actions/" method="post">
				<input type="hidden" name="action" value="dienstleister_verwaltung__select_joborder_empfaenger">
				<div class="select-wrapper">
					<select name="dienstleister_user_id" id="dienstleister_user_id">
						<option value="null">-----------</option>
						<?php foreach($users as $user){ ?>
							<option value="<?php echo $user->id; ?>"<?php echo ($user->id == $user_joborder_empfaenger_id) ? " selected" : ""; ?>><?php echo $user->vorname; ?> <?php echo $user->nachname; ?></option>
						   <?php } ?>
					</select>
				</div>
				<button type="submit" class="button">Speichern</button>
			</form>
		</article>
		<article class="gd gd--12 user-rechnungs-empfaenger">
			<h3>Benutzer, der die Rechnungen erhalten und einsehen können soll</h3>
			<form action="/app/actions/" method="post">
				<input type="hidden" name="action" value="dienstleister_verwaltung__select_rechnungs_empfaenger">
				<div class="select-wrapper">
					<select name="dienstleister_user_id" id="dienstleister_user_id">
						<option value="null">-----------</option>
						<?php foreach($users as $user){ ?>
							<option value="<?php echo $user->id; ?>"<?php echo ($user->id == $user_rechnungs_empfaenger_id) ? " selected" : ""; ?>><?php echo $user->vorname; ?> <?php echo $user->nachname; ?></option>
						   <?php } ?>
					</select>
				</div>
				<button type="submit" class="button">Speichern</button>
			</form>
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
							<td><a class="button" href="/app/stammdaten/?id=<?php echo $user->id; ?>#benutzer-pakete">bearbeiten</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<p>Es sind noch keine Benutzer angelegt!</p>
			<?php } ?>
		</article>

<?php
        
    } elseif ($wpUserRole == "kunde"){
        
        $users = $api->get("kunden/$wpUserSTAQQId/user", [])->decode_response();

?>
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
							<td><a class="button" href="/app/stammdaten/?id=<?php echo $user->id; ?>#benutzer-pakete">bearbeiten</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<p>Es sind noch keine Benutzer angelegt!</p>
			<?php } ?>
		</article>

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