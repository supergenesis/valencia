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

//**********
//*
//* This class is a Object Relational Mapper (ORM) for building datamodels
//*
//**********
class OrmondClass {
    public $applicationName;
    public $limitTablesByPrefix;

    public function __construct($applicationName, $limitTablesByPrefix = "") {
        $this->applicationName = $applicationName;
        $this->limitTablesByPrefix = $limitTablesByPrefix;
        $this->model();
    }

    public function model() {
        //make an objectmodel of the tables with a specific prefix
    }

}


//**********
//*
//* This class is the main wrapper for a users application
//*
//**********
class ApplicationClass {
    public $applicationName;
    public $limitTablesByPrefix;

    public $orm;

    public function __construct($applicationName) {
        //fill required variables
        $this->applicationName = $applicationName;
    }

    public function run() {
        //actually do something, after all variables have been set
        $this->orm = new OrmondClass($this->applicationName, $this->limitTablesByPrefix);
    }

}


//**********
//*
//* This class provides control over the Valencia platform
//*
//**********
class ValenciaClass {
    public $config;
    public $db;
    public $apps;

    public function __construct() {
        $this->config = new ConfigClass();

        $this->db = new DatabaseClass(array($this->config->dbServer,$this->config->dbName,$this->config->dbUser,$this->config->dbPass,$this->config->dbTablePrefix));
        //$this->db = new DatabaseClass();

        //create an array index for every application registered in the database
        $this->apps = array("valencia" => new ApplicationClass("valencia") );
        $name = "myApp";
        $newArray = array( $name => new ApplicationClass($name) );
        $this->apps = $this->apps + $newArray;
    }

}

?>