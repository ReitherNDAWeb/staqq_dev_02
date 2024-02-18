<?php

    require 'vendor/autoload.php';
    require '../config.php';

    error_reporting (0);
    ini_set('display_errors', 'Off');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

    global $null;
    $null = null;

    $app = new \Slim\App();

    require_once 'functions.php';
    require_once 'parts/auth/signup.php';
    require_once 'parts/auth/signin.php';
    require_once 'parts/auth/agb.php';
    require_once 'parts/users/ressources.php';
    require_once 'parts/users/dienstleister.php';
    require_once 'parts/users/kunden.php';
    require_once 'parts/users/dienstleister_user.php';
    require_once 'parts/users/kunden_user.php';
    require_once 'parts/users/bewertungen.php';
    require_once 'parts/users/wordpress.php';
    require_once 'parts/berufe/berufsfelder.php';
    require_once 'parts/berufe/berufsgruppen.php';
    require_once 'parts/berufe/berufsbezeichnungen.php';
    require_once 'parts/berufe/berufe.php';
    require_once 'parts/berufe/beschaeftigungsausmasse.php';
    require_once 'parts/berufe/beschaeftigungsarten.php';
    require_once 'parts/location/bundeslaender.php';
    require_once 'parts/location/bezirke.php';
    require_once 'parts/location/filialen.php';
    require_once 'parts/location/arbeitsstaetten.php';
    require_once 'parts/skills/items.php';
    require_once 'parts/skills/kategorien.php';
    require_once 'parts/jobs/joborders.php';
    require_once 'parts/jobs/templates.php';
    require_once 'parts/jobs/bewerbungen.php';
    require_once 'parts/jobs/gemerkt.php';
    require_once 'parts/jobs/abgelehnt.php';
    require_once 'parts/jobs/castings.php';
    require_once 'parts/notifications/notifications.php';
    require_once 'parts/test.php';

    $app->run();