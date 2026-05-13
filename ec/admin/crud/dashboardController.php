<?php
header('Content-Type: application/json');

include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/dashboardApi.php";

$db = new Database();
$conn = $db->getConnection();
$dashboard = new Dashboard($conn);


$data = $dashboard->getStats();

echo json_encode($data);