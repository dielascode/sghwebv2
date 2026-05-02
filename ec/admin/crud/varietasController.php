<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/varietasApi.php";

$db = new Database();
$conn = $db->getConnection();
$buah = new Buah($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'tambah') {
    if (isset($_POST['nama_buah'])) {
        $result = $buah->store($_POST);
        echo json_encode($result);
    } else {
        echo json_encode(['status' => false, 'message' => 'Input nama_buah kosong']);
    }
} else if ($action === 'update') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $buah->update($id, $_POST);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => false, 'message' => 'ID tidak ditemukan']);
        }
        exit;
    }
} else if ($action === 'delete') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $buah->delete($id); 
            echo json_encode($result);
        } else {
            echo json_encode(['status' => false, 'message' => 'ID tidak ditemukan untuk dihapus']);
        }
        exit;
    }
}else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;
