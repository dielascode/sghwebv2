<?php
include __DIR__ . "/../logic/admin/varietasController.php"; //pake dir aja biar enak
include __DIR__ . "/../logic/connection.php";

header('Content-Type: application/json');

// ambil data JSON
$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['id'])){
    $id = (int)$data['id'];

    $result = deleteVarietas($conn, $id);

    echo json_encode([
        "success" => $result ? true : false
    ]);
    exit;
}

echo json_encode(["success" => false]);
?>