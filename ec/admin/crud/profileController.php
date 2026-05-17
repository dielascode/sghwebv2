<?php
// Letakkan di paling atas
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
// include __DIR__ . "/../../logic/admin/produkApi.php";

$db = new Database();
$conn = $db->getConnection();
// $produk = new Produk($conn);

$action = $_GET['action'] ?? 'tidak ada action';

if ($action === 'update') {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $hp = $_POST['nomor_telepon'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET 
            nama=?, email=?, username=?, nomor_telepon=?, password=?
            WHERE id=?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $nama, $email, $username, $hp, $password, $id);

    } else {
        $query = "UPDATE users SET 
            nama=?, email=?, username=?, nomor_telepon=?
            WHERE id=?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $nama, $email, $username, $hp, $id);
    }

    if ($stmt->execute()) {

        // update session biar langsung berubah
        $_SESSION['user']['nama'] = $nama;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['nomor_telepon'] = $hp;

        echo json_encode([
            'status' => true,
            'message' => 'Berhasil update'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Gagal update'
        ]);
    }
}