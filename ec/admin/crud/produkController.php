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
    $dataProduk = [
        'id' => 'PRD-' . time(),
        'nama_produk' => $_POST['nama_produk'],
        'tipe' => $_POST['tipe'],
        'deskripsi' => $_POST['deskripsi'],
        'stok' => $_POST['stok'],
        'harga' => $_POST['harga']
    ];

    $komposisi = json_decode($_POST['komposisi']);

    $targetDir = __DIR__ . "/../../../asset/image/produk/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uploadedImages = [];
    if (!empty($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $cleanFileName = time() . "_" . str_replace(' ', '_', $_FILES['images']['name'][$key]);
            $targetFile = $targetDir . $cleanFileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $uploadedImages[] = $cleanFileName;
            }
        }
    }

    $produk = new Produk($conn);
    error_log("Jumlah gambar terupload: " . count($uploadedImages));

    $result = $produk->storeComplex($dataProduk, $komposisi, $uploadedImages);

    echo json_encode($result);
} else if ($action === 'update') {
    $id = $_POST['id'] ?? null;

    if (!$id) {
        echo json_encode([
            "status" => false,
            "message" => "ID tidak ditemukan"
        ]);
        exit;
    }

    $data = [
        "id" => $id,
        "nama_produk" => $_POST['nama_produk'],
        "tipe" => $_POST['tipe'],
        "harga" => $_POST['harga'],
        "stok" => $_POST['stok'],
        "deskripsi" => $_POST['deskripsi'],
        "komposisi" => json_decode($_POST['komposisi'], true),
        "oldImages" => json_decode($_POST['oldImages'], true)
    ];

    $result = $produk->updateProduk($data, $_FILES);

    echo json_encode($result);
} else if ($action === 'delete') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode([
            "status" => false,
            "message" => "ID tidak ditemukan"
        ]);
        exit;
    }

    $result = $produk->deleteProduk($id);

    echo json_encode($result);
} else if ($action === 'get_detail') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        $data = $produk->getProdukDetail($id);

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode([
            "error" => "ID tidak ditemukan"
        ]);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;
