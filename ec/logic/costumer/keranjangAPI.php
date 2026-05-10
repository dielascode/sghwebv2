<?php

session_start();
require_once __DIR__ . "/../../config/connection.php";

$db = new Database();
$conn = $db->getConnection();

$action = $_POST['action'] ?? null;


/* =========================
   ADD TO CART
========================= */
if ($action == 'add') {

    $id_detail = $_POST['id_detail'] ?? null;
    $qty = (int) ($_POST['qty'] ?? 1);

    // sementara hardcode dulu
    $id_customer = "CST001";

    if (!$id_detail) {
        die("ID produk kosong");
    }

    // cek produk ada atau tidak
    $query = "SELECT id
              FROM detail_produk
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $id_detail);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $produk = mysqli_fetch_assoc($result);

    if (!$produk) {
        die("produk tidak ditemukan");
    }


    // cek produk sudah ada di keranjang customer
    $check = mysqli_prepare($conn,
        "SELECT *
         FROM keranjang
         WHERE id_detail_produk = ?
         AND id_customer = ?"
    );

    mysqli_stmt_bind_param(
        $check,
        "ss",
        $id_detail,
        $id_customer
    );

    mysqli_stmt_execute($check);

    $checkResult = mysqli_stmt_get_result($check);


    // kalau sudah ada -> update qty
    if (mysqli_num_rows($checkResult) > 0) {

        $update = mysqli_prepare($conn,
            "UPDATE keranjang
             SET qty = qty + ?
             WHERE id_detail_produk = ?
             AND id_customer = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "iss",
            $qty,
            $id_detail,
            $id_customer
        );

        mysqli_stmt_execute($update);

    } else {

        // generate ID keranjang
        $queryId = mysqli_query($conn,
            "SELECT id
             FROM keranjang
             ORDER BY id DESC
             LIMIT 1"
        );

        $dataId = mysqli_fetch_assoc($queryId);

        if ($dataId) {

            $lastId = $dataId['id'];

            $number = (int) substr($lastId, 3);

            $number++;

            $id_keranjang = 'KRJ' .
                str_pad($number, 3, '0', STR_PAD_LEFT);

        } else {

            $id_keranjang = 'KRJ001';

        }


        // insert baru
        $insert = mysqli_prepare($conn,
            "INSERT INTO keranjang
            (id, id_detail_produk, id_customer, qty)
            VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $insert,
            "sssi",
            $id_keranjang,
            $id_detail,
            $id_customer,
            $qty
        );

        mysqli_stmt_execute($insert);

    }

    echo "success";
    exit;
}



/* =========================
   GET TOTAL CART
========================= */
if ($action == 'get_total') {

    $id_customer = "CST001";

    $query = mysqli_prepare($conn,
        "SELECT SUM(qty) as total
         FROM keranjang
         WHERE id_customer = ?"
    );

    mysqli_stmt_bind_param(
        $query,
        "s",
        $id_customer
    );

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

    $id_customer = "CST001";

    if (!$id) {
        die("ID kosong");
    }

    // ambil qty sekarang
    $check = mysqli_prepare($conn,
        "SELECT qty
         FROM keranjang
         WHERE id_detail_produk = ?
         AND id_customer = ?"
    );

    mysqli_stmt_bind_param(
        $check,
        "ss",
        $id,
        $id_customer
    );

    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    $item = mysqli_fetch_assoc($result);

    if (!$item) {
        die("produk tidak ditemukan");
    }

    $newQty = $item['qty'] + $delta;

    // kalau qty <= 0 hapus
    if ($newQty <= 0) {

        $delete = mysqli_prepare($conn,
            "DELETE FROM keranjang
             WHERE id_detail_produk = ?
             AND id_customer = ?"
        );

        mysqli_stmt_bind_param(
            $delete,
            "ss",
            $id,
            $id_customer
        );

        mysqli_stmt_execute($delete);

    } else {

        $update = mysqli_prepare($conn,
            "UPDATE keranjang
             SET qty = ?
             WHERE id_detail_produk = ?
             AND id_customer = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "iss",
            $newQty,
            $id,
            $id_customer
        );

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

    $id_customer = "CST001";

    if (!$ids || !is_array($ids)) {
        die("data kosong");
    }

    foreach ($ids as $id) {

        $delete = mysqli_prepare($conn,
            "DELETE FROM keranjang
             WHERE id_detail_produk = ?
             AND id_customer = ?"
        );

        mysqli_stmt_bind_param(
            $delete,
            "ss",
            $id,
            $id_customer
        );

        mysqli_stmt_execute($delete);

    }

    echo "success";
    exit;
}