<?php

	$app->get('/test', function($request, $response, $args) {
        
        var_dump($args);
        var_dump($request->getParsedBody());
        return $response;
        
    });

	$app->put('/test', function($request, $response, $args) {
        
        var_dump($args);
        var_dump($request->getParsedBody());
        return $response;
        
    });

	$app->post('/test', function($request, $response, $args) {
        
        var_dump($args);
        var_dump($request->getParsedBody());
        return $response;
        
    });

	$app->delete('/test', function($request, $response, $args) {
        
        var_dump($args);
        var_dump($request->getParsedBody());
        return $response;
        
    });

	$app->post('/test/sms', function($request, $response, $args) {
        
        var_dump($args);
        var_dump($request->getParsedBody());
		$sms = sendSMS($request->getParsedBody()['number'], $request->getParsedBody()['content']);
        var_dump($sms);
        return $response;
        
    });

	$app->post('/test/mail/dienstleister', function($request, $response, $args) {
		try{
        
            $db = getDB();
			include("../../wp-load.php");

			$ressource_id = 1;
			
			// Joborder
			$sth = $db->prepare("SELECT * FROM joborders WHERE id=14");
			//$sth->bindParam(':id', $ressource_id, PDO::PARAM_INT);
			$sth->execute();
			$j = utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC))[0];
			
			// Ressource
			$sth = $db->prepare("SELECT * FROM ressources WHERE id=:id");

			$sth->bindParam(':id', $ressource_id, PDO::PARAM_INT);
			$sth->execute();

			foreach(utf8_converter($sth->fetchAll(PDO::FETCH_ASSOC)) as $b){

				if (intval($b['email_benachrichtigungen'])) {
					
					$ab = date("d.m.Y", strtotime($j['arbeitsbeginn']));
					$ae = date("d.m.Y", strtotime($j['arbeitsende']));
					
					$html =  "Sehr geehrte(r) {$b['anrede']} {$b['vorname']} {$b['nachname']}!";
					$html .= "<br><br>";
					$html .= nl2br(utf8_decode(get_option('email_absage_anderwaertig_vergeben')));
					$html .= "<br><br>";
					$html .= "Job: {$j['jobtitel']} ($ab - $ae)";
					$html .= "<br><br>";
					$html .= nl2br(utf8_decode(get_option('grusszeile')));

					$betreff = utf8_decode(get_option('email_absage_anderwaertig_vergeben_betreff'));

					$ret = sendMail($request->getParsedBody()['email'], $betreff, $html, '');
				}

			}
			
            $body = json_encode(['status' => $ret, 'b' => $betreff, 'html' => $html]);
            
        } catch(PDOException $e){
            $response->withStatus(400);
            $body = json_encode(['msg' => $e]);
        }
		
        $response->write($body);
        return $response;
        
    });

	$app->post('/test/encoding', function($request, $response, $args) {
		
		include("../../wp-load.php");
		
		$test1 = nl2br(get_option('email_absage_anderwaertig_vergeben'));
		$test2 = mb_detect_encoding($test1, 'UTF-8', true);
		$test3 = utf8_decode($test1);
		$test4 = "Job wurde leider anderwärtig vergeben";
		$test5 = mb_detect_encoding($test4, 'UTF-8', true);
		$test6 = utf8_decode($test4);

		var_dump($test1, $test2, $test3, $test4, $test5, $test6);
		
		//$ret = sendMail($request->getParsedBody()['email'], , $html, '');
        
        
        
    });


	$app->post('/test/testNotification', function($request, $response, $args) {
		
		$set = array(
			'receiver_type'	=> $request->getParsedBody()['receiver_type'], 
			'receiver_id' 	=> $request->getParsedBody()['receiver_id'], 
			'titel' 		=> $request->getParsedBody()['titel'], 
			'nachricht' 	=> $request->getParsedBody()['nachricht'], 
			'subtitle' 		=> $request->getParsedBody()['subtitle'], 
			'kategorie' 	=> 'egal', 
			'link_web' 		=> '/app/', 
			'link_mobile' 	=> '/'.$request->getParsedBody()['receiver_type'].'/notifications', 
			'send_web' 		=> true, 
			'send_mobile' 	=> true,
			'force' 		=> true
		);
        
		fireNotification ($set);
		
		echo "hello"; 
        
    });


	$app->post('/test/notifyUser/{id}', function($request, $response, $args) {
		
		$path = getcwd()."/parts/notifications/notifyRessourcesAboutNewJob.php";
		//var_dump(PHP_BINDIR . "/php $path '{$args['id']}' 'alert' >> /var/log/paging.log &");
		shell_exec(PHP_BINDIR . "/php $path '{$args['id']}'");
        
    });


	$app->get('/test/verrechnung', function($request, $response, $args) {
		
		echo "<a href='".verrechneJoboorder(array(14), 'dienstleister', 1)."'>Link</a>";
        
    });

	$app->post('/test/login', function($request, $response, $args) {
		
		include("../../wp-load.php");
		
		var_dump(wp_signon(array('user_login' => $request->getParsedBody()['email'], 'user_password' => $request->getParsedBody()['password'], 'remember' => true)));
        
    });

	$app->post('/test/logout', function($request, $response, $args) {
		
		include("../../wp-load.php");
		
		var_dump(wp_logout());
        
    });

	$app->get('/test/loggedin', function($request, $response, $args) {
		
		include("../../wp-load.php");
		
		$body = json_encode(['status' => is_user_logged_in(), 'curr' => wp_get_current_user()]);
		
        $response->write($body);
        return $response;
    });

?>