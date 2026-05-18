<?php

session_name('sghwebv2_session');
                              session_start();

require_once __DIR__ . '/../../config/connection.php';

$db = new Database();
$conn = $db->getConnection();

// =====================================
// CEK LOGIN
// =====================================
if (!isset($_SESSION['id'])) {

    header("Location: ../../index.php");
    exit;
}

$id = $_SESSION['id'];

// =====================================
// AMBIL DATA COSTUMER
// =====================================
$cek = mysqli_query($conn, "
    SELECT * FROM costumer
    WHERE id_costumer = '$id'
");

$data = mysqli_fetch_assoc($cek);

// =====================================
// CEK FILE FOTO
// =====================================
if (isset($_FILES['profile_image']) &&
    !empty($_FILES['profile_image']['name'])) {

    // =====================================
    // GENERATE NAMA FOTO
    // =====================================
    $ext = pathinfo(
        $_FILES['profile_image']['name'],
        PATHINFO_EXTENSION
    );

    $foto_baru =
        time() . '_' . rand(1000, 9999) . '.' . $ext;

    // =====================================
    // FILE TEMP
    // =====================================
    $tmp = $_FILES['profile_image']['tmp_name'];

    // =====================================
    // PATH UPLOAD
    // =====================================
    $upload_path =
        __DIR__ . '/../../../asset/image/profile/' . $foto_baru;

    // =====================================
    // UPLOAD FILE
    // =====================================
    if (move_uploaded_file($tmp, $upload_path)) {

        // =====================================
        // HAPUS FOTO LAMA
        // =====================================
        if (!empty($data['foto_profil'])) {

            $old =
                __DIR__ . '/../../../asset/image/profile/' .
                $data['foto_profil'];

            if (
                file_exists($old) &&
                $data['foto_profil'] != 'Anonim.jpg'
            ) {

                unlink($old);
            }
        }

        // =====================================
        // UPDATE DATABASE
        // =====================================
        if (mysqli_num_rows($cek) > 0) {

            $update = mysqli_query($conn, "
                UPDATE costumer
                SET foto_profil = '$foto_baru'
                WHERE id_costumer = '$id'
            ");

            if (!$update) {

                die(mysqli_error($conn));
            }

        } else {

            $insert = mysqli_query($conn, "
                INSERT INTO costumer (
                    id_costumer,
                    foto_profil
                ) VALUES (
                    '$id',
                    '$foto_baru'
                )
            ");

            if (!$insert) {

                die(mysqli_error($conn));
            }
        }

    } else {

        die("Upload file gagal");
    }
}

// =====================================
// REDIRECT
// =====================================
header("Location: ../../index.php?page=profile");
exit;