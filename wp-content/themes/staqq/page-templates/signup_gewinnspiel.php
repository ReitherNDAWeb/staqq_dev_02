<?php

    /**
     *   Template Name: STAQQ Sign up / Gewinnspiel
     */

   
    get_header('gewinnspiel');
            
            
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

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/css/gewinnspiel_main.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php /* <script type="text/javascript" src="https://unpkg.com/vue"></script> */?>



    <div id="app">

    <nav id="nav">
      <div class="left">
        <a class="menuButton">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <a href="/gewinnspiel">
        <img alt="staqq" src="<?php echo get_stylesheet_directory_uri(); ?>/img/gewinnspiel/logo.jpg"/>
        </a>
      </div>
      <div class="right">
        <a target="_blank" href="https://staqq.at/app/" class="pill">Login</a>
      </div>

      <div id="mainMenu" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
          <center class="menu">
            <ul class="menu-list"><li id="menu-item-7" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-7"><a href="https://staqq.at/">Home</a></li>
            <li id="menu-item-32" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-32"><a href="https://staqq.at/vorteile/">Vorteile</a></li>
            <li id="menu-item-28" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-23 current_page_item menu-item-28"><a href="https://staqq.at/registrierung/">Registrierung</a></li>
            </ul>
            </center>
        </div>
        <button class="modal-close"></button>
      </div>
    </nav>
    
    <div class="container mainCont">
      <div class="signup-step signup-step--step-user-type signup-step--active">
        <section id="header">
          <div class="mainSquare square">
            <div class="is-overlay-image">
              <div class="img" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/img/gewinnspiel/strand2.jpg');"></div>
            </div>
            <h1 class="title is-1">Jetzt 1000€ Urlaubszuschuss gewinnen</h1>
            <input type="radio" name="user_type" id="ressource" value="ressource" checked style="height:0; overflow: hidden;">
            <a class="boxlink scroll" href="#register" onclick="nextStepNew('user-type', 'tel');">
              <span hred="#">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
              </span>
              <p>Jetzt registrieren und Urlaubszuschuss sichern</p>
            </a>
            <div class="square isQuater isSec"></div>
            <div class="square isQuater isLightGray"></div>
          </div>
        </section>
      </div>

    
      <div class="signup-step signup-step--step-tel">
        <section class="register halfSquare middle">
          <div class="square isGray"></div>
          <div class="is-overlay-text">
            <div class="va">
              <div>
                <h2 id="register" class="title is-1">
                  Registrieren & gewinnen
                </h2>
                  <?php /*                
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
                 */?>
                  <div class="form-center">
                    <form>
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
                     
                  </form>
                   <a href="#aktivierung" class="pill" onclick="nextStepNew('tel', 'aktivierung');">Fortfahren</a>
                </div>
              </div>
              </div>
            </div>
        </section>
      </div>



      <div class="signup-step signup-step--step-aktivierung">
        <section class="confirm halfSquare right">
          <div class="square">
            <div class="is-overlay-image">
              <div class="img" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/img/gewinnspiel/flug.jpg');"></div>
            </div>
            <div class="square isPrim"></div>
          </div>
          <div class="is-overlay-text">
            <div class="va">
              <div>
                <div class="columns">
                  <div class="column is-8 is-half-desktop">
                    <h3 id="aktivierung" class="title is-1">
                      Bestätigen & losstarten
                    </h3>
                    
                      <p>Wir senden Ihnen in Kürze eine SMS an die von Ihnen angegebene Rufnummer. Bitte bestätigen Sie diese zur Verifizierung Ihres Accounts innerhalb der nächsten 5 Minuten – andernfalls verfällt Ihre Anmeldung.</p>
                      <form>
                        <input type="text" name="code" id="code" value="" placeholder="Aktivierungscode" required>
                      </form>
                      <a href="#passwordAnchor" class="pill" onclick="nextStepNew('aktivierung', 'passwort');">Fortfahren</a>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>


      <div class="signup-step signup-step--step-passwort">
        <section class="user halfSquare left">
          <div class="square">
            <div class="is-overlay-image">
              <div class="img" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/img/gewinnspiel/frau.jpg');"></div>
            </div>
            <div class="square isLightGray"></div>
          </div>
          <div class="is-overlay-text">
            <div class="va">
              <div>
                <div class="columns">
                  <div class="column is-8 is-offset-4 is-half-desktop is-offset-6-desktop ">
                    <h3 id="passwordAnchor" class="title is-1">
                      Benutzerkonto anlegen
                    </h3>
                    
                      <input type="password" name="password" id="password" placeholder="Passwort" required>
                      <input type="password" name="password2" id="password2" placeholder="Passwort Wiederholung" required>
                      <ul class="helper-text">
                          <li class="length">Mindestens 8 Zeichen.</li>
                          <li class="lowercase">Beinhaltet Kleinbuchstaben.</li>
                          <li class="uppercase">Beinhaltet Großbuchtstaben.</li>
                          <li class="special">Beinhaltet eine Zahl oder ein Sonderzeichen.</li>
                      </ul>
                      <button id="lastbutton" class="pill" onclick="nextStepNew('passwort', 'informationen');">Fortfahren</button>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>


    </div>

    <div id="thankYou" class="modal">
      <div class="modal-background"></div>
      <div class="modal-content">
        <center>
          <p style="color: #ffffff;">
            Vielen Dank, dass du dich bei STAQQ registriert hast. Es sind nur noch ein paar Clicks bis zu deinem Traumjob. Hinterlege deine Stammdaten und lass dich von deinem neuen Arbeitgeber finden.
          </p>
          <p>
            <a href="/app" class="pill">
              Login
            </a>
            <a href="/" class="pill">
              Home
            </a>
          </p>
        </center>
      </div>
    </div>


    
    
    

   
   
   
  
    
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




	</script>


  <script type="text/javascript">
  jQuery(document).on('ready', function() {
    jQuery('#mainMenu .modal-close, .menuButton').on('click', function() {
      jQuery('#mainMenu').fadeToggle();
      jQuery('#mainMenu').toggleClass('test');
    });
  });



  function nextStepNew(f, n){
          if(jQuery('.signup-step--step-'+f).hasClass('signup-step--active')){

              if (f == "user-type"){
              
                  user_type = jQuery('.signup-step--step-user-type [name=user_type]:checked').val();
                  jQuery('.signup-step--user-'+user_type).css('display', 'block');
                  if(user_type == "dienstleister" || user_type == "kunde") jQuery('.signup-step--step-tel #firmenwortlaut').show();
                  goToNew(n);
                  
              } else if (f == "tel"){
                  
                  user = {
                      user_type: user_type,
                      firmenwortlaut: jQuery('.signup-step--step-tel #firmenwortlaut').val(),
                      email: jQuery('.signup-step--step-tel #email').val(),
                      telefon: jQuery('.signup-step--step-tel #laendervorwahl').val() + jQuery('.signup-step--step-tel #vorwahl').val() + jQuery('.signup-step--step-tel #telefon').val(),
                      vorname: jQuery('.signup-step--step-tel #vorname').val(),
                      nachname: jQuery('.signup-step--step-tel #nachname').val(),
                      debug: DEBUG
                  };
                  
                  
                  if ((user.email != "") && (jQuery('.signup-step--step-tel #telefon').val() != "") && (user.vorname != "") && (user.nachname != "") && ((user.user_type == "ressource") || (user.firmenwortlaut != ""))){
                      
                      if (jQuery.isNumeric(jQuery('.signup-step--step-tel #telefon').val())){

                          jQuery(".signup-step--step-user-type .form-center").validate({
                            debug: true
                          });

                          showSpinner();

                          signUpRegister(function(d) {

                              hideSpinner();

                              if (d.status){
                                  goToNew(n);
                              }else{
                                  error(d.msg);
                              }
                          });
                      }else{
                          error("Angegebene Telefonnummer ist nicht numerisch!");
                      }
                  }else{
                      error("Es müssen alle Felder ausgefüllt sein!");
                  }
              } else if (f == "aktivierung") {
                  showSpinner();
                  signUpActivation(function(d){
                      
                      hideSpinner();
                      if (d.status){
                          ressource.registrations_id = d.id;
                          dienstleister.registrations_id = d.id;
                          kunde.registrations_id = d.id;
                          goToNew(n);
                      }else{
                          error(d.msg);
                      }
                  });
              } else if (f == "passwort") {
                  
                  var p1 = jQuery('.signup-step--step-passwort #password').val();
                  var p2 = jQuery('.signup-step--step-passwort #password2').val();
                  
                  if (p1 == ""){
                      error("Es muss ein Passwort gewählt werden!");
                  } else if(!jQuery('.signup-step--step-passwort #password').hasClass('valid')){
                      error("Das Passwort entspricht nicht den Anforderungen!");
                  } else if (p1 != p2){
                      error("Die beiden Passwörter stimmen nicht überein!");
                  }else{
                      showSpinner();
                      passwort = p1;
                  
                      signUpPassword(function(d){
                      
                          hideSpinner();
                          if (d.status){
                              jQuery('#thankYou').addClass('is-active');
                          }else{
                              error(d.msg);
                          }
                      });
                  }
                      
              } else if (f == "informationen") {
                  
                  showSpinner();
                  signUpInformationen(function(d){

                      hideSpinner();
                      if (d.status){
                          goToNew(n);
                      }else{
                          error(d.msg);
                      }
                  });
                  
              } else {
                  goToNew(n);
              }
              
          }
      }


  function goToNew(n){
      jQuery('.signup-step').removeClass('signup-step--active');
      jQuery('.signup-step--step-'+n).addClass('signup-step--active');
      
      if (n == "aktivierung"){
          jQuery('#code').focus();
      }
      
      if (n == "informationen"){
          target = jQuery('.signup-step--user-'+user_type+'.signup-step--step-'+n);
      }else{
          target = jQuery('.signup-step--step-'+n);
      }

  }

  jQuery(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    var id = jQuery(this).attr('href');

    // target element
    var id = jQuery(id);
    if (id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = id.offset().top;

    // animated top scrolling
    jQuery('body, html').animate({scrollTop: (pos-90) });
  });
  </script>


<?php    
    }
?>
                        
<?php get_footer(); ?>