<?php

namespace VALENCIA;

class ConfigClass {
    public $dbserver = "localhost";
    public $dbname = "valencia";
    public $dbuser = "root";
    public $dbpass = "";
}

class DatabaseClass {
    public $name = "chris";
}

class CoreClass {
    public $config;
    public $db;

    public function __construct() {
        $this->config = new ConfigClass();
        $this->db = new DatabaseClass();
    }

}


?>
