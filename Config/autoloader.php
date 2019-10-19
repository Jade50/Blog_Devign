<?php

    function loadClass($className){

        if (file_exists('Entities/'.$className.'.php')) {
            require_once('Entities/'.$className.'.php');
        }
    }

    spl_autoload_register('loadClass');

    function loadModels($modelName){

        if (file_exists('Models/'.$modelName.'.php')) {
            require_once('Models/'.$modelName.'.php');
        }
    }

    spl_autoload_register('loadModels');


    function loadControllers($controllerName){

        if (file_exists('Controllers/'.$controllerName.'.php')) {
            require_once('Controllers/'.$controllerName.'.php');
        }
    }

    spl_autoload_register('loadControllers');

?>