<?php

function getAllArticlesFeatured() {
    return executeQuery("SELECT * FROM article ORDER BY price DESC LIMIT 0,4");
}

function getAllArticlesWithPagination() {
    $page = ($_POST['id'] - 1) * 4;
    return executeQuery("SELECT * FROM article LIMIT $page, 4");
}

function getNumberOfArticles() {
    global $conn;
    return $conn->query("SELECT COUNT(*) AS numOfArticles FROM article")->fetch();
}

function getArticlesPerCategory($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) AS numOfArticles FROM article WHERE idCategory = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getArticlesBySearchValue($text) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM article WHERE name LIKE LOWER(?)");
    $stmt->execute([$text]);
    return $stmt->fetchAll();
}

function getAllArticles() {
    return executeQuery("SELECT a.*, c.name AS categoryName FROM article a INNER JOIN category c ON a.idCategory = c.idCategory");
}

function getOneArticle($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM article WHERE idArticle = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
}