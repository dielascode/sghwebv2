<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/pesananApi.php';

$db = new Database();
$conn = $db->getConnection();

$api = new PesananAPI($conn);

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'selesai':

        $nomor_pesanan = $_GET['nomor_pesanan'] ?? '';

        echo json_encode(
            $api->toggleStatus($nomor_pesanan, 'selesai')
        );

    break;

    default:

        echo json_encode([
            "status" => false,
            "message" => "Action salah"
        ]);

    break;
}