<?php

class Produk
{
    private $conn;
    private $table = "produk";
    private $table2 = "buah";
    private $table3 = "varietas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBuah()
    {
        return $this->conn->query("SELECT * FROM $this->table2");
    }

    public function getVarietas()
    {
        $query = "SELECT 
                    v.id,
                    v.nama_varietas,
                    v.id_buah,
                    b.nama_buah
                  FROM $this->table3 v
                  JOIN buah b ON v.id_buah = b.id";
        
        return $this->conn->query($query);
    }

    public function getProduk()
    {
        $query = "SELECT 
            p.id,           -- p merujuk ke produk
            p.nama_produk,
            p.stok,
            p.harga,
            b.nama_buah,    -- b merujuk ke buah
            v.nama_varietas -- v merujuk ke varietas
          FROM $this->table p
          LEFT JOIN detail_produk dp ON p.id = dp.id_produk
          LEFT JOIN buah b ON dp.id_buah = b.id
          LEFT JOIN varietas v ON dp.id_varietas = v.id";

        return $this->conn->query($query);
    }

    // public function store($data) {
    //     $stmt = $this->conn->prepare("INSERT INTO $this->table (id, nama_produk, tipe, id_buah, id_varietas, deskripsi, stok, harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    //     $stmt->bind_param("sssiisid", 
    //         $data['id'], 
    //         $data['nama_produk'], 
    //         $data['tipe'], 
    //         $data['id_buah'], 
    //         $data['id_varietas'], 
    //         $data['deskripsi'], 
    //         $data['stok'], 
    //         $data['harga']
    //     );

    //     if ($stmt->execute()) {
    //         return ['status' => true, 'message' => 'Produk berhasil ditambahkan!'];
    //     } else {
    //         return ['status' => false, 'message' => 'Gagal menambah produk: ' . $this->conn->error];
    //     }
    // }

    // public function delete($id) {
    //     $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
    //     $stmt->bind_param("s", $id);

    //     if ($stmt->execute()) {
    //         return ['status' => true, 'message' => 'Produk berhasil dihapus!'];
    //     } else {
    //         return ['status' => false, 'message' => 'Gagal menghapus produk'];
    //     }
    // }
}
