<?php
class Auth
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        if (session_status() == PHP_SESSION_NONE) {
            session_name('sghwebv2_session');
                              session_start();
        }
    }
    public function login($email, $password)
    {
        $email = trim($email);
        $password = trim($password);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (!password_verify($password, $user['password'])) {
                return [
                    'status' => false,
                    'message' => 'Password salah!'
                ];
            }

            if ($user['status'] !== 'aktif') {
                return [
                    'status' => false,
                    'message' => 'Akun tidak aktif!'
                ];
            }

            if (!in_array($user['role'], ['admin', 'superadmin'])) {
                return [
                    'status' => false,
                    'message' => 'Akses ditolak! Bukan admin.'
                ];
            }

            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            return [
                'status' => true,
                'message' => 'Login berhasil!'
            ];
        }

        return [
            'status' => false,
            'message' => 'Email tidak ditemukan!'
        ];
    }
}
