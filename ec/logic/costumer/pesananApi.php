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
}
