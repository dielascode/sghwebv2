<?php
include __DIR__ . "/../connection.php"; //pake dir aja biar enak

function getCostumer($conn){
    $query = "SELECT * FROM user
WHERE role = 'customer'";
    $result = mysqli_query($conn, $query);

    $customer = [];
    while($row = mysqli_fetch_assoc($result)){
        $customer[] = $row;
    }

    return $customer;
}