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

        // SESSION LOGIN
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // REDIRECT ROLE
        if ($user['role'] === 'superadmin') {
            header("Location: superadmin.php");
        } elseif ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}
?>