<?php

class Produk
{
    private $conn;
    private $table = "produk";
    private $table2 = "buah";
    private $table3 = "varietas";
    private $table4 = "detail_produk";

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
        $query = "SELECT * FROM $this->table";
        return $this->conn->query($query);
   }

    public function getProdukDetail($id)
    {
        // 1. Ambil data produk utama
        $query = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $produk = $stmt->get_result()->fetch_assoc();

        // 2. Ambil komposisi buah & varietas
        $queryDetail = "SELECT b.nama_buah, v.nama_varietas 
                    FROM detail_produk dp
                    JOIN buah b ON dp.id_buah = b.id
                    JOIN varietas v ON dp.id_varietas = v.id
                    WHERE dp.id_produk = ?";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bind_param("s", $id);
        $stmtDetail->execute();
        $produk['komposisi'] = $stmtDetail->get_result()->fetch_all(MYSQLI_ASSOC);

        // 3. Ambil galeri gambar
        $queryImg = "SELECT gambar FROM gambar_produk WHERE id_produk = ?";
        $stmtImg = $this->conn->prepare($queryImg);
        $stmtImg->bind_param("s", $id);
        $stmtImg->execute();
        $produk['images'] = $stmtImg->get_result()->fetch_all(MYSQLI_ASSOC);

        return $produk;
    }

    public function storeComplex($data, $komposisi, $images)
    {
        try {
            // Mulai transaksi
            $this->conn->begin_transaction();

            // 1. Simpan ke tabel produk
            $stmt = $this->conn->prepare("INSERT INTO $this->table (id, nama_produk, tipe, deskripsi, stok, harga) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssid", $data['id'], $data['nama_produk'], $data['tipe'], $data['deskripsi'], $data['stok'], $data['harga']);
            $stmt->execute();

            // 2. Simpan Komposisi ke detail_produk (Hasil json_decode dari Alpine.js)
            $id_produk = $data['id'];
            $stmtDetail = $this->conn->prepare("INSERT INTO detail_produk (id_produk, id_buah, id_varietas) VALUES (?, ?, ?)");

            foreach ($komposisi as $item) {
                $stmtDetail->bind_param("sii", $id_produk, $item->id_buah, $item->id_varietas);
                $stmtDetail->execute();
            }

            // Di dalam method storeComplex atau simpan gambar
            $stmtImg = $this->conn->prepare("INSERT INTO gambar_produk (id_produk, gambar) VALUES (?, ?)");
            // Di dalam produkApi.php
            foreach ($images as $fileName) {
                // Pastikan $id_produk yang dikirim ke bind_param benar
                $stmtImg->bind_param("ss", $id_produk, $fileName);
                $stmtImg->execute();
            }

            // Kalau semua oke, permanenkan!
            $this->conn->commit();
            return ['status' => true, 'message' => 'Produk berhasil disimpan!'];
        } catch (Exception $e) {
            // Kalau ada yang error, batalin semua yang udah masuk
            $this->conn->rollback();
            return ['status' => false, 'message' => 'Gagal: ' . $e->getMessage()];
        }
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
