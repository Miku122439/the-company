<?php

class Database{
    //add the properties
    //Difine properties for the database connection details
    private $server_name = "localhost";
    private $username = "root";
    private $password = "root";
    private $db_name = "the_company";
    
    // Protected connection property to be used by classes that extend Database
    protected $conn;

    //Create the method to connect to the database
    //Constructor method to create a datebase connection automatically
    public function __construct(){
        $this->conn = new mysqli($this->server_name,$this->username,$this->password,$this->db_name);

        if($this->conn->connect_error){
            die('Unable to connect to the database: ' .$this->conn->connect_error);
        }
    }
}
?>