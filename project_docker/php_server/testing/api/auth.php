<?php

class Auth {

    private $conn;
    public function __construct() {

        // Include the connection file
        require_once __DIR__ . '/../config/connection.php';
        require_once __DIR__ . '/../functions/Utils.php';

        $this->conn = $conn;
    }



    public function login() {

        $us = RunQuery($this->conn, 'select * from user', []);

        
        return $_POST;


    }
}
