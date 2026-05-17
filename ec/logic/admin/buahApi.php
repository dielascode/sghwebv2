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
        $cek = $this->conn->prepare("SELECT * FROM $this->table WHERE nama_buah = ?");
        $cek->bind_param("s", $data['nama_buah']);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            return [
                'status' => false,
                'message' => 'Buah sudah ada!'
            ];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table(nama_buah) VALUES (?)");
        $stmt->bind_param("s", $data['nama_buah']);

        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Buah berhasil disimpan!'
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
        $cek = $this->conn->prepare("SELECT * FROM $this->table WHERE nama_buah = ? AND id != ?");
        $cek->bind_param("si", $data['nama_buah'], $id);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            return [
                'status' => false,
                'message' => 'Nama buah sudah dipakai!'
            ];
        }

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
