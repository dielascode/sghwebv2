<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Contoh validasi sederhana (bisa diganti database)
    if ($email == "admin@gmail.com" && $password == "12345") {
        $_SESSION["user"] = $email;
        echo "<script>alert('Login berhasil!');</script>";
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">

    <!-- Bagian Kiri -->
    <div class="left">
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

            <span class="error"><?= $error ?></span>

            <button type="submit">Masuk Sekarang</button>

            <p class="signup">
                Belum punya akun? <a href="registrasi.php">Sign Up</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>