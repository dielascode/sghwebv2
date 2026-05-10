<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/connection.php';

$data = null;

if (isset($_SESSION['id_user'])) {

    $id_user = $_SESSION['id_user'];

    $query = mysqli_query($conn, "
        SELECT 
            users.*,
            costumer.jenis_kelamin,
            costumer.foto_profile
        FROM users
        LEFT JOIN costumer 
            ON users.id = costumer.id_costumer
        WHERE users.id = '$id_user'
    ");

    if ($query) {
        $data = mysqli_fetch_assoc($query);
    }
}
?>