<?php

require_once "../config/connection.php";

header("Content-Type: application/json");

$code = 404;
$data = null;

if (isset($_POST['send'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $errors = [];

    $reFirstLastName = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,15}$/";
    $reUsername = "/^[a-zšđčćž0-9\_]{4,15}$/";
    $rePassword = "/^[A-z0-9]{6,20}$/";
    
    if (!preg_match($reFirstLastName, $firstName)) {
        array_push($errors, "Fist Name field isn't proprely filled!");
    } elseif(!$firstName) {
        array_push($errors, "First Name is required!");
    }
    if (!preg_match($reFirstLastName, $lastName)) {
        array_push($errors, "Last Name field isn't proprely filled!");
    } elseif (!$lastName) {
        array_push($errors, "Last Name is required!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't in good format!");
    }
    if (!preg_match($reUsername, $username)) {
        array_push($errors, "Username field isn't proprely filled!");
    } elseif (!$username) {
        array_push($errors, "Username is required!");
    }
    if (!preg_match($rePassword, $_POST['password'])) {
        array_push($errors, "Password field isn't proprely filled!");
    } elseif (!$_POST['password']) {
        array_push($errors, "Password is required!");
    }

    if (count($errors)) {
        $code = 422;
        $data = $errors;
    } else {
        $queryRegisterUser = "INSERT INTO user (first_name, last_name, email, username, password, active, idRole) VALUES (:firstName, :lastName, :email, :username, :password, 1, 2)";

        $stmt = $conn->prepare($queryRegisterUser);
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);

        try {
            $code = $stmt->execute() ? 201 : 500;
        } catch(PDOException $ex) {
            echo "Registration failed: " . $ex->getMessage();
        }
    }
}

http_response_code($code);
echo json_encode($data);