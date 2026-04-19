
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
        <img src="http://localhost/semester%202/proyek%20SGH/sghwebv2/ec/images/Tablet%20login-amico.png" alt="Login Image">
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

            <p class="signup">
                Belum punya akun? <a href="registrasi.php">Sign Up</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>