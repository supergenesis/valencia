<?php

namespace VALENCIA;

require_once(__DIR__ . "/../config.php");

class ConfigClass {
    public $dbServer;
    public $dbName;
    public $dbUser;
    public $dbPass;
    public $dbTablePrefix;

    function __construct() {
        global $dbServer;
        global $dbName;
        global $dbUser;
        global $dbPass;
        global $dbTablePrefix;

        $this->dbServer = $dbServer;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbTablePrefix = $dbTablePrefix;
    }
}

class DatabaseClass {
    public $dbServer;
    public $dbName;
    public $dbUser;
    public $dbPass;
    public $dbTablePrefix;

    function __construct( $connectParam = NULL ) {
        if($connectParam !== NULL) {
            $this->dbServer = $connectParam[0];
            $this->dbName = $connectParam[1];
            $this->dbUser = $connectParam[2];
            $this->dbPass = $connectParam[3];
            $this->dbTablePrefix = $connectParam[4];
            $this->connect();
        }
    }
    
    function connect() {
        echo "connect to " . $this->dbServer . "<br />";
    }
}

class CoreClass {
    public $config;
    public $db;

    public function __construct() {
        $this->config = new ConfigClass();

        $this->db = new DatabaseClass(array($this->config->dbServer,$this->config->dbName,$this->config->dbUser,$this->config->dbPass,$this->config->dbTablePrefix));
        //$this->db = new DatabaseClass();

    }

}


?>
