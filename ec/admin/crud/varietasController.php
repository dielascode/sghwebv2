<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/varietasApi.php";

$db = new Database();
$conn = $db->getConnection();
$varietas = new Varietas($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'tambah') {
    if (isset($_POST['id_buah'], $_POST['nama_varietas'])) {
        $result = $varietas->store($_POST);
        echo json_encode($result);
    } else {
        echo json_encode(['status' => false, 'message' => 'Input id_buah kosong']);
    }
} else if ($action === 'update') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        
        if ($id) {
            $result = $varietas->update($id, $_POST);
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
            $result = $varietas->delete($id); 
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
