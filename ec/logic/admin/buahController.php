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

function tambahBuah($conn, $nama_buah){
    $nama_buah = mysqli_real_escape_string($conn, $nama_buah);

    $query = "INSERT INTO buah (nama_buah) 
              VALUES ('$nama_buah')";

    return mysqli_query($conn, $query);
}

function deleteBuah($conn,$id){
    $query = "DELETE FROM buah WHERE id='$id'";
    return mysqli_query($conn,$query);
}

function updateBuah($conn, $id, $nama_buah){
    $nama_buah = mysqli_real_escape_string($conn, $nama_buah);

    $query = "UPDATE buah 
              SET nama_buah='$nama_buah'
              WHERE id=$id";

    return mysqli_query($conn, $query);
}

?>