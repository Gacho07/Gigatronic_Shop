<?php

$serverName = "localhost";
$dbName = "gigatronic_shop";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Error with database: " . $ex->getMessage();
}

function executeQuery($query) {
    global $conn;
    $result = $conn->query($query)->fetchAll();
    return $result;
}