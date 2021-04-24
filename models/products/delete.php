<?php

if (isset($_GET['id'])) {
    require_once "../../config/connection.php";
    $id = $_GET['id'];

    $prepare = $conn->prepare("DELETE FROM article WHERE idArticle = :id");
    $prepare->bindParam(":id", $id);
    $prepare->execute();

    header("Location: ../../index.php?page=adminProducts");
}