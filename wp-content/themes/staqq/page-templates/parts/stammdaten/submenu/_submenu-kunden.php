<?php if ($wpUserRole == "kunde"): ?>
	<li class="current-item" data-tab="stammdaten">Stammdaten</li>
	<li data-tab="dienstleister-einladen">Dienstleister einladen</li>
<?php endif; ?>

<li data-tab="passwort">Passwort ändern</li>

<?php if ($wpUserRole == "kunde"): ?>
	<li data-tab="delete">Account Löschung beantragen</li>
<?php endif; ?>

<?php if ($wpUserRole == "kunde"): ?>
	<li data-tab="benutzer-pakete">Meine Benutzer und Pakete</li>
<?php endif; ?>
<li data-tab="rechnungen">Rechnungen</li>

<?php  if ($wpUserRole == "kunde" || $userBerechtigungen->berechtigung_einkauf): ?>
	<li data-tab="ordering">Pakete bestellen</li>
<?php endif; ?>