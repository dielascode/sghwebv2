<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/produkApi.php";

$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'tambah') {
    // Ambil data teks
    $dataProduk = [
        'id' => 'PRD-' . time(), // Contoh generate ID
        'nama_produk' => $_POST['nama_produk'],
        'tipe' => $_POST['tipe'],
        'deskripsi' => $_POST['deskripsi'],
        'stok' => $_POST['stok'],
        'harga' => $_POST['harga']
    ];

    // Decode JSON komposisi dari Alpine.js
    $komposisi = json_decode($_POST['komposisi']);

    // Tentukan folder tujuan secara absolut
    $targetDir = __DIR__ . "/../assets/images/produk/";

    // Pastikan folder ada, kalau belum ada kita buat otomatis
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uploadedImages = [];
    if (!empty($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            // Hilangkan spasi di nama file supaya tidak error di URL
            $cleanFileName = time() . "_" . str_replace(' ', '_', $_FILES['images']['name'][$key]);
            $targetFile = $targetDir . $cleanFileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $uploadedImages[] = $cleanFileName;
            }
        }
    }

    // Panggil Model
    $produk = new Produk($conn);
    // Tambahkan ini buat ngetes jumlah gambar yang berhasil diupload ke folder
    error_log("Jumlah gambar terupload: " . count($uploadedImages));

    $result = $produk->storeComplex($dataProduk, $komposisi, $uploadedImages);

    echo json_encode($result);
} else if ($action === 'update') {
} else if ($action === 'delete') {
} else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;
