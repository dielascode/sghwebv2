<?php

class Pengaduan
{
    private $conn;
    private $table = "pengaduan";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPengaduan()
    {
        return $this->conn->query("SELECT $this->table.*,
                $this->table.status AS status_pengaduan,
                users.status AS status_user, users.nama FROM $this->table JOIN users ON $this->table.id_costumer = users.id");
    }
    public function getDetailPengaduan($id)
    {
        $query = "SELECT 
                    $this->table.*,
                    $this->table.status AS status_pengaduan,
                    users.status AS status_user,
                    users.nama 
                FROM $this->table 
                JOIN users ON $this->table.id_costumer = users.id 
                WHERE $this->table.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pengaduan = $stmt->get_result()->fetch_assoc();
        return $pengaduan;
    }

    public function updateStatus($id, $status)
{
    $query = "UPDATE $this->table SET status=? WHERE id=?";
    $stmt = $this->conn->prepare($query);

    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        return [
            'status' => true,
            'message' => 'Status berhasil diupdate'
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Gagal update status'
        ];
    }
}
}
