<?php 
session_name('sghwebv2_session');
session_start(); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/costumer/loginRegist.css">
    <title>Lupa Password</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="logic/class/handleforgetPassword.php">
                <h1>Lupa Password</h1>

                <?php if (isset($_SESSION['error'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                <?php endif; ?>

                <input type="email" name="email" placeholder="Masukkan Email Anda" required />

                <button type="submit" name="reset">Kirim Tautan Setel Ulang</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Ingat Password?</h1>
                    <p>Kembali ke halaman login untuk masuk ke akun Anda.</p>
                    <a href="./login.php"><button class="ghost" id="signIn">Login</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>