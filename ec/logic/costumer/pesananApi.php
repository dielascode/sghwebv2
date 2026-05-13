<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // ← fix ini
require_once "../../config/connection.php";
require_once "../../logic/costumer/Apipesanan.php";

header('Content-Type: application/json');

/* =========================
   DB CONNECTION
========================= */
$db = new Database();
$conn = $db->getConnection();

/* =========================
   INIT CLASS
========================= */
$pesanan = new PesananApi($conn);

/* =========================
   CEK LOGIN
========================= */
$id_costumer = $_SESSION['id'] ?? null;

if (!$id_costumer) {
    echo json_encode([]);
    exit;
}

/* =========================
   STATUS
========================= */
$status = $_GET['status'] ?? 'diproses';

/* =========================
   GET PESANAN
========================= */
$result = $pesanan->getByStatus($id_costumer, $status);

$data = [];

while ($p = $result->fetch_assoc()) {

    $nomor = $p['nomor_pesanan'];

    /* DETAIL */
    $detail = $pesanan->getDetail($nomor);

    $total = 0;
    $qty = 0;
    $first = null;

    while ($d = $detail->fetch_assoc()) {
        $total += $d['harga_produk'] * $d['kuantitas'];
        $qty += $d['kuantitas'];

        if (!$first) {
            $first = $d;
        }
    }

    $data[] = [
        "nomor_pesanan" => $nomor,
        "status" => $p['status'],
        "total" => $total,
        "qty" => $qty,
        "nama_produk" => $first['nama_produk'] ?? "-",
        "foto" => $first['foto_produk'] ?? "default.png"
    ];
}


echo json_encode($data);
