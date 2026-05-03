<?php


function getProduk($conn, $tipe = 'all'){
    $query = "SELECT 
        produk.id,
        produk.nama_produk,
        produk.deskripsi,
        produk.tipe,
        produk.harga,
        produk.stok,
        buah.nama_buah,
        varietas.nama_varietas
    FROM produk
    JOIN detail_produk ON produk.id = detail_produk.id_produk
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