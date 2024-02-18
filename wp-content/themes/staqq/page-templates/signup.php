<?php

    /**
     *   Template Name: STAQQ Sign Up
     */


    get_header('pre');
    get_header();


    if (is_user_logged_in())
    {

?>
    Eingelogged
    <a href="<?php echo wp_logout_url(site_url()); ?>" class="button">Abmelden?</a>

<?php

    }else{

    $berufsfelder = $api->get("berufsfelder", [])->decode_response();
    $berufsgruppen = $api->get("berufsgruppen", [])->decode_response();
    $berufsbezeichnungen = $api->get("berufsbezeichnungen", [])->decode_response();
    $skills = $api->get("skills/nested", [])->decode_response();
    $bezirke = $api->get("bezirke", [])->decode_response();
    $dienstleister = $api->get("dienstleister", [])->decode_response();

	$skills_items = $api->get("skills/items", [])->decode_response();
	$skills_kategorien = $api->get("skills/kategorien", [])->decode_response();
    $bezirke = $api->get("bezirke", [])->decode_response();
    $bundeslaender = $api->get("bundeslaender", [])->decode_response();

    $berufe = $api->get("berufe", [])->decode_response();

?>
    <seciton class="section signup-step signup-step--step-user-type signup-step--active">


              <div class="center regheader">
                <p>Willkommen zur <br/>Registrierung</p>
              </div>

      <div class="regsvg only-mobile">
      <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
       width="100%" height="100%" viewBox="0 0 1333.000000 346.000000"
       preserveAspectRatio="xMidYMid meet">
      <metadata>
      Created by potrace 1.15, written by Peter Selinger 2001-2017
      </metadata>
      <g transform="translate(0.000000,346.000000) scale(0.100000,-0.100000)"
      fill="#f5a705" stroke="none">
      <path d="M0 1805 c0 -910 2 -1655 4 -1655 2 0 34 14 72 31 38 17 87 39 109 49
      23 10 90 40 150 65 61 26 137 60 170 75 33 15 110 49 170 75 111 48 187 82
      260 115 22 10 85 37 140 60 55 23 127 55 160 70 33 15 110 49 170 75 61 26
      133 58 160 70 77 35 461 204 540 237 39 16 88 38 110 48 22 11 146 65 275 121
      129 56 278 120 330 144 52 23 124 55 160 70 36 15 110 48 165 72 55 24 129 57
      165 73 36 15 97 43 135 60 39 18 86 38 105 45 19 7 64 26 100 43 74 34 155 69
      390 172 91 40 200 87 243 106 42 19 114 50 160 70 45 20 102 45 127 56 25 12
      74 33 110 48 36 16 106 46 155 68 702 308 726 317 920 366 147 37 231 53 410
      78 140 20 202 23 495 23 342 0 426 -6 660 -46 255 -43 462 -105 675 -199 22
      -10 76 -34 120 -53 70 -31 154 -67 490 -214 44 -19 103 -46 131 -58 27 -13 72
      -33 100 -44 27 -11 101 -43 164 -71 63 -28 167 -74 230 -101 63 -28 153 -67
      200 -88 47 -22 150 -67 230 -101 80 -34 174 -76 210 -92 36 -17 83 -36 104
      -44 22 -8 44 -18 50 -23 6 -4 43 -21 81 -36 39 -15 75 -31 80 -35 6 -4 46 -22
      89 -40 44 -17 87 -36 95 -41 9 -5 147 -65 306 -134 160 -69 304 -132 320 -140
      99 -45 147 -66 205 -90 36 -15 89 -38 119 -52 76 -35 564 -250 636 -280 33
      -14 84 -36 112 -49 29 -13 119 -52 200 -87 82 -36 168 -74 193 -85 25 -11 119
      -53 210 -92 187 -82 393 -172 460 -203 76 -34 182 -77 191 -77 5 0 9 732 9
      1650 l0 1650 -6665 0 -6665 0 0 -1655z"/>
      </g>
      </svg>
    </div>
        <div class="regpull">

            <div class="section__wrapper">
                <div class="center">

                    <!--<article class="gd gd--12 only-mobile">
                        <h1>Verwenden Sie unsere Apps!</h1>
						<a href="https://itunes.apple.com/us/app/staqq/id1143533994" class="button" target="_blank">iOS</a><br>
						<br>
						oder
						<br><br>
						<a href="https://play.google.com/store/apps/details?id=com.appartig.staqq" class="button" target="_blank">Android</a>



          </article>-->

                    <article class="gd gd--12">
                        <!--<h1>Willkommen zur Registrierung</h1>-->
                        <p>als wer wollen Sie sich registrieren?</p>
                    </article>
                    <div class="user-type-radio-images">
                      <article class="gd gd--4">
                          <label class="user-type-radio user-type-radio--ressource active" for="ressource">
                              <img src="/wp-content/themes/staqq/img/icons/icon_bewerber.png" alt="">
                              <input type="radio" name="user_type" id="ressource" value="ressource" checked>

                          </label>
                      </article>
                      <article class="gd gd--4">
                          <label class="user-type-radio user-type-radio--ressource" for="kunde">
                              <img src="/wp-content/themes/staqq/img/icons/icon_kunde.png" alt="">
                              <input type="radio" name="user_type" id="kunde" value="kunde">

                          </label>
                      </article>
                      <article class="gd gd--4">
                          <label class="user-type-radio user-type-radio--ressource" for="dienstleister">
                              <img src="/wp-content/themes/staqq/img/icons/icon_dienstleister.png" alt="">
                              <input type="radio" name="user_type" id="dienstleister" value="dienstleister">
                          </label>
                      </article>
                  </div>
                  <!--  <article class="gd gd--4">
                        <label class="user-type-radio user-type-radio--ressource" for="ressource">
                            <h3>Mitarbeiter-Bewerber</h3>
                            <input type="radio" name="user_type" id="ressource" value="ressource" checked>
                        </label>
                    </article>
                    <article class="gd gd--4">
                        <label class="user-type-radio user-type-radio--kunde" for="kunde">
                            <h3>Kunde</h3>
                            <input type="radio" name="user_type" id="kunde" value="kunde">
                        </label>
                    </article>
                    <article class="gd gd--4">
                        <label class="user-type-radio user-type-radio--dienstleister" for="dienstleister">
                            <h3>Personal-Dienstleister</h3>
                            <input type="radio" name="user_type" id="dienstleister" value="dienstleister">
                        </label>
                    </article>-->
                    <article class="gd gd--12">
                        <button class="button" onclick="nextStep('user-type', 'tel');">Fortfahren</button>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-tel">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--12">

						<div class="social-registrierung-buttons">
							<button class="button button--social-registrierung button--facebook-registrierung" onclick="connectFacebook();">
								<span>über Facebook registrieren</span>
							</button>
							<button class="button button--social-registrierung button--linkedin-registrierung" onclick="connectLinkedin();">
								<span>über LinkedIn registrieren</span>
							</button>
							<button class="button button--social-registrierung button--xing-registrierung" onclick="alert('Sie müssen auf Log in klicken!')">
								<span>über Xing registrieren</span>
								<script type="xing/login">{"consumer_key": "ae2f71c6e35a04e7e5ff"}</script>
							</button>
						</div>

                        <div class="form-center">

                            <input type="text" name="firmenwortlaut" id="firmenwortlaut" placeholder="Firmenwortlaut" required style="display:none;">
                            <input type="text" name="vorname" id="vorname" placeholder="Vorname" required>
                            <input type="text" name="nachname" id="nachname" placeholder="Nachname" required>
                            <input type="email" name="email" id="email" placeholder="E-Mail" required>
                            <div class="input-tel">
                                <input type="text" class="input-tel__land" value="0043" name="laendervorwahl" id="laendervorwahl" readonly>
                                <div class="select-wrapper input-tel__vorwahl">
                                    <select name="vorwahl" id="vorwahl">
                                        <option value="664">664</option>
                                        <option value="660">660</option>
                                        <option value="676">676</option>
                                        <option value="699">699</option>
                                        <option value="680">680</option>
                                        <option value="663">663</option>
                                        <option value="681">681</option>
                                        <option value="665">665</option>
                                        <option value="677">677</option>
                                        <option value="678">678</option>
                                        <option value="670">670</option>
                                        <option value="650">650</option>
                                    </select>
                                </div>
                                <input type="text" name="telefon" id="telefon" class="input-tel__nummer" placeholder="Telefonnummer" required>
                            </div>
                            <button class="button" onclick="nextStep('tel', 'aktivierung');">Fortfahren</button>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-aktivierung">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--12">
                        <p>Wir senden Ihnen in Kürze eine SMS an die von Ihnen angegebene Rufnummer. Bitte bestätigen Sie diese zur Verifizierung Ihres Accounts innerhalb der nächsten 5 Minuten – andernfalls verfällt Ihre Anmeldung.</p>
                        <div class="form-center">
                            <input type="text" name="code" id="code" value="" placeholder="Aktivierungscode" required>
                            <button class="button" onclick="nextStep('aktivierung', 'passwort');">Fortfahren</button>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-passwort">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--12">
                        <div class="form-center">
                            <input type="password" name="password" id="password" placeholder="Passwort" required>
                            <input type="password" name="password2" id="password2" placeholder="Passwort Wiederholung" required>
                            <ul class="helper-text">
                                <li class="length">Mindestens 8 Zeichen.</li>
                                <li class="lowercase">Beinhaltet Kleinbuchstaben.</li>
                                <li class="uppercase">Beinhaltet Großbuchtstaben.</li>
                                <li class="special">Beinhaltet eine Zahl oder ein Sonderzeichen.</li>
                            </ul>
                            <button class="button" onclick="nextStep('passwort', 'informationen');">Fortfahren</button>

                        </div>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-informationen signup-step--user-ressource" style="display:none;">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">

                    <article class="gd gd--12">
                        <h2>Berufe</h2>
                    </article>
                    <article class="gd gd--4 berufswahl" id="berufsfelder-wrapper">
                        <h3>Felder (mind. 1)</h3>
                        <div class="berufswahl__items">
                        <?php
                            foreach ($berufsfelder as $f){
                                echo '<p><input class="berufsfelder" name="berufsfelder[]" type="checkbox" value="'.$f->id.'"><i class="icon icon--berufswahl icon--berufsfeld-'.$f->id.'"></i>'.$f->name.'</p>';
                            }
                        ?>
                        </div>
                    </article>
                    <article class="gd gd--4 berufswahl" id="berufsgruppen-wrapper">
                        <h3>Gruppen (mind. 1)</h3>
                        <div class="berufswahl__items">
                        <?php
                            foreach ($berufsgruppen as $g){
                                echo '<p data-berufsfeld="'.$g->berufsfelder_id.'" name="berufsgruppen[]" style="display: none;"><input class="berufsgruppen" type="checkbox" value="'.$g->id.'"><i class="icon icon--berufswahl icon--berufsfeld-'.$g->berufsfelder_id.'"></i>'.$g->name.'</p>';
                            }
                        ?>
                        </div>
                    </article>
                    <article class="gd gd--4 berufswahl" id="berufsbezeichnungen-wrapper">
                        <h3>Bezeichnungen (optional)</h3>
                        <div class="berufswahl__items">
                        <?php
                            foreach ($berufsbezeichnungen as $z){
                                echo '<p data-berufsgruppe="'.$z->berufsgruppen_id.'" name="berufsbezeichnungen[]" style="display: none;"><input class="berufsbezeichnungen" type="checkbox" value="'.$z->id.'"><i class="icon icon--berufswahl icon--berufsfeld-'.$z->berufsfelder_id.'"></i>'.$z->name.'</p>';
                            }
                        ?>
                        </div>
                    </article>




                    <article class="gd gd--6">

                        <h2>Stammdaten</h2>

                        <!--<div id="skills-wrapper">
                            <label for="skills">Skills (mind. 1)</label>
                            <select multiple="multiple" name="skills[]" id="skills">
                                <?php

                                    foreach ($skills as $k){
                                        echo '<optgroup label="'.$k->name.'">';
                                        foreach ($k->items as $s){
                                            echo '<option value="'.$s->id.'">'.$s->name.'</option>';
                                        }
                                        echo '</optgroup>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div id="regionen-wrapper">
                            <label for="regionen">Region Jobannahme (mind. 1) <i class="icon icon--tooltip tooltip" title="Um Ihnen passende Jobangebote anbieten zu können wählen Sie Ihre bevorzugten Bezirke."></i></label>
                            <select multiple="multiple" name="regionen[]" id="regionen">
                                <?php
                                    foreach ($bezirke as $b){
                                        echo '<option value="'.$b->id.'">'.$b->bundeslaender_name.' - '.$b->name.'</option>';
                                    }
                                ?>
                            </select>
                        </div>-->

                        <h3>Optionale Angaben</h3>

                        <label for="dl_gecastet">Gecastete Dienstleister <i class="icon icon--tooltip tooltip" title="Wählen Sie all jene Zeitarbeitsfirmen aus bei denen Sie bereits ein Vorstellungsgespräch hatten. Um Jobangebote annehmen zu können muss ein erfolgtes Vorstellungsgespräch in Ihren Stammdaten eingetragen und von einer Zeitarbeitsfirma bestätigt sein."></i></label>
                        <select multiple="multiple" name="dl_gecastet" id="dl_gecastet">
                            <?php
                                foreach ($dienstleister as $d){
                                    echo '<option value="'.$d->id.'">'.$d->firmenwortlaut.'</option>';
                                }
                            ?>
                        </select>

                        <label for="dl_blacklist">Dienstleister Blacklist <i class="icon icon--tooltip tooltip" title="Wenn Sie von einzelnen Zeitarbeitsfirmen keine Jobangebote erhalten wollen, markieren Sie diese hier."></i></label>
                        <select multiple="multiple" name="dl_blacklist" id="dl_blacklist">
                            <?php
                                foreach ($dienstleister as $d){
                                    echo '<option value="'.$d->id.'">'.$d->firmenwortlaut.'</option>';
                                }
                            ?>
                        </select>
                    </article>
                    <article class="gd gd--6">
                        <h2>Basic Skills</h2>

                        <input type="checkbox" name="skill_fuehrerschein" id="skill_fuehrerschein" class="switchable" data-label="Führerschein">
                        <input type="checkbox" name="skill_pkw" id="skill_pkw" class="switchable" data-label="Eigener PKW">
                        <input type="checkbox" name="skill_berufsabschluss" id="skill_berufsabschluss" class="switchable" data-label="Berufsabschluss im ausgewählten Berufsfeld">
                        <input type="checkbox" name="skill_eu_buerger" id="skill_eu_buerger" class="switchable" data-label="EU Bürger">
                        <input type="checkbox" name="skill_rwr_karte" id="skill_rwr_karte" class="switchable" data-label="RWR-Karte">
                        <input type="text" name="skill_hoechster_schulabschluss" id="skill_hoechster_schulabschluss" placeholder="Höchster Schulabschluss">
                    </article>
                    <article class="gd gd--12">
									<h2 class="form-headline">Skills (mind. 1)</h2>
								</article>
								<article class="gd gd--4 skill-chooser">
									<div class="select-wrapper">
										<select id="skill-chooser__kategorie">
											<?php foreach($skills_kategorien as $k){ ?>
												<option data-kategorie="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</article>
								<article class="gd gd--4 skill-chooser">
									<div class="select-wrapper">
										<select id="skill-chooser__items">
											<?php foreach($skills_items as $i){ ?>
												<option data-kategorie="<?php echo $i->skills_kategorien_id; ?>" value="<?php echo $i->id; ?>" data-name="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</article>
								<article class="gd gd--4">
									<button type="button" class="button" id="skill-chooser__add">Hinzufügen</button>
								</article>
								<article class="gd gd--12">

									<div class="selected-skills"></div>

								</article>


                                <article class="gd gd--12">
									<h2 class="form-headline">Ort/Region (mind. 1)</h2>
								</article>
								<article class="gd gd--4 region-chooser">
									<div class="select-wrapper">
										<select id="region-chooser__kategorie">
											<?php foreach($bundeslaender as $k){ ?>
												<option data-kategorie="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</article>
								<article class="gd gd--4 region-chooser">
									<div class="select-wrapper">
										<select id="region-chooser__items">
											<?php foreach($bezirke as $i){ ?>
												<option data-kategorie="<?php echo $i->bundeslaender_id; ?>" value="<?php echo $i->id; ?>" data-name="<?php echo $i->name; ?>"><?php echo $i->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</article>
								<article class="gd gd--4">
									<button type="button" class="button" id="region-chooser__add">Hinzufügen</button>
								</article>
								<article class="gd gd--12">

									<div class="selected-regionen"></div>

								</article>
                    <article class="gd gd--12">
                        <button class="button" onclick="nextStep('informationen', 'agb');">Fortfahren</button>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-informationen signup-step--user-dienstleister">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--6">
                        <h2>Stammdaten</h2>
                        <input type="text" name="firmenwortlaut" id="firmenwortlaut" placeholder="Firmenwortlaut (pflicht)">
                        <input type="text" name="gesellschaftsform" id="gesellschaftsform" placeholder="Gesellschaftsform (pflicht)">
                        <select name="ansprechpartner_anrede" id="ansprechpartner_anrede">
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                        </select>
                        <input type="text" name="ansprechpartner_titel" id="ansprechpartner_titel" placeholder="Ansprechpartner Titel (optional)">
                        <input type="text" name="ansprechpartner_vorname" id="ansprechpartner_vorname" placeholder="Ansprechpartner Vorname (pflicht)">
                        <input type="text" name="ansprechpartner_nachname" id="ansprechpartner_nachname" placeholder="Ansprechpartner Nachname (pflicht)">
                        <input type="text" name="ansprechpartner_position" id="ansprechpartner_position" placeholder="Ansprechpartner Position (pflicht)">
                        <input type="text" name="uid" id="uid" placeholder="Umsatzsteuer ID (pflicht)">
                        <input type="text" name="fn" id="fn" placeholder="Firmenbuchnummer (pflicht)">
                        <input type="text" name="website" id="website" placeholder="Website (pflicht)">
                        <input type="text" name="firmensitz_adresse" id="firmensitz_adresse" placeholder="Firmensitz Straße und Hausnummer (pflicht)">
                        <input type="text" name="firmensitz_plz" id="firmensitz_plz" placeholder="Firmensitz PLZ (pflicht)">
                        <input type="text" name="firmensitz_ort" id="firmensitz_ort" placeholder="Firmensitz Ort (pflicht)">
                    </article>
                    <article class="gd gd--6">
                        <h2>Optional</h2>

                        <div class="filialen_wrapper">
                            <input type="text" name="filialen[]" class="filialen" placeholder="Filialenname" value="">

                            <button class="button filialen_wrapper__add" onclick="addNewInputByName('filialen', 'Filialenname', '.filialen_wrapper__add');">Weitere Filiale hinzufügen</button>
                        </div>

                        <div id="berufsfelder-wrapper" class="berufswahl">
                            <h4>Berufsfelder (mind. 1)</h4>
                            <?php
                                foreach ($berufsfelder as $f){
                                    echo '<p><input class="berufsfelder" name="berufsfelder[]" type="checkbox" value="'.$f->id.'"><i class="icon icon--berufswahl icon--berufsfeld-'.$f->id.'"></i>'.$f->name.'</p>';
                                }
                            ?>
                        </div>
                    </article>
                    <article class="gd gd--12">
                        <button class="button" onclick="nextStep('informationen', 'agb');">Fortfahren</button>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-informationen signup-step--user-kunde">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--6">
                        <h2>Stammdaten</h2>
                        <input type="text" name="firmenwortlaut" id="firmenwortlaut" placeholder="Firmenwortlaut (pflicht)">
                        <input type="text" name="gesellschaftsform" id="gesellschaftsform" placeholder="Gesellschaftsform (pflicht)">
                        <select name="ansprechpartner_anrede" id="ansprechpartner_anrede">
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                        </select>
                        <input type="text" name="ansprechpartner_titel" id="ansprechpartner_titel" placeholder="Ansprechpartner Titel (optional)">
                        <input type="text" name="ansprechpartner_vorname" id="ansprechpartner_vorname" placeholder="Ansprechpartner Vorname (pflicht)">
                        <input type="text" name="ansprechpartner_nachname" id="ansprechpartner_nachname" placeholder="Ansprechpartner Nachname (pflicht)">
                        <!--
                        <input type="text" name="ansprechpartner_position" id="ansprechpartner_position" placeholder="Ansprechpartner Position (pflicht)">
                        <input type="text" name="uid" id="uid" placeholder="Umsatzsteuer ID (optional)">
                        <input type="text" name="fn" id="fn" placeholder="Firmenbuchnummer (optional)">
                        <input type="text" name="website" id="website" placeholder="Website (pflicht)">
                        <input type="text" name="firmensitz_adresse" id="firmensitz_adresse" placeholder="Firmensitz Straße und Hausnummer (pflicht)">
                        <input type="text" name="firmensitz_plz" id="firmensitz_plz" placeholder="Firmensitz PLZ (pflicht)">
                        <input type="text" name="firmensitz_ort" id="firmensitz_ort" placeholder="Firmensitz Ort (pflicht)">
                        -->
                    </article>
                    <article class="gd gd--6">
                        <h2>Optional</h2>
                        <div class="arbeitsstaetten_wrapper">
                            <input type="text" name="arbeitsstaetten[]" class="arbeitsstaetten" placeholder="Arbeitsstätte" value="">

                            <button class="button arbeitsstaetten_wrapper__add" onclick="addNewInputByName('arbeitsstaetten', 'Arbeitsstätte', '.arbeitsstaetten_wrapper__add');">Weitere Arbeitsstätte hinzufügen</button>
                        </div>

                        <label for="dienstleister">Ausgewählte Dienstleister</label>
                        <select multiple="multiple" name="dienstleister" id="dienstleister">
                            <?php
                                foreach ($dienstleister as $d){
                                    echo '<option value="'.$d->id.'">'.$d->firmenwortlaut.'</option>';
                                }
                            ?>
                        </select>

                        <button class="button" style="margin-top: 40px; margin-bottom: 10px;" onclick="dlNichtInAuswahl();">Dienstleister nicht in Auswahl</button>

                        <input type="hidden" name="dl_anforderung_bool" id="dl_anforderung_bool" value="0">

                        <div id="dl_anforderung" style="display: none;">
                        	<input type="text" name="dl_anforderung_name" id="dl_anforderung_name" placeholder="Name des Dienstleisters">
							<input type="text" name="dl_anforderung_ansprechpartner_titel" id="dl_anforderung_ansprechpartner_titel" placeholder="Ansprechpartner Titel">
							<input type="text" name="dl_anforderung_ansprechpartner_vorname" id="dl_anforderung_ansprechpartner_vorname" placeholder="Ansprechpartner Vorname">
							<input type="text" name="dl_anforderung_ansprechpartner_nachname" id="dl_anforderung_ansprechpartner_nachname" placeholder="Ansprechpartner Nachname">
							<input type="text" name="dl_anforderung_ansprechpartner_email" id="dl_anforderung_ansprechpartner_email" placeholder="Ansprechpartner E-Mail">
                       		<h3>Nachricht an den Dienstleister:</h3>
                       		<p class="dl_anforderung_placeholder dl_anforderung_placeholder--betreff">Betreff: <?php echo utf8_decode(get_option('dienstleister_einladen_betreff')); ?></p>
							<p class="dl_anforderung_placeholder dl_anforderung_placeholder--betreff">Nachricht:</p>
							<p class="dl_anforderung_placeholder">Sehr geehrte(r) Vorname Nachname!</p>
							<textarea name="dl_anforderung_infotext" id="dl_anforderung_infotext" cols="30" rows="10"><?php echo utf8_decode(get_option('dienstleister_einladen_text')); ?></textarea>
                        </div>

                    </article>
                    <article class="gd gd--12">
                        <button class="button" onclick="nextStep('informationen', 'agb');">Fortfahren</button>
                    </article>
                </div>
            </div>
        </div>
    </seciton>
    <seciton class="section signup-step signup-step--step-agb">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
                    <article class="gd gd--12">
                        <p>Bitte bestätigen Sie unsere <a id="agb-link" href="/agb-datenschutzerklaerung?acceptmode=1&user_type=ressource&user_id=1" target="_blank">Datenschutzerklärung und unseren Ethikkodex</a>, andernfalls können wir Ihnen keine Jobangebote zukommen lassen. Möchten Sie diese jetzt nicht bestätigen, haben Sie innerhalb von 30 Tagen die Möglichkeit dies nachzuholen, ohne Ihre kompletten Daten erneut eingeben zu müssen. Nach Ablauf der 30 Tage wird Ihr Datensatz jedoch gelöscht.</p>

                       	<p>
							<input type="checkbox" id="accept-checkbox" name="accept-checkbox" /> Ich akzepiere die <a id="agb-link" href="/agb-datenschutzerklaerung?acceptmode=1&user_type=ressource&user_id=1" target="_blank">Datenschutzerklärung und den Ethikkodex</a>.
                       	</p>

                        <button class="button" onclick="acceptAGB();">Registrierung abschließen</button>
                    </article>
                </div>
            </div>
        </div>
    </seciton>

    <script type="text/javascript" src="//platform.linkedin.com/in.js">api_key: 86ckqkwnbdfrvn</script>
    <script>

		function dlNichtInAuswahl(){
			jQuery('#dl_anforderung_bool').val(1);
			jQuery('#dl_anforderung').show();
		}


		// Social Logins

		function setSocialInformation(network, id, first_name, last_name, email, gender){

			jQuery('input[name=vorname]').val(first_name);
			jQuery('input[name=nachname]').val(last_name);
			jQuery('input[name=email]').val(email);

			if (gender == "male"){
				jQuery("select[name=ansprechpartner_anrede] option").filter(function() {
					return jQuery(this).text() == "Herr";
				}).prop('selected', true);
			}else{
				jQuery("select[name=ansprechpartner_anrede] option").filter(function() {
					return jQuery(this).text() == "Frau";
				}).prop('selected', true);
			}

			jQuery('input[name=ansprechpartner_vorname]').val(ansprechpartner_vorname);
			jQuery('input[name=ansprechpartner_nachname]').val(ansprechpartner_nachname);
		}


		// Linkedin

		var connectLinkedin = function() {
			IN.UI.Authorize().params({"scope":["r_basicprofile", "r_emailaddress"]}).place();
			IN.Event.on(IN, 'auth', getProfileData);
		}

		var getProfileData = function() {
			IN.API.Profile("me").fields("id,firstName,lastName,email-address,picture-urls::(original),public-profile-url,location:(name)").result(function (me) {
				var profile = me.values[0];
				setSocialInformation('linkedin', profile.id, profile.firstName, profile.lastName, profile.emailAddress, 'male');
			});
		}



		// Xing

		function onXingAuthLogin(response) {
			console.log(response);

			if (response.user) {
				setSocialInformation('xing', response.user.id, response.user.first_name, response.user.last_name, response.user.active_email, 'male');
			} else if (response.error) {
				//output = 'Error: ' + response.error;
			}
		}

		(function(d) {
			var js, id='lwx';
			if (d.getElementById(id)) return;
			js = d.createElement('script'); js.id = id; js.src = "https://www.xing-share.com/plugins/login.js";
			d.getElementsByTagName('head')[0].appendChild(js)
		}(document));



		// Facebook

		function connectFacebook(){

			FB.login(function(response) {
				if (response.authResponse) {
					FB.api('/me', {fields: 'id, first_name, last_name, email, gender'}, function(response) {
						setSocialInformation('facebook', response.id, response.first_name, response.last_name, response.email, response.gender);
					});
				} else {
					console.log('User cancelled login or did not fully authorize.');
				}
			}, {scope: 'email'});
		}

		window.fbAsyncInit = function() {
			FB.init({
				appId      : '454143068255402',
				xfbml      : true,
				version    : 'v2.8'
			});

			FB.AppEvents.logPageView();
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

    jQuery(".user-type-radio-images .gd--4").on('click', 'input', function(event) {
      jQuery(".user-type-radio-images .gd").removeClass("active");
      console.log("now");
      jQuery(this).parent().parent().addClass("active");
    });

	</script>

<?php
    }
?>

<?php get_footer("register"); ?>
