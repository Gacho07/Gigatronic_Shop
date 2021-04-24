<?php
session_start();

if (isset($_POST['btnUpdateUser']) && $_SESSION['user']->roleName == 'admin') {
    require_once "../../config/connection.php";

    $idUser = $_POST['hiddenUserId'];
    $firstName = $_POST['tbFirstName'];
    $lastName = $_POST['tbLastName'];
    $email = $_POST['tbEmail'];
    $username = $_POST['tbUsername'];
    $password = $_POST['tbPassword'];
    $role = $_POST['ddlRole'];

    $dateForm = $_POST['dateRegistration'];
    $dateArray = explode("-", $dateForm);
    $timestamp = mktime(0, 0, 0, $dateArray[1], $dateArray[2], $dateArray[0]);
    $date = date("Y-m-d H:i:s", $timestamp);

    $active = isset($_POST['chbActive']) ? $_POST['chbActive'] : 0;

    $reFirstLastName = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,15}$/";
    $reUsername = "/^[a-zšđčćž0-9\_]{4,15}$/";
    $rePassword = "/^[A-z0-9]{6,20}$/";

    $errors = [];

    if (!preg_match($reFirstLastName, $firstName)) {
        array_push($errors, "First Name isn't in good format!");
    }
    if (!preg_match($reFirstLastName, $lastName)) {
        array_push($errors, "Last Name isn't in good format!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email isn't in good format!");
    }
    if (!preg_match($reUsername, $username)) {
        array_push($errors, "Username isn't in good format!");
    }
    if ($role == 0) {
        array_push($errors, "You didn't choose role!");
    }

    if (count($errors)) {
        $_SESSION['message'] = $errors;
        header("Location: ../../index.php?page=adminUsers");
    } else {
        if ($password == "") {
            $queryUpdateUser = "UPDATE user SET first_name = :firstName, last_name = :lastName, email = :email, username = :username, date_registration = :dateRegistration, active = :active, idRole = :idRole WHERE idUser = :id";

            $prepare = $conn->prepare($queryUpdateUser);
            $prepare->bindParam(":firstName", $firstName);
            $prepare->bindParam(":lastName", $lastName);
            $prepare->bindParam(":email", $email);
            $prepare->bindParam(":username", $username);
            $prepare->bindParam(":dateRegistration", $date);
            $prepare->bindParam(":active", $active);
            $prepare->bindParam(":idRole", $role);
            $prepare->bindParam(":id", $idUser);

            if ($prepare->execute()) {
                $_SESSION['message'] = "User successfully updated.";
                header("Location: ../../index.php?page=adminUsers");
            } else {
                $_SESSION['message'] = "Error, user isn't updated.";
                header("Location: ../../index.php?page=adminUsers&error");
            }
        } else {
            if (!preg_match($rePassword, $password)) {
                $_SESSION['message'] = "You didn't enter correctly all data, and check again password, please.";
            } else {
                $password = md5($password);
                $queryUpdateUser = "UPDATE user SET first_name = :firstName, last_name = :lastName, email = :email, username = :username, password = :password, date_registration = :dateRegistration, active = :active, idRole = :idRole WHERE idUser = :id";

                $prepare = $conn->prepare($queryUpdateUser);
                $prepare->bindParam(":firstName", $firstName);
                $prepare->bindParam(":lastName", $lastName);
                $prepare->bindParam(":email", $email);
                $prepare->bindParam(":username", $username);
                $prepare->bindParam(":password", $password);
                $prepare->bindParam(":dateRegistration", $date);
                $prepare->bindParam(":active", $active);
                $prepare->bindParam(":idRole", $role);
                $prepare->bindParam(":id", $idUser);

                if ($prepare->execute()) {
                    $_SESSION['message'] = "User successfully updated.";
                    header("Location: ../../index.php?page=adminUsers");
                } else {
                    $_SESSION['message'] = "Error, user isn't updated.";
                    header("Location: ../../index.php?page=adminUsers&error");
                }
            }
        }
    }
}
