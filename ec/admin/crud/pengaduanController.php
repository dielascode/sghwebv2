<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/pengaduanApi.php";

$db = new Database();
$conn = $db->getConnection();
$pengaduan = new Pengaduan($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'get_detail') {
    $id = $_GET['id'];

    if ($id) {
        $data = $pengaduan->getDetailPengaduan($id);

        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode([
            "error" => "ID tidak ditemukan"
        ]);
    }
} else if ($action === 'update_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if ($id && $status) {
        $result = $pengaduan->updateStatus($id, $status);
        echo json_encode($result);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Data tidak lengkap'
        ]);
    }
}