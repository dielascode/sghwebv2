<?php

require_once __DIR__ . "/../config/database.php";
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


    if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("location: ../../../forgetPassword.php");
        exit();
    }

    // check if user exists
    $stmt =  $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {

        // generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));


        // store token in db
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);


        // create reset link
        $resetLink = "http://localhost/sghwebv2/ec/resetPassword.php?token=" . $token;

        // send email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'nextarchocolatepie@gmail.com';
            $mail->Password = 'kchlthstngifogkr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Timeout    = 15; // short timeout so it doesn't hang forever

            $mail->setFrom("nextarchocolatepie@gmail.com", "Reset Password");
            $mail->addAddress($email);

            // email content 
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body    = "<h1> Hello, </h1>
            <p>We received a request to reset your password. Click the link below to reset it:</p>
            <p><a href='{$resetLink}'>$resetLink</a></p>
            <p>This link will be expire in 1 hour.</p>";

            $mail->send();
            $_SESSION['success'] = "A reset Link has been send to your email.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
    }
    header("Location: ../../../forgetPassword.php");
    exit();
}
