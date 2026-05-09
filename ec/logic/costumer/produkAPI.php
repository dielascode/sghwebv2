<?php


function getProduk($conn, $tipe = 'all'){
    $query = "SELECT 
    detail_produk.id AS id_detail,
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
    $query .= " GROUP BY produk.id";

    $result = mysqli_query($conn, $query);

    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    return $data;
}