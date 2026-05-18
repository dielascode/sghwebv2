<?php

session_name('sghwebv2_session');
session_start();
include __DIR__ . '/../../config/connection.php';

require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = new Database();
$conn = $db->conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
        header("Location: ../../forgetPassword.php");
        exit();
    }

    // check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // store token in db
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

        // create reset link
        $resetLink = "http://localhost/sghwebv2/ec/resetPassword.php?token=" . $token;

        // send email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nextarchocolatepie@gmail.com';
            $mail->Password = 'kchlthstngifogkr';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPDebug = 0;
            $mail->Timeout = 15; // short timeout so it doesn't hang forever

            $mail->setFrom("nextarchocolatepie@gmail.com", "Ubah Password");
            $mail->addAddress($email);

            // email content
            $mail->isHTML(true);
            $mail->Subject = "Permintaan Reset Kata Sandi";
            $mail->Body = "<h1>Halo,</h1>
            <p>We Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tautan di bawah ini untuk mengatur ulang kata sandi Anda.:</p>
            <p><a href='{$resetLink}'>$resetLink</a></p>
            <p>Tautan ini akan kedaluwarsa dalam 10 menit.</p>";

            $mail->send();
            $_SESSION['success'] = "Tautan untuk mengatur ulang telah dikirim ke email Anda.";
            header("Location: ../../dummyforgetPassword.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Email tidak dapat dikirim. Terjadi kesalahan.: {$mail->ErrorInfo}";
            header("Location: ../../forgetPassword.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Tidak ditemukan akun dengan email tersebut.";
        header("Location: ../../forgetPassword.php");
        exit();
    }
}
