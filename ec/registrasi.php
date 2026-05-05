<link rel="stylesheet" href="style/costumer/loginRegist.css">
<div class="container right-panel-active" id="container">
	<div class="form-container sign-up-container">
		<form action="proses_register.php" method="POST">
			<h1>Sign Up</h1>

			<input type="text" name="nama" placeholder="Name" required />
			<input type="email" name="email" placeholder="Email" required />
            <input type="text" name="hp" placeholder="Phone Number" required />
			<input type="password" name="password" placeholder="Password" required />
            <input type="password" name="confirm_password" placeholder="Confirm Password" required />

			<button type="submit">Buat Akun</button>
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