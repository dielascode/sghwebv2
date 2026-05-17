<?php
class Dashboard {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getStats() {

        $users = $this->conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();

        $orders = $this->conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc();

        // $revenue = $this->conn->query("SELECT SUM(total_harga) as total FROM pesanan WHERE status='selesai'")->fetch_assoc();

        $recent = $this->conn->query("
            SELECT pesanan.nomor_pesanan, users.nama, pesanan.status, pesanan.tanggal_order
            FROM pesanan
            JOIN users ON pesanan.id_costumer = users.id
            ORDER BY pesanan.tanggal_order DESC
            LIMIT 5
        ");

        $recentOrders = [];
        while($row = $recent->fetch_assoc()){
            $recentOrders[] = $row;
        }

        $chart = $this->conn->query("
            SELECT DATE(tanggal_order) as tanggal, COUNT(*) as total
            FROM pesanan
            WHERE tanggal_order >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(tanggal_order)
        ");

        $chartData = [];
        while($row = $chart->fetch_assoc()){
            $chartData[] = $row;
        }

        return [
            'users' => $users['total'],
            'orders' => $orders['total'],
            'revenue' => $revenue['total'] ?? 0,
            'recentOrders' => $recentOrders,
            'chart' => $chartData
        ];
    }
}