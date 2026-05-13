<?php

session_start();
include 'logic/class/handleRegister.php';

if (isset($_POST['register'])) {
    $registerHandler = new RegisterHandler();
    $registerHandler->handleRegistration($_POST);
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
				<h1>Mendaftar</h1>

				<input type="text" name="nama" placeholder="Nama" required />
				<input type="email" name="email" placeholder="Email" required />
				<input type="text" name="nomor_telepon" placeholder="Nomor Telepon" required />
				<input type="password" name="password" placeholder="Password" required />
				<input type="password" name="confirm_password" placeholder="Konfirmasi Password" required />

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