<?php
// include __DIR__ . "/../../config/connection.php"; 

class Buah
{
    private $conn;
    private $table = "buah";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBuah()
    {
        return $this->conn->query("SELECT * FROM $this->table");
    }

    public function store($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table(nama_buah) VALUES (?)");
        $stmt->bind_param("s", $data['nama_buah']);

        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Buah berhasil disimpan ke AgriNexa!'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Gagal simpan: ' . $this->conn->error
            ];
        }
    }

    public function update($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET nama_buah=? WHERE id=?");
        $stmt->bind_param("si", $data['nama_buah'], $id);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Data buah berhasil diperbarui!'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Gagal update: ' . $this->conn->error
            ];
        }
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Data buah berhasil dihapus!'];
        } else {
            return ['status' => false, 'message' => 'Gagal menghapus: ' . $this->conn->error];
        }
    }
    public function getBuahById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
