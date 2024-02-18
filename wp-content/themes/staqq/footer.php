<?php

    $wpUser = wp_get_current_user();
    $wpUserSTAQQId = get_user_meta($wpUser->ID, 'staqq_id')[0];

 	if (in_array("ressource", $wpUser->roles)) {
		$wpUserRole = "ressource";
        $wpUserSTAQQUser = true;
	} else if (in_array("kunde", $wpUser->roles)) {
		$wpUserRole = "kunde";
        $wpUserSTAQQUser = true;
	} else if (in_array("dienstleister", $wpUser->roles)) {
		$wpUserRole = "dienstleister";
        $wpUserSTAQQUser = true;
	} else if (in_array("kunde_u", $wpUser->roles)) {
		$wpUserRole = "kunde_user";
        $wpUserSTAQQUser = true;
	} else if (in_array("dienstleister_u", $wpUser->roles)) {
		$wpUserRole = "dienstleister_user";
        $wpUserSTAQQUser = true;
	}

?>

		</main>
		<footer class="footer section">
      <?php if(is_front_page()){ ?>
        <div class="regsvg only-mobile">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
         width="100%" height="100%" viewBox="0 0 1333.000000 346.000000"
         preserveAspectRatio="xMidYMid meet">
        <g transform="translate(0.000000,346.000000) scale(0.100000,-0.100000)"
        fill="#fdf9ee" stroke="none">
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
      <?php } ?>

		    <div class="section__overlay">
		        <div class="section__wrapper">
		            <article class="gd gd--12">
		                <p><?php echo utf8_decode(get_option('fusszeile')); ?></p>
		            </article>
		        </div>
		    </div>
		</footer>

		<?php wp_footer(); ?>
       	<?php if ($wpUserSTAQQUser){ ?>

        <?php if (in_array("ressource", $wpUser->roles)): ?>
        <script>
            jQuery.get('/api/v1/ressources/<?php echo $wpUserSTAQQId; ?>/zahlen', function(data){

                var zahlen = JSON.parse(data);

				// Castings
				var bubble = jQuery('.menu-item--casting .anzahl');
                bubble.html(zahlen.castings.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.castings.offen);

				// Bewertungen
                var bubble = jQuery('.menu-item--bewertungen .anzahl');
                bubble.html(zahlen.bewertungen.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.bewertungen.offen);

            });
        </script>
        <?php endif; ?>

        <?php if (in_array("dienstleister", $wpUser->roles)): ?>
        <script>
            jQuery.get('/api/v1/dienstleister/<?php echo $wpUserSTAQQId; ?>', function(data){

                var user = JSON.parse(data);
                var bubble = jQuery('.header__zahlen--joborders #anzahl_joborders');
                bubble.html(user.anzahl_joborders);

            });

            jQuery.get('/api/v1/dienstleister/<?php echo $wpUserSTAQQId; ?>/zahlen', function(data){

                var zahlen = JSON.parse(data);
                var bubble = jQuery('.menu-item--bewertungen .anzahl');
                bubble.html(zahlen.bewertungen.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.bewertungen.offen);

            });
        </script>
        <?php endif; ?>

        <?php if (in_array("dienstleister_u", $wpUser->roles)): ?>
        <script>
			jQuery.get('/api/v1/dienstleister/user/<?php echo $wpUserSTAQQId; ?>/berechtigungen', function(data){

				var id = JSON.parse(data).dienstleister_id;

				jQuery.get('/api/v1/dienstleister/'+id, function(data2){

					var user = JSON.parse(data2);
					var bubble = jQuery('.header__zahlen--joborders #anzahl_joborders');
					bubble.html(user.anzahl_joborders);

				});
			});

            jQuery.get('/api/v1/dienstleister/user/<?php echo $wpUserSTAQQId; ?>/zahlen', function(data){

                var zahlen = JSON.parse(data);
                var bubble = jQuery('.menu-item--bewertungen .anzahl');
                bubble.html(zahlen.bewertungen.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.bewertungen.offen);

            });
        </script>
        <?php endif; ?>

        <?php if (in_array("kunde", $wpUser->roles)): ?>
        <script>
            jQuery.get('/api/v1/kunden/<?php echo $wpUserSTAQQId; ?>', function(data){

                var user = JSON.parse(data);
                var bubble = jQuery('.header__zahlen--joborders #anzahl_joborders');
                bubble.html(user.anzahl_joborders);

            });

            jQuery.get('/api/v1/kunden/<?php echo $wpUserSTAQQId; ?>/zahlen', function(data){

                var zahlen = JSON.parse(data);
                var bubble = jQuery('.menu-item--bewertungen .anzahl');
                bubble.html(zahlen.bewertungen.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.bewertungen.offen);

            });
        </script>
        <?php endif; ?>

        <?php if (in_array("kunde_u", $wpUser->roles)): ?>
        <script>
			jQuery.get('/api/v1/kunden/user/<?php echo $wpUserSTAQQId; ?>/berechtigungen', function(data){

				var id = JSON.parse(data).kunden_id;

				jQuery.get('/api/v1/kunden/'+id, function(data2){

					var user = JSON.parse(data2);
					var bubble = jQuery('.header__zahlen--joborders #anzahl_joborders');
					bubble.html(user.anzahl_joborders);

				});
			});

            jQuery.get('/api/v1/kunden/user/<?php echo $wpUserSTAQQId; ?>/zahlen', function(data){

                var zahlen = JSON.parse(data);
                var bubble = jQuery('.menu-item--bewertungen .anzahl');
                bubble.html(zahlen.bewertungen.offen);
                bubble.attr('class', 'anzahl');
                bubble.addClass('anzahl--'+zahlen.bewertungen.offen);

            });
        </script>
        <?php endif; ?>

        <audio id="notificationSound" src="<?php echo get_stylesheet_directory_uri(); ?>/audio/notification.mp3"></audio>
		<script>

			// Initial
			checkNotifications();
			setInterval(checkNotifications, 60 * 1000);

			jQuery('#notifications-true, #notifications-false').click(function(event){
				event.stopPropagation();
				jQuery('#notifications-popup').show();

				jQuery.ajax({
					url: '/api/v1/readNotifications/<?php echo "$wpUserRole/$wpUserSTAQQId"; ?>',
					type: 'PUT',
					success: function(result) {
						jQuery('#notifications-true').hide();
						jQuery('#notifications-false').show();
					}
				});
			});

			jQuery(window).click(function() {
				if (jQuery('#notifications-popup').is(":visible")){
					jQuery('#notifications-popup').hide();
				}
			});

			function checkNotifications(){

				jQuery.get('/api/v1/checkNotifications/<?php echo "$wpUserRole/$wpUserSTAQQId"; ?>', function(data){

					var data = JSON.parse(data);
					jQuery('#notifications-popup .notifications').html("");

					if (data.ungelesen.length > 0){

						jQuery('#notifications-true .bubble').text(data.ungelesen.length);
						jQuery('#notifications-true').show();
						jQuery('#notifications-false').hide();

						for (var i=0;i<data.ungelesen.length;i++){
							jQuery('#notifications-popup .notifications').append('<a href="javascript:location.href=\''+data.ungelesen[i].link_web+'\'" class="notification"><h4>'+data.ungelesen[i].titel+'</h4><p>'+data.ungelesen[i].nachricht+'</p></a>');
						}

						document.getElementById('notificationSound').play();

					}else{
						jQuery('#notifications-popup .notifications').html('<div class="notification"><p>Keine neuen Benachrichtigungen vorhanden!</p></div>');
						jQuery('#notifications-true').hide();
						jQuery('#notifications-false').show();
					}

					for (var i=0;i<data.gelesen.length;i++){
						jQuery('#notifications-popup .notifications').append('<a href="javascript:location.href=\''+data.gelesen[i].link_web+'\'" class="notification notification--read"><h4>'+data.gelesen[i].titel+'</h4><p>'+data.gelesen[i].nachricht+'</p></a>');
					}

				});
			}

		</script>

      	<?php } ?>

        <script src="https://use.typekit.net/xzr6phw.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>

        <!-- Google Analytics -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-XXXXX-Y', 'auto');
		ga('send', 'pageview');
		</script>
		<!-- End Google Analytics -->

    </body>
</html>
