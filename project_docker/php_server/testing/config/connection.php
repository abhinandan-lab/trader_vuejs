<?php


$host = "db";
$db_name = "testdb";
$username = "abh";
$password = "abcd";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connection success";
    return $conn;
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    return null;
}







?>