<?php
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjek = $_POST["subjek"];
    $pesan = $_POST["pesan"];
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $email = $_POST["email"];
    $alamat = $_POST["alamat"];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid!');</script>";
    } else {
        $success = "Pengaduan berhasil dikirim!";
        // Di sini bisa ditambahkan simpan ke database
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengaduan</title>
    <link rel="stylesheet" href="pengaduan.css">
</head>
<body>


<!-- CONTENT -->
<div class="container">
    <h2>Formulir Pengaduan</h2>
    <p class="subtitle">Berikan pendapat Anda dengan jujur tentang apa yang Anda pikirkan</p>
    <hr>

    <form method="POST">
        <label>Subjek</label>
        <input type="text" name="subjek" required>

        <label>Pesan Pengaduan</label>
        <textarea name="pesan" placeholder="Ketik disini...." required></textarea>

        <div class="row">
            <div class="col">
                <label>Nama Lengkap</label><br>
                <input type="text" name="nama" required>
            </div>
            <div class="col">
                <label>No Telepon</label><br>
                <input type="text" name="telp" required>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>E-mail</label><br>
                <input type="text" name="email" placeholder="contoh: xxx@contoh.com" required>
            </div>
            <div class="col">
                <label>Alamat</label><br>
                <input type="text" name="alamat" required>
            </div>
        </div>

        <button type="submit">KIRIM</button>

        <?php if($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
    </form>
</div>

</body>
</html>