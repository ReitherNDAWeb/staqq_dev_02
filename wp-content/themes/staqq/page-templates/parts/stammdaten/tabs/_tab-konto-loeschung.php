<h2>Konto löschen</h2>
<p>Sie können hier ihr Konto zur Löschung beantragen. Damit wird eine Nachricht an das STAQQ-Team geschickt, die Sie und alle ihre Daten aus unserem STAQQ-System löschen.</p>
<form action="" method="post">
	<input type="hidden" name="action" value="requestDelete">
	<input type="hidden" name="id" value="<?php echo $wpUserSTAQQId; ?>">
	<input type="hidden" name="role" value="<?php echo $wpUserRole; ?>">
	<button type="submit" class="button">Löschung beantragen</button>
</form>