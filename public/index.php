
<?php
    require_once(__DIR__ . "/../loader.php");

    $uri = substr($_SERVER['REQUEST_URI'], 1);
    $target = $valencia->db->getsingle("SELECT target FROM `valencia_routes` WHERE uri='" . $uri . "'");
    if( file_exists($target) ) {
        include_once($target);
    } else {
        echo $uri . " does not exist";
    }

?> 

