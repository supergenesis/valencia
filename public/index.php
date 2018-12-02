
<?php
    require_once(__DIR__ . "/../loader.php");
    print_r($_SERVER['REQUEST_URI']);

    include_once("myApp/home.php");

    print_r($valencia->apps['valencia']->applicationName);

?> 