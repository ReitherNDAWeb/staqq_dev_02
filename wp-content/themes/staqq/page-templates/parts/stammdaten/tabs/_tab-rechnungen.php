<?php      
      $rechnungen = $api->get("user/{$wpUser->ID}/rechnungen", [])->decode_response();
?>
		
<article class="gd gd--12">
	<?php if(count($rechnungen) > 0){ ?>
		<table class="table rechnungen-table">
			<thead>
				<tr>
					<th>Typ</th>
					<th>Inhalt</th>
					<th>Summe</th>
					<th>Bezahlen</th>
					<th>Rechnung</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rechnungen as $rechnung){ ?>
				<tr>
					<td><?php echo $rechnung->type; ?></td>
					<td><?php echo implode(', ', $rechnung->contentNames); ?></td>
					<td><?php echo $rechnung->summe; ?></td>
					<td>
						<?php 
							if(!$rechnung->rechnung){
						?>
							<a class="button" target="_blank" href="<?php echo $rechnung->payment_url; ?>">jetzt bezahlen</a>
						<?php 
							}else{ 
								echo 'bereits bezahlt';
							}
						?>
					</td>
					<td>
						<?php 
							if($rechnung->rechnung){
						?>
							<a class="button" href="<?php echo $rechnung->rechnung; ?>">Rechnung herunterladen</a>
						<?php 
							}else{
								echo "Rechnung nach erfolgter Zahlung verfügbar";
							}
						?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<p>Es sind noch keine Rechnugen verfügbar!</p>
	<?php } ?>
</article>

<script>
	jQuery(document).ready(function(){
		jQuery('.rechnungen-table').DataTable({
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