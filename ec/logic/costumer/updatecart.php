<?php
session_start();

$action = $_POST['action'] ?? null;


/* =========================
   GET TOTAL CART
========================= */
if ($action == 'get_total') {

    $totalQty = 0;

    if (isset($_SESSION['cart'])) {

        foreach ($_SESSION['cart'] as $item) {

            $totalQty++;

        }

    }

    echo $totalQty;
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

    foreach ($_SESSION['cart'] as $key => $item) {

        if ($item['id_detail'] == $id) {

            $_SESSION['cart'][$key]['qty'] += $delta;

            if ($_SESSION['cart'][$key]['qty'] <= 0) {
                unset($_SESSION['cart'][$key]);
            }

            echo "success";
            exit;
        }
    }

    echo "produk tidak ditemukan";
}



/* =========================
   DELETE SELECTED
========================= */
if ($action == 'delete_selected') {

    $ids = json_decode($_POST['ids'], true);

    if (!$ids) {
        die("data kosong");
    }

    foreach ($_SESSION['cart'] as $key => $item) {

        if (in_array($item['id_detail'], $ids)) {

            unset($_SESSION['cart'][$key]);
        }
    }

    echo "success";
}