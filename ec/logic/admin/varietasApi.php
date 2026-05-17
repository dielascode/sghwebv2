<?php

class Varietas
{
    private $conn;
    private $table = "varietas";
    private $table_buah = "buah";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBuah()
    {
        return $this->conn->query("SELECT * FROM $this->table_buah");
    }

    public function getVarietas()
    {
        $query = "SELECT 
                    v.id,
                    v.nama_varietas,
                    v.id_buah,
                    b.nama_buah
                  FROM $this->table v
                  JOIN buah b ON v.id_buah = b.id";

        return $this->conn->query($query);
    }

    public function store($data)
    {
        $cek = $this->conn->prepare("SELECT * FROM $this->table WHERE id_buah = ? AND nama_varietas = ?");
        $cek->bind_param("is", $data['id_buah'], $data['nama_varietas']);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            return [
                'status' => false,
                'message' => 'Varietas untuk buah ini sudah ada!'
            ];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (id_buah, nama_varietas) VALUES (?, ?)");
        $stmt->bind_param("is", $data['id_buah'], $data['nama_varietas']);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Varietas berhasil ditambahkan!'];
        } else {
            return ['status' => false, 'message' => 'Gagal menambah varietas: ' . $this->conn->error];
        }
    }

    public function update($id, $data)
    {
        $cek = $this->conn->prepare("SELECT * FROM $this->table WHERE id_buah = ? AND nama_varietas = ? AND id != ?");
        $cek->bind_param("isi", $data['id_buah'], $data['nama_varietas'], $id);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            return [
                'status' => false,
                'message' => 'Varietas sudah dipakai untuk buah ini!'
            ];
        }

        $stmt = $this->conn->prepare("UPDATE $this->table SET nama_varietas = ?, id_buah = ? WHERE id = ?");
        $stmt->bind_param("sii", $data['nama_varietas'], $data['id_buah'], $id);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Varietas berhasil diupdate!'];
        } else {
            return ['status' => false, 'message' => 'Gagal update varietas: ' . $this->conn->error];
        }
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Varietas berhasil dihapus!'];
        } else {
            return ['status' => false, 'message' => 'Gagal menghapus varietas'];
        }
    }

    public function getVarietasById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
