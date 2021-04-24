<?php

if (isset($_POST['id'])) {
    header("Content-Type: application/json");
    require_once "../../config/connection.php";

    $id = $_POST['id'];
    
    $code = 404;
    $data = null;

    $queryGetUser = "SELECT * FROM user u INNER JOIN role r ON u.idRole = r.idRole WHERE u.idUser = :id";
    $prepare = $conn->prepare($queryGetUser);
    $prepare->bindParam(":id", $id);

    try {
        $prepare->execute();
        $user = $prepare->fetch();
        if ($user) {
            $data = $user;
            $code = 201;
        } else {
            $code = 500;
        }
    } catch(PDOException $ex) {
        $code = 500;
        $data = $ex->getMessage();
    }
}
http_response_code($code);
echo json_encode($data);