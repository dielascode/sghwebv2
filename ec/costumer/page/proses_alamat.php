<?php
session_start();
require '../../config/connection.php';

$db          = (new Database())->getConnection();
$id_costumer = $_SESSION['id_costumer'];
$action      = $_GET['action'] ?? '';

switch ($action) {
    case 'simpan':
    $id          = !empty($_POST['id']) ? (int) $_POST['id'] : null;
    $alamat_json = $_POST['alamat_json'] ?? '';

    if (empty($alamat_json)) { header("Location: alamatcustomer.php?error=data_kosong"); exit; }

    $decoded = json_decode($alamat_json, true);
    if (json_last_error() !== JSON_ERROR_NONE) { header("Location: alamatcustomer.php?error=json_invalid"); exit; }

    if ($id) {
        $stmt = $db->prepare("UPDATE alamat_costumer SET alamat = ? WHERE id = ? AND id_costumer = ?");
        $stmt->bind_param("sii", $alamat_json, $id, $id_costumer);
        $stmt->execute();
        $stmt->close();
    } else {
        $cek = $db->prepare("SELECT COUNT(*) AS total FROM alamat_costumer   WHERE id_costumer = ?");
        $cek->bind_param("i", $id_costumer);
        $cek->execute();
        $total  = $cek->get_result()->fetch_assoc()['total'];
        $cek->close();
        $status = ($total == 0) ? 'utama' : 'bukan';

        $stmt = $db->prepare("INSERT INTO alamat_costumer (id_costumer, alamat, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_costumer, $alamat_json, $status);
        $stmt->execute();
        $stmt->close();
    }
    break;

    case 'hapus':
    $id = (int) ($_GET['id'] ?? 0);
    if ($id > 0) {
        $cek = $db->prepare("SELECT status FROM alamat_costumer WHERE id = ? AND id_costumer = ?");
        $cek->bind_param("ii", $id, $id_costumer);
        $cek->execute();
        $row = $cek->get_result()->fetch_assoc();
        $cek->close();
        if ($row && $row['status'] !== 'utama') {
            $stmt = $db->prepare("DELETE FROM alamat_costumer WHERE id = ? AND id_costumer = ?");
            $stmt->bind_param("ii", $id, $id_costumer);
            $stmt->execute();
            $stmt->close();
        }
    }
    break;

    case 'set_utama':
    $id = (int) ($_GET['id'] ?? 0);
    if ($id > 0) {
        $cek = $db->prepare("SELECT id FROM alamat_costumer WHERE id = ? AND id_costumer = ?");
        $cek->bind_param("ii", $id, $id_costumer);
        $cek->execute();
        $exists = $cek->get_result()->fetch_assoc();
        $cek->close();
        if ($exists) {
            $reset = $db->prepare("UPDATE alamat_costumer SET status = 'bukan' WHERE id_costumer = ?");
            $reset->bind_param("i", $id_costumer);
            $reset->execute();
            $reset->close();

            $stmt = $db->prepare("UPDATE alamat_costumer    SET status = 'utama' WHERE id = ? AND id_costumer = ?");
            $stmt->bind_param("ii", $id, $id_costumer);
            $stmt->execute();
            $stmt->close();
        }
    }
    break;
}

header("Location: alamatcustomer.php");
exit;