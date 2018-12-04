<?php
    require_once "vendor/autoload.php";
    require_once "app/model/main_model.php";

    /*
    $dir = "app/model/";
    foreach($file in scandir($dir)) {
        if($file[0] !== ".") {
            if(substr($file,0,6) == "model_") {
                require_once($dir . $file);
            }
        }
    }
    */

    $valencia = new VALENCIA\ValenciaClass();
?>
