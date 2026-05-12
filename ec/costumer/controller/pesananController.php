<?php

require_once __DIR__ . '/../../config/connection.php';

class PesananController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // =========================
    // GET DATA PESANAN (SELECTED CART)
    // =========================
    public function getSelectedProduk($id_costumer, $selected = [])
    {
        if (empty($selected)) {
            return [];
        }

        $ids = implode(",", array_map('intval', $selected));

        $query = "
            SELECT
                keranjang.kuantitas,
                detail_produk.id AS id_detail,
                produk.id AS id_produk,
                produk.nama_produk,
                produk.harga,
                produk.deskripsi,
                varietas.nama_varietas
            FROM keranjang
            JOIN detail_produk 
                ON keranjang.id_detail_produk = detail_produk.id
            JOIN produk 
                ON detail_produk.id_produk = produk.id
            JOIN varietas 
                ON detail_produk.id_varietas = varietas.id
            WHERE keranjang.id_detail_produk IN ($ids)
            AND keranjang.id_costumer = '$id_costumer'
        ";
$result = mysqli_query($this->conn, $query);

if (!$result) {
    echo "<pre>";
    echo "QUERY ERROR:\n";
    echo mysqli_error($this->conn);
    echo "\n\nQUERY:\n";
    echo $query;
    echo "</pre>";
    exit;
}

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    // =========================
    // HITUNG TOTAL
    // =========================
    public function getTotal($items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['harga'] * $item['kuantitas'];
        }

        return $total;
    }
}