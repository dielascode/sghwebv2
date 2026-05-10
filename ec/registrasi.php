<?php

session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'config/connection.php';

$db = new Database();
$conn = $db->getConnection();



function generateID($conn) {
    $query = mysqli_query($conn, "SELECT id FROM users ORDER BY id DESC LIMIT 1");

    if (mysqli_num_rows($query) == 0) {
        return "USR001";
    }

    $data = mysqli_fetch_assoc($query);
    $last_id = $data['id']; // contoh: USR005

    $number = (int) substr($last_id, 3);
    $number++;

    $new_id = "USR" . str_pad($number, 3, "0", STR_PAD_LEFT);

    return $new_id;
}

if (isset($_POST['register'])) {

    $otp = rand(10000, 99999);

    // simpan ke session
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expired'] = time() + 300; // 5 menit
    $_SESSION['data_register'] = $_POST;

    $email = $_POST['email'];
	
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nextarchocolatepie@gmail.com'; // ganti
        $mail->Password = 'kchlthstngifogkr'; // wajib app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
		$mail->SMTPDebug = 2;
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
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style/costumer/loginRegist.css">
</head>
<body>
	<div class="container right-panel-active" id="container">
		<div class="form-container sign-up-container">
			<form method="POST">
				<h1>Sign Up</h1>

				<input type="text" name="nama" placeholder="Name" required />
				<input type="email" name="email" placeholder="Email" required />
				<input type="text" name="nomor_telepon" placeholder="Phone Number" required />
				<input type="password" name="password" placeholder="Password" required />
				<input type="password" name="confirm_password" placeholder="Confirm Password" required />

				<button type="submit" name="register">Buat Akun</button>
			</form>
		</div>

		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Bergabung Bersama Kami</h1>
					<p>Lengkapi formulir pendaftaran untuk mulai menggunakan layanan dan mengelola aktivitas Anda dengan mudah. Jika sudah memilki akun maka lanjutkan ke halaman Login dibawah.</p>
					<button class="ghost switch-btn" data-target="login.php" data-mode="sign-in">
						Login
					</button>
				</div>
			</div>
		</div>
	</div>

<script src="js/loginRegist.js"></script>
</body>
</html>