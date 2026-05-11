<?php
session_start();
include 'logic/class/handleLogin.php';

if (isset($_POST['login'])) {
    $loginHandler = new LoginHandler();
    $loginHandler->handleLogin($_POST['email'], $_POST['password']);
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style/costumer/loginRegist.css">
    <title>Login</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST">
                <h1>Log In</h1>


                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <a class="forget-password" href="./forgetPassword.php">Lupa Password?</a>

                <button type="submit" name="login">Masuk Sekarang</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Masuk ke Akun Anda</h1>
                    <p>Silakan masuk menggunakan email dan kata sandi <br> yang telah terdaftar untuk melanjutkan.
                        <br>Jika belum memiliki akun maka lakukan Sign Up dibawah.</p>
                    <button class="ghost switch-btn" data-target="registrasi.php" data-mode="sign-up">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>
        <script src="js/loginRegist.js"></script>
</body>

</html>