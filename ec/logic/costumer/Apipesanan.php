<?php

class PesananApi
{
    public function __construct(private $conn) {}

    private function query(string $sql, string $types, array $params)
    {
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    private function exec(string $sql, string $types, array $params): void
    {
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
    }

    public function getSelectedProduk(string $id_costumer, array $selected): array
{
    if (empty($selected)) return [];

    $ids  = implode(",", array_map(fn($id) => "'" . mysqli_real_escape_string($this->conn, $id) . "'", $selected));
    $rows = $this->query("
        SELECT k.kuantitas, p.id AS id_produk, p.nama_produk, p.harga, p.deskripsi, v.nama_varietas
        FROM keranjang k
        JOIN produk p ON k.id_produk = p.id
        JOIN detail_produk dp ON p.id = dp.id_produk
        JOIN varietas v ON dp.id_varietas = v.id
        WHERE k.id_produk IN ($ids) AND k.id_costumer = ?
        GROUP BY p.id
    ", 's', [$id_costumer]);

    $data = [];
    while ($row = mysqli_fetch_assoc($rows)) $data[] = $row;
    return $data;
}
public function getBuyNowProduk(string $id_produk): array|null
{
    return mysqli_fetch_assoc($this->query("
        SELECT p.id AS id_produk, p.nama_produk, p.harga, p.deskripsi, v.nama_varietas
        FROM produk p
        JOIN detail_produk dp ON p.id = dp.id_produk
        JOIN varietas v ON dp.id_varietas = v.id
        WHERE p.id = ?
        GROUP BY p.id
        LIMIT 1
    ", 's', [$id_produk]));
}

    public function insertPesanan(string $nomor, string $id_costumer, ?string $bukti): void
    {
        $this->exec(
            "INSERT INTO pesanan (nomor_pesanan, id_costumer, bukti_bayar, metode, tanggal_order, status)
             VALUES (?, ?, ?, 'QRIS', NOW(), 'menunggu_konfirmasi')",
            'sss', [$nomor, $id_costumer, $bukti]
        );
    }

    public function insertDetail(string $nomor, string $id_produk, int $kuantitas): void
    {
        $this->exec(
            "INSERT INTO detail_pesanan (nomor_pesanan, id_produk, kuantitas) VALUES (?, ?, ?)",
            'ssi', [$nomor, $id_produk, $kuantitas]
        );
    }

    public function getKuantitasKeranjang(string $id_produk, string $id_costumer): array|null
    {
        return mysqli_fetch_assoc($this->query(
            "SELECT kuantitas FROM keranjang WHERE id_produk = ? AND id_costumer = ?",
            'ss', [$id_produk, $id_costumer]
        ));
    }

    public function deleteKeranjang(string $id_produk, string $id_costumer): void
    {
        $this->exec(
            "DELETE FROM keranjang WHERE id_produk = ? AND id_costumer = ?",
            'ss', [$id_produk, $id_costumer]
        );
    }

    public function getByStatus(string $id_costumer, string $status)
    {
        return $this->query(
            "SELECT * FROM pesanan WHERE id_costumer = ? AND status = ? ORDER BY tanggal_order DESC",
            'ss', [$id_costumer, $status]
        );
    }

    public function getDetail(string $nomor)
    {
        return $this->query("
            SELECT dp.kuantitas, dp.id_produk, p.nama_produk, p.harga AS harga_produk,
                (SELECT gambar FROM gambar_produk WHERE id_produk = p.id LIMIT 1) AS foto_produk
            FROM detail_pesanan dp
            JOIN produk p ON dp.id_produk = p.id
            WHERE dp.nomor_pesanan = ?
        ", 's', [$nomor]);
    }
  
}