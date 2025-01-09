<?php
function getConnection() {
    $host = DB_HOST;
    $db_name = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        return null;
    }
}
?>
