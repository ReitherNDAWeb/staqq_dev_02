<?php if ($wpUserRole == "kunde" || $userBerechtigungen->berechtigung_joborders_schalten): ?>
	<li class="<?php echo currentMenuItem('/app/joborders/'); ?>">
		<a href="/app/joborders/">
			<i class="icon icon--menu icon--joborders"></i>
			<div>Jobs</div>
		</a>
	</li>
<?php endif; ?>

<?php if ($wpUserRole == "kunde" || $userBerechtigungen->berechtigung_einkauf): ?>
	<li class="<?php echo currentMenuItem('/app/stammdaten/'); ?>">
		<a href="/app/stammdaten/">
			<i class="icon icon--menu icon--stammdaten"></i>
			<div>Stammdaten</div>
		</a>
	</li>
<?php endif; ?>

<li class="menu-item--bewertungen <?php echo currentMenuItem('/app/bewertungssystem/'); ?>">
	<a href="/app/bewertungssystem/">
		<i class="icon icon--menu icon--verwaltung"></i>
		<div>Bewertungssystem</div>
	</a>
	<span class="anzahl anzahl--0">0</span>
</li>