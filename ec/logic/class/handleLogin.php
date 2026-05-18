<?php
include __DIR__ . '/../../config/connection.php';

class LoginHandler {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function handleLogin($email, $password) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name('sghwebv2_session');
            session_start();
        }

        // QUERY LOGIN berdasarkan email saja, lalu verify password hashed
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) === 0) {
            echo "<script>alert('Login gagal: email atau password salah');</script>";
            return;
        }

        $user = mysqli_fetch_assoc($result);

        if (!password_verify($password, $user['password'])) {
            echo "<script>alert('Login gagal: email atau password salah');</script>";
            return;
        }

        // Hanya role costumer yang bisa login
        if ($user['role'] !== 'costumer') {
            echo "<script>alert('Hanya costumer yang bisa login di sini');</script>";
            return;
        }

        // SESSION LOGIN
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // Pastikan data ada di tabel costumer
        $query_check = "SELECT * FROM costumer WHERE id_costumer='{$user['id']}'";
        $result_check = mysqli_query($this->conn, $query_check);
        if (mysqli_num_rows($result_check) == 0) {
            // Insert data costumer default dengan relasi ke users.id
            $insert = "INSERT INTO costumer (id_costumer, jenis_kelamin, foto_profil) VALUES ('{$user['id']}', NULL, NULL)";
            mysqli_query($this->conn, $insert);
        }

        // REDIRECT
        header("Location: index.php");
        exit;
    }
}
?>