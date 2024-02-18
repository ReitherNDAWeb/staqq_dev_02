<article class="gd gd--12">  
	<table class="table pricing-table">
		<thead>
			<tr>
				<th></th>
				<th><h3>Basis</h3></th>
				<th><h3>Gold</h3></th>
				<th><h3>Platinum</h3></th>
			</tr>
			<tr>
				<th></th>
				<th>Kostenlos</th>
				<th>€ 100,- pro Monat<br>€ 1.000,- pro Jahr</th>
				<th>€ 1.000,- pro Monat<br>€ 10.000,- pro Jahr</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>

				</th>
				<td>

				</td>
				<td>
					<button onclick="openPaketModal('gold')" class="button">Kaufen</button>
				</td>
				<td>
					<button onclick="openPaketModal('platinum')" class="button">Kaufen</button>
				</td>
			</tr>
			<tr>
				<th>
					Joborders
				</th>
				<td>
					5 Joborder pro Jahr
				</td>
				<td>
					50 Joborders pro Kalenderjahr
				</td>
				<td>
					unbegrenzte Anzahl Joborders
				</td>
			</tr>
			<tr>
				<th>
					Benutzer
				</th>
				<td>
					1 Benutzerkonto
				</td>
				<td>
					10 Benutzer
				</td>
				<td>
					unbegrenzte Anzahl Benutzer
				</td>
			</tr>
			<tr>
				<th>
					E-Mail-Support
				</th>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
			</tr>
			<tr>
				<th>
					Joborders als Vorlage speichern
				</th>
				<td>

				</td>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
			</tr>
			<tr>
				<th>
					Eingabemöglichkeit Std. Sätze von-bis
				</th>
				<td>

				</td>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
			</tr>
			<tr>
				<th>
					Auswertung aus dem System
				</th>
				<td>

				</td>
				<td>
					begrenzt
				</td>
				<td>
					unbegrenzt
				</td>
			</tr>
			<tr>
				<th>
					Abteilungen pro Benutzer - Segmentierung (Berufsfeld, Berufsgruppe, Regionen)
				</th>
				<td>

				</td>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
			</tr>
			<tr>
				<th>
					Firmenlogo auf Joborders
				</th>
				<td>

				</td>
				<td>
					&#10004;
				</td>
				<td>
					&#10004;
				</td>
			</tr>
			<tr>
				<th>
					Kunden spezifische Daten-Schnittstelle ohne laufender Kosten. Einmalige Einrichtungskosten je nach Aufwand.
				</th>
				<td>

				</td>
				<td>

				</td>
				<td>
					&#10004;
				</td>
			</tr>
		</tbody>
	</table>
</article>

<article class="gd gd--12">
	<h2>Einzelne Pakete</h2>
</article>

<article class="gd gd--6">
	<table class="table pricing-table pricing-table--no-width">
		<tbody>
			<?php
				$args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'joborders', 'orderby' => 'name', 'order' => 'ASC');
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

					<tr>
						<td><?php the_title(); ?></td>
						<td><?php echo $product->get_price_html(); ?></td>
						<td><a href="/app/verwaltung/warenkorb/?add-to-cart=<?php echo $loop->post->ID; ?>" class="button">Kaufen</a></td>
					</tr>

			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</tbody>
	</table>
</article>

<article class="gd gd--6">
	<table class="table pricing-table pricing-table--no-width">
		<tbody>
			<?php
				$args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'benutzer', 'orderby' => 'name', 'order' => 'ASC');
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

					<tr>
						<td><?php the_title(); ?></td>
						<td><?php echo $product->get_price_html(); ?></td>
						<td><a href="/app/verwaltung/warenkorb/?add-to-cart=<?php echo $loop->post->ID; ?>" class="button">Kaufen</a></td>
					</tr>

			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</tbody>
	</table>
</article>

<article class="gd gd--12">
	<p>Alle angeführten Preise verstehen sich exkl. MwSt.</p>
	<p>* Abteilungen pro Benutzer - Segmentierung (Berufsfeld, Berufsgruppe, Regionen)</p>
</article>


<div class="remodal remodal--paket" data-remodal-id="paket">
	
	<h1><span class="name"></span> Paket</h1>
	
	<div class="step step--1">
		<h3>Zahlungsweise</h3>
		<button class="button button--monatlich" onclick="selectPaketZahlungsintervall('monatlich')">Monatlich</button>
		<button class="button button--jaehrlich" onclick="selectPaketZahlungsintervall('jaehrlich')">Jährlich</button>
	</div>
	
	<form method="post" action="/app/actions/" class="step step--2 step--gold-monatlich" style="display: none;">
		<input type="hidden" name="action" value="paket_anfrage_senden">
		<h3>Nehmen Sie mit uns Kontakt auf</h3>
		<textarea name="content" id="content" cols="30" rows="10"><?php echo utf8_decode(get_option('paket_anfrage_gold_monatlich')); ?></textarea>
		
		<button type="submit" class="button">Senden</button>
	</form>
	
	<form method="post" action="/app/actions/" class="step step--2 step--gold-jaehrlich" style="display: none;">
		<input type="hidden" name="action" value="paket_anfrage_senden">
		<h3>Nehmen Sie mit uns Kontakt auf</h3>
		<textarea name="content" id="content" cols="30" rows="10"><?php echo utf8_decode(get_option('paket_anfrage_gold_jaehrlich')); ?></textarea>
		
		<button type="submit" class="button">Senden</button>
	</form>
	
	<form method="post" action="/app/actions/" class="step step--2 step--platinum-monatlich" style="display: none;">
		<input type="hidden" name="action" value="paket_anfrage_senden">
		<h3>Nehmen Sie mit uns Kontakt auf</h3>
		<textarea name="content" id="content" cols="30" rows="10"><?php echo utf8_decode(get_option('paket_anfrage_platinum_monatlich')); ?></textarea>
		
		<button type="submit" class="button">Senden</button>
	</form>
	
	<form method="post" action="/app/actions/" class="step step--2 step--platinum-jaehrlich" style="display: none;">
		<input type="hidden" name="action" value="paket_anfrage_senden">
		<h3>Nehmen Sie mit uns Kontakt auf</h3>
		<textarea name="content" id="content" cols="30" rows="10"><?php echo utf8_decode(get_option('paket_anfrage_platinum_jaehrlich')); ?></textarea>
		
		<button type="submit" class="button">Senden</button>
	</form>
</div>

<script>
	
	var selectedSlug;
	
	function openPaketModal(slug){
		
		jQuery('.remodal--paket .step--1').show();
		jQuery('.remodal--paket .step--2').hide();
		
		selectedSlug = slug;
		var PaketName = (slug == 'gold') ? "Gold" : "Platinum";
		
		jQuery('.remodal--paket h1 span.name').text(PaketName);
		jQuery('.remodal--paket').remodal().open();
		
	}
	
	function selectPaketZahlungsintervall(slug){
		
		var IntervallName = (slug == 'monatlich') ? "Monatlich" : "Jährlich";
		
		jQuery('.remodal--paket .step--1').hide();
		console.log('.remodal--paket .step--2.step--'+selectedSlug+'-'+slug);
		jQuery('.remodal--paket .step--2.step--'+selectedSlug+'-'+slug).show();
	}
	
</script>