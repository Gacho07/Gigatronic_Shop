<?php

session_start();

if (isset($_POST['btnLogin'])) {
    require_once "../config/connection.php";

    $email = $_POST['tbEmail'];
    $password = $_POST['tbPassword'];

    $errors = [];

    $rePassword = "/^[A-z0-9]{6,20}$/";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not good!";
    }

    if (!preg_match($rePassword, $password)) {
        $errors[] = "Password is not good!";
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: ../index.php");
    } else {
        $queryLoginUser = "SELECT u.idUser, u.first_name, u.last_name, u.email, u.username, r.name AS roleName FROM user u INNER JOIN role r ON u.idRole = r.idRole WHERE email = :email AND password = :password";

        $stmt = $conn->prepare($queryLoginUser);

        $password = md5($password);

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user;
            if(isset($_SESSION['user']) && $_SESSION['user']->roleName=='admin'):
                header("Location: ../index.php?page=adminUsers");
            else:
                header("Location: ../index.php?page=home");
            endif;
        } else {
            $_SESSION['errors'] = "Wrong email or password!";
            header("Location: ../index.php");
        }
    }
}