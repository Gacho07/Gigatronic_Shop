<?php

use PHPMailer\PHPMailer\PHPMailer;
session_start();

if (isset($_POST['btnSendMessage'])) {
    require "../assets/vendor/PHPMailer/src/PHPMailer.php";
    require "../assets/vendor/PHPMailer/src/SMTP.php";
    require "../assets/vendor/PHPMailer/src/Exception.php";

    $firstName = $_POST['firstNameContact'];
    $visitor_email = $_POST['formEmail'];
    $message = $_POST['contentContact'];

    $errors = [];

    $reFirstName = "/^[A-Z][a-z]{2,14}$/";
    $reMessage = "/^[\w\d\s\.\+\,]{1,255}$/";

    if (!preg_match($reFirstName, $firstName)) {
        array_push($errors, "First name is not in good format.");
    }
    if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Your email is not in good format.");
    }
    if (!preg_match($reMessage, $message)) {
        array_push($errors, "Message must contain only letters, numbers and whitespace");
    }

    if (count($errors) > 0) {
        $_SESSION['contactErrors'] = $errors;
        header("Location: ../index.php?page=contact");
    } else {
        try {
            # create an instance of PHPMailer
            $mail = new PHPMailer(true);
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            # enable SMTP
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            # set a host
            $mail->Host = "smtp.gmail.com";
            # set authentication to true
            $mail->SMTPAuth = true;
            # set login details for Gmail account
            $mail->Username = "auditorne.php@gmail.com";
            $mail->Password = "Sifra123";
            # set type of protection
            $mail->SMTPSecure = 'tls';
            # set a port
            $mail->Port = 587;
            # set who is sending email
            $mail->setFrom($visitor_email, $firstName);
            # set where we are sending email
            $mail->addAddress("marko.gacanovic.38.17@ict.edu.rs", "Marko Gacanovic");
            $mail->isHTML(true);
            # set subject
            $mail->Subject = "New Form submission.";
            # set body
            $mail->Body = "You have received a new message from the user $firstName.\n" . "Here is the message:\n $message " . $to = "marko.gacanovic.38.17@ict.edu.rs";
            # send an email
            $mail->send();
            header("Location: ../thanks.html");
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
} else {
    echo "Yoou need to submit the form!";
}
