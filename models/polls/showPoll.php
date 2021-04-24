<?php

header("Content-Type: application/json");

if (isset($_POST['send'])) {
    require_once "../../config/connection.php";
    require_once "functions.php";

    $id = $_POST['id'];

    $code = 404;
    $data = null;

    try {
        $data = getResultOfSinglePoll($id);
        $code = 200;
    } catch(PDOException $ex) {
        $code = 500;
        echo $ex->getMessage();
    }
}

echo json_encode($data);
http_response_code($code);