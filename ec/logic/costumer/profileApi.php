<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_name('sghwebv2_session');
session_start();

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

/* =========================
   SESSION FIX
========================= */
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_SESSION['id'] ?? null;

// =========================
// AMBIL DATA FORM
// =========================
$username      = $_POST['username'] ?? '';
$nama          = $_POST['nama'] ?? '';
$email         = $_POST['email'] ?? '';
$no_telepon    = $_POST['nomor_telepon'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';

// =========================
// UPDATE USERS
// =========================
mysqli_query($conn, "
    UPDATE users SET
        username = '$username',
        nama = '$nama',
        email = '$email',
        nomor_telepon = '$no_telepon'
    WHERE id = '$id'
");

// =========================
// CEK COSTUMER
// =========================
$cek = mysqli_query($conn, "
    SELECT * FROM costumer
    WHERE id_costumer = '$id'
");

$data_costumer = mysqli_fetch_assoc($cek);

/* FOTO HARUS ADA INI (BIAR TIDAK ERROR) */
$foto_baru = null;

// =========================
// UPDATE / INSERT COSTUMER
// =========================
if ($data_costumer) {

    if ($foto_baru) {
        mysqli_query($conn, "
            UPDATE costumer SET
                jenis_kelamin = '$jenis_kelamin',
                foto_profil = '$foto_baru'
            WHERE id_costumer = '$id'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE costumer SET
            jenis_kelamin = '$jenis_kelamin'
            WHERE id_costumer = '$id'
        ");
    }

} else {

    mysqli_query($conn, "
        INSERT INTO costumer (
            id_costumer,
            jenis_kelamin,
            foto_profil
        ) VALUES (
            '$id',
            '$jenis_kelamin',
            '$foto_baru'
        )
    ");
}

// =========================
// REDIRECT
// =========================
$_SESSION['success'] = 'Perubahan berhasil disimpan!';
header("Location: ../../index.php?page=profile");
exit;