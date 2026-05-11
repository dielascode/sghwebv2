<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/connection.php";

$db = new Database();
$conn = $db->getConnection();

$action = $_POST['action'] ?? null;

// ambil id user dari session login
$id_users = $_SESSION['id'];


/* =========================
   ADD TO CART
========================= */
if ($action == 'add') {
    $id_users = $_SESSION['id'] ?? null;

    

    if (!$id_users) {
        die("SESSION KOSONG");
    }

    $id_detail = $_POST['id_detail'] ?? null;
    $qty = (int) ($_POST['qty'] ?? 1);

    if (!$id_detail) {
        die("ID produk kosong");
    }

    // cek produk
    $stmt = mysqli_prepare($conn,
        "SELECT id FROM detail_produk WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_detail);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $produk = mysqli_fetch_assoc($result);

    if (!$produk) {
        die("produk tidak ditemukan");
    }

    // cek cart
    $check = mysqli_prepare($conn,
        "SELECT qty FROM keranjang
         WHERE id_detail_produk = ?
         AND id_users = ?"
    );

    mysqli_stmt_bind_param($check, "is", $id_detail, $id_users);
    mysqli_stmt_execute($check);

    $checkResult = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($checkResult) > 0) {

        $update = mysqli_prepare($conn,
            "UPDATE keranjang
             SET qty = qty + ?
             WHERE id_detail_produk = ?
             AND id_users = ?"
        );

        mysqli_stmt_bind_param($update, "iis", $qty, $id_detail, $id_users);
        mysqli_stmt_execute($update);

    } else {

        $queryId = mysqli_query($conn,
            "SELECT id FROM keranjang ORDER BY id DESC LIMIT 1"
        );

        $dataId = mysqli_fetch_assoc($queryId);

        if ($dataId) {
            $lastId = $dataId['id'];
            $number = (int) substr($lastId, 3);
            $number++;
            $id_keranjang = 'KRJ' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            $id_keranjang = 'KRJ001';
        }

        $insert = mysqli_prepare($conn,
            "INSERT INTO keranjang
            (id, id_detail_produk, id_users, qty)
            VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param($insert, "sisi", $id_keranjang, $id_detail, $id_users, $qty);
        mysqli_stmt_execute($insert);
    }

    echo "success";
    exit;
}



/* =========================
   GET TOTAL CART
========================= */
/* =========================
   GET TOTAL CART
========================= */
if ($action == 'get_total') {

    $id_users = $_SESSION['id'] ?? null;

    if (!$id_users) {
        echo 0;
        exit;
    }

    $query = mysqli_prepare($conn,
        "SELECT count(*) as total
         FROM keranjang
         WHERE id_users = ?"
    );

    mysqli_stmt_bind_param($query, "s", $id_users);

    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);

    $data = mysqli_fetch_assoc($result);

    echo $data['total'] ?? 0;

    exit;
}


/* =========================
   UPDATE QTY
========================= */
if ($action == 'qty') {

    $id = $_POST['id_detail'] ?? null;
    $delta = (int) ($_POST['qty'] ?? 0);

    if (!$id) {
        die("ID kosong");
    }

    // ambil qty sekarang
    $check = mysqli_prepare($conn,
        "SELECT qty FROM keranjang
         WHERE id_detail_produk = ?
         AND id_users = ?"
    );

    // ✅ FIX: bind ke $check, bukan $update — dan variabel sudah ada semua
    mysqli_stmt_bind_param($check, "ss", $id, $id_users);

    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);
    $item = mysqli_fetch_assoc($result);

    if (!$item) {
        die("produk tidak ditemukan");
    }

    $newQty = $item['qty'] + $delta;

    if ($newQty <= 0) {

        $delete = mysqli_prepare($conn,
            "DELETE FROM keranjang
             WHERE id_detail_produk = ?
             AND id_users = ?"
        );

        mysqli_stmt_bind_param($delete, "ss", $id, $id_users);
        mysqli_stmt_execute($delete);

    } else {

        $update = mysqli_prepare($conn,
            "UPDATE keranjang SET qty = ?
             WHERE id_detail_produk = ?
             AND id_users = ?"
        );

        // ✅ FIX: prepare dulu, baru bind — urutannya benar sekarang
        mysqli_stmt_bind_param($update, "iss", $newQty, $id, $id_users);
        mysqli_stmt_execute($update);

    }

    echo "success";
    exit;
}



/* =========================
   DELETE SELECTED
========================= */
if ($action == 'delete_selected') {

    $ids = json_decode($_POST['ids'], true);

    if (!$ids || !is_array($ids)) {
        die("data kosong");
    }

    foreach ($ids as $id) {

        $delete = mysqli_prepare($conn,
            "DELETE FROM keranjang
             WHERE id_detail_produk = ?
             AND id_users = ?"
        );

      mysqli_stmt_bind_param($delete, "ss", $id, $id_users);

        mysqli_stmt_execute($delete);

    }

    echo "success";
    exit;
}
if ($action == 'set_selected') {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $ids = json_decode($_POST['ids'] ?? '[]', true);

    if (!is_array($ids) || empty($ids)) {
        echo "invalid";
        exit;
    }

    $_SESSION['selected_cart'] = $ids;

    echo "success";
    exit;
}