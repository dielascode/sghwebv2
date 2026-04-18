<?php
include __DIR__ . "/../connection.php"; //pake dir aja biar enak

function getBuah($conn){
    $query = "select * from buah";
    $result = mysqli_query($conn, $query);

    $buah = [];
    while($row = mysqli_fetch_assoc($result)){
        $buah[] = $row;
    }

    return $buah;
}

function getVarietas($conn){
    $query = "SELECT 
                varietas.id,
                varietas.nama_varietas,
                buah.nama_buah
              FROM varietas
              JOIN buah ON varietas.id_buah = buah.id";

    $result = mysqli_query($conn, $query);

    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    return $data;
}

function tambahVarietas($conn, $nama_varietas, $id_buah){
    $nama_varietas = mysqli_real_escape_string($conn, $nama_varietas);
    $id_buah = (int)$id_buah;

    $query = "INSERT INTO varietas (id_buah, nama_varietas) 
              VALUES ('$id_buah','$nama_varietas')";

    return mysqli_query($conn, $query);
}

function deleteVarietas($conn,$id){
    $query = "DELETE FROM varietas WHERE id='$id'";
    return mysqli_query($conn,$query);
}

?>