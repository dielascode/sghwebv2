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
        $query = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $produk = $stmt->get_result()->fetch_assoc();

        $queryDetail = "SELECT dp.id_buah, dp.id_varietas, b.nama_buah, v.nama_varietas 
                    FROM detail_produk dp
                    JOIN buah b ON dp.id_buah = b.id
                    JOIN varietas v ON dp.id_varietas = v.id
                    WHERE dp.id_produk = ?";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bind_param("s", $id);
        $stmtDetail->execute();
        $produk['komposisi'] = $stmtDetail->get_result()->fetch_all(MYSQLI_ASSOC);

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
            $this->conn->begin_transaction();

            $stmt = $this->conn->prepare("INSERT INTO $this->table (id, nama_produk, tipe, deskripsi, stok, harga) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssid", $data['id'], $data['nama_produk'], $data['tipe'], $data['deskripsi'], $data['stok'], $data['harga']);
            $stmt->execute();

            $id_produk = $data['id'];
            $stmtDetail = $this->conn->prepare("INSERT INTO detail_produk (id_produk, id_buah, id_varietas) VALUES (?, ?, ?)");

            foreach ($komposisi as $item) {
                $stmtDetail->bind_param("sii", $id_produk, $item->id_buah, $item->id_varietas);
                $stmtDetail->execute();
            }

            $stmtImg = $this->conn->prepare("INSERT INTO gambar_produk (id_produk, gambar) VALUES (?, ?)");
            foreach ($images as $fileName) {
                $stmtImg->bind_param("ss", $id_produk, $fileName);
                $stmtImg->execute();
            }

            $this->conn->commit();
            return ['status' => true, 'message' => 'Produk berhasil disimpan!'];
        } catch (Exception $e) {
            $this->conn->rollback();
            return ['status' => false, 'message' => 'Gagal: ' . $e->getMessage()];
        }
    }

    public function updateProduk($data, $files)
    {
        $id = $data['id'];

        $query = "UPDATE $this->table 
              SET nama_produk=?, tipe=?, harga=?, stok=?, deskripsi=? 
              WHERE id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssddss",
            $data['nama_produk'],
            $data['tipe'],
            $data['harga'],
            $data['stok'],
            $data['deskripsi'],
            $id
        );

        $stmt->execute();

        $this->conn->query("DELETE FROM detail_produk WHERE id_produk='$id'");

        foreach ($data['komposisi'] as $item) {
            $q = "INSERT INTO detail_produk (id_produk, id_buah, id_varietas)
              VALUES (?, ?, ?)";

            $stmt = $this->conn->prepare($q);
            $stmt->bind_param("sss", $id, $item['id_buah'], $item['id_varietas']);
            $stmt->execute();
        }

        $oldImages = $data['oldImages'];

        $queryImg = "SELECT gambar FROM gambar_produk WHERE id_produk=?";
        $stmtImg = $this->conn->prepare($queryImg);
        $stmtImg->bind_param("s", $id);
        $stmtImg->execute();

        $existing = $stmtImg->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($existing as $img) {
            $found = false;

            foreach ($oldImages as $old) {
                if ($old['gambar'] === $img['gambar']) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->conn->query("DELETE FROM gambar_produk 
                                WHERE id_produk='$id' AND gambar='{$img['gambar']}'");

                $path = __DIR__ . "/../../admin/assets/images/produk/" . $img['gambar'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        if (!empty($files['images']['name'][0])) {

            foreach ($files['images']['name'] as $i => $name) {

                $tmp = $files['images']['tmp_name'][$i];

                $newName = time() . "_" . $name;

                move_uploaded_file($tmp, __DIR__ . "/../../admin/assets/images/produk/" . $newName);

                $this->conn->query("INSERT INTO gambar_produk (id_produk, gambar) 
                                VALUES ('$id', '$newName')");
            }
        }

        return [
            "status" => true,
            "message" => "Berhasil update produk"
        ];
    }



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
