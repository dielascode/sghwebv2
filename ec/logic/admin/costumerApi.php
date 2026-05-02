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
}
