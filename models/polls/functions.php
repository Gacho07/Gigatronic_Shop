<?php

function getAllPolls()
{
    return executeQuery("SELECT * FROM poll");
}

function getActivePoll()
{
    global $conn;
    return $conn->query("SELECT * FROM poll WHERE active = 1")->fetch();
}

function getActivePollAnswers()
{
    return executeQuery("SELECT * FROM poll p INNER JOIN answer a ON p.idPoll = a.idPoll WHERE p.active = 1");
}

function ifVoted($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM poll p INNER JOIN answer a ON p.idPoll = a.idPoll INNER JOIN voting v ON a.idAnswer = v.idAnswer WHERE p.active = 1 AND v.idUser = ?");
    $stmt->execute([$id]);
    return $stmt;
}

function voting($idAnswer, $idUser)
{
    global $conn;
    $vote = $conn->prepare("INSERT INTO voting(idAnswer, idUser) VALUES(?,?)");
    return $vote->execute([$idAnswer, $idUser]);
}
 
function getResultOfSinglePoll($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT a.answer, COUNT(v.idAnswer) AS num FROM answer a LEFT OUTER JOIN voting v ON a.idAnswer = v.idAnswer WHERE a.idPoll = ? GROUP BY a.answer");
    $stmt->execute([$id]);
    return $stmt->fetchAll();
}