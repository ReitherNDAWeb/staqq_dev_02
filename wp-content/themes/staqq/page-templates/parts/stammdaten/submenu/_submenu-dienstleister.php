<?php if ($wpUserRole == "dienstleister"): ?>
	<li class="current-item" data-tab="stammdaten">Stammdaten</li>
<?php endif; ?>

<li data-tab="passwort">Passwort ändern</li>

<?php if ($wpUserRole == "dienstleister"): ?>
	<li data-tab="delete">Account Löschung beantragen</li>
	<li data-tab="benutzer-pakete">Meine Benutzer und Pakete</li>
<?php endif; ?>
<li data-tab="rechnungen">Rechnungen</li>

<?php  if ($wpUserRole == "dienstleister" || $userBerechtigungen->berechtigung_einkauf): ?>
	<li data-tab="ordering">Pakete bestellen</li>
<?php endif; ?>