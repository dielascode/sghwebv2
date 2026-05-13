<?php

class PemesananApi
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSelectedProduk($id_costumer, $selected = [])
    {
        if (empty($selected)) {
            return [];
        }

      $ids = implode(",", array_map(fn($id) => "'" . mysqli_real_escape_string($this->conn, $id) . "'", $selected));

        $query = "
            SELECT
                k.kuantitas,
                p.id AS id_produk,
                p.nama_produk,
                p.harga,
                p.deskripsi,
                v.nama_varietas
            FROM keranjang k
            JOIN produk p
                ON k.id_produk = p.id
            JOIN detail_produk dp
                ON p.id = dp.id_produk
            JOIN varietas v
                ON dp.id_varietas = v.id
            WHERE k.id_produk IN ($ids)
            AND k.id_costumer = ?
        ";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "s", $id_costumer);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
    public function getBuyNowProduk($id_produk)
{
    $query = "
        SELECT
             p.id AS id_produk,  
            p.nama_produk,
            p.harga,
            p.deskripsi,
            v.nama_varietas
        FROM produk p
        JOIN detail_produk dp 
            ON p.id = dp.id_produk
        JOIN varietas v 
            ON dp.id_varietas = v.id
        WHERE p.id = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($this->conn, $query);

    mysqli_stmt_bind_param($stmt, "s", $id_produk);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}
 public function getNamaUser(string $id_costumer): string
{
    $stmt = mysqli_prepare($this->conn, "SELECT nama FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 's', $id_costumer);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    return $row['nama'] ?? '';
}
}