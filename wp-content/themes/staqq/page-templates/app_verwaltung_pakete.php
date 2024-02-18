<?php

    /**
     *   Template Name: STAQQ / App / Verwaltung / Pakete
     */

    get_header();

    //if (!($wpUserSTAQQUser && $wpUserState)) //wp_redirect('Location: /', 302);

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <a href="/app/verwaltung/" class="button">Zurück</a>
                </article>
               
                <?php
                    if ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"){
                ?>
               
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
                                <th>€ 1.500,- pro Jahr</th>
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
                                    <a href="#" class="button">Kaufen</a>
                                </td>
                                <td>
                                    <a href="#" class="button">Kaufen</a>
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
                    <p>* Abteilungen pro Benutzer - Segmentierung (Berufsfeld, Berufsgruppe, Regionen)</p>
                </article>
                
                <?php
                    }elseif ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"){
						
						if ($wpUserRole == "kunde"){
							$k = $api->get("kunden/$wpUserSTAQQId", [])->decode_response();
						}else{
							$k = $api->get("kunden/$wpUserSTAQQKundeId", [])->decode_response();
						}
						
						if ($k->uid != "" && $k->ansprechpartner_position != "" && $k->website != "" && $k->firmensitz_plz > 0 && $k->firmensitz_adresse != "" && $k->firmensitz_ort != ""){
            
                ?>
               
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
                                <th>€ 1.500,- pro Jahr</th>
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
                                    <a href="#" class="button">Kaufen</a>
                                </td>
                                <td>
                                    <a href="#" class="button">Kaufen</a>
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
                                    Blackliste Dienstleister
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
                    <p>* Abteilungen pro Benutzer - Segmentierung (Berufsfeld, Berufsgruppe, Regionen)</p>
                </article>
                   
                <?php     	
						}else{
							
				?>
					
						<article class="gd gd--12">
							<h1>Sie müssen Ihre Stammdaten aktualisieren!</h1>
							<p>Um neue Jobs schalten zu können müssen Sie folgende Felder eingetragen haben: UID, Ansprechpartner Position, Adresse, PLZ, Ort und Website.</p>
							<a href="/app/stammdaten/" class="button">Zu den Stammdaten</a>
						</article>
								
				<?php
							
						}
                    }
                ?>
                
            </div>
        </div>
    </seciton>

<?php get_footer(); ?>