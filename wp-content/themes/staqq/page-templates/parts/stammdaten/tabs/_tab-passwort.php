<form id="password_form" action="" method="post" onsubmit="return passwortCheck();">
	<input type="hidden" name="action" value="changePasswort">
	<input type="hidden" name="email" value="<?php echo $email; ?>">
	<article class="gd gd--12">
		<h2>Passwort ändern</h2>
	</article>
	<article class="gd gd--6">
		<input type="password" placeholder="Altes Passwort" name="passwort_alt" id="passwort_alt">
	</article>
	<article class="gd gd--6">
		<input type="password" placeholder="Neues Passwort" name="passwort_neu_1" id="passwort_neu_1">
		<input type="password" placeholder="Neues Passwort wiederholen" name="passwort_neu_2" id="passwort_neu_2">
	</article>
	<article class="gd gd--12">
		<button type="submit" class="button">Passwort ändern</button>
	</article>
</form>