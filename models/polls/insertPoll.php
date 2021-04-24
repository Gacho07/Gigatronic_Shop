<?php

header("Content-Type: application/json");

if (isset($_POST['send'])) {
    require_once "../../config/connection.php";

    $name = $_POST['name'];
    $answers = $_POST['answers'];

    $regOverall = "/^([\wŠĐŽĆČčćžšđ\d\.\?])+(\s[\wŠĐŽĆČčćžšđ\d\.\?]+)*$/";

    $code = 404;
    $data = null;
    $errors = [];

    if (!preg_match($regOverall, $name)) {
        $errors[] = "Question is not in good format.";
    }

    if (count($answers) < 1) {
        $errors[] = "Answer is not in good format.";
    } else {
        for ($i = 0; $i < count($answers); $i++) {
            if (!preg_match($regOverall, trim($answers[$i]))) {
                $answers[] = ($i + 1) . " answer is not in good format";
            }
        }
    }

    if (count($errors)) {
        $print = "";
        foreach ($errors as $error) {
            $print = $error . "<br/>";
        }
        $code = 422;
        $data = ["message" => $print];
    } else {
        try {
            $conn->beginTransaction();
            $poll = $conn->prepare("INSERT INTO poll(idPoll, question, active) VALUES (NULL, :name, 0)");
            $poll->bindParam(":name", $name);
            $poll->execute();

            $id = $conn->lastInsertId();
            $parameters = [];
            $values = [];

            foreach ($answers as $ans) {
                $parameters[] = "(?,?)";
                $values[] = $id;
                $values[] = $ans;
            }

            $query = $conn->prepare("INSERT INTO answer (idPoll, answer) VALUES" . implode(",", $parameters));
            $query->execute($values);

            $conn->commit();
            $data = ["message" => "Poll is successfully added."];
            $code = 201;
        } catch (PDOException $ex) {
            $conn->rollBack();
            $code = 500;
        }
    }
}

echo json_encode($data);
http_response_code($code);
