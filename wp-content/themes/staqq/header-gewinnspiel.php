<?php

	function currentMenuItem($uri){
		if (strpos($_SERVER['REQUEST_URI'], $uri) !== false){
			return 'current';
		}else{
			return '';
		}
	}

    function in_array_by_id($n, $arr){
        
        foreach($arr as $a){
            if ($a->id == $n->id) return true;
        }
        return false;
    }

    function in_array_by_id_2($n, $arr){
        
        foreach($arr as $a){
            if ($a->id == $n) return true;
        }
        return false;
    }

    global $wpUserState, $wpUserRole, $wpUserSTAQQUser, $wpUser, $wpUserSTAQQId, $api, $userBerechtigungen, $wpUserSTAQQDienstleisterId, $wpUserSTAQQKundeId;
    
    require_once get_template_directory().'/inc/funktionen.php';
    require_once get_template_directory().'/vendor/restclient.php';
    
    $wpUserState     = is_user_logged_in();
    $wpUserRole      = false;
    $wpUserSTAQQUser = false;
    $wpUser          = false;
    
    if ($wpUserState){
        
        $wpUser = wp_get_current_user();
        $wpUserSTAQQId = get_user_meta($wpUser->ID, 'staqq_id')[0];
        
        if (in_array("ressource", $wpUser->roles)) {
            $wpUserRole = "ressource";
            $wpUserSTAQQUser = true;
        } else if (in_array("kunde", $wpUser->roles)) {
            $wpUserRole = "kunde";
            $wpUserSTAQQUser = true;
            $wpUserSTAQQKundeId = $wpUserSTAQQId;
        } else if (in_array("dienstleister", $wpUser->roles)) {
            $wpUserRole = "dienstleister";
            $wpUserSTAQQUser = true;
            $wpUserSTAQQDienstleisterId = $wpUserSTAQQId;
        } else if (in_array("kunde_u", $wpUser->roles)) {
            $wpUserRole = "kunde_user";
            $wpUserSTAQQUser = true;
            $b = $api->get("kunden/user/$wpUserSTAQQId/berechtigungen", [])->decode_response();
            $userBerechtigungen = new stdClass();
            $userBerechtigungen->berechtigung_joborders_schalten = filter_var($b->berechtigung_joborders_schalten, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->berechtigung_einkauf = filter_var($b->berechtigung_einkauf, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->berechtigung_auswertung = filter_var($b->berechtigung_auswertung, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->einschraenkung_aktiv_von_bis = filter_var($b->einschraenkung_aktiv_von_bis, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->aktiv_von = $b->aktiv_von;
            $userBerechtigungen->aktiv_bis = $b->aktiv_bis;
            $wpUserSTAQQKundeId = $b->kunden_id;
            
            if ($userBerechtigungen->einschraenkung_aktiv_von_bis && (time() < strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_von)) || time() > strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_bis)))){
                if ($_SERVER['REQUEST_URI'] != "/app/fehler/?e=1") {wp_redirect('app/fehler/?e=1'); exit;}
            }
        } else if (in_array("dienstleister_u", $wpUser->roles)) {
            $wpUserRole = "dienstleister_user";
            $wpUserSTAQQUser = true;
            $b = $api->get("dienstleister/user/$wpUserSTAQQId/berechtigungen", [])->decode_response();
            $userBerechtigungen = new stdClass();
            $userBerechtigungen->berechtigung_joborders_schalten = filter_var($b->berechtigung_joborders_schalten, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->berechtigung_einkauf = filter_var($b->berechtigung_einkauf, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->berechtigung_auswertung = filter_var($b->berechtigung_auswertung, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->einschraenkung_aktiv_von_bis = filter_var($b->einschraenkung_aktiv_von_bis, FILTER_VALIDATE_BOOLEAN);
            $userBerechtigungen->aktiv_von = $b->aktiv_von;
            $userBerechtigungen->aktiv_bis = $b->aktiv_bis;
            $wpUserSTAQQDienstleisterId = $b->dienstleister_id;
            
            if ($userBerechtigungen->einschraenkung_aktiv_von_bis && (time() < strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_von)) || time() > strtotime(str_replace('.', '-', $userBerechtigungen->aktiv_bis)))){
                if ($_SERVER['REQUEST_URI'] != "/app/fehler/?e=1") {wp_redirect('app/fehler/?e=1'); exit;}
            }
        } else{
            $wpuserRole = $wpUser->roles;
        }
        
        if ($wpUserSTAQQUser) show_admin_bar(false);
        
        
        // Redeirect if wrong
        
        if (($wpUserRole == "dienstleister_user" || $wpUserRole == "kunde_user") && (!$userBerechtigungen->berechtigung_joborders_schalten) && ($_SERVER['REQUEST_URI'] == "/app/joborders/")) header('Location: /app/verwaltung/');
        if (($wpUserRole == "dienstleister_user" || $wpUserRole == "kunde_user") && (!$userBerechtigungen->berechtigung_einkauf) && ($_SERVER['REQUEST_URI'] == "/app/verwaltung/")) header('Location: /app/stammdaten/');
        
    }
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" style="margin-top: 0px !important;">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="spinner-backdrop">
        <div id="spinner"></div>
    </div>
    <div class="staqq-notification">
        <div class="staqq-notification__wrapper">
            <h2 class="staqq-notification__title"></h2>
            <p class="staqq-notification__message"></p>
            <div class="staqq-notification__close" onclick="closeNotification();">
                <svg enable-background="new 0 0 24 24" id="Layer_1" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M12,2C6.5,2,2,6.5,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,6.5,17.5,2,12,2z M16.9,15.5l-1.4,1.4L12,13.4l-3.5,3.5   l-1.4-1.4l3.5-3.5L7.1,8.5l1.4-1.4l3.5,3.5l3.5-3.5l1.4,1.4L13.4,12L16.9,15.5z"/></g></svg>
            </div>
        </div>
    </div>
    
    
    
    <main class="content">