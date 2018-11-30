
<?php
    require_once "../model/loader.php";
    print_r($_SERVER['REQUEST_URI']);

    include_once "app/home.php";

    echo $valencia->config->dbserver;

?>