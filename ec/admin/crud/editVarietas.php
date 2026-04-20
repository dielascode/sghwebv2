<?php
include __DIR__ . "/../../logic/admin/varietasController.php"; //pake dir aja biar enak
include __DIR__ . "/../../logic/connection.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['id'])){
    $id = (int)$data['id'];
    $nama = $data['nama'];
    $id_buah = (int)$data['id_buah'];

    $result = updateVarietas($conn, $id, $nama, $id_buah);

    echo json_encode(["success" => $result ? true : false]);
    exit;
}

echo json_encode(["success" => false]);
?>