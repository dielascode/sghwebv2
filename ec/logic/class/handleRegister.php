<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include __DIR__ . '/../../config/connection.php';

class RegisterHandler {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function handleRegistration($postData) {
        $email = trim($postData['email'] ?? '');
        $password = $postData['password'] ?? '';
        $confirmPassword = $postData['confirm_password'] ?? '';

        if (strlen($password) < 8) {
            echo "<script>alert('Password minimal 8 karakter'); window.history.back();</script>";
            return;
        }

        if ($password !== $confirmPassword) {
            echo "<script>alert('Password dan konfirmasi password tidak sama'); window.history.back();</script>";
            return;
        }

        if ($this->isEmailRegistered($email)) {
            echo "<script>alert('Email sudah terdaftar, tidak bisa daftar'); window.history.back();</script>";
            return;
        }

        $otp = rand(10000, 99999);

        // simpan ke session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expired'] = time() + 90; // 1.5 menit
        $_SESSION['data_register'] = $postData;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nextarchocolatepie@gmail.com'; // ganti
            $mail->Password = 'kchlthstngifogkr'; // wajib app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPDebug = 0;
            $mail->setFrom('nextarchocolatepie@gmail.com', 'OTP Register');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Kode OTP Registrasi';
            $mail->Body = "<h3>Kode OTP kamu: <b>$otp</b></h3>";

            $mail->send();

            echo "<script>alert('OTP dikirim ke email'); window.location='otpRegist.php';</script>";

        } catch (Exception $e) {
            echo "Gagal kirim OTP: {$mail->ErrorInfo}";
        }
    }

    private function isEmailRegistered($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($this->conn, $query);

        return $result && mysqli_num_rows($result) > 0;
    }
}
?>