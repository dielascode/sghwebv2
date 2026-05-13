<?php
require_once '../../config/connection.php';
class PesananAPI
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // =========================
    // AMBIL PESANAN USER
    // =========================
    public function getOrderHistory($id_costumer)
    {
        $pesanan = $this->getPesanan($id_costumer);
        $result = [];

        foreach ($pesanan as $p) {

            $detail = $this->getDetail($p['nomor_pesanan']);

            $total_qty = 0;
            $total_harga = 0;

            foreach ($detail as $d) {
                $total_qty += $d['kuantitas'];
                $total_harga += $d['kuantitas'] * $d['harga'];
            }

            $first = $detail[0] ?? null;

            $result[] = [
                "nomor_pesanan" => $p['nomor_pesanan'],
                "status" => $p['status'],
                "tanggal_order" => $p['tanggal_order'],

                "nama_produk" => $first['nama_produk'] ?? '-',
                "gambar" => $first['gambar'] ?? 'default.png',

                "total_qty" => $total_qty,
                "total_harga" => $total_harga,

                "detail" => $detail
            ];
        }

        return $result;
    }

    // =========================
    // GET PESANAN
    // =========================
    private function getPesanan($id_costumer)
    {
        $sql = "SELECT * FROM pesanan 
                WHERE id_costumer = ?
                ORDER BY tanggal_order DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_costumer);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // =========================
    // GET DETAIL PESANAN
    // =========================
    private function getDetail($nomor_pesanan)
    {
        $sql = "SELECT 
            d.nomor_pesanan,
            d.id_produk,
            d.kuantitas,
            p.nama_produk,
            p.harga,
            (SELECT gp.gambar 
             FROM gambar_produk gp 
             WHERE gp.id_produk = p.id 
             LIMIT 1) as gambar
        FROM detail_pesanan d
        JOIN produk p 
            ON p.id = d.id_produk
        WHERE d.nomor_pesanan = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("SQL ERROR: " . $this->conn->error);
        }

        $stmt->bind_param("s", $nomor_pesanan);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetailOrder($nomor_pesanan)
    {
        $query = "SELECT 
                pesanan.nomor_pesanan,
                pesanan.id_costumer,
                pesanan.tanggal_order,
                pesanan.status,
                pesanan.metode,
                pesanan.bukti_bayar,

                users.nama,
                users.nomor_telepon AS no_hp,

                alamat_costumer.alamat,

                detail_pesanan.kuantitas,

                produk.nama_produk,
                produk.harga,

                gambar_produk.gambar

            FROM pesanan

            JOIN users
                ON users.id = pesanan.id_costumer

            LEFT JOIN alamat_costumer
                ON alamat_costumer.id_costumer = users.id
                AND alamat_costumer.status = 'utama'

            JOIN detail_pesanan
                ON detail_pesanan.nomor_pesanan = pesanan.nomor_pesanan

            JOIN produk
                ON produk.id = detail_pesanan.id_produk

            LEFT JOIN gambar_produk
                ON gambar_produk.id_produk = produk.id

            WHERE pesanan.nomor_pesanan = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("SQL ERROR: " . $this->conn->error);
        }

        $stmt->bind_param("s", $nomor_pesanan);

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    

    public function toggleStatus($nomor_pesanan, $status)
    {
        $query = "UPDATE pesanan 
                  SET status=? 
                  WHERE nomor_pesanan=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $status, $nomor_pesanan);

        if ($stmt->execute()) {

            return [
                "status" => true,
                "message" => "Status berhasil diubah"
            ];

        } else {

            return [
                "status" => false,
                "message" => $stmt->error
            ];

        }
    }
}

