<?php

    /**
     * Plugin Name: STAQQ User
     * Plugin URI:  https://www.staqq.at
     * Description: User Admin für STAQQ
     * Author:      Ploner Communications
     * Author URI:  http://www.ploner-communications.com
     * Version:     1.0.0
     */

    add_action('admin_menu', 'staqq_admin_user_menu');
	
	// Doing Actions
	add_action('admin_post_staqq_admin_dev__reset_data', 'action__staqq_admin_dev__reset_data');
	add_action('admin_post_staqq_admin_dev__reset_skills', 'action__staqq_admin_dev__reset_skills');

	add_action('admin_post_staqq_admin_user__delete_ressource', 'action__staqq_admin_user__delete_ressource');
	add_action('admin_post_staqq_admin_user__export_ressources', 'action__staqq_admin_user__export_ressources');
	add_action('admin_post_staqq_admin_user__update_dienstleister', 'action__staqq_admin_user__update_dienstleister');
	add_action('admin_post_staqq_admin_user__delete_dienstleister', 'action__staqq_admin_user__delete_dienstleister');
	add_action('admin_post_staqq_admin_user__update_kunde', 'action__staqq_admin_user__update_kunde');
	add_action('admin_post_staqq_admin_user__delete_kunde', 'action__staqq_admin_user__delete_kunde');

	add_action('admin_post_staqq_admin_berufe_berufsfelder__edit', 'action__staqq_admin_berufe_berufsfelder__edit');
	add_action('admin_post_staqq_admin_berufe_berufsfelder__delete', 'action__staqq_admin_berufe_berufsfelder__delete');
	add_action('admin_post_staqq_admin_berufe_berufsfelder__create', 'action__staqq_admin_berufe_berufsfelder__create');
	add_action('admin_post_staqq_admin_berufe_berufsgruppen__edit', 'action__staqq_admin_berufe_berufsgruppen__edit');
	add_action('admin_post_staqq_admin_berufe_berufsgruppen__delete', 'action__staqq_admin_berufe_berufsgruppen__delete');
	add_action('admin_post_staqq_admin_berufe_berufsgruppen__create', 'action__staqq_admin_berufe_berufsgruppen__create');
	add_action('admin_post_staqq_admin_berufe_berufsbezeichnungen__edit', 'action__staqq_admin_berufe_berufsbezeichnungen__edit');
	add_action('admin_post_staqq_admin_berufe_berufsbezeichnungen__delete', 'action__staqq_admin_berufe_berufsbezeichnungen__delete');
	add_action('admin_post_staqq_admin_berufe_berufsbezeichnungen__create', 'action__staqq_admin_berufe_berufsbezeichnungen__create');

	add_action('admin_post_staqq_admin_skills_items__edit', 'action__staqq_admin_skills_items__edit');
	add_action('admin_post_staqq_admin_skills_items__delete', 'action__staqq_admin_skills_items__delete');
	add_action('admin_post_staqq_admin_skills_items__create', 'action__staqq_admin_skills_items__create');
	add_action('admin_post_staqq_admin_skills_kategorien__edit', 'action__staqq_admin_skills_kategorien__edit');
	add_action('admin_post_staqq_admin_skills_kategorien__delete', 'action__staqq_admin_skills_kategorien__delete');
	add_action('admin_post_staqq_admin_skills_kategorien__create', 'action__staqq_admin_skills_kategorien__create');

	add_action('admin_post_staqq_admin_sammelrechnungen__doit', 'action__staqq_admin_sammelrechnungen__doit');

	add_action('admin_post_staqq_admin_verrechnung__edit', 'action__staqq_admin_verrechnung__edit');
	add_action('admin_post_staqq_admin_verrechnung__delete', 'action__staqq_admin_verrechnung__delete');
	add_action('admin_post_staqq_admin_verrechnung__create', 'action__staqq_admin_verrechnung__create');

	add_action('admin_post_staqq_admin_texte__save', 'action__staqq_admin_texte__save');

	// Scripts and Styles
	wp_enqueue_style( 'datatables', get_template_directory_uri() . '/css/backend.css', NULL, NULL);
	wp_enqueue_style( 'datatables', '//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css', NULL, NULL);
	wp_enqueue_style( 'twentysixteen-remodal', get_template_directory_uri() . '/vendor/remodal/dist/remodal.css', NULL, NULL);
	wp_enqueue_style( 'twentysixteen-remodal-theme', get_template_directory_uri() . '/vendor/remodal/dist/remodal-default-theme.css', NULL, NULL);
    wp_enqueue_script( 'datatables', '//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', array(), '', true );
    wp_enqueue_script( 'twentysixteen-remodal', get_template_directory_uri() . '/vendor/remodal/dist/remodal.min.js', array(), '', true );

	add_action( 'after_setup_theme', function(){
		add_theme_support('woocommerce');	
	});

    function staqq_admin_user_menu() {
		
		remove_menu_page('tools.php');
		remove_menu_page('plugins.php');
		remove_menu_page('edit.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('options-general.php');
		
        add_menu_page('STAQQ Jobs', 'Jobs', 'staqq_admin', 'staqq_admin_joborders', 'staqq_admin_joborders', 'dashicons-lightbulb', 2);
		
        add_menu_page('STAQQ Auswertung', 'Auswertung', 'staqq_admin', 'staqq_admin_auswertung', 'staqq_admin_auswertung', 'dashicons-chart-pie', 2);
		
        add_menu_page('STAQQ User', 'User', 'staqq_admin', 'staqq_admin_user', null, 'dashicons-admin-users', 2);
        
        add_submenu_page('staqq_admin_user', 'Ressources', 'Ressources', 'staqq_admin', 'staqq_admin_user', 'staqq_admin_user_options_ressources');
        add_submenu_page('staqq_admin_user', 'Dienstleister', 'Dienstleister', 'staqq_admin', 'staqq_admin_user_dienstleister', 'staqq_admin_user_options_dienstleister');
        add_submenu_page('staqq_admin_user', 'Dienstleister User', 'Dienstleister User', 'staqq_admin', 'staqq_admin_user_dienstleister_user', 'staqq_admin_user_options_dienstleister_user');
        add_submenu_page('staqq_admin_user', 'Kunden', 'Kunden', 'staqq_admin', 'staqq_admin_user_kunden', 'staqq_admin_user_options_kunden');
        add_submenu_page('staqq_admin_user', 'Kunden User', 'Kunden User', 'staqq_admin', 'staqq_admin_user_kunden_user', 'staqq_admin_user_options_kunden_user');
		
        add_menu_page('STAQQ Entwicklung', 'Entwicklung', 'staqq_admin', 'staqq_admin_dev', 'staqq_admin_dev', 'dashicons-editor-code', 2);
        
		add_menu_page('STAQQ Berufe', 'Berufe', 'staqq_admin', 'staqq_admin_berufe_berufsfelder', null, 'dashicons-universal-access-alt', 2);
        add_submenu_page('staqq_admin_berufe_berufsfelder', 'Berufsfelder', 'Berufsfelder', 'staqq_admin', 'staqq_admin_berufe_berufsfelder', 'staqq_admin_berufe_berufsfelder');
        add_submenu_page('staqq_admin_berufe_berufsfelder', 'Berufsgruppen', 'Berufsgruppen', 'staqq_admin', 'staqq_admin_berufe_berufsgruppen', 'staqq_admin_berufe_berufsgruppen');
        add_submenu_page('staqq_admin_berufe_berufsfelder', 'Berufsbezeichnungen', 'Berufsbezeichnungen', 'staqq_admin', 'staqq_admin_berufe_berufsbezeichnungen', 'staqq_admin_berufe_berufsbezeichnungen');
		
		add_menu_page('STAQQ Joborders', 'Rechnungen', 'staqq_admin', 'staqq_admin_sammelrechnungen_erstellen', null, 'dashicons-money', 3);
		add_submenu_page('staqq_admin_sammelrechnungen_erstellen', 'Offen', 'Offen', 'staqq_admin', 'staqq_admin_sammelrechnungen_erstellen', 'staqq_admin_sammelrechnungen_erstellen');
		add_submenu_page('staqq_admin_sammelrechnungen_erstellen', 'Erstellt', 'Erstellt', 'staqq_admin', 'staqq_admin_sammelrechnungen_erstellt', 'staqq_admin_sammelrechnungen_erstellt');
		add_submenu_page('staqq_admin_sammelrechnungen_erstellen', 'Bezahlt', 'Bezahlt', 'staqq_admin', 'staqq_admin_sammelrechnungen_bezahlt', 'staqq_admin_sammelrechnungen_bezahlt');
		
		add_menu_page('STAQQ Verrechnung', 'Verrechnung', 'staqq_admin', 'staqq_admin_verrechnung', 'staqq_admin_verrechnung', 'dashicons-cart', 2);
		
		add_menu_page('STAQQ Texte', 'Texte', 'staqq_admin', 'staqq_admin_texte', 'staqq_admin_texte', 'dashicons-editor-paste-text', 2);
		
		add_menu_page('STAQQ Skills', 'Skills', 'staqq_admin', 'staqq_admin_skills_items', null, 'dashicons-hammer', 2);
        add_submenu_page('staqq_admin_skills_items', 'Items', 'Items', 'staqq_admin', 'staqq_admin_skills_items', 'staqq_admin_skills_items');
        add_submenu_page('staqq_admin_skills_items', 'Kategorien', 'Kategorien', 'staqq_admin', 'staqq_admin_skills_kategorien', 'staqq_admin_skills_kategorien');
    
    }

    function staqq_admin_get_db (){


        require_once get_home_path().'/api/config.php';

        $dbhost = API_DB_HOST;
        $dbuser = API_DB_USER;
        $dbpass = API_DB_PASS;
        $dbname = API_DB_NAME;

        $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
        $db = new PDO($mysql_conn_string, $dbuser, $dbpass); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }







	/**************************************************************
	** JOBORDERS
	**************************************************************/

    function staqq_admin_joborders(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT *, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende, DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von, DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis FROM joborders ORDER BY id DESC");
        $sth->execute();
		
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		for ($i=0;$i<count($data);$i++){
			
			if ($data[$i]['creator_type'] == "kunde"){
				$c = "kunden";
				$data[$i]['subuser'] = false;
				
			}elseif ($data[$i]['creator_type'] == "kunde_user"){
				$c = "kunden_user";	
				$data[$i]['subuser'] = true;
			}elseif ($data[$i]['creator_type'] == "dienstleister"){
				$c = $data[$i]['creator_type'];
				$lj = "dienstleister";
				$data[$i]['subuser'] = false;
			}elseif ($data[$i]['creator_type'] == "dienstleister_user"){
				$c = $data[$i]['creator_type'];
				$lj = "dienstleister";
				$data[$i]['subuser'] = true;
			}
			
			//echo "SELECT * FROM $c LEFT JOIN $lj ON {$lj}.id = {$c}.{$lj}_id WHERE $c.id = {$data[$i]['creator_id']}";
			
			if ($data[$i]['subuser']){
				$sth = $db->prepare("SELECT * FROM $c LEFT JOIN $lj ON {$lj}.id = {$c}.{$lj}_id WHERE $c.id = {$data[$i]['creator_id']}");
			}else{
				$sth = $db->prepare("SELECT * FROM $c WHERE $c.id = {$data[$i]['creator_id']}");
			}
			
			
			$sth->execute();
        	$data[$i]['creator'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
		}
		
?>
        <div class="wrap">
           
            <h1>Joborders</h1>
        
            <table class="widefat backend-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jobtitel</th>
                        <th colspan="2">Erstellt von</th>
                        <th>Arbeitszeitraum</th>
                        <th>Bewerbungszeitraum</th>
                        <th>Tage</th>
                        <th>Kosten</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($data as $row){
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['jobtitel']; ?></td>
                            <td><?php echo $row['creator_type']; ?> [ID: <?php echo $row['creator_id']; ?>]</td>
                            <td><?php echo $row['creator']['firmenwortlaut']; echo ($row['subuser']) ? " (User: {$row['creator']['vorname']} {$row['creator']['nachname']})" : ""; ?></td>
                            <td><?php echo $row['arbeitsbeginn']; ?> - <?php echo $row['arbeitsende']; ?></td>
                            <td><?php echo $row['bewerbungen_von']; ?> - <?php echo $row['bewerbungen_bis']; ?></td>
                            <td><?php echo $row['tage']; ?></td>
                            <td><?php echo "€ " . number_format($row['kosten'], 2, ",", ""); ?></td>
                            <td>
                            	<button class="button" onclick="openJobDetails(<?php echo $row['id']; ?>);">Details</button>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    	
    	<div class="remodal remodal-job-details">
    		<div class="spinner-wrapper">
    			<style type='text/css'>@-webkit-keyframes uil-default-anim { 0% { opacity: 1} 100% {opacity: 0} }@keyframes uil-default-anim { 0% { opacity: 1} 100% {opacity: 0} }.uil-default-css > div:nth-of-type(1){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.5s;animation-delay: -0.5s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(2){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.4166666666666667s;animation-delay: -0.4166666666666667s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(3){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.33333333333333337s;animation-delay: -0.33333333333333337s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(4){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.25s;animation-delay: -0.25s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(5){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.16666666666666669s;animation-delay: -0.16666666666666669s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(6){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.08333333333333331s;animation-delay: -0.08333333333333331s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(7){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0s;animation-delay: 0s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(8){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.08333333333333337s;animation-delay: 0.08333333333333337s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(9){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.16666666666666663s;animation-delay: 0.16666666666666663s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(10){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.25s;animation-delay: 0.25s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(11){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.33333333333333337s;animation-delay: 0.33333333333333337s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}.uil-default-css > div:nth-of-type(12){-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.41666666666666663s;animation-delay: 0.41666666666666663s;}.uil-default-css { position: relative;background:none;width:200px;height:200px;}</style><div class='uil-default-css' style='transform:scale(0.6);'><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(0deg) translate(0,-60px);transform:rotate(0deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(30deg) translate(0,-60px);transform:rotate(30deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(60deg) translate(0,-60px);transform:rotate(60deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(90deg) translate(0,-60px);transform:rotate(90deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(120deg) translate(0,-60px);transform:rotate(120deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(150deg) translate(0,-60px);transform:rotate(150deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(180deg) translate(0,-60px);transform:rotate(180deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(210deg) translate(0,-60px);transform:rotate(210deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(240deg) translate(0,-60px);transform:rotate(240deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(270deg) translate(0,-60px);transform:rotate(270deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(300deg) translate(0,-60px);transform:rotate(300deg) translate(0,-60px);border-radius:10px;position:absolute;'></div><div style='top:80px;left:93px;width:14px;height:40px;background:#00b2ff;-webkit-transform:rotate(330deg) translate(0,-60px);transform:rotate(330deg) translate(0,-60px);border-radius:10px;position:absolute;'></div></div>
    		</div>
    		<div class="content">
    			
    			<h1 class="content__jobtitel"></h1>
    			
    			<h2>Grundinformationen</h2>
    			<table class="widefat">
    				<tbody>
    					<tr>
    						<th>Arbeitsbeginn</th>
    						<td class="content__arbeitsbeginn"></td>
    					</tr>
    					<tr>
    						<th>Arbeitsende</th>
    						<td class="content__arbeitsende"></td>
    					</tr>
    					<tr>
    						<th>Arbeitszeitmodell</th>
    						<td class="content__arbeitszeitmodell"></td>
    					</tr>
    					<tr>
    						<th>Kollektivvertrag</th>
    						<td class="content__kollektivvertrag"></td>
    					</tr>
    					<tr>
    						<th>Beschäftigungsausmaß</th>
    						<td class="content__beschaeftigungsausmasse_name"></td>
    					</tr>
    					<tr>
    						<th>Beschäftigungsart</th>
    						<td class="content__beschaeftigungsarten_name"></td>
    					</tr>
    					<tr>
    						<th>Brutto Bezug</th>
    						<td class="content__brutto_bezug"></td>
    					</tr>
    					<tr>
    						<th>Brutto Bezug / Einheit</th>
    						<td class="content__brutto_bezug_einheit"></td>
    					</tr>
    					<tr>
    						<th>Brutto Bezug / Überzahlung</th>
    						<td class="content__brutto_bezug_ueberzahlung"></td>
    					</tr>
    					<tr>
    						<th>Tätigkeitsbeschreibung</th>
    						<td class="content__taetigkeitsbeschreibung"></td>
    					</tr>
    					<tr>
    						<th>Bewerbungen von</th>
    						<td class="content__bewerbungen_von"></td>
    					</tr>
    					<tr>
    						<th>Bewerbungen bis</th>
    						<td class="content__bewerbungen_bis"></td>
    					</tr>
    				</tbody>
    			</table>
    			
    			<h2>Arbeitsort</h2>
    			<table class="widefat">
    				<tbody>
    					<tr>
    						<th>Bezirk</th>
    						<td class="content__bezirk"></td>
    					</tr>
    					<tr>
    						<th>Adresse</th>
    						<td class="content__adresse"></td>
    					</tr>
    					<tr>
    						<th>PLZ und Ort</th>
    						<td class="content__plz_ort"></td>
    					</tr>
    				</tbody>
    			</table>
    			
    			<h2>Basic Skills</h2>
    			<table class="widefat">
    				<tbody>
    					<tr>
    						<th>Führerschein</th>
    						<td class="content__skill_fuehrerschein"></td>
    					</tr>
    					<tr>
    						<th>Eigener PKW</th>
    						<td class="content__skill_pkw"></td>
    					</tr>
    					<tr>
    						<th>Berufsabschluss</th>
    						<td class="content__skill_berufsabschluss"></td>
    					</tr>
    				</tbody>
    			</table>
    			
    			<h2>Berufsfelder</h2>
    			<table class="widefat">
    				<tbody class="content__berufsfelder">
    				</tbody>
    			</table>
    			
    			<h2>Berufsgruppen</h2>
    			<table class="widefat">
    				<tbody class="content__berufsgruppen">
    				</tbody>
    			</table>
    			
    			<h2>Skills</h2>
    			<table class="widefat">
    				<tbody class="content__skills">
    				</tbody>
    			</table>
    			
    			<h2>Kosten</h2>
    			<table class="widefat">
    				<tbody>
    					<tr>
    						<th>Verrechnungs Kategorie</th>
    						<td class="content__verrechnungs_kategorien_name"></td>
    					</tr>
    					<tr>
    						<th>Tage</th>
    						<td class="content__tage"></td>
    					</tr>
    					<tr>
    						<th>Kosten</th>
    						<td class="content__kosten"></td>
    					</tr>
    				</tbody>
    			</table>
    			
    			<h2>Bewerbungen</h2>
    			<table class="widefat">
    				<tbody>
    					<tr>
    						<th>Anzahl Bewerbungen gesamt</th>
    						<td class="content__anzahl_bewerbungen_gesamt"></td>
    					</tr>
    					<tr>
    						<th>Anzahl Bewerbungen vergeben</th>
    						<td class="content__anzahl_bewerbungen_vergeben"></td>
    					</tr>
    					<tr>
    						<th>Anzahl Bewerbungen Einsatz bestätigt</th>
    						<td class="content__anzahl_bewerbungen_einsatz_bestaetigt"></td>
    					</tr>
    				</tbody>
    			</table>
    			
    		</div>
    	</div>
    	
    	<script>

			function openJobDetails(id){
					
				// Setup Spinner
				jQuery('.remodal-job-details .content').hide();
				jQuery('.remodal-job-details .spinner-wrapper').show();
					
				// Open Modal
				jQuery('.remodal-job-details').remodal().open();
				
				jQuery.ajax('/api/v1/joborders/'+id, {method: 'GET'}).done(function(response){
					
					var joborder = JSON.parse(response);
					
					jQuery('.remodal-job-details .content__jobtitel').html(joborder.jobtitel);
					//jQuery('.remodal-job-details .content__x').html(response);
					jQuery('.remodal-job-details .content__arbeitsbeginn').html(joborder.arbeitsbeginn);
					jQuery('.remodal-job-details .content__arbeitsende').html(joborder.arbeitsende);
					jQuery('.remodal-job-details .content__arbeitszeitmodell').html(joborder.arbeitszeitmodell);
					jQuery('.remodal-job-details .content__kollektivvertrag').html(joborder.kollektivvertrag);
					jQuery('.remodal-job-details .content__beschaeftigungsausmasse_name').html(joborder.beschaeftigungsausmasse_name);
					jQuery('.remodal-job-details .content__beschaeftigungsarten_name').html(joborder.beschaeftigungsarten_name);
					jQuery('.remodal-job-details .content__brutto_bezug').html(joborder.brutto_bezug);
					jQuery('.remodal-job-details .content__brutto_bezug_einheit').html(joborder.brutto_bezug_einheit);
					jQuery('.remodal-job-details .content__brutto_bezug_ueberzahlung').html((joborder.brutto_bezug_ueberzahlung == 1) ? 'Ja' : 'Nein');
					jQuery('.remodal-job-details .content__taetigkeitsbeschreibung').html(joborder.taetigkeitsbeschreibung);
					jQuery('.remodal-job-details .content__bewerbungen_von').html(joborder.bewerbungen_von);
					jQuery('.remodal-job-details .content__bewerbungen_bis').html(joborder.bewerbungen_bis);
					
					jQuery('.remodal-job-details .content__bezirk').html(joborder.bezirke_name);
					jQuery('.remodal-job-details .content__adresse').html(joborder.adresse_strasse_hn);
					jQuery('.remodal-job-details .content__plz_ort').html(joborder.adresse_plz + ' ' + joborder.adresse_ort);
					
					jQuery('.remodal-job-details .content__skill_fuehrerschein').html((joborder.skill_fuehrerschein == 1) ? 'Ja' : 'Nein');
					jQuery('.remodal-job-details .content__skill_pkw').html((joborder.skill_pkw == 1) ? 'Ja' : 'Nein');
					jQuery('.remodal-job-details .content__skill_berufsabschluss').html((joborder.skill_berufsabschluss == 1) ? 'Ja' : 'Nein');
					
					jQuery('.remodal-job-details .content__berufsfelder').html('');
					for (var i=0;i<joborder.berufsfelder.length;i++){
						jQuery('.remodal-job-details .content__berufsfelder').append('<tr><td>'+joborder.berufsfelder[i].name+'</td></tr>');
					}
					
					jQuery('.remodal-job-details .content__berufsgruppen').html('');
					for (var i=0;i<joborder.berufsgruppen.length;i++){
						jQuery('.remodal-job-details .content__berufsgruppen').append('<tr><td>'+joborder.berufsgruppen[i].name+'</td></tr>');
					}
					
					jQuery('.remodal-job-details .content__skills').html('');
					for (var i=0;i<joborder.skills.length;i++){
						jQuery('.remodal-job-details .content__skills').append('<tr><td>'+joborder.skills[i].name+'</td></tr>');
					}
					
					jQuery('.remodal-job-details .content__verrechnungs_kategorien_name').html(joborder.verrechnungs_kategorien_name);
					jQuery('.remodal-job-details .content__tage').html(joborder.tage + ' Tage');
					jQuery('.remodal-job-details .content__kosten').html('€ ' + joborder.kosten);
					
					jQuery('.remodal-job-details .content__anzahl_bewerbungen_gesamt').html(joborder.anzahl_bewerbungen_gesamt);
					jQuery('.remodal-job-details .content__anzahl_bewerbungen_vergeben').html(joborder.anzahl_bewerbungen_vergeben);
					jQuery('.remodal-job-details .content__anzahl_bewerbungen_einsatz_bestaetigt').html(joborder.anzahl_bewerbungen_einsatz_bestaetigt);
					
					// Close Spinner - Show content
					jQuery('.remodal-job-details .spinner-wrapper').hide();
					jQuery('.remodal-job-details .content').fadeIn();
				});
				
			}
			
		</script>
    
    <?php
          
    }







	/**************************************************************
	** AUSWERTUNG
	**************************************************************/

    function staqq_admin_auswertung(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT *, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende, DATE_FORMAT(joborders.bewerbungen_von,'%d.%m.%Y') AS bewerbungen_von, DATE_FORMAT(joborders.bewerbungen_bis,'%d.%m.%Y') AS bewerbungen_bis FROM joborders ORDER BY id DESC");
        $sth->execute();
		
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		for ($i=0;$i<count($data);$i++){
			
			if ($data[$i]['creator_type'] == "kunde"){
				$c = "kunden";
				$data[$i]['subuser'] = false;
				
			}elseif ($data[$i]['creator_type'] == "kunde_user"){
				$c = "kunden_user";	
				$data[$i]['subuser'] = true;
			}elseif ($data[$i]['creator_type'] == "dienstleister"){
				$c = $data[$i]['creator_type'];
				$lj = "dienstleister";
				$data[$i]['subuser'] = false;
			}elseif ($data[$i]['creator_type'] == "dienstleister_user"){
				$c = $data[$i]['creator_type'];
				$lj = "dienstleister";
				$data[$i]['subuser'] = true;
			}
			
			if ($data[$i]['subuser']){
				$sth = $db->prepare("SELECT * FROM $c LEFT JOIN $lj ON {$lj}.id = {$c}.{$lj}_id WHERE $c.id = {$data[$i]['creator_id']}");
			}else{
				$sth = $db->prepare("SELECT * FROM $c WHERE $c.id = {$data[$i]['creator_id']}");
			}
			
			$sth->execute();
        	$data[$i]['creator'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			
			$sth = $db->prepare("SELECT COUNT(*) AS anzahl_bewerber FROM bewerbungen WHERE joborders_id={$data[$i]['id']}");
			$sth->execute();
        	$data[$i]['anzahl_bewerber'] = $sth->fetchAll(PDO::FETCH_ASSOC)[0]['anzahl_bewerber'];
			
			$sth = $db->prepare("SELECT dienstleister.*, COUNT(*) AS anzahl_vergeben FROM bewerbungen LEFT JOIN dienstleister ON dienstleister.id = bewerbungen.dienstleister_id WHERE bewerbungen.joborders_id={$data[$i]['id']} AND (bewerbungen.status = 'vergeben' OR bewerbungen.status = 'einsatz_bestaetigt')");
			$sth->execute();
			
			$tmp = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
        	$data[$i]['anzahl_vergeben'] = $tmp['anzahl_vergeben'];
        	$data[$i]['vergeben_dl'] = $tmp['firmenwortlaut'] ? $tmp['firmenwortlaut'] : "-";
		}
		
?>
        <div class="wrap">
           
            <h1>Auswertung</h1>
        
            <table class="widefat backend-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jobtitel</th>
                        <th colspan="2">Erstellt von</th>
                        <th>Arbeitszeitraum</th>
                        <th>Bewerbungszeitraum</th>
                        <th>Anzahl Bewerbungen</th>
                        <th>Anzahl gesuchte Bewerber</th>
                        <th>Anzahl besetzte Bewerber</th>
                        <th>Stelle besetzt durch</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($data as $row){
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['jobtitel']; ?></td>
                            <td><?php echo $row['creator_type']; ?> [ID: <?php echo $row['creator_id']; ?>]</td>
                            <td><?php echo $row['creator']['firmenwortlaut']; echo ($row['subuser']) ? " (User: {$row['creator']['vorname']} {$row['creator']['nachname']})" : ""; ?></td>
                            <td><?php echo $row['arbeitsbeginn']; ?> - <?php echo $row['arbeitsende']; ?></td>
                            <td><?php echo $row['bewerbungen_von']; ?> - <?php echo $row['bewerbungen_bis']; ?></td>
                            <td><?php echo $row['anzahl_bewerber']; ?></td>
                            <td><strong><?php echo $row['anzahl_ressourcen']; ?></strong></td>
                            <td><strong><?php echo $row['anzahl_vergeben']; ?></strong></td>
                            <td><strong><?php echo $row['vergeben_dl']; ?></strong></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    	
    <?php
          
    }






	/**************************************************************
	** USERS
	**************************************************************/

    function staqq_admin_user_options_ressources(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM ressources");
        //$sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>Ressources</h1>
            
            <a href="/wp-admin/admin-post.php?action=staqq_admin_user__export_ressources" class="page-title-action">CSV Export</a>
            
            <?php if (isset($_GET['done'])) echo '<div class="error"><p><strong>Löschen war erfolgreich!</strong></p></div>'; ?>
        
            <table class="widefat backend-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>E-Mail</th>
                        <th>Löschen</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($data as $row){
							
							$sth = $db->prepare("SELECT * FROM relation_ressources_berufsfelder LEFT JOIN berufsfelder ON relation_ressources_berufsfelder.berufsfelder_id = berufsfelder.id WHERE ressources_id=".$row['id']);
							$sth->execute();
							$berufsfelder = $sth->fetchAll(PDO::FETCH_ASSOC);
							
							$sth = $db->prepare("SELECT * FROM relation_ressources_berufsgruppen LEFT JOIN berufsgruppen ON relation_ressources_berufsgruppen.berufsgruppen_id = berufsgruppen.id WHERE ressources_id=".$row['id']);
							$sth->execute();
							$berufsgruppen = $sth->fetchAll(PDO::FETCH_ASSOC);
							
							$sth = $db->prepare("SELECT * FROM relation_ressources_berufsbezeichnungen LEFT JOIN berufsbezeichnungen ON relation_ressources_berufsbezeichnungen.berufsbezeichnungen_id = berufsbezeichnungen.id WHERE ressources_id=".$row['id']);
							$sth->execute();
							$berufsbezeichnungen = $sth->fetchAll(PDO::FETCH_ASSOC);
							
							$sth = $db->prepare("SELECT skills_items.name AS skills_items_name, skills_kategorien.name AS skills_kategorien_name FROM relation_ressources_skills LEFT JOIN skills_items ON relation_ressources_skills.skills_items_id = skills_items.id LEFT JOIN skills_kategorien ON skills_kategorien.id = skills_items.skills_kategorien_id WHERE ressources_id=".$row['id']);
							$sth->execute();
							$skills = $sth->fetchAll(PDO::FETCH_ASSOC);
							
							$sth = $db->prepare("SELECT bezirke.name AS bezirke_name, bundeslaender.name AS bundeslaender_name FROM relation_ressources_bezirke LEFT JOIN bezirke ON relation_ressources_bezirke.bezirke_id = bezirke.id LEFT JOIN bundeslaender ON bezirke.bundeslaender_id = bundeslaender.id WHERE ressources_id=".$row['id']);
							$sth->execute();
							$bezirke = $sth->fetchAll(PDO::FETCH_ASSOC);
							
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['vorname']; ?></td>
                            <td><?php echo $row['nachname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_user__delete_ressource&email=<?php echo $row['email']; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('Sind Sie sicher <?php echo $row['vorname']; ?> <?php echo $row['nachname']; ?> löschen zu wollen?')">Löschen</a></td>
                            <td>
                            	<button class="button" onclick="showDetails(<?php echo $row['id']; ?>)">Details</button>
                            	<div class="remodal remodal-user remodal-user--<?php echo $row['id']; ?>">
                            		
                            		<h1><?php echo $row['vorname']; ?> <?php echo $row['nachname']; ?></h1>
                            		<table class="widefat">
                            			<tbody>
                            				<tr>
                            					<th>E-Mail</th>
                            					<td><?php echo $row['email']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Telefon</th>
                            					<td><?php echo $row['telefon']; ?></td>
                            				</tr>
                            			</tbody>
                            		</table>
                            		
                            		<h3>Basic Skills</h3>
                            		<table class="widefat">
                            			<tbody>
                            				<tr>
                            					<th>Führerschein</th>
                            					<td><?php echo ($row['skill_fuehrerschein'] == 1) ? "Ja" : "Nein"; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Eigener PKW</th>
                            					<td><?php echo ($row['skill_pkw'] == 1) ? "Ja" : "Nein"; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Berufsabschluss</th>
                            					<td><?php echo ($row['skill_berufsabschluss'] == 1) ? "Ja" : "Nein"; ?></td>
                            				</tr>
                            				<tr>
                            					<th>EU Bürger</th>
                            					<td><?php echo ($row['skill_eu_buerger'] == 1) ? "Ja" : "Nein"; ?></td>
                            				</tr>
                            				<tr>
                            					<th>RWR Karte</th>
                            					<td><?php echo ($row['skill_rwr_karte'] == 1) ? "Ja" : "Nein"; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Höchster Schulabschluss</th>
                            					<td><?php echo $row['skill_hoechster_schulabschluss']; ?></td>
                            				</tr>
                            			</tbody>
                            		</table>
                            		
                            		<h3>Berufe</h3>
                            		<table class="widefat">
                            			<tbody>
											<?php
												foreach($berufsfelder as $b){
											?>
                            				<tr>
                            					<th>Berufsfeld</th>
                            					<td><?php echo $b['name']; ?></td>
                            				</tr>
											<?php
												}
											?>
											<?php
												foreach($berufsgruppen as $b){
											?>
                            				<tr>
                            					<th>Berufsgruppe</th>
                            					<td><?php echo $b['name']; ?></td>
                            				</tr>
											<?php
												}
											?>
											<?php
												foreach($berufsbezeichnungen as $b){
											?>
                            				<tr>
                            					<th>Berufsbezeichnung</th>
                            					<td><?php echo $b['name']; ?></td>
                            				</tr>
											<?php
												}
											?>
                            			</tbody>
                            		</table>
                            		
                            		<h3>Skills</h3>
                            		<table class="widefat">
                            			<tbody>
											<?php
												foreach($skills as $s){
											?>
                            				<tr>
                            					<th><?php echo $s['skills_kategorien_name']; ?></th>
                            					<td><?php echo $s['skills_items_name']; ?></td>
                            				</tr>
											<?php
												}
											?>
                            			</tbody>
                            		</table>
                            		
                            		<h3>Regionen</h3>
                            		<table class="widefat">
                            			<tbody>
											<?php
												foreach($bezirke as $r){
											?>
                            				<tr>
                            					<td><?php echo $r['bundeslaender_name']; ?></td>
                            					<td><?php echo $r['bezirke_name']; ?></td>
                            				</tr>
											<?php
												}
											?>
                            			</tbody>
                            		</table>
                            		
                            	</div>
                            </td>
                            
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    	<script>
			
			function showDetails(id){
				jQuery('.remodal-user--'+id).remodal().open();
			}
			
		</script>
    <?php
          
    }

    function staqq_admin_user_options_dienstleister(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM dienstleister");
        //$sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="wrap">
           
            <h1>Dienstleister</h1>
            
			<?php if (isset($_GET['done'])) echo '<div class="error"><p><strong>Löschen war erfolgreich!</strong></p></div>'; ?>
			<table class="widefat backend-datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Firmenwortlaut</th>
						<th>Vorname</th>
						<th>Nachname</th>
						<th>E-Mail</th>
						<th>S</th>
						<th>J</th>
						<th>U</th>
						<th>Settings</th>
						<th>Löschen</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($data as $row){
							
							$sth = $db->prepare("SELECT * FROM relation_dienstleister_berufsfelder LEFT JOIN berufsfelder ON relation_dienstleister_berufsfelder.berufsfelder_id = berufsfelder.id WHERE dienstleister_id=".$row['id']);
							$sth->execute();
							$berufsfelder = $sth->fetchAll(PDO::FETCH_ASSOC);
					?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['firmenwortlaut']; ?></td>
							<td><?php echo $row['ansprechpartner_vorname']; ?></td>
							<td><?php echo $row['ansprechpartner_nachname']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo ($row['sammelrechnungen'] == "1") ? "Ja" : "Nein"; ?></td>
							<td><?php echo $row['anzahl_joborders']; ?></td>
							<td><?php echo $row['anzahl_user']; ?></td>
							<td><button class="button" onclick="openDienstleisterUpdate('<?php echo $row['id']; ?>', '<?php echo $row['sammelrechnungen']; ?>', <?php echo $row['anzahl_joborders']; ?>, <?php echo $row['anzahl_user']; ?>);">Bearbeiten</button></td>
							<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_user__delete_dienstleister&email=<?php echo $row['email']; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('Sind Sie sicher <?php echo $row['firmenwortlaut']; ?> - <?php echo $row['ansprechpartner_vorname']; ?> <?php echo $row['ansprechpartner_nachname']; ?> löschen zu wollen?')">Löschen</a></td>
							<td>
                            	<button class="button" onclick="showDetails(<?php echo $row['id']; ?>)">Details</button>
                            	<div class="remodal remodal-user remodal-user--<?php echo $row['id']; ?>">
                            		
                            		<h1><?php echo $row['firmenwortlaut']; ?></h1>
                            		<table class="widefat">
                            			<tbody>
                            				<tr>
                            					<th>Ansprechpartner Vorname</th>
                            					<td><?php echo $row['ansprechpartner_vorname']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Ansprechpartner Nachnae</th>
                            					<td><?php echo $row['ansprechpartner_nachname']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>E-Mail</th>
                            					<td><?php echo $row['email']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Telefon</th>
                            					<td><?php echo $row['ansprechpartner_telefon']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Position</th>
                            					<td><?php echo $row['ansprechpartner_position']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>UID</th>
                            					<td><?php echo $row['uid']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>FN</th>
                            					<td><?php echo $row['fn']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Adresse</th>
                            					<td><?php echo $row['firmensitz_adresse']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>PLZ und Ort</th>
                            					<td><?php echo $row['firmensitz_plz']; ?> <?php echo $row['firmensitz_ort']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Website</th>
                            					<td><?php echo $row['website']; ?></td>
                            				</tr>
                            			</tbody>
                            		</table>
                            		
                            		<h3>Berufe</h3>
                            		<table class="widefat">
                            			<tbody>
											<?php
												foreach($berufsfelder as $b){
											?>
                            				<tr>
                            					<th>Berufsfeld</th>
                            					<td><?php echo $b['name']; ?></td>
                            				</tr>
											<?php
												}
											?>
                            			</tbody>
                            		</table>
                            		
                            	</div>
                            </td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
        </div>
        
        <div class="remodal remodal--dienstleister">
        	
            <form action="/wp-admin/admin-post.php">

        		<input type="hidden" name="action" value="staqq_admin_user__update_dienstleister">
           		
           		<input type="hidden" name="id" id="id">
           		
           		<label for="anzahl_joborders">Sammelrechnung</label>
				<select name="sammelrechnungen" id="sammelrechnungen">
					<option value="0">Nein</option>
					<option value="1">Ja</option>
				</select>
          		
          		<br>
          		<label for="anzahl_joborders">Joborders</label>
          		<input type="number" name="anzahl_joborders" id="anzahl_joborders" value="">
          		
          		<br>
          		<label for="anzahl_joborders">User</label>
          		<input type="number" name="anzahl_user" id="anzahl_user" value="">
          		
           		<br>
            	<button type="submit" class="button button-primary">Speichern</button>
			</form>
        </div>
        
        <script>
			var dlmodal;
			
			jQuery(document).ready(function(){
				dlmodal = jQuery('.remodal--dienstleister').remodal();
			});
			
			function openDienstleisterUpdate(id, sammelrechnungen, anzahl_joborders, anzahl_user){
				jQuery('.remodal--dienstleister #id').val(id);
				jQuery('.remodal--dienstleister #sammelrechnungen').val(sammelrechnungen);
				jQuery('.remodal--dienstleister #anzahl_joborders').val(anzahl_joborders);
				jQuery('.remodal--dienstleister #anzahl_user').val(anzahl_user);
				dlmodal.open();
			}
			
			function showDetails(id){
				jQuery('.remodal-user--'+id).remodal().open();
			}
			
		</script>
    
 <?php
          
    }

    function staqq_admin_user_options_dienstleister_user(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT dienstleister_user.*, dienstleister.firmenwortlaut FROM dienstleister_user LEFT JOIN dienstleister ON dienstleister.id = dienstleister_user.dienstleister_id");
        //$sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="wrap">
           
            <h1>Dienstleister User</h1>
            
			<table class="widefat backend-datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Dienstleister</th>
						<th>Vorname</th>
						<th>Nachname</th>
						<th>E-Mail</th>
						<th>Telefon</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($data as $row){
					?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['firmenwortlaut']; ?></td>
							<td><?php echo $row['vorname']; ?></td>
							<td><?php echo $row['nachname']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefon']; ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
        </div>
    
 <?php
          
    }

    function staqq_admin_user_options_kunden(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM kunden");
        //$sth->bindParam(':id', $joborders_id, PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="wrap">
           
            <h1>Kunden</h1>
            
            <?php if (isset($_GET['done'])) echo '<div class="error"><p><strong>Löschen war erfolgreich!</strong></p></div>'; ?>
        
            <table class="widefat backend-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Firmenwortlaut</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>E-Mail</th>
						<th>J</th>
						<th>U</th>
						<th>Settings</th>
                        <th>Löschen</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($data as $row){
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['firmenwortlaut']; ?></td>
                            <td><?php echo $row['ansprechpartner_vorname']; ?></td>
                            <td><?php echo $row['ansprechpartner_nachname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
							<td><?php echo $row['anzahl_joborders']; ?></td>
							<td><?php echo $row['anzahl_user']; ?></td>
							<td><button class="button" onclick="openKundeUpdate('<?php echo $row['id']; ?>', <?php echo $row['anzahl_joborders']; ?>, <?php echo $row['anzahl_user']; ?>);">Bearbeiten</button></td>
                            <td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_user__delete_kunde&email=<?php echo $row['email']; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('Sind Sie sicher <?php echo $row['firmenwortlaut']; ?> - <?php echo $row['ansprechpartner_vorname']; ?> <?php echo $row['ansprechpartner_nachname']; ?> löschen zu wollen?')">Löschen</a></td>
                            <td>
                            	<button class="button" onclick="showDetails(<?php echo $row['id']; ?>)">Details</button>
                            	<div class="remodal remodal-user remodal-user--<?php echo $row['id']; ?>">
                            		
                            		<h1><?php echo $row['firmenwortlaut']; ?></h1>
                            		<table class="widefat">
                            			<tbody>
                            				<tr>
                            					<th>Ansprechpartner Vorname</th>
                            					<td><?php echo $row['ansprechpartner_vorname']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Ansprechpartner Nachnae</th>
                            					<td><?php echo $row['ansprechpartner_nachname']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>E-Mail</th>
                            					<td><?php echo $row['email']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Telefon</th>
                            					<td><?php echo $row['ansprechpartner_telefon']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Position</th>
                            					<td><?php echo $row['ansprechpartner_position']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>UID</th>
                            					<td><?php echo $row['uid']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>FN</th>
                            					<td><?php echo $row['fn']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Adresse</th>
                            					<td><?php echo $row['firmensitz_adresse']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>PLZ und Ort</th>
                            					<td><?php echo $row['firmensitz_plz']; ?> <?php echo $row['firmensitz_ort']; ?></td>
                            				</tr>
                            				<tr>
                            					<th>Website</th>
                            					<td><?php echo $row['website']; ?></td>
                            				</tr>
                            			</tbody>
                            		</table>
                            		
                            	</div>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="remodal remodal--kunde">
        	
            <form action="/wp-admin/admin-post.php">

        		<input type="hidden" name="action" value="staqq_admin_user__update_kunde">
           		
           		<input type="hidden" name="id" id="id">
          		
          		<br>
          		<label for="anzahl_joborders">Joborders</label>
          		<input type="number" name="anzahl_joborders" id="anzahl_joborders" value="">
          		
          		<br>
          		<label for="anzahl_joborders">User</label>
          		<input type="number" name="anzahl_user" id="anzahl_user" value="">
          		
           		<br>
            	<button type="submit" class="button button-primary">Speichern</button>
			</form>
        </div>
        
        <script>
			var dlmodal;
			
			jQuery(document).ready(function(){
				dlmodal = jQuery('.remodal--kunde').remodal();
			});
			
			function openKundeUpdate(id, anzahl_joborders, anzahl_user){
				jQuery('.remodal--kunde #id').val(id);
				jQuery('.remodal--kunde #anzahl_joborders').val(anzahl_joborders);
				jQuery('.remodal--kunde #anzahl_user').val(anzahl_user);
				dlmodal.open();
			}
			
			function showDetails(id){
				jQuery('.remodal-user--'+id).remodal().open();
			}
		</script>
    
 <?php
          
    }

    function staqq_admin_user_options_kunden_user(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT kunden_user.*, kunden.firmenwortlaut FROM kunden_user LEFT JOIN kunden ON kunden.id = kunden_user.kunden_id");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="wrap">
           
            <h1>Kunden User</h1>
            
			<table class="widefat backend-datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Kunde</th>
						<th>Vorname</th>
						<th>Nachname</th>
						<th>E-Mail</th>
						<th>Telefon</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($data as $row){
					?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['firmenwortlaut']; ?></td>
							<td><?php echo $row['vorname']; ?></td>
							<td><?php echo $row['nachname']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefon']; ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
        </div>
    
 <?php
          
    }

	function action__staqq_admin_user__delete_ressource(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		$id = $_GET['id'];
		$res = $api->delete("ressources/$id", [
			'email' => $_GET['email']
		])->decode_response();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_user&done=true');
		
	}

	function action__staqq_admin_user__export_ressources(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=staqq_export.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
        
        $res = $api->get("ressources", [])->decode_response();
		$ressourcen = array();
		
		foreach($res as $r){
			
			$ressource = $api->get("ressources/{$r->id}", [])->decode_response();
			
			$tmp = $ressource->berufsfelder;
			$ressource->berufsfelder = array();
			foreach($tmp as $b){array_push($ressource->berufsfelder, utf8_decode($b->name));}
			
			$tmp = $ressource->berufsgruppen;
			$ressource->berufsgruppen = array();
			foreach($tmp as $b){array_push($ressource->berufsgruppen, utf8_decode($b->name));}
			
			$tmp = $ressource->berufsbezeichnungen;
			$ressource->berufsbezeichnungen = array();
			foreach($tmp as $b){array_push($ressource->berufsbezeichnungen, utf8_decode($b->name));}
			
			$tmp = $ressource->skills;
			$ressource->skills = array();
			foreach($tmp as $b){array_push($ressource->skills, utf8_decode($b->name));}

			$tmp = $ressource->bezirke;
			$ressource->einsatzorte_namen = array();
			foreach($tmp as $b){array_push($ressource->einsatzorte_namen, utf8_decode($b->name . " ({$b->bundeslaender_name})"));}
			
			array_push($ressourcen, $ressource);
			
		}
		
        $outputBuffer = fopen("php://output", 'w');
		$delimiter = ";";
		
		fputcsv($outputBuffer, array(
			'ressources_id', 
			'vorname', 
			'nachname', 
			'telefon', 
			'email',
			'adresse_strasse_hn',
			'adresse_plz',
			'adresse_ort',
			'skill_fuehrerschein',
			'skill_pkw',
			'skill_berufsabschluss',
			'skill_hoechster_schulabschluss',
			'berufsfelder',
			'berufsgruppen',
			'berufsbezeichnungen',
			'skills',
			'einsatzorte_namen'
		), $delimiter);
		
		foreach($ressourcen as $r){
			fputcsv($outputBuffer, array(
				$r->id, 
				$r->vorname, 
				$r->nachname, 
				$r->telefon, 
				$r->email,
				$r->adresse_strasse_hn,
				$r->adresse_plz,
				$r->adresse_ort,
				$r->skill_fuehrerschein,
				$r->skill_pkw,
				$r->skill_berufsabschluss,
				$r->skill_hoechster_schulabschluss,
				implode(", ", $r->berufsfelder),
				implode(", ", $r->berufsgruppen),
				implode(", ", $r->berufsbezeichnungen),
				implode(", ", $r->skills),
				implode(", ", $r->einsatzorte_namen)
			), $delimiter);
		}
        fclose($outputBuffer);
		
		exit;
		
	}

	function action__staqq_admin_user__update_dienstleister(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		$id = $_GET['id'];
		$sammelrechnungen = $_GET['sammelrechnungen'];
		$anzahl_joborders = $_GET['anzahl_joborders'];
		$anzahl_user = $_GET['anzahl_user'];
			
		$response = $api->put("dienstleister/$id/backendSettings", [
			'sammelrechnungen' => $sammelrechnungen,
			'anzahl_joborders' => $anzahl_joborders,
			'anzahl_user' => $anzahl_user
		])->decode_response();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_user_dienstleister');
		
	}

	function action__staqq_admin_user__delete_dienstleister(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		$id = $_GET['id'];
		$res = $api->delete("dienstleister/$id", [
			'email' => $_GET['email']
		])->decode_response();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_user_dienstleister&done=true');
		
	}

	function action__staqq_admin_user__update_kunde(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		$id = $_GET['id'];
		$anzahl_joborders = $_GET['anzahl_joborders'];
		$anzahl_user = $_GET['anzahl_user'];
			
		$response = $api->put("kunden/$id/backendSettings", [
			'anzahl_joborders' => $anzahl_joborders,
			'anzahl_user' => $anzahl_user
		])->decode_response();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_user_kunden');
		
	}

	function action__staqq_admin_user__delete_kunde(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';
		
		$id = $_GET['id'];
		$res = $api->delete("kunden/$id", [
			'email' => $_GET['email']
		])->decode_response();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_user_kunden&done=true');
		
	}




	/**************************************************************
	** Reset
	**************************************************************/

	function staqq_admin_dev(){

?>
		<div class="wrap">
           
            <h1>Entwicklungs Tools</h1>
            
            <?php if (isset($_GET['done'])) echo '<div class="error"><p><strong>Reset war erfolgreich!</strong></p></div>'; ?>
            
            <form action="/wp-admin/admin-post.php" method="get">
        		<input type="hidden" name="action" value="staqq_admin_dev__reset_data">
				<button class="button" type="submit">Komplette Datenbank leeren</button>
			</form>
           
            <br><br>
            
            <form action="/wp-admin/admin-post.php" method="get">
        		<input type="hidden" name="action" value="staqq_admin_dev__reset_skills">
				<button class="button" type="submit">Skills reset</button>
			</form>
			
		</div>
<?php
							   
	}

	function action__staqq_admin_dev__reset_data(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';

        require_once get_home_path().'/api/config.php';
		// Name of the file
		$filename = (__DIR__).'/staqq_reset.sql';
		$mysql_host = API_DB_HOST;
		// MySQL username
		$mysql_username = API_DB_USER;
		// MySQL password
		$mysql_password = API_DB_PASS;
		// Database name
		$mysql_database = API_DB_NAME;

		
		
		// Connect to MySQL server
		mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
		// Select database
		mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		// Loop through each line
		foreach ($lines as $line)
		{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			// Reset temp variable to empty
			$templine = '';
		}
		}
		
		
		$users = get_users(
			array(
				'role__in' => array(
					'ressource',
					'kunde',
					'dienstleister',
					'kunde_u',
					'dienstleister_u'
				)
			)
		);
		
		foreach ($users as $user){
			wp_delete_user($user->data->ID);
		}
		
		
		// Jakob´s User
		
		$res = $api->post("ressources", [
			'registrations_id' => 0,
			'vorname' => "Jakob",
			'nachname' => "Vesely",
			'passwort' => "qivnrjzh",
			'email' => "ressource@appartig.at",
			'old_email' => null,
			'telefon' => "0043 660 5114062",
			'skill_fuehrerschein' => 1,
			'skill_berufsabschluss' => 1,
			'skill_pkw' => 1,
			'skill_eu_buerger' => 1,
			'skill_rwr_karte' => 1,
			'skill_hoechster_schulabschluss' => "Jakob",

			'berufsfelder' => json_encode(array(1,2)),
			'berufsgruppen' => json_encode(array(1,2)),
			'berufsbezeichnungen' => json_encode(array(1,2)),

			'skills' => json_encode(array(1,2)),
			'regionen' => json_encode(array(1,2)),

			'dl_gecastet' => "[]",
			'dl_blacklist' => "[]",
			'agb_accept' => 1
		])->decode_response();
				
		$res = $api->post("ressources", [
			'registrations_id' => 0,
			'vorname' => "Jakob",
			'nachname' => "Vesely Jr.",
			'passwort' => "qivnrjzh",
			'email' => "ressource2@appartig.at",
			'old_email' => null,
			'telefon' => "0043 660 5114062",
			'skill_fuehrerschein' => 1,
			'skill_berufsabschluss' => 1,
			'skill_pkw' => 1,
			'skill_eu_buerger' => 1,
			'skill_rwr_karte' => 1,
			'skill_hoechster_schulabschluss' => "Jakob",

			'berufsfelder' => json_encode(array(1,2)),
			'berufsgruppen' => json_encode(array(1,2)),
			'berufsbezeichnungen' => json_encode(array(1,2)),

			'skills' => json_encode(array(1,2)),
			'regionen' => json_encode(array(1,2)),

			'dl_gecastet' => "[]",
			'dl_blacklist' => "[]",
			'agb_accept' => 1
		])->decode_response();
		
		$res = $api->post("dienstleister", [
			'registrations_id' => 0,
			'firmenwortlaut' => "AppArtig e.U. (DL)",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.appartig.at",
			'firmensitz_adresse' => "Wiener Straße 9, Top 2",
			'firmensitz_plz' => "3133",
			'firmensitz_ort' => "Traismauer",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => "Ing.",
			'ansprechpartner_vorname' => "Jakob",
			'ansprechpartner_nachname' => "Vesely",
			'passwort' => "qivnrjzh",
			'email' => "dienstleister@appartig.at",
			'telefon' => "0043 660 5114062",

			'berufsfelder' => json_encode(array(1,2)),
			'filialen' => json_encode(array('F1', 'F2')),
			
			'anzahl_user' => 1,
			'anzahl_joborders' => 5,
			'agb_accept' => 1
		])->decode_response();
		
		$res = $api->post("dienstleister", [
			'registrations_id' => 0,
			'firmenwortlaut' => "AppArtig e.U. (DL) der II",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.appartig.at",
			'firmensitz_adresse' => "Wiener Straße 9, Top 2",
			'firmensitz_plz' => "3133",
			'firmensitz_ort' => "Traismauer",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => "Ing.",
			'ansprechpartner_vorname' => "Jakob",
			'ansprechpartner_nachname' => "Vesely",
			'passwort' => "qivnrjzh",
			'email' => "dienstleister2@appartig.at",
			'telefon' => "0043 660 5114062",

			'berufsfelder' => json_encode(array(1,2)),
			'filialen' => json_encode(array('F1', 'F2')),
			
			'anzahl_user' => 1,
			'anzahl_joborders' => 5,
			'agb_accept' => 1
		])->decode_response();

		$res = $api->post("kunden", [
			'registrations_id' => 0,
			'firmenwortlaut' => "AppArtig e.U. (KU)",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.appartig.at",
			'firmensitz_adresse' => "Wiener Straße 9, Top 2",
			'firmensitz_plz' => "3133",
			'firmensitz_ort' => "Traismauer",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => "Ing.",
			'ansprechpartner_vorname' => "Jakob",
			'ansprechpartner_nachname' => "Vesely",
			'passwort' => "qivnrjzh",
			'email' => "kunde@appartig.at",
			'telefon' => "0043 660 5114062",

			'berufsfelder' => json_encode(array(1,2)),
			'arbeitsstaetten' => json_encode(array('A1', 'A2')),
			
			'anzahl_user' => 1,
			'anzahl_joborders' => 5,
			'agb_accept' => 1
		])->decode_response();
		
		$res = $api->post("dienstleister/1/user", [
			'anrede' => "Herr",
			'titel' => "Ing.",
			'vorname' => "Jakob",
			'nachname' => "Vesely",
			'position' => "Abteilungsleiter",
			'telefon' => "0043 660 5114062",
			'email' => "dluser@appartig.at",
			'passwort' => "qivnrjzh",
			'aktiv_von' => date('Y-m-d', time()),
			'aktiv_bis' => date('Y-m-d', time()),
			'debug' => 0,
			'berechtigung_joborders_schalten' => 1,
			'berechtigung_einkauf' => 1,
			'berechtigung_auswertung' => 1,
			'einschraenkung_aktiv_von_bis' => 0,
			'einschraenkung_filialen' => 0,
			'einschraenkung_berufsfelder' => 0,
			'einschraenkung_suchgruppen' => 0,
			'berufsfelder' => "[]",
			'suchgruppen' => "[]",
			'filialen' => "[]"
		])->decode_response();
		
		$res = $api->post("kunden/1/user", [
			'anrede' => "Herr",
			'titel' => "Ing.",
			'vorname' => "Jakob",
			'nachname' => "Vesely",
			'position' => "Abteilungsleiter",
			'telefon' => "0043 660 5114062",
			'email' => "kduser@appartig.at",
			'passwort' => "qivnrjzh",
			'aktiv_von' => date('Y-m-d', time()),
			'aktiv_bis' => date('Y-m-d', time()),
			'debug' => 0,
			'berechtigung_joborders_schalten' => 1,
			'berechtigung_einkauf' => 1,
			'berechtigung_auswertung' => 1,
			'einschraenkung_aktiv_von_bis' => 0,
			'einschraenkung_filialen' => 0,
			'einschraenkung_berufsfelder' => 0,
			'einschraenkung_suchgruppen' => 0,
			'berufsfelder' => "[]",
			'suchgruppen' => "[]",
			'filialen' => "[]"
		])->decode_response();
		
		
		// Manfred´s User
		
		// Dienstleister 1
		$res = $api->post("dienstleister", [
			'registrations_id' => 0,
			'firmenwortlaut' => "DL M.Muster",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Am Graben 1",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => "Ing.",
			'ansprechpartner_vorname' => "Manfred",
			'ansprechpartner_nachname' => "Muster",
			'passwort' => "M.muster1234",
			'email' => "m@muster.at",
			'telefon' => "0043 6645345719",

			'berufsfelder' => json_encode(array(1,2)),
			'filialen' => json_encode(array('F1', 'F2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();

  
		// Dienstleister 2
		$res = $api->post("dienstleister", [
			'registrations_id' => 0,
			'firmenwortlaut' => "DL E.Muster",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Am Hof 1",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Frau",
			'ansprechpartner_titel' => " ",
			'ansprechpartner_vorname' => "Elke",
			'ansprechpartner_nachname' => "Muster",
			'passwort' => "E.muster1234",
			'email' => "e@muster.at",
			'telefon' => "0043 6645345719",

			'berufsfelder' => json_encode(array(1,2)),
			'filialen' => json_encode(array('F1', 'F2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();

		// Dienstleister 3
		$res = $api->post("dienstleister", [
			'registrations_id' => 0,
			'firmenwortlaut' => "DL W.Muster",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745777",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Mahlerstraße 1",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => " ",
			'ansprechpartner_vorname' => "Walter",
			'ansprechpartner_nachname' => "Muster",
			'passwort' => "W.muster1234",
			'email' => "w@muster.at",
			'telefon' => "0043 6645345719",

			'berufsfelder' => json_encode(array(1,2)),
			'filialen' => json_encode(array('F1', 'F2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();

		//Kunde 1
		$res = $api->post("kunden", [
			'registrations_id' => 0,
			'firmenwortlaut' => "KD M.core",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Schottengasse 2",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => " ",
			'ansprechpartner_vorname' => "Manfred",
			'ansprechpartner_nachname' => "Core",
			'passwort' => "M.core1234",
			'email' => "m@core.at",
			'telefon' => "0043 664 5345719",

			'berufsfelder' => json_encode(array(1,2)),
			'arbeitsstaetten' => json_encode(array('A1', 'A2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();
 
		// Kunde 2
		$res = $api->post("kunden", [
			'registrations_id' => 0,
			'firmenwortlaut' => "KD E.core",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Schottenring 12",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Frau",
			'ansprechpartner_titel' => " ",
			'ansprechpartner_vorname' => "ELke",
			'ansprechpartner_nachname' => "Core",
			'passwort' => "E.core1234",
			'email' => "e@core.at",
			'telefon' => "0043 664 5345719",

			'berufsfelder' => json_encode(array(1,2)),
			'arbeitsstaetten' => json_encode(array('A1', 'A2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();
 

		// Kunde 3
		$res = $api->post("kunden", [
			'registrations_id' => 0,
			'firmenwortlaut' => "KD W.core",
			'gesellschaftsform' => "Einzelunternehmen",
			'uid' => "ATU68745888",
			'fn' => "FN397616f",
			'website' => "www.staqq.at",
			'firmensitz_adresse' => "Schubertring 12",
			'firmensitz_plz' => "1010",
			'firmensitz_ort' => "Wien",
			'ansprechpartner_position' => "GF",
			'ansprechpartner_anrede' => "Herr",
			'ansprechpartner_titel' => " ",
			'ansprechpartner_vorname' => "Walter",
			'ansprechpartner_nachname' => "Core",
			'passwort' => "W.core1234",
			'email' => "w@core.at",
			'telefon' => "0043 664 5345719",

			'berufsfelder' => json_encode(array(1,2)),
			'arbeitsstaetten' => json_encode(array('A1', 'A2')),
			
			'anzahl_user' => 5,
			'anzahl_joborders' => 10,
			'agb_accept' => 1
		])->decode_response();

		// Bewerber 1
		$res = $api->post("ressources", [
			'registrations_id' => 0,
			'vorname' => "Manfred",
			'nachname' => "Kern",
			'passwort' => "M.kern1234",
			'email' => "make5439@aon.at",
			'old_email' => null,
			'telefon' => "0043 664 5345719",
			'skill_fuehrerschein' => 1,
			'skill_berufsabschluss' => 1,
			'skill_pkw' => 1,
			'skill_eu_buerger' => 1,
			'skill_rwr_karte' => 1,
			'skill_hoechster_schulabschluss' => "HFS Modul",

			'berufsfelder' => json_encode(array(1,2)),
			'berufsgruppen' => json_encode(array(1,2)),
			'berufsbezeichnungen' => json_encode(array(1,2)),

			'skills' => json_encode(array(1,2)),
			'regionen' => json_encode(array(1,2)),

			'dl_gecastet' => "[]",
			'dl_blacklist' => "[]",
			'agb_accept' => 1
		])->decode_response();
 
		// Bewerber 2
		$res = $api->post("ressources", [
			'registrations_id' => 0,
			'vorname' => "Elke",
			'nachname' => "Kern",
			'passwort' => "E.kern1234",
			'email' => "make5439@gmx.at",
			'old_email' => null,
			'telefon' => "0043 664 5345719",
			'skill_fuehrerschein' => 1,
			'skill_berufsabschluss' => 1,
			'skill_pkw' => 1,
			'skill_eu_buerger' => 1,
			'skill_rwr_karte' => 1,
			'skill_hoechster_schulabschluss' => "HAK",

			'berufsfelder' => json_encode(array(1,2)),
			'berufsgruppen' => json_encode(array(1,2)),
			'berufsbezeichnungen' => json_encode(array(1,2)),

			'skills' => json_encode(array(1,2)),
			'regionen' => json_encode(array(1,2)),

			'dl_gecastet' => "[]",
			'dl_blacklist' => "[]",
			'agb_accept' => 1
		])->decode_response();

 
		// Bewerber 3
		$res = $api->post("ressources", [
			'registrations_id' => 0,
			'vorname' => "Walter",
			'nachname' => "Kern",
			'passwort' => "W.kern1234",
			'email' => "kern@flenreiss.at",
			'old_email' => null,
			'telefon' => "0043 664 5345719",
			'skill_fuehrerschein' => 1,
			'skill_berufsabschluss' => 1,
			'skill_pkw' => 1,
			'skill_eu_buerger' => 1,
			'skill_rwr_karte' => 1,
			'skill_hoechster_schulabschluss' => "HAK",

			'berufsfelder' => json_encode(array(1,2)),
			'berufsgruppen' => json_encode(array(1,2)),
			'berufsbezeichnungen' => json_encode(array(1,2)),

			'skills' => json_encode(array(1,2)),
			'regionen' => json_encode(array(1,2)),

			'dl_gecastet' => "[]",
			'dl_blacklist' => "[]",
			'agb_accept' => 1
		])->decode_response();

		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_dev&done=true');
	}
	
	function action__staqq_admin_dev__reset_skills(){
		
		global $api;
		require_once get_template_directory().'/vendor/restclient.php';

        require_once get_home_path().'/api/config.php';
		// Name of the file
		$filename = (__DIR__).'/staqq_reset_skills.sql';
		$mysql_host = API_DB_HOST;
		// MySQL username
		$mysql_username = API_DB_USER;
		// MySQL password
		$mysql_password = API_DB_PASS;
		// Database name
		$mysql_database = API_DB_NAME;
		
		// Connect to MySQL server
		mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
		// Select database
		mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		// Loop through each line
		foreach ($lines as $line)
		{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			// Reset temp variable to empty
			$templine = '';
		}
		}
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_dev&done=true');
	}



	/**************************************************************
	** AGB
	**************************************************************/
	
	add_action('init', 'staqq_admin_agb');
	
	function staqq_admin_agb(){
		register_post_type(
			'agb',
				array(
					'labels' => array(
					'name' => __('AGB & Ethik'),
					'singular_name' => __('AGB & Ethik')
				),
				'public' 			=> true,
				'has_archive' 		=> false,
				'show_in_nav_menus' => true,
				'menu_position' 	=> 3,
				'menu_icon'			=> 'dashicons-media-text',
				'supports'          => array ('editor', 'title'),
				'capabilities' 		=> array(
					'edit_post'          => 'staqq_admin', 
					'read_post'          => 'staqq_admin', 
					'delete_post'        => 'staqq_admin', 
					'edit_posts'         => 'staqq_admin', 
					'edit_others_posts'  => 'staqq_admin', 
					'publish_posts'      => 'staqq_admin',       
					'read_private_posts' => 'staqq_admin',
					'create_posts'       => 'staqq_admin', 
				),
			)
		);
	}




	/**************************************************************
	** EDIT Berufe
	**************************************************************/

	// Berufsfelder

    function staqq_admin_berufe_berufsfelder(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM berufsfelder ORDER BY berufsfelder.name");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>
				Berufsfelder
				<a href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsfelder&action=create" class="page-title-action">Erstellen</a>
            </h1>
            
            <?php //if (isset($_GET['done'])) echo '<div class="error"><p><strong>Löschen war erfolgreich!</strong></p></div>'; ?>
        	
          	<?php
				if ((isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) || (isset($_GET['action']) && $_GET['action'] == "create")){ 
				
					if (isset($_GET['id'])){
						$sth = $db->prepare("SELECT * FROM berufsfelder WHERE id=:id");
						$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
						$sth->execute();
						$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					}else{
						$set = array(
							"name" => ""
						);
					}
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_berufe_berufsfelder__<?php echo isset($_GET['id']) ? 'edit' : 'create'; ?>">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
           	<?php }else{ ?>
           
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsfelder&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_berufe_berufsfelder__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_berufe_berufsfelder__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE berufsfelder SET name=:name WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsfelder');
		
	}

	function action__staqq_admin_berufe_berufsfelder__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM berufsfelder WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsfelder');
		
	}

	function action__staqq_admin_berufe_berufsfelder__create(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("INSERT INTO berufsfelder (name) VALUES (:name)");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsfelder');
		
	}



	// berufsgruppen

    function staqq_admin_berufe_berufsgruppen(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT berufsgruppen.*, berufsfelder.name AS berufsfelder_name, verrechnungs_kategorien.name AS verrechnungs_kategorien_name, verrechnungs_kategorien.preis AS verrechnungs_kategorien_preis FROM berufsgruppen LEFT JOIN berufsfelder ON berufsfelder.id = berufsgruppen.berufsfelder_id LEFT JOIN verrechnungs_kategorien ON berufsgruppen.verrechnungs_kategorien_id = verrechnungs_kategorien.id ORDER BY berufsfelder.name, berufsgruppen.name");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>
            	Berufsgruppen
            <a href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsgruppen&action=create" class="page-title-action">Erstellen</a>
            </h1>
        	
          	<?php
				if ((isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) || (isset($_GET['action']) && $_GET['action'] == "create")){ 
				
				if (isset($_GET['id'])){
					$sth = $db->prepare("SELECT * FROM berufsgruppen WHERE id=:id");
					$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
					$sth->execute();
					$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				}else{
					$set = array(
						"name" => "",
						"berufsfelder_id" => null,
						"verrechnungs_kategorien_id" => null	
					);
				}
					
				$sth = $db->prepare("SELECT * FROM berufsfelder");
				$sth->execute();
				$berufsfelder = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				$sth = $db->prepare("SELECT * FROM verrechnungs_kategorien");
				$sth->execute();
				$verrechnungs_kategorien = $sth->fetchAll(PDO::FETCH_ASSOC);
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_berufe_berufsgruppen__<?php echo isset($_GET['id']) ? 'edit' : 'create'; ?>">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<select name="berufsfelder_id" id="berufsfelder_id">
							<?php foreach($berufsfelder as $b){ ?><option value="<?php echo $b['id'] ?>" <?php if ($b['id'] == $set['berufsfelder_id']) echo 'selected'; ?>><?php echo $b['name']; ?></option><?php } ?>
						</select>
						<select name="verrechnungs_kategorien_id" id="verrechnungs_kategorien_id">
							<?php foreach($verrechnungs_kategorien as $v){ ?><option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $set['verrechnungs_kategorien_id']) echo 'selected'; ?>><?php echo $v['name']; ?> (€ <?php echo $v['preis']; ?>)</option><?php } ?>
						</select>
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
          	
           	<?php } else { ?>
           	
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Berufsfeld</th>
							<th>Verrechnungskategorie</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['berufsfelder_name']; ?></td>
								<td><?php echo $row['verrechnungs_kategorien_name']; ?> (€ <?php echo $row['verrechnungs_kategorien_preis']; ?>)</td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsgruppen&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_berufe_berufsgruppen__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_berufe_berufsgruppen__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE berufsgruppen SET name=:name, berufsfelder_id=:berufsfelder_id, verrechnungs_kategorien_id=:verrechnungs_kategorien_id WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->bindParam(':verrechnungs_kategorien_id', $_GET['verrechnungs_kategorien_id'], PDO::PARAM_INT);
		$sth->bindParam(':berufsfelder_id', $_GET['berufsfelder_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsgruppen');
		
	}

	function action__staqq_admin_berufe_berufsgruppen__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM berufsgruppen WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsgruppen');
		
	}

	function action__staqq_admin_berufe_berufsgruppen__create(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("INSERT INTO berufsgruppen (name, berufsfelder_id, verrechnungs_kategorien_id) VALUES (:name, :berufsfelder_id, :verrechnungs_kategorien_id)");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':berufsfelder_id', $_GET['berufsfelder_id'], PDO::PARAM_INT);
		$sth->bindParam(':verrechnungs_kategorien_id', $_GET['verrechnungs_kategorien_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsgruppen');
		
	}



	// berufsbezeichnungen

    function staqq_admin_berufe_berufsbezeichnungen(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT berufsbezeichnungen.*, berufsgruppen.name AS berufsgruppen_name, berufsfelder.name AS berufsfelder_name, verrechnungs_kategorien.name AS verrechnungs_kategorien_name, verrechnungs_kategorien.preis AS verrechnungs_kategorien_preis FROM berufsbezeichnungen LEFT JOIN berufsgruppen ON berufsgruppen.id = berufsbezeichnungen.berufsgruppen_id LEFT JOIN berufsfelder ON berufsfelder.id = berufsgruppen.berufsfelder_id LEFT JOIN verrechnungs_kategorien ON berufsbezeichnungen.verrechnungs_kategorien_id = verrechnungs_kategorien.id ORDER BY berufsfelder.name, berufsgruppen.name, berufsbezeichnungen.name");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>
            	Berufsbezeichnungen
            <a href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsbezeichnungen&action=create" class="page-title-action">Erstellen</a>
            </h1>
        	
        	<?php
				if ((isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) || (isset($_GET['action']) && $_GET['action'] == "create")){ 
				
					if (isset($_GET['id'])){
						$sth = $db->prepare("SELECT * FROM berufsfelder WHERE id=:id");
						$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
						$sth->execute();
						$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					}else{
						$set = array(
							"name" => "",
							"berufsgruppen_id" => null,
							"verrechnungs_kategorien_id" => null	
						);
					} 
				
				$sth = $db->prepare("SELECT * FROM berufsbezeichnungen WHERE id=:id");
        		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
				$sth->execute();
				$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				
				$sth = $db->prepare("SELECT * FROM berufsgruppen");
				$sth->execute();
				$berufsgruppen = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				$sth = $db->prepare("SELECT * FROM verrechnungs_kategorien");
				$sth->execute();
				$verrechnungs_kategorien = $sth->fetchAll(PDO::FETCH_ASSOC);
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_berufe_berufsbezeichnungen__<?php echo isset($_GET['id']) ? 'edit' : 'create'; ?>">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<select name="berufsgruppen_id" id="berufsgruppen_id">
							<?php foreach($berufsgruppen as $b){ ?><option value="<?php echo $b['id'] ?>" <?php if ($b['id'] == $set['berufsgruppen_id']) echo 'selected'; ?>><?php echo $b['name']; ?></option><?php } ?>
						</select>
						<select name="verrechnungs_kategorien_id" id="verrechnungs_kategorien_id">
							<?php foreach($verrechnungs_kategorien as $v){ ?><option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $set['verrechnungs_kategorien_id']) echo 'selected'; ?>><?php echo $v['name']; ?> (€ <?php echo $v['preis']; ?>)</option><?php } ?>
						</select>
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
          	
           	<?php } else { ?>
           	
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Berufsgruppe</th>
							<th>Berufsfeld</th>
							<th>Verrechnungskategorie</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['berufsgruppen_name']; ?></td>
								<td><?php echo $row['berufsfelder_name']; ?></td>
								<td><?php echo $row['verrechnungs_kategorien_name']; ?> (€ <?php echo $row['verrechnungs_kategorien_preis']; ?>)</td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_berufe_berufsbezeichnungen&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_berufe_berufsbezeichnungen__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_berufe_berufsbezeichnungen__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE berufsbezeichnungen SET name=:name, berufsgruppen_id=:berufsgruppen_id, verrechnungs_kategorien_id=:verrechnungs_kategorien_id WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->bindParam(':verrechnungs_kategorien_id', $_GET['verrechnungs_kategorien_id'], PDO::PARAM_INT);
		$sth->bindParam(':berufsgruppen_id', $_GET['berufsgruppen_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsbezeichnungen');
		
	}

	function action__staqq_admin_berufe_berufsbezeichnungen__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM berufsbezeichnungen WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsbezeichnungen');
		
	}

	function action__staqq_admin_berufe_berufsbezeichnungen__create(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("INSERT INTO berufsbezeichnungen (name, berufsgruppen_id, verrechnungs_kategorien_id) VALUES (:name, :berufsgruppen_id, :verrechnungs_kategorien_id)");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':berufsgruppen_id', $_GET['berufsgruppen_id'], PDO::PARAM_INT);
		$sth->bindParam(':verrechnungs_kategorien_id', $_GET['verrechnungs_kategorien_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_berufe_berufsbezeichnungen');
		
	}


	/**************************************************************
	** Joborders / Rechnungen
	**************************************************************/

    function staqq_admin_sammelrechnungen_erstellen(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT joborders.*, dienstleister.firmenwortlaut, dienstleister.id AS dienstleister_id, verrechnungs_kategorien.name AS verrechnungs_kategorien_name, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id LEFT JOIN dienstleister ON dienstleister.id = bewerbungen.dienstleister_id LEFT JOIN verrechnungs_kategorien ON verrechnungs_kategorien.id = joborders.verrechnungs_kategorien_id WHERE dienstleister_einsatz_bestaetigt=1 AND ressource_einsatz_bestaetigt=1 AND joborders.rechnung_erstellt=0 ORDER BY joborders.id DESC");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>Offene Joborders</h1>
            
            <?php if (isset($_GET['error'])) echo '<div class="error"><p><strong>'.$_GET['msg'].'</strong></p></div>'; ?>
            
            <form action="/wp-admin/admin-post.php">
			
           		<button type="submit" class="button button-primary">Rechnung aus markierten Jobs erstellen</button>
				<input type="hidden" name="action" value="staqq_admin_sammelrechnungen__doit">
				
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>Markierung</th>
							<th>ID</th>
							<th>Jobtitel</th>
							<th>Erstellt von</th>
							<th>Arbeitszeitraum</th>
							<th>Dienstleister</th>
							<th>Tage</th>
							<th>Kategorie</th>
							<th>Kosten</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td>
									<input type="checkbox" value="<?php echo $row['dienstleister_id']; ?>" name="joborder_ids[<?php echo $row['id']; ?>]">
								</td>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['jobtitel']; ?></td>
								<td><?php echo $row['publisher_type']; ?> <?php echo $row['publisher_id']; ?></td>
								<td><?php echo $row['arbeitsbeginn']; ?> - <?php echo $row['arbeitsende']; ?></td>
								<td><?php echo $row['firmenwortlaut']; ?></td>
								<td><?php echo $row['tage']; ?></td>
								<td><?php echo $row['verrechnungs_kategorien_name']; ?></td>
								<td><?php echo "€ {$row['kosten']}"; ?></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</form>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
<?php
          
    }

	function staqq_admin_sammelrechnungen_erstellt(){
		
		$db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT dienstleister.firmenwortlaut, dienstleister.id AS dienstleister_id, joborders.*, verrechnungs_kategorien.name AS verrechnungs_kategorien_name, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id LEFT JOIN dienstleister ON dienstleister.id = bewerbungen.dienstleister_id LEFT JOIN verrechnungs_kategorien ON verrechnungs_kategorien.id = joborders.verrechnungs_kategorien_id WHERE dienstleister_einsatz_bestaetigt=1 AND ressource_einsatz_bestaetigt=1 AND joborders.rechnung_erstellt=1 AND joborders.rechnung_bezahlt=0 ORDER BY joborders.id DESC");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>Joborders / Order Erstellt - Bezahlung offen</h1>
            
			<table class="widefat backend-datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Jobtitel</th>
						<th>Erstellt von</th>
						<th>Arbeitszeitraum</th>
						<th>Dienstleister</th>
						<th>Tage</th>
						<th>Kategorie</th>
						<th>Kosten</th>
						<th>Order Erstellt</th>
						<th>Direct Payment</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($data as $row){
					?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['jobtitel']; ?></td>
							<td><?php echo $row['publisher_type']; ?> <?php echo $row['publisher_id']; ?></td>
							<td><?php echo $row['arbeitsbeginn']; ?> - <?php echo $row['arbeitsende']; ?></td>
							<td><?php echo $row['firmenwortlaut']; ?></td>
							<td><?php echo $row['tage']; ?></td>
							<td><?php echo $row['verrechnungs_kategorien_name']; ?></td>
							<td><?php echo "€ {$row['kosten']}"; ?></td>
							<td><?php echo $row['rechnung_erstellt_datum']; ?></td>
							<td><input type="text" value="<?php echo $row['payment_url']; ?>" readonly></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
<?php
		
	}

	function staqq_admin_sammelrechnungen_bezahlt(){
		
		$db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT dienstleister.firmenwortlaut, dienstleister.id AS dienstleister_id, joborders.*, verrechnungs_kategorien.name AS verrechnungs_kategorien_name, DATE_FORMAT(joborders.arbeitsbeginn,'%d.%m.%Y') AS arbeitsbeginn, DATE_FORMAT(joborders.arbeitsende,'%d.%m.%Y') AS arbeitsende FROM bewerbungen LEFT JOIN joborders ON joborders.id = bewerbungen.joborders_id LEFT JOIN dienstleister ON dienstleister.id = bewerbungen.dienstleister_id LEFT JOIN verrechnungs_kategorien ON verrechnungs_kategorien.id = joborders.verrechnungs_kategorien_id WHERE dienstleister_einsatz_bestaetigt=1 AND ressource_einsatz_bestaetigt=1 AND joborders.rechnung_erstellt=1 AND joborders.rechnung_bezahlt=1 ORDER BY joborders.id DESC");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>Joborders / Bezahlt</h1>

			<table class="widefat backend-datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Jobtitel</th>
						<th>Erstellt von</th>
						<th>Arbeitszeitraum</th>
						<th>Dienstleister</th>
						<th>Tage</th>
						<th>Kategorie</th>
						<th>Kosten</th>
						<th>Order Erstellt</th>
						<th>Bezahlt</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($data as $row){
					?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['jobtitel']; ?></td>
							<td><?php echo $row['publisher_type']; ?> <?php echo $row['publisher_id']; ?></td>
							<td><?php echo $row['arbeitsbeginn']; ?> - <?php echo $row['arbeitsende']; ?></td>
							<td><?php echo $row['firmenwortlaut']; ?></td>
							<td><?php echo $row['tage']; ?></td>
							<td><?php echo $row['verrechnungs_kategorien_name']; ?></td>
							<td><?php echo "€ {$row['kosten']}"; ?></td>
							<td><?php echo $row['rechnung_erstellt_datum']; ?></td>
							<td><?php echo $row['rechnung_bezahlt_datum']; ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
<?php
		
	}

	function action__staqq_admin_sammelrechnungen__doit(){
		
		$jids = array();
		$dids = array();
		
		foreach($_GET['joborder_ids'] as $joborder_id => $dienstleister_id){
			array_push($jids, intval($joborder_id));
			array_push($dids, intval($dienstleister_id));
		}
		
		// check ob nur 1 rechungsempfänger (!)
		if (count(array_unique($dids)) == 1){
			
			include_once get_home_path().'/api/v1/functions.php';
			verrechneJoboorder($jids, 'dienstleister', $dids[0]);
			header ('Location: /wp-admin/admin.php?page=staqq_admin_sammelrechnungen_erstellt');
			
		// more than one dl
		}else{
			header ('Location: /wp-admin/admin.php?page=staqq_admin_sammelrechnungen_erstellen&error=true&msg=FEHLER:%20Mehr%20als%20ein%20Dienstleister%20bei%20markierten%20Joborders!');
		}
		
	}






	/**************************************************************
	** Verrechnungs Kategorien
	**************************************************************/

    function staqq_admin_verrechnung(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM verrechnungs_kategorien");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>Verrechnung</h1>
            
          	<?php
				if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])){ 
				
				$sth = $db->prepare("SELECT * FROM verrechnungs_kategorien WHERE id=:id");
        		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
				$sth->execute();
				$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_verrechnung__edit">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<input type="text" name="preis" value="<?php echo $set['preis']; ?>" placeholder="Name">
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
           	<?php }else{ ?>
           
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Preis</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td>€ <?php echo $row['preis']; ?></td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_verrechnung&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_verrechnung__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_verrechnung__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE verrechnungs_kategorien SET name=:name, preis=:preis WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':preis', $_GET['preis'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_verrechnung');
		
	}

	function action__staqq_admin_verrechnung__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM verrechnungs_kategorien WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_verrechnung');
		
	}



	/**************************************************************
	** Skills
	**************************************************************/


	// Items

    function staqq_admin_skills_items(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT skills_items.*, skills_kategorien.name AS skills_kategorien_name FROM skills_items LEFT JOIN skills_kategorien ON skills_kategorien.id = skills_items.skills_kategorien_id ORDER BY skills_kategorien.name, skills_items.name");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>
            	Skills Items
            	<a href="/wp-admin/admin.php?page=staqq_admin_skills_items&action=create" class="page-title-action">Erstellen</a>
            </h1>
        	
          	<?php
				if ((isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) || (isset($_GET['action']) && $_GET['action'] == "create")){ 
				
				if (isset($_GET['id'])){
					$sth = $db->prepare("SELECT * FROM skills_items WHERE id=:id");
					$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
					$sth->execute();
					$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
				}else{
					$set = array(
						"name" => "",
						"skills_kategorien_id" => null
					);
				}
					
				$sth = $db->prepare("SELECT * FROM skills_kategorien");
				$sth->execute();
				$kategorien = $sth->fetchAll(PDO::FETCH_ASSOC);
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_skills_items__<?php echo isset($_GET['id']) ? 'edit' : 'create'; ?>">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<select name="skills_kategorien_id" id="skills_kategorien_id">
							<?php foreach($kategorien as $b){ ?><option value="<?php echo $b['id'] ?>" <?php if ($b['id'] == $set['skills_kategorien_id']) echo 'selected'; ?>><?php echo $b['name']; ?></option><?php } ?>
						</select>
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
          	
           	<?php } else { ?>
           	
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Kategorie</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['skills_kategorien_name']; ?></td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_skills_items&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_skills_items__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_skills_items__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE skills_items SET name=:name, skills_kategorien_id=:skills_kategorien_id WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->bindParam(':skills_kategorien_id', $_GET['skills_kategorien_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_items');
		
	}

	function action__staqq_admin_skills_items__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM skills_items WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_items');
		
	}

	function action__staqq_admin_skills_items__create(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("INSERT INTO skills_items (name, skills_kategorien_id) VALUES (:name, :skills_kategorien_id)");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':skills_kategorien_id', $_GET['skills_kategorien_id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_items');
		
	}

	// Kategorien

    function staqq_admin_skills_kategorien(){
        
        $db = staqq_admin_get_db();
        $sth = $db->prepare("SELECT * FROM skills_kategorien ORDER BY skills_kategorien.name");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="wrap">
           
            <h1>
				Skills Kategorien
				<a href="/wp-admin/admin.php?page=staqq_admin_skills_kategorien&action=create" class="page-title-action">Erstellen</a>
            </h1>
        	
          	<?php
				if ((isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id'])) || (isset($_GET['action']) && $_GET['action'] == "create")){ 
				
					if (isset($_GET['id'])){
						$sth = $db->prepare("SELECT * FROM skills_kategorien WHERE id=:id");
						$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
						$sth->execute();
						$set = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
					}else{
						$set = array(
							"name" => ""
						);
					}
			?>
				<div class="backend-edit-form">
					<form id="edit" action="/wp-admin/admin-post.php">
						<input type="hidden" name="action" value="staqq_admin_skills_kategorien__<?php echo isset($_GET['id']) ? 'edit' : 'create'; ?>">
						<input type="hidden" name="id" value="<?php echo $set['id']; ?>" placeholder="ID">
						<input type="text" name="name" value="<?php echo $set['name']; ?>" placeholder="Name">
						<button type="submit" class="button button-primary">Speichern</button>
					</form>
				</div>
           	<?php }else{ ?>
           
				<table class="widefat backend-datatable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Bearbeiten</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($data as $row){
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><a class="button button-primary" href="/wp-admin/admin.php?page=staqq_admin_skills_kategorien&action=edit&id=<?php echo $row['id']; ?>">Bearbeiten</a></td>
								<td><a class="button" href="/wp-admin/admin-post.php?action=staqq_admin_skills_kategorien__delete&id=<?php echo $row['id']; ?>">Löschen</a></td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			<?php } ?>
		</div>
        
        <script>
			jQuery(document).ready(function(){
				//jQuery('.backend-datatable').DataTable();
			});
			
		</script>
    
    <?php
          
    }

	function action__staqq_admin_skills_kategorien__edit(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("UPDATE skills_kategorien SET name=:name WHERE id=:id LIMIT 1");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_kategorien');
		
	}

	function action__staqq_admin_skills_kategorien__delete(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("DELETE FROM skills_kategorien WHERE id=:id LIMIT 1");
		$sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_kategorien');
		
	}

	function action__staqq_admin_skills_kategorien__create(){
		
        $db = staqq_admin_get_db();
        $sth = $db->prepare("INSERT INTO skills_kategorien (name) VALUES (:name)");
		$sth->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
        $res = $sth->execute();
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_skills_kategorien');
		
	}

	/**************************************************************
	** Texte
	**************************************************************/

	function staqq_admin_texte(){
		
		$email_absage_anderwaertig_vergeben_betreff = get_option('email_absage_anderwaertig_vergeben_betreff') ? utf8_decode(get_option('email_absage_anderwaertig_vergeben_betreff')) : "";
		$email_absage_anderwaertig_vergeben = get_option('email_absage_anderwaertig_vergeben') ? utf8_decode(get_option('email_absage_anderwaertig_vergeben')) : "";
		$dienstleister_einladen_betreff = get_option('dienstleister_einladen_betreff') ? utf8_decode(get_option('dienstleister_einladen_betreff')) : "";
		$dienstleister_einladen_text = get_option('dienstleister_einladen_text') ? utf8_decode(get_option('dienstleister_einladen_text')) : "";
		$grusszeile = get_option('grusszeile') ? utf8_decode(get_option('grusszeile')) : "";
		$fusszeile = get_option('fusszeile') ? utf8_decode(get_option('fusszeile')) : "";
		
		$paket_anfrage_gold_monatlich = get_option('paket_anfrage_gold_monatlich') ? utf8_decode(get_option('paket_anfrage_gold_monatlich')) : "";
		$paket_anfrage_gold_jaehrlich = get_option('paket_anfrage_gold_jaehrlich') ? utf8_decode(get_option('paket_anfrage_gold_jaehrlich')) : "";
		$paket_anfrage_platinum_monatlich = get_option('paket_anfrage_platinum_monatlich') ? utf8_decode(get_option('paket_anfrage_platinum_monatlich')) : "";
		$paket_anfrage_platinum_jaehrlich = get_option('paket_anfrage_platinum_jaehrlich') ? utf8_decode(get_option('paket_anfrage_platinum_jaehrlich')) : "";

?>
		<div class="wrap">
           
            <h1>Texte</h1>
            
            <table class="widefat backend-datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Verwendung</th>
                        <th>Text</th>
                        <th>Speichern</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Betreff - E-Mail Absage an einen Bewerber</td>
							<td></td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="email_absage_anderwaertig_vergeben_betreff">
								<input name="content" id="content" type="text" value="<?php echo $email_absage_anderwaertig_vergeben_betreff; ?>">
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - E-Mail Absage an einen Bewerber</td>
							<td>Text, der in der E-Mail bei Absage an einem Bewerber geschickt wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="email_absage_anderwaertig_vergeben">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $email_absage_anderwaertig_vergeben; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Betreff - Dienstleister Einladen</td>
							<td></td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="dienstleister_einladen_betreff">
								<input name="content" id="content" type="text" value="<?php echo $dienstleister_einladen_betreff; ?>">
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - Dienstleister Einladen</td>
							<td>Text, den der Kunde editieren und an einen nicht vorhandenen<br> Dienstleister schicken kann, um auf STAQQ aufmerksam zu machen.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="dienstleister_einladen_text">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $dienstleister_einladen_text; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - Anfrage Gold-Paket / Monatliche Zahlung</td>
							<td>Text, Der für die E-Mail vorgegeben wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="paket_anfrage_gold_monatlich">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $paket_anfrage_gold_monatlich; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - Anfrage Gold-Paket / Jährliche Zahlung</td>
							<td>Text, Der für die E-Mail vorgegeben wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="paket_anfrage_gold_jaehrlich">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $paket_anfrage_gold_jaehrlich; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - Anfrage Platinum-Paket / Monatliche Zahlung</td>
							<td>Text, Der für die E-Mail vorgegeben wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="paket_anfrage_platinum_monatlich">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $paket_anfrage_platinum_monatlich; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Text - Anfrage Platinum-Paket / Jährliche Zahlung</td>
							<td>Text, Der für die E-Mail vorgegeben wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="paket_anfrage_platinum_jaehrlich">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $paket_anfrage_platinum_jaehrlich; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Grußzeile</td>
							<td>Grußzeile, die unter jedes automatisierte Mail gesetzt wird.</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="grusszeile">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $grusszeile; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                	<tr>
						<form action="/wp-admin/admin-post.php">
							<td>Fußzeile</td>
							<td>Fußzeile in HTML(!)</td>
							<td>
								<input type="hidden" name="action" value="staqq_admin_texte__save">
								<input type="hidden" name="name" value="fusszeile">
								<textarea name="content" id="content" cols="30" rows="10"><?php echo $fusszeile; ?></textarea>
							</td>
							<td>
								<button class="button-primary">Speichern</button>
							</td>
						</form>
                	</tr>
                </tbody>
            </table>
			
		</div>
<?php
							   
	}

	function action__staqq_admin_texte__save(){

		$option_name = $_GET['name'];
		$new_value = stripslashes(utf8_encode($_GET['content']));

		if (get_option($option_name) !== false) {
			update_option($option_name, $new_value);
		} else {
			$deprecated = null;
			$autoload = 'no';
			add_option($option_name, $new_value, $deprecated, $autoload);
		}
		
		header ('Location: /wp-admin/admin.php?page=staqq_admin_texte');
	}
	
?>