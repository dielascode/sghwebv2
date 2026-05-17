<?php
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/costumerApi.php";

$db = new Database();
$conn = $db->getConnection();
$costumer = new Costumer($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'detail') {
    $id = $_GET['id'];

    $data = $costumer->getDetail($id);

    header('Content-Type: application/json');
    echo json_encode($data);
}

if ($action === 'nonaktifkan') {
    $id = $_POST['id'];

    $result = $costumer->nonaktifkan($id);

    header('Content-Type: application/json');
    echo json_encode($result);
}