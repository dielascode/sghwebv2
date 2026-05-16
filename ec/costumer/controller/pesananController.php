<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/Apipesanan.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'konfirmasi') {
        $db   = new Database();
        $conn = $db->getConnection();
        $api  = new PesananApi($conn);

        $id_costumer = $_SESSION['id'] ?? null;
        if (!$id_costumer) {
            ob_end_clean();
            echo "error: tidak login";
            exit;
        }

        $buynow   = $_SESSION['buynow'] ?? null; // ← fix di sini
        $selected = $_SESSION['selected_cart'] ?? [];

        $nomor     = 'ORD-' . time();
        $bukti     = null;
        $uploadDir = __DIR__ . '/../../uploads/bukti/';

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] === 0) {
            $ext   = pathinfo($_FILES['bukti_bayar']['name'], PATHINFO_EXTENSION);
            $bukti = $nomor . '.' . $ext;
            move_uploaded_file($_FILES['bukti_bayar']['tmp_name'], $uploadDir . $bukti);
        }

        $api->insertPesanan($nomor, $id_costumer, $bukti);

        if ($buynow) {
            $api->insertDetail($nomor, $buynow['id_produk'], (int) $buynow['qty']);
            unset($_SESSION['buynow']);
        } elseif (!empty($selected)) {
            foreach ($selected as $id_produk) {
                $item = $api->getKuantitasKeranjang($id_produk, $id_costumer);
                if ($item) $api->insertDetail($nomor, $id_produk, (int) $item['kuantitas']);
            }
            foreach ($selected as $id_produk) {
                $api->deleteKeranjang($id_produk, $id_costumer);
            }
            unset($_SESSION['selected_cart']);
        } else {
            ob_end_clean();
            echo "error: tidak ada produk";
            exit;
        }

        ob_end_clean();
        echo "success";
    }
}