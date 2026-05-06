<?php


function getProduk($conn, $tipe = 'all'){
    $query = "SELECT 
    produk.id,
    ANY_VALUE(detail_produk.id) AS id_detail,
    ANY_VALUE(produk.nama_produk) AS nama_produk,
    ANY_VALUE(produk.deskripsi) AS deskripsi,
    ANY_VALUE(produk.tipe) AS tipe,
    ANY_VALUE(produk.harga) AS harga,
    ANY_VALUE(produk.stok) AS stok,
    ANY_VALUE(buah.nama_buah) AS nama_buah,
    ANY_VALUE(varietas.nama_varietas) AS nama_varietas,

    GROUP_CONCAT(gambar_produk.gambar ORDER BY gambar_produk.id ASC) AS gambar,

    (
        SELECT gp.gambar 
        FROM gambar_produk gp 
        WHERE gp.id_produk = produk.id 
        ORDER BY gp.id ASC 
        LIMIT 1
    ) AS foto_utama

FROM produk
JOIN detail_produk ON produk.id = detail_produk.id_produk
JOIN buah ON detail_produk.id_buah = buah.id
JOIN varietas ON detail_produk.id_varietas = varietas.id
LEFT JOIN gambar_produk ON produk.id = gambar_produk.id_produk";

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