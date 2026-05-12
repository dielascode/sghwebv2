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
        $otp = rand(10000, 99999);

        // simpan ke session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expired'] = time() + 300; // 5 menit
        $_SESSION['data_register'] = $postData;

        $email = $postData['email'];
        
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
}
?>