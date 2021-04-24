<?php

session_start();

if (isset($_POST['btnUpdateProduct'])) {
    require_once "../../config/connection.php";

    $id = $_POST['hiddenProductID'];
    $name = $_POST['productName'];
    $description = $_POST['taDescription'];
    $price = $_POST['productPrice'];
    $file = $_FILES['productImage'];
    $alt = $_POST['productAlt'];
    $category = $_POST['ddlCategory'];

    $errors = [];

    $reName = "/^[A-z\d\-\_]+(\s[A-z\d\-\_]+)*$/";
    $reDescription = "/^[\w\d\s\-\.\,]{1,255}$/";
    $rePrice = "/^(\d+)$/";
    
    if (!preg_match($reName, $name)) {
        array_push($errors, "Name of article is not in good format.");
    }
    if (!preg_match($reDescription, $description)) {
        array_push($errors, "Description only contains letters, numbers and whitespace");
    }
    if (!preg_match($rePrice, $price)) {
        array_push($errors, "Price is not in good format.");
    }
    if (!preg_match($reName, $alt)) {
        array_push($errors, "Alt attribute is not in good format.");
    }
    if ($category == '0') {
        array_push($errors, "You must choose category.");
    }

    if ($file['name'] == '') {
        if (count($errors) > 0) {
            $_SESSION['errorUpdate'] = $errors;
            header("Location: ../../index.php?page=adminProducts");
        } else {
            $queryUpdate = "UPDATE article SET name=:name, description=:description, price=:price, alt=:alt, idCategory=:idCategory WHERE idArticle=:idArticle";

            $stmt = $conn->prepare($queryUpdate);
            $stmt->bindParam(":idArticle", $id);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":alt", $alt);
            $stmt->bindParam(":idCategory", $category);

            if ($stmt->execute()) {
                $_SESSION['errorUpdate'] = "Article is successfully updated.";
            } else {
                $_SESSION['errorUpdate'] = "Error, article is not updated.";
            }

            header("Location: ../../index.php?page=adminProducts");
        }
    } else {
        $allowedFormats = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

        $fileName = $file["name"];
        $tmpName = $file["tmp_name"];
        $fileType = $file["type"];
        $fileSize = $file["size"];

        $path = "../../assets/img/shop/" . $fileName;
        $pathDatabase = "assets/img/shop/" . $fileName;
        $image = "../../" . $_POST["emptyImage"];
        unlink($image);

        if (!in_array($fileType, $allowedFormats)) {
            array_push($errors, "File type is not allowed.");
        }
        if ($fileSize > 2000000) {
            array_push($errors, "Max file size is 2MB");
        }

        if (count($errors) > 0) {
            $_SESSION['errorUpdate'] = $errors;
            header("Location: ../../index.php?page=adminProducts");
        } elseif(move_uploaded_file($tmpName, $path)) {
            $queryUpdate = "UPDATE article SET name=:name, description=:description, price=:price, image=:image, alt=:alt, idCategory=:idCategory WHERE idArticle=:idArticle";

            $stmt = $conn->prepare($queryUpdate);
            $stmt->bindParam(":idArticle", $id);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":image", $pathDatabase);
            $stmt->bindParam(":alt", $alt);
            $stmt->bindParam(":idCategory", $category);

            if ($stmt->execute()) {
                $_SESSION['errorUpdate'] = "Article is successfully updated.";
            } else {
                $_SESSION['errorUpdate'] = "Error, article is not updated.";
            }

            header("Location: ../../index.php?page=adminProducts");
        }
    }
}
