<?php
include __DIR__ . "/../logic/admin/buahController.php";
include __DIR__ . "/../logic/connection.php";

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents("php://input"), true);

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'tambah':
        if(isset($_POST['nama_buah'])){
            $result = tambahBuah($conn, $_POST['nama_buah']);
            echo json_encode(["success" => $result]);
        }
        break;

    case 'delete':
        if(isset($input['id'])){
            $result = deleteBuah($conn, (int)$input['id']);
            echo json_encode(["success" => $result]);
        }
        break;

    case 'edit':
        if(isset($input['id'])){
            $result = updateBuah(
                $conn,
                (int)$input['id'],
                $input['nama_buah']
            );
            echo json_encode(["success" => $result]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid action"]);
}