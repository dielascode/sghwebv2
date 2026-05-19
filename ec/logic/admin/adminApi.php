<?php


class Admin
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    private function generateId()
    {
        $query = "SELECT id FROM users WHERE id LIKE 'ADM%' ORDER BY id DESC LIMIT 1";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $lastId = $result->fetch_assoc()['id'];

            $number = (int) substr($lastId, 3);

            $number++;

            $newId = 'ADM' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'ADM001';
        }

        return $newId;
    }
    public function getAdmin()
    {
        $role = 'admin';
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE role = ?");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function store($data)
    {
        $role = 'admin';
        $status = 'aktif';
        $tanggal_daftar = date('Y-m-d H:i:s'); //isinisasi awal
        $id = $this->generateId();
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        //filter
        $cek = $this->conn->prepare("SELECT id FROM users WHERE username=?");
        $cek->bind_param("s", $data['username']);
        $cek->execute();

        if ($cek->get_result()->num_rows > 0) {
            return [
                "status" => false,
                "message" => "Username sudah digunakan"
            ];
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => false,
                'message' => 'Format email tidak valid'
            ]);
            exit;
        }

        $query = "INSERT INTO users 
        (id, nama, username, email, password, nomor_telepon, role, status, tanggal_daftar) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; //iinsert ke admin data data yyg tadi tu

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param( //ngisi parameteer
            "sssssssss",
            $id,
            $data['nama'],
            $data['username'],
            $data['email'],
            $password,
            $data['nomor_telepon'],
            $role,
            $status,
            $tanggal_daftar
        );

        if ($stmt->execute()) {
            return [
                "status" => true,
                "message" => "Admin berhasil ditambahkan"
            ];
        } else {
            return [
                "status" => false,
                "message" => "Gagal tambah admin: " . $this->conn->error
            ];
        }
    }
    public function update($id, $data)
    {
        $role = 'admin';
        $status = 'aktif';

        if (!empty($data['password'])) { //klao password kosong baru dijalanin

            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $query = "UPDATE users SET 
            nama=?, username=?, email=?, password=?, nomor_telepon=?, role=?, status=? 
            WHERE id=?";

            $stmt = $this->conn->prepare($query);

            $stmt->bind_param(
                "ssssssss",
                $data['nama'],
                $data['username'],
                $data['email'],
                $password,
                $data['nomor_telepon'],
                $role,
                $status,
                $id
            );
        } else {

            $query = "UPDATE users SET 
            nama=?, username=?, email=?, nomor_telepon=?, role=?, status=? 
            WHERE id=?";

            $stmt = $this->conn->prepare($query);

            $stmt->bind_param(
                "sssssss",
                $data['nama'],
                $data['username'],
                $data['email'],
                $data['nomor_telepon'],
                $role,
                $status,
                $id
            );
        }
        if ($stmt->execute()) {
            return [
                "status" => true,
                "message" => "Berhasil update"
            ];
        } else {
            return [
                "status" => false,
                "message" => $stmt->error
            ];
        }
    }

    public function toggleStatus($id, $currentStatus) //set status
    {
        $newStatus = ($currentStatus === 'aktif') ? 'nonaktif' : 'aktif';

        $query = "UPDATE users SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $newStatus, $id);

        if ($stmt->execute()) {
            return [
                "status" => true,
                "message" => "Status berhasil diubah ke $newStatus"
            ];
        } else {
            return [
                "status" => false,
                "message" => $stmt->error
            ];
        }
    }
}
