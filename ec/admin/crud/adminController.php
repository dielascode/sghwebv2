<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/adminApi.php";

$db = new Database();
$conn = $db->getConnection(); //ngambil koneksi
$admin = new Admin($conn); //create objek

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'tambah') {

    if (
        !empty($_POST['nama']) &&
        !empty($_POST['username']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['nomor_telepon'])
    ) {

        $result = $admin->store($_POST); //kirim ke api function store
        echo json_encode($result);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Semua field wajib diisi'
        ]);
    }
} else if ($action === 'update') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $result = $admin->update($id, $_POST);
        echo json_encode($result);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'ID tidak ditemukan'
        ]);
    }
} else if ($action === 'toggle_status') {

    $id = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null;

    if ($id && $status) {
        $result = $admin->toggleStatus($id, $status);
        echo json_encode($result);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data tidak lengkap"
        ]);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;
