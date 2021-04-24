<?php

header("Content-Type: application/json");

require_once "../../config/connection.php";
require_once "functions.php";

$data = null;
$code = 404;

try {
    $data = getAllPolls();
    $code = 200;
} catch(PDOException $ex) {
    $code = 500;
    echo $ex->getMessage();
}

echo json_encode($data);
http_response_code($code);