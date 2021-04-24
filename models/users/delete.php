<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    require_once "../../config/connection.php";

    $prepare = $conn->prepare("DELETE FROM user WHERE idUser = :id");

    $prepare->bindParam(":id", $id);
    $prepare->execute();

    header("Location: ../../index.php?page=adminUsers");
}