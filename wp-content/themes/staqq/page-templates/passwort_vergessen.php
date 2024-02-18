<?php

    /**
     *   Template Name: STAQQ App / Passwort vergessen
     */

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

                        <article class="gd gd--12">
                            <form name="loginform" class="form--max-width" id="loginform" action="/wp-login.php?action=lostpassword" method="post">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logos/main.jpg" alt="">
                                <input type="text" id="user_login" name="user_login" placeholder="E-Mail">
                                <button class="button" type="submit">Passwort zurücksetzen</button>
                                <input name="redirect_to" value="/app/" type="hidden">
                                <input name="testcookie" value="1" type="hidden">
                            </form>
                        </article>
                 
                    <?php    
                        }
                    ?>
                </div>
            </div>
        </div>
    </seciton>

<?php get_footer(); ?>