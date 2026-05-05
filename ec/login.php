
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="style/costumer/loginStyles.css"> -->
    <link rel="stylesheet" href="style/costumer/loginStyles.css">

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>    

<div class="container">

    <!-- Bagian Kiri -->
    <div class="left">
        <img src="images/Tablet login-amico.png" alt="Login Image">
        <h2>Masuk ke Akun Anda</h2>
        <p>Silakan masuk menggunakan email dan kata sandi yang telah terdaftar untuk melanjutkan.</p>
    </div>

    <!-- Bagian Kanan -->
    <div class="right">
        <h2>LOG IN</h2>

        <form method="POST" action="">
            <label>Email :</label>
            <input type="text" name="email" required>

            <label>Password :</label>
            <input type="password" name="password" required>

            <p class="forgot">Lupa Password?</p>

            <span class="error"></span>

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