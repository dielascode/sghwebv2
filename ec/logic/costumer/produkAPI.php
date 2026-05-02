<?php
include __DIR__ . "/../connection.php"; // Menghubungkan ke database
include __DIR__ . '/../admin/produkController.php'; // file yg ada getProduk()
function getProduk($conn){
    $query = "SELECT 
        buah.nama_buah,
        varietas.nama_varietas,
        produk.harga,
        produk.stok
    FROM produk
    JOIN buah ON produk.id_buah = buah.id
    JOIN varietas ON produk.id_varietas = varietas.id";

    $result = mysqli_query($conn, $query);

    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    return $data;
}
?>