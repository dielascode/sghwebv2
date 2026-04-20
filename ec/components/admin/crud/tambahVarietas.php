<?php
include __DIR__ . "/../logic/admin/varietasController.php"; //pake dir aja biar enak
include __DIR__ . "/../logic/connection.php";

header('Content-Type: application/json');

if(isset($_POST['nama_varietas']) && isset($_POST['id_buah'])){
    $nama = $_POST['nama_varietas'];
    $id_buah = $_POST['id_buah'];

    $result = tambahVarietas($conn, $nama, $id_buah);

    echo json_encode([
        "success" => $result ? true : false
    ]);
    exit;
}

echo json_encode(["success" => false]);