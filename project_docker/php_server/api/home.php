<?php

class Home {

    private $conn;
    public function __construct() {

        // Include the connection file
        require_once __DIR__ . '/../config/connection.php';
        require_once __DIR__ . '/../functions/Utils.php';

        $this->conn = $conn;
    }



    public function welcome() {

        $us = RunQuery($this->conn, 'select * from user', []);

        // var_dump($us);
        return $us;


    }
}
