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
    // =========================private function getDetail($nomor_pesanan)
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

    (
        SELECT gp.gambar
        FROM gambar_produk gp
        WHERE gp.id_produk = produk.id
        LIMIT 1
    ) AS gambar

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

WHERE pesanan.nomor_pesanan = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("SQL ERROR: " . $this->conn->error);
        }

        $stmt->bind_param("s", $nomor_pesanan);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($result as &$row) {

            if ($row['status'] == 'menunggu_konfirmasi') {

                $row['status_label'] = 'Menunggu Konfirmasi';
                $row['status_color'] = '#ef6c00';
                $row['status_bg'] = '#fff3e0';

            } elseif ($row['status'] == 'diproses') {

                $row['status_label'] = 'Sedang Diproses';
                $row['status_color'] = '#1565c0';
                $row['status_bg'] = '#e3f2fd';

            } elseif ($row['status'] == 'dikirim') {

                $row['status_label'] = 'Sedang Dikirim';
                $row['status_color'] = '#6a1b9a';
                $row['status_bg'] = '#f3e5f5';

            } elseif ($row['status'] == 'selesai') {

                $row['status_label'] = 'Selesai';
                $row['status_color'] = '#2e7d32';
                $row['status_bg'] = '#e8f5e9';

            } elseif ($row['status'] == 'dibatalkan') {

                $row['status_label'] = 'Pesanan Dibatalkan';
                $row['status_color'] = '#c62828';
                $row['status_bg'] = '#ffebee';

            } else {

                $row['status_label'] = ucfirst($row['status']);
                $row['status_color'] = '#424242';
                $row['status_bg'] = '#eeeeee';

            }

        }

        foreach ($result as &$row) {

            $alamat = json_decode($row['alamat'], true);

            if ($alamat) {

                $alamatLengkap = $alamat['jalan'];

                if (!empty($alamat['detail'])) {

                    $alamatLengkap .= ', ' . $alamat['detail'];

                }

                $alamatLengkap .=
                    ', ' . $alamat['kelurahan'] .
                    ', ' . $alamat['kecamatan'] .
                    ', ' . $alamat['kota'] .
                    ', ' . $alamat['provinsi'];

                $row['alamat_lengkap'] = $alamatLengkap;

            } else {

                $row['alamat_lengkap'] = '-';

            }

        }

        return $result;
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

