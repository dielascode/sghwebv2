<link rel="stylesheet" href="style/costumer/loginRegist.css">
<div class="container" id="container">
    <div class="form-container sign-in-container">
        <form action="proses_login.php" method="POST">
            <h1>Log In</h1>


            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <a class="forget-password" href="">Lupa Password?</a>
        
            <button type="submit">Masuk Sekarang</button>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Masuk ke Akun Anda</h1>
                <p>Silakan masuk menggunakan email dan kata sandi <br> yang telah terdaftar untuk melanjutkan. <br>Jika belum memiliki akun maka lakukan Sign Up dibawah.</p>
                <button class="ghost switch-btn" data-target="registrasi.php" data-mode="sign-up">
                    Sign Up
                </button>
            </div>
        </div>
    </div>
</div>

<script src="js/loginRegist.js"></script>