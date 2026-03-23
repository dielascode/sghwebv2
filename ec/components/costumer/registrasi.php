<?php
$emailErr = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

// Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Format email tidak valid!";
    } else {
        echo "<script>alert('Pendaftaran berhasil!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="regist.css">
</head>
<body>

<div class="container">
    <div class="left">
        <h2>SIGN UP</h2>

        <form method="POST" action="">
            <label>Nama Lengkap :</label>
            <input type="text" name="nama" required>

            <label>Email :</label>
            <input type="text" name="email" value="<?= $email ?>" required>
            <span class="error"><?= $emailErr ?></span>

            <label>No Hp :</label>
            <input type="text" name="hp" required>

            <label>Password :</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password :</label>
            <input type="password" name="konfirmasi" required>

            <div class="checkbox">
                <input type="checkbox" required>
                <span>Saya setuju dengan Syarat & Ketentuan</span>
            </div>

            <button type="submit">Daftar Sekarang</button>

            <p>Sudah punya akun? <a href="#">Log In</a></p>
        </form>
    </div>

    <div class="right">
        <h2>Bergabung Bersama Kami</h2>
        <p>Lengkapi formulir pendaftaran untuk mulai menggunakan layanan dan mengelola aktivitas Anda dengan mudah.</p>
    </div>
</div>

</body>
</html>
