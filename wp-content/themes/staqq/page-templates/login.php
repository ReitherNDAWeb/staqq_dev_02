<?php

    /**
     *   Template Name: STAQQ Login
     */

if (!is_user_logged_in()){
	//Set a cookie now to see if they are supported by the browser.
$secure = ( 'https' === parse_url( wp_login_url(), PHP_URL_SCHEME ) );
setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure );
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );
}

    get_header('pre');
    get_header();
	
?>
    <seciton class="section section--login">
        <div class="section__overlay">
            <div class="section__wrapper">
                <div class="center">
            
            <?php
                if (is_user_logged_in()){
                    ?>
                       
                        <article class="gd gd--12">
							<form>
								Eingelogged
							</form>
						</article>
                        
                    <?php 
                        }else{
                    ?>
    
                        <?php if (isset($_GET['signup'])): ?>

                        <div class="signup-info">
                            <h2>Danke für Ihre Registrierung bei STAQQ!</h2>
                            <p>Sie können sich nun anmelden.</p>
                        </div>

                        <?php endif; ?>

                        <article class="gd gd--12">
                            <form name="loginform" class="form--max-width" id="loginform" action="/wp-login.php?action=noredirect" method="post">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logos/main.jpg" alt="">
                                <input type="text" id="log" name="log" placeholder="E-Mail">
                                <input type="password" id="pwd" name="pwd" placeholder="Passwort">
                                <button class="button" type="submit">Anmelden</button>
                                <input name="redirect_to" value="/app/joborders" type="hidden">
                                <input name="testcookie" value="1" type="hidden">
                                <a href="/app/passwort-vergessen/" style="color: #989898;padding-top: 20px;font-size: 0.9rem;display: block;">Passwort vergessen</a>
                            </form>
                        </article>
                 
                    <?php    
                        }
                    ?>
                </div>
            </div>
        </div>
    </seciton>
    
    <?php if ($_GET['login'] == "failed"): ?>
    
    <div class="remodal-faild-login">
    	<h2>Die Anmeldung ist leider fehlgeschalgen!</h2>
    </div>
    
    <script>
        
        jQuery(document).ready(function(){
            jQuery('.remodal-faild-login').remodal().open();
			
			setTimeout(function(){
				jQuery('.remodal-faild-login').remodal().close();
			}, 2500);
        });
        
    </script>
	<?php endif; ?>

<?php get_footer(); ?>