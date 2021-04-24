<?php
session_start();
define("FILE_SIZE", 3000000);

if (isset($_POST['btnUpload'])) {
    require_once "../../config/connection.php";

    $errors = [];

    $articleName = $_POST['articleName'];
    $description = $_POST['taDescription'];
    $price = $_POST['price'];
    $alt = $_POST['alt'];
    $category = $_POST['ddlCategory'];

    $reArticleName = "/^[\w\s\-\_\.]{1,255}$/";
    if (!preg_match($reArticleName, $articleName)) {
        array_push($errors, "Article name is not in good format.");
    }

    if ($description == '') {
        array_push($errors, "Description must be filled.");
    }

    $rePrice = "/^\d+(.\d+)?$/";
    if (!preg_match($rePrice, $price)) {
        array_push($errors, "Price is not in good format.");
    }

    if (!preg_match($reArticleName, $alt)) {
        array_push($errors, "Alt attribute is not in good format.");
    }

    if ($category == "0") {
        array_push($errors, "You must choose category.");
    }

    $file = $_FILES['imageFile'];
    $fileType = $file['type'];
    $fileSize = $file['size'];

    $allowedFormats = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    if (!in_array($fileType, $allowedFormats)) {
        array_push($errors, "File format is not image.");
    }

    if ($fileSize > FILE_SIZE) {
        array_push($errors, "Maximum allowed format is 3 MB");
    }

    if (count($errors) == 0) {
        $tmpPath = $file['tmp_name'];
        $fileName = $file['name']; // time() if we don't want to have upload at same time
        $newPath = "../../assets/img/shop/" . $fileName;
        $upload = move_uploaded_file($tmpPath, $newPath);

        if ($upload) {
            $queryInsertArticle = "INSERT INTO article (name, description, price, image, alt, idCategory) VALUES (:name, :description, :price, :image, :alt, :idCategory)";

            $stmt = $conn->prepare($queryInsertArticle);

            $stmt->bindParam(":name", $articleName);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":image", $newPath);
            $stmt->bindParam(":alt", $alt);
            $stmt->bindParam(":idCategory", $category);

            try {
                $stmt->execute();
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
            if ($stmt->rowCount()) {
                $_SESSION['msg'] = "Successfull upload.";
                header("Location: ../../index.php?page=adminInsertProduct");
            }
        } else {
            $_SESSION['msg'] = "Upload can't be done. Check database.";
            header("Location: ../../index.php?page=adminInsertProduct");
        }
    } else {
        $_SESSION['msg'] = $errors;
        header("Location: ../../index.php?page=adminInsertProduct");
    }
}
