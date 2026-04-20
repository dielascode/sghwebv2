<?php
include __DIR__ . "/../connection.php"; //pake dir aja biar enak

function getProduk($conn){;
    $query = "SELECT 
            buah.nama_buah,
            varietas.nama_varietas,
        produk.harga
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

// function tambahProduk($conn,$nama,$harga){
//     $query = "INSERT INTO produk (nama_produk, harga) 
//               VALUES ('$nama','$harga')";
//     return mysqli_query($conn,$query);
// }

// function updateProduk($conn,$id,$nama,$harga){
//     $query = "UPDATE produk 
//               SET nama_produk='$nama', harga='$harga'
//               WHERE id_produk='$id'";
//     return mysqli_query($conn,$query);
// }

// function deleteProduk($conn,$id){
//     $query = "DELETE FROM produk WHERE id_produk='$id'";
//     return mysqli_query($conn,$query);
// }
