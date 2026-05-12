<?php
require_once  __DIR__ . '/../../config/connection.php';

class OtpHandler {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    private function generateID() {
        $query = mysqli_query($this->conn, "SELECT id FROM users ORDER BY id DESC LIMIT 1");

        if (mysqli_num_rows($query) == 0) {
            return "COST001";
        }

        $data = mysqli_fetch_assoc($query);
        $number = (int) substr($data['id'], 4);
        $number++;
    
        return "COST" . str_pad($number, 3, "0", STR_PAD_LEFT);
    }

    public function handleOtpVerification($otp_input) {
        if (!isset($_SESSION['otp']) || !isset($_SESSION['data_register'])) {
            header("Location: register.php");
            exit;
        }

        if (strlen($otp_input) != 5) {
            echo "<script>alert('OTP harus 5 digit');</script>";
            return;
        }

        if (time() > $_SESSION['otp_expired']) {
            session_destroy();
            echo "<script>alert('OTP kadaluarsa'); window.location='register.php';</script>";
            exit;
        }

        if ($otp_input == $_SESSION['otp']) {
            $data = $_SESSION['data_register'];
            $id = $this->generateID();

            // Hash the password before storing
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO users 
            (id, nama, email, username, password, nomor_telepon, role) 
            VALUES 
            ('$id', '{$data['nama']}', '{$data['email']}', '{$data['nama']}', '$hashedPassword', '{$data['nomor_telepon']}', 'costumer')";

            if (mysqli_query($this->conn, $query)) {
                session_destroy();
                header("Location: dummyRegist.php");
                exit;
            } else {
                echo "Error DB: " . mysqli_error($this->conn);
            }
        } else {
            echo "<script>alert('OTP salah');</script>";
        }
    }
}
?>