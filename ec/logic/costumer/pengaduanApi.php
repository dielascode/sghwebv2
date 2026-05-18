<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_name('sghwebv2_session');
                              session_start();

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->conn;

if (!isset($_SESSION['id'])) {
    die("SESSION USER TIDAK ADA");
}


$id_costumer = $_SESSION['id'];

if (isset($_POST['submit_pengaduan'])) {

    $subjek = trim($_POST['subjek'] ?? '');
    $pesan  = trim($_POST['pesan'] ?? '');

    if ($subjek == '' || $pesan == '') {
        die("Subjek / pesan kosong");
    }

    $sql = "INSERT INTO pengaduan
            (id_costumer, subjek, pesan, status)
            VALUES
            (?, ?, ?, 'diterima')";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare gagal: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $id_costumer,
        $subjek,
        $pesan
    );

    $query = mysqli_stmt_execute($stmt);

    if (!$query) {
        die("Gagal simpan: " . mysqli_stmt_error($stmt));
    }

    echo "
    <script>
        alert('Pengaduan berhasil dikirim');
        window.location.href='../../index.php';
    </script>
    ";
}
?>