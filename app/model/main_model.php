<?php

namespace VALENCIA;

use Mysqli;

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

    //config variables
    public $dbServer;
    public $dbName;
    public $dbUser;
    public $dbPass;
    public $dbTablePrefix;

    public $mysqli;
    public $result;

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

    function __destruct() {
        $this->mysqli->close();
    }
    
    public function connect() {
        $this->mysqli = new mysqli($this->dbServer, $this->dbUser, $this->dbPass, $this->dbName);
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        } 
    }

    public function runsql($sql) {
        if( $this->result = $this->mysqli->query($sql) ) {
            return $this->result;
        } else {
            die("shit");
        }
    }

    public function getsingle($sql) {
        if( $this->result = $this->mysqli->query($sql) ) {
            if($this->result->num_rows > 0) {
                $row = $this->result->fetch_row();
                return $row[0];
            } else {
                return false;
            }
        } else {    
            return false;
        }
    }

}

//**********
//*
//* This class interprets application files
//*
//**********
class InterlakenClass {
    public $applicationName;
    public $limitTablesByPrefix;
    public $vars = array();
    public $output = array();

    public function __construct() {
        //nothing?
    }

    private function transpose($src) {
        $a = preg_split("/[^A-Za-z0-9_$]/", $src);
        foreach($a as $b) {
            if(substr($b,0,1) == "$") {
                $src = str_replace($b, $this->vars[$b], $src);
            }
        }
        return $src;
    }

    private function arithmics($src) {
        
        return $src;
    }

    private function interpret($lines) {
        //if cansolve then solve else call new interpret
        foreach($lines as $line) {
            if(substr($line, 0, 2) == "{{") {
                $line = trim(str_replace(";", "", substr($line, 2, -2)));
                if($line[0] == "$") {
                    $line = "set " . $line;
                }
                $instruction = substr($line, 0, stripos($line, " "));
                $parameters = substr($line, stripos($line, " "));
                switch($instruction) {
                    case "set":
                        $a = explode("=", $parameters);
                        $a[0] = trim($a[0]);
                        $a[1] = trim($a[1]);
                        $a[1] = $this->transpose($a[1]); //fill in the vars
                        $a[1] = $this->arithmics($a[1]); //calculate +*-/|&
                        $this->vars[$a[0]] = $a[1];
                        break;
                    case "print":
                        break;
                    case "if":
                        break;
                    case "endif":
                        break;
                    case "for":
                        break;
                    case "endfor":
                        break;
                }
            } else {
                array_push($this->output, $line);
            }
        }
        
    }

    public function show($page) {

        $file = file_get_contents($page);
        $lines = array('');
        $intag = false;
        for($i=0; $i<=strlen($file); $i++) {
            if(substr($file, $i, 2) == "{{") {
                $intag = true;
                array_push($lines, '');
            }
            $lines[count($lines)-1] .= substr($file, $i, 1);
            if($intag and substr($file, $i, 1) == ";") {
                $lines[count($lines)-1] .= "}}";
                array_push($lines, '{{');
            }
            if($intag and substr($file, $i-1, 2) == "}}") {
                $intag = false;
                array_push($lines, '');
            }
        }
        
        $this->interpret($lines);

        /*
        $handle = fopen($page, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                
                if(stripos($line, "{{") and stripos($line, "}}")) {

                    while(stripos($line, "{{")) {
                        $endpos = stripos($line, "}}") + 2;
                        for($i=0; $i<$endpos; $i++) {
                            if(substr($line, $i, 2) == "{{") 
                                $startpos = $i;
                        }
                        $fullterm = substr($line, $startpos, $endpos - $startpos);
                        $term = trim(substr($fullterm, 2, -2));
                        $aterm = explode(" ", $term);
                        
                        //split after ';'
                        //split ' '
                        //first element is command, use switch

                        $line = str_replace($fullterm, implode("-",$aterm), $line);
                    }

                } 

                echo $line;
                
            }
            fclose($handle);
        } else {
            die("file '" . $page . "' does not exists or cannot be opened");
        } 
        */
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
    public $interpret;

    public function __construct() {
        $this->config = new ConfigClass();
        $this->interpret = new InterlakenClass();

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
