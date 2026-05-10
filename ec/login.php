<?php
session_start();
include 'config/connection.php';

$db = new Database();
$conn = $db->getConnection();

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // QUERY LOGIN
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    
    $result = mysqli_query($conn, $query);

    // CEK LOGIN
    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        // SESSION LOGIN
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // REDIRECT ROLE
        if ($user['role'] == 'superadmin') {

            header("Location: superadmin.php");

        } elseif ($user['role'] == 'admin') {

            header("Location: admin.php");

        } else {

            header("Location: index.php");
        }

        exit;

    } else {

        echo "<script>alert('Login gagal');</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style/costumer/loginRegist.css">

</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST">
                <h1>Log In</h1>


                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <a class="forget-password" href="">Lupa Password?</a>

                <button type="submit" name="login">Masuk Sekarang</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Masuk ke Akun Anda</h1>
                    <p>Silakan masuk menggunakan email dan kata sandi <br> yang telah terdaftar untuk melanjutkan.
                        <br>Jika belum memiliki akun maka lakukan Sign Up dibawah.</p>
                    <button class="ghost switch-btn" data-target="registrasi.php" data-mode="sign-up">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>
        <script src="js/loginRegist.js"></script>
</body>

</html>