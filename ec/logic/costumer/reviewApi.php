<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

class Review
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function tambahReview(
        $id_costumer,
        $nomor_pesanan,
        $rating,
        $komentar,
        $file = null
    )
    {

        $query = "INSERT INTO review
        (
            id_costumer,
            nomor_pesanan,
            rating,
            komentar,
            file,
            tanggal_review
        )
        VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {

            return [
                "status" => false,
                "message" => $this->conn->error
            ];

        }

        $stmt->bind_param(
            "ssiss",
            $id_costumer,
            $nomor_pesanan,
            $rating,
            $komentar,
            $file
        );

        if ($stmt->execute()) {

            return [
                "status" => true,
                "message" => "Review berhasil dikirim"
            ];

        }

        return [
            "status" => false,
            "message" => $stmt->error
        ];
    }
}

try {

   
    session_name('sghwebv2_session');
    session_start();

    require_once __DIR__ . '/../../config/connection.php';

    $db = new Database();
    $conn = $db->getConnection();

    $api = new Review($conn);

    $id_costumer = $_SESSION['id'] ?? null;

    $nomor_pesanan = $_POST['nomor_pesanan'] ?? '';
    $rating = $_POST['rating'] ?? 0;
    $komentar = $_POST['komentar'] ?? '';

    if (!$id_costumer) {
        throw new Exception("User belum login");
    }

    if (!$nomor_pesanan) {
        throw new Exception("Nomor pesanan kosong");
    }

    $file = null;

    if (!empty($_FILES['photos']['name'][0])) {

       $folder = __DIR__ . '/../../../asset/image/review/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $namaFile = time() . '_' . $_FILES['photos']['name'][0];

        $tmp = $_FILES['photos']['tmp_name'][0];

        move_uploaded_file(
            $tmp,
            $folder . $namaFile
        );

        $file = $namaFile;
    }

    echo json_encode(
        $api->tambahReview(
            $id_costumer,
            $nomor_pesanan,
            $rating,
            $komentar,
            $file
        )
    );

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);

}