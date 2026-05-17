<?php
class Dashboard {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getStats() {

    // total user
    $users = $this->conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();

    // total pesanan
    $orders = $this->conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc();

    // recent orders
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

    // chart 7 hari terakhir
    $chart = $this->conn->query("
        SELECT DATE(tanggal_order) as tanggal, COUNT(*) as total
        FROM pesanan
        WHERE tanggal_order >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(tanggal_order)
        ORDER BY tanggal ASC
    ");

    $labels = [];
    $data = [];

    while($row = $chart->fetch_assoc()){
        $labels[] = $row['tanggal'];
        $data[] = (int)$row['total'];
    }

    return [
        'users' => (int)$users['total'],
        'orders' => (int)$orders['total'],
        'recentOrders' => $recentOrders,
        'chart' => [
            'labels' => $labels,
            'data' => $data
        ]
    ];
}
}