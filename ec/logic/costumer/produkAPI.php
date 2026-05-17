<?php

function getProduk($conn, $tipe = 'all'){

    $query = "SELECT 
        detail_produk.id AS id_detail,
        produk.id AS id_produk,
        produk.nama_produk,
        produk.deskripsi,
        produk.tipe,
        produk.harga,
        produk.stok,
        buah.nama_buah,
        varietas.nama_varietas
    FROM detail_produk
    JOIN produk ON detail_produk.id_produk = produk.id
    JOIN buah ON detail_produk.id_buah = buah.id
    JOIN varietas ON detail_produk.id_varietas = varietas.id";

    if($tipe != 'all'){
        $query .= " WHERE produk.tipe = '$tipe'";
    }

    $result = mysqli_query($conn, $query);

    $data = [];

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    return $data;
}
function getGambarProduk($conn, $id_produk)
{
    $query = "SELECT gambar 
              FROM gambar_produk
              WHERE id_produk = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $id_produk);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $gambar = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $gambar[] = $row['gambar'];
    }

    return $gambar;
}
function getReviewProduk($conn, $id_produk) {
    $stmt = mysqli_prepare($conn, "
        SELECT r.rating, r.komentar, r.tanggal_review, r.file, u.nama
        FROM review r
        JOIN pesanan p ON p.nomor_pesanan = r.nomor_pesanan
        JOIN detail_pesanan dp ON dp.nomor_pesanan = p.nomor_pesanan
        JOIN users u ON u.id = r.id_costumer
        WHERE dp.id_produk = ?
        ORDER BY r.tanggal_review DESC
        LIMIT 2
    ");
    mysqli_stmt_bind_param($stmt, 's', $id_produk);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}