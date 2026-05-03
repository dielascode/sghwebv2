<?php


class Costumer
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getCustomers()
    {
        $role = 'costumer';
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE role = ?");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getCustomerStats()
    {
        $query = "SELECT 
                COUNT(*) as total_pelanggan,
                SUM(CASE WHEN status = 'aktif' THEN 1 ELSE 0 END) as total_aktif
              FROM $this->table 
              WHERE role = 'costumer'";

        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    public function getTotalUserBaruBulanIni()
    {
        $query = "SELECT COUNT(*) as total 
              FROM $this->table 
              WHERE role = 'costumer' 
              AND MONTH(tanggal_daftar) = MONTH(CURRENT_DATE())
              AND YEAR(tanggal_daftar) = YEAR(CURRENT_DATE())";

        $result = $this->conn->query($query);
        $data = $result->fetch_assoc();

        return $data['total'] ?? 0;
    }
}
