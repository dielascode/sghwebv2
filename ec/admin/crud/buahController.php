<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/buahApi.php";

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
} else {
    echo json_encode(['status' => false, 'message' => 'Action salah: ' . $action]);
}
exit;

// switch ($action) {

//     case 'tambah':
//         if(isset($_POST['nama_buah'])){
//             $result = tambahBuah($conn, $_POST['nama_buah']);
//             echo json_encode(["success" => $result]);
//         }
//         break;

//     case 'delete':
//         if(isset($input['id'])){
//             $result = deleteBuah($conn, (int)$input['id']);
//             echo json_encode(["success" => $result]);
//         }
//         break;

//     case 'edit':
//         if(isset($input['id'])){
//             $result = updateBuah(
//                 $conn,
//                 (int)$input['id'],
//                 $input['nama_buah']
//             );
//             echo json_encode(["success" => $result]);
//         }
//         break;

//     default:
//         echo json_encode(["success" => false, "message" => "Invalid action"]);
// }