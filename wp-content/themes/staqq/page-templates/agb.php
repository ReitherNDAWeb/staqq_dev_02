<?php

    require_once get_template_directory().'/vendor/restclient.php';
    
	if (isset($_POST['action']) && $_POST['action'] == "accept"){
		
		$user_type = $_GET['user_type'];
		$user_id = $_GET['user_id'];
		
        $response = $api->post("$user_type/$user_id/acceptAGB", [])->decode_response();
        
        wp_redirect('/app/?signup=true'); exit;
	}

    /**
     *   Template Name: STAQQ AGBs
     */

    get_header();

	if (!$wpUserSTAQQUser && !isset($_GET['user_type'])){
		
?>
	<seciton class="section">
        <div class="section__overlay">
			<div class="section__wrapper">
                <article class="gd gd--12">
                	<h1>AGB & Ethikkodex</h1>
				</article>
                <article class="gd gd--4">
					<a class="agb-item agb-item--ressource" href="/agb-datenschutzerklaerung/?user_type=ressource">Mitarbeiter-Bewerber</a>
				</article>
                <article class="gd gd--4">
					<a class="agb-item agb-item--kunde"  href="/agb-datenschutzerklaerung/?user_type=kunde">Kunde</a>
                </article>
                <article class="gd gd--4">
					<a class="agb-item agb-item--dienstleister"  href="/agb-datenschutzerklaerung/?user_type=dienstleister">Personal-Dienstleister</a>
				</article>
			</div>
		</div>
	</seciton>
	
<?php
		
	}else{

?>
   

    <seciton class="section">
        <div class="section__overlay">
          	<?php if(($_GET['user_type'] == 'ressource') || ($wpUserSTAQQUser && $wpUserRole == "ressource")){ ?>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>AGB Mitarbeiter-Bewerber</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(168)->post_content; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>Ethikkodex</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(209)->post_content; ?>
                </article>
            </div>
            <?php
																						  
				}elseif(($_GET['user_type'] == 'dienstleister') || ($wpUserSTAQQUser && ($wpUserRole == "dienstleister" || $wpUserRole == "dienstleister_user"))){ 
			?>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>AGB Personal-Dienstleister</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(169)->post_content; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>Ethikkodex</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(218)->post_content; ?>
                </article>
            </div>
            <?php
																						  
				}elseif(($_GET['user_type'] == 'kunde') || ($wpUserSTAQQUser && ($wpUserRole == "kunde" || $wpUserRole == "kunde_user"))){ 
			?>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>AGB Kunden</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(170)->post_content; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                	<h2>Ethikkodex</h2>
                </article>
                <article class="gd gd--12">
                	<?php echo get_post(219)->post_content; ?>
                </article>
            </div>
            <?php } ?>
        </div>
    </seciton>

<?php 
	
	}

	if ($_GET['acceptmode'] == 1){
		
		$user_type = $_GET['user_type'];
		$user_id = $_GET['user_id'];
?>
    
    <div id="agb-accept-hover">
    	
    	<form action="" method="post" onsubmit="return checkAccept()" >
    		<input type="checkbox" id="accept-checkbox" name="accept-checkbox" /> Ich akzepiere die Datenschutzerklärung und den Ethikkodex
    		<input type="hidden" name="action" value="accept">
    		<input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
    		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    		<button class="button button--white" type="submit">Registrierung abschließen</button>
    	</form>
    	
    </div>
	
	<script>
		
		function checkAccept(){
			if (jQuery('#accept-checkbox').is(":checked")){
				return true;
			}else{
				error("Sie müssen die Datenschutzerklärung und den Ethikkodex akzeptieren!");
				return false;
			}
		}
		
	</script>
<?php
		
	}

    get_footer();

?>