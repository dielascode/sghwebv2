<?php
// $host = "localhost";
// $user = "root";
// $password = "";
// $database = "sgh";

// $conn = mysqli_connect($host, $user, $password, $database);

// if (!$conn) {
//     die("Koneksi gagal: " . mysqli_connect_error());
// }
?>
<?php
class Database{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "sgh";

    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new mysqli(
                $this->host, $this->user, $this->password, $this->database
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getConnection(){
        return $this->conn;
    }
}
?>