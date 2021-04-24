<?php

header("Content-Type: application/json");

$data = null;
$code = 404;

if (isset($_POST['send'])) {
    require_once "../../config/connection.php";

    $page = ($_POST['idPagination'] - 1) * 4;
    $idCategory = $_POST['idCategory'];

    $query = "SELECT * FROM article";

    if ($idCategory != '0') {
        $query .= " WHERE idCategory=:idCategory";
    }

    $query .= " LIMIT 4 OFFSET $page";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":idCategory", $idCategory);

    try {
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            $code = 200;
        } else {
            $code = 500;
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        $code = 500;
    }
}

echo json_encode($data);
http_response_code($code);