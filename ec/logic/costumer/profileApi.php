<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// =========================
// AMBIL DATA FORM
// =========================
$username      = $_POST['username'] ?? '';
$nama          = $_POST['nama'] ?? '';
$email         = $_POST['email'] ?? '';
$no_telepon    = $_POST['nomor_telepon'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';

// =========================
// UPDATE USERS (AMAN)
// =========================
mysqli_query($conn, "
    UPDATE users SET
        username = '$username',
        nama = '$nama',
        email = '$email',
        nomor_telepon = '$no_telepon'
    WHERE id = '$id_user'
");

// =========================
// CEK COSTUMER
// =========================
$cek = mysqli_query($conn, "SELECT * FROM costumer WHERE id_costumer = '$id_user'");
$data_costumer = mysqli_fetch_assoc($cek);



// =========================
// UPDATE / INSERT COSTUMER
// =========================
if ($data_costumer) {

    // kalau tidak upload foto → JANGAN overwrite foto_profil
    if ($foto_baru) {
        mysqli_query($conn, "
            UPDATE costumer SET
                jenis_kelamin = '$jenis_kelamin',
                foto_profil = '$foto_baru'
            WHERE id_costumer = '$id_user'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE costumer SET
                jenis_kelamin = '$jenis_kelamin'
            WHERE id_costumer = '$id_user'
        ");
    }

} else {

    mysqli_query($conn, "
        INSERT INTO costumer (
            id_costumer,
            jenis_kelamin,
            foto_profil
        ) VALUES (
            '$id_user',
            '$jenis_kelamin',
            '$foto_baru'
        )
    ");
}

// =========================
// REDIRECT
// =========================
header("Location: ../../index.php?page=profile");
exit;