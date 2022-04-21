<?php

    error_reporting(E_ALL);
    ini_set('ignore_repeated_errors', TRUE);
    ini_set('display_errors', FALSE);
    ini_set('log_errors', TRUE);
    ini_set('error_log', 'php-error.log');

    require_once 'libs/Connection.php';
    require_once 'classes/success_messages.php';
    require_once 'classes/error_messages.php';
    require_once 'libs/Controller.php';
    require_once 'libs/model.php';
    require_once 'libs/view.php';
    require_once 'classes/sessionController.php';
    require_once 'libs/app.php';
    
    require_once 'config/Database.php';


    $app = new App();

?>