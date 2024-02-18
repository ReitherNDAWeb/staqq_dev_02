<?php

    $app->get('/agb/{type}', function($request, $response, $args) {
        
        include("../../wp-load.php");
		if ($args['type'] == "ressource"){
			$body = get_post(168)->post_content;
		} else if ($args['type'] == "dienstleister"){
			$body = get_post(169)->post_content;
		} else if ($args['type'] == "kunde"){
			$body = get_post(170)->post_content;
		}
		
        $response->write($body);
        return $response;
    });

?>