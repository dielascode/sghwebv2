<?php
class Pesanan
{
    private $conn;
    private $table = "pesanan";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPesanan()
    {
        return $this->conn->query("
            SELECT 
                $this->table.*,
                $this->table.status AS status_pesanan,
                users.status AS status_user,
                users.nama
            FROM $this->table
            JOIN users ON $this->table.id_costumer = users.id
            ORDER BY tanggal_order DESC
        ");
    }
    public function getTotalOrdersStats()
    {
        $query = "SELECT 
                COUNT(*) as total_order
              FROM $this->table ";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    public function getTotalOrdersWaitingStats()
    {
        $query = "SELECT 
                COUNT(*) as total_order_waiting
              FROM $this->table WHERE status = 'menunggu_konfirmasi'";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    public function getTotalOrdersProcessStats()
    {
        $query = "SELECT 
                COUNT(*) as total_order_process
              FROM $this->table WHERE status = 'diproses'";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    public function getTotalOrdersSendStats()
    {
        $query = "SELECT 
                COUNT(*) as total_order_send
              FROM $this->table WHERE status = 'dikirim'";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    public function getTotalOrdersDoneStats()
    {
        $query = "SELECT 
                COUNT(*) as total_order_done
              FROM $this->table WHERE status = 'selesai'";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    public function getDetail($nomor_pesanan)
    {
        $query = "SELECT 
                    $this->table.*,
                    users.nama,
                    users.email,
                    users.nomor_telepon,
                    alamat_costumer.alamat
                FROM $this->table
                JOIN users ON $this->table.id_costumer = users.id
                LEFT JOIN alamat_costumer 
                    ON alamat_costumer.id_costumer = users.id 
                    AND alamat_costumer.status = 'utama'
                WHERE $this->table.nomor_pesanan = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nomor_pesanan);
        $stmt->execute();
        $pesanan = $stmt->get_result()->fetch_assoc();
        $queryDetail = "SELECT 
            detail_pesanan.*,
            produk.nama_produk,
            produk.harga
            FROM detail_pesanan
            JOIN produk ON detail_pesanan.id_produk = produk.id
            WHERE detail_pesanan.nomor_pesanan = ?";
        $stmtDetail = $this->conn->prepare($queryDetail);
        $stmtDetail->bind_param("s", $pesanan['nomor_pesanan']);
        $stmtDetail->execute();

        $pesanan['items'] = $stmtDetail->get_result()->fetch_all(MYSQLI_ASSOC);

        return $pesanan;
    }
    public function toggleStatus($nomor_pesanan, $status)
    {
        $query = "UPDATE pesanan SET status=? WHERE nomor_pesanan=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $status, $nomor_pesanan);

        if ($stmt->execute()) {
            return [
                "status" => true,
                "message" => "Status berhasil diubah ke $status"
            ];
        } else {
            return [
                "status" => false,
                "message" => $stmt->error
            ];
        }
    }
    public function cancelStatus($nomor_pesanan, $status)
    {
        $query = "UPDATE pesanan SET status=? WHERE nomor_pesanan=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $status, $nomor_pesanan);

        if ($stmt->execute()) {
            return [
                "status" => true,
                "message" => "Status berhasil diubah ke $status"
            ];
        } else {
            return [
                "status" => false,
                "message" => $stmt->error
            ];
        }
    }
}
