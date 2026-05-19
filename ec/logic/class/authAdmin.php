<?php
class Auth
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        if (session_status() == PHP_SESSION_NONE) {
           
            // session_name('sghwebv2_session');
            session_start();
        }
    }
    public function login($email, $password)
    {
        $email = trim($email); //ngehapus spasi
        $password = trim($password);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); //dibenntuk array

            if (!password_verify($password, $user['password'])) { //memverifikasi
                return [
                    'status' => false,
                    'message' => 'Password salah!'
                ];
            }

            if ($user['status'] !== 'aktif') { //aktif apa engga
                return [
                    'status' => false,
                    'message' => 'Akun tidak aktif!'
                ];
            }

            if (!in_array($user['role'], ['admin', 'superadmin'])) { //role nya ya khusus admin dan superadmmin
                return [
                    'status' => false,
                    'message' => 'Akses ditolak! Bukan admin.'
                ];
            }

            session_regenerate_id(true); //hapus session lama
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
