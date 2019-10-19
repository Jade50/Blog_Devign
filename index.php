<?php

    session_start();
    
    require_once('Config/ini.php');
    require_once('Config/App.php');
    require_once('Config/autoloader.php');

    if (!empty($_POST)) {
        $app = new AppController($_POST);
     
    } else {
        $app = new AppController();
    }

?>
