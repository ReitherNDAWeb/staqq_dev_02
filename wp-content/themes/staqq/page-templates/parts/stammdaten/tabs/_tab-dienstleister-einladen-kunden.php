<article class="gd gd--12">
	<h2>Dienstleister zu STAQQ einladen</h2>
</article>
<form action="/app/stammdaten/#stammdaten" method="post">
	<input type="hidden" name="action" value="dienstleisterEinladen">
	<input type="hidden" name="id" value="<?php echo $wpUserSTAQQId; ?>">
	<input type="hidden" name="role" value="<?php echo $wpUserRole; ?>">
	<input type="hidden" name="firmenwortlaut" value="<?php echo $firmenwortlaut; ?>">
	<input type="hidden" name="email" value="<?php echo $email; ?>">
	<article class="gd gd--6">
		<input type="text" name="dl_anforderung_name" id="dl_anforderung_name" placeholder="Name des Dienstleisters">
		<input type="text" name="dl_anforderung_ansprechpartner_email" id="dl_anforderung_ansprechpartner_email" placeholder="Ansprechpartner E-Mail">
	</article>
	<article class="gd gd--6">
		<input type="text" name="dl_anforderung_ansprechpartner_titel" id="dl_anforderung_ansprechpartner_titel" placeholder="Ansprechpartner Titel">
		<input type="text" name="dl_anforderung_ansprechpartner_vorname" id="dl_anforderung_ansprechpartner_vorname" placeholder="Ansprechpartner Vorname">
		<input type="text" name="dl_anforderung_ansprechpartner_nachname" id="dl_anforderung_ansprechpartner_nachname" placeholder="Ansprechpartner Nachname">
	</article>
	<article class="gd gd--12">
		<h3>Nachricht an den Dienstleister:</h3>
		<p class="dl_anforderung_placeholder dl_anforderung_placeholder--betreff">Betreff: <?php echo utf8_decode(get_option('dienstleister_einladen_betreff')); ?></p>
		<p class="dl_anforderung_placeholder dl_anforderung_placeholder--betreff">Nachricht:</p>
		<p class="dl_anforderung_placeholder">Sehr geehrte(r) Vorname Nachname!</p>
		<textarea name="dl_anforderung_infotext" id="dl_anforderung_infotext" cols="30" rows="10"><?php echo utf8_decode(get_option('dienstleister_einladen_text')); ?></textarea>
	</article>
	<article class="gd gd--12">
		<button class="button" type="submit">Einladung senden</button>
	</article>
</form>