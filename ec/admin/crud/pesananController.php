<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/pesananApi.php";

$db = new Database();
$conn = $db->getConnection();
$pesanan = new Pesanan($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'get_detail') {
    $nomor_pesanan = $_GET['nomor_pesanan'];
    $result = $pesanan->getDetail($nomor_pesanan);
    echo json_encode($result);
} else if ($action === 'update') {
    
} else if ($action === 'delete') {
    
}else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;
