<?php

session_start();
require_once __DIR__ . "/../../config/connection.php";

$id_detail = $_POST['id_detail'];
$qty = (int) $_POST['qty'];

$db = new Database();
$conn = $db->getConnection();

// ambil produk dari DB
$query = "SELECT 
    detail_produk.id AS id_detail,
    produk.nama_produk,
    produk.harga
FROM detail_produk
JOIN produk ON detail_produk.id_produk = produk.id
WHERE detail_produk.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_detail);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    echo "produk tidak ditemukan";
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id_detail])) {
    $_SESSION['cart'][$id_detail]['qty'] += $qty;
} else {
    $_SESSION['cart'][$id_detail] = [
        'id_detail' => $produk['id_detail'],
        'nama' => $produk['nama_produk'],
        'harga' => $produk['harga'],
        'qty' => $qty
    ];
}

echo "success";