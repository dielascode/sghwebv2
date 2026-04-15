
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../style/costumer/registrasiStyles.css">
</head>
<body>

<div class="container">
    <div class="left">
        <h2>SIGN UP</h2>

        <form method="POST" action="">
            <label>Nama Lengkap :</label>
            <input type="text" name="nama" required>

            <label>Email :</label>
            <input type="text" name="email"
            <span class="error">

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

            <p>Sudah punya akun? <a href="login.php">Log In</a></p>
        </form>
    </div>

    <div class="right">
        <h2>Bergabung Bersama Kami</h2>
        <p>Lengkapi formulir pendaftaran untuk mulai menggunakan layanan dan mengelola aktivitas Anda dengan mudah.</p>
    </div>
</div>

</body>
</html>
