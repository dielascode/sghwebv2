<?php
// include __DIR__ . "/../../config/connection.php"; 

class Buah
{
    private $conn;
    private $table = "buah";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBuah()
    {
        // $query = "select * from buah";
        // $result = mysqli_query($conn, $query);

        // $buah = [];
        // while ($row = mysqli_fetch_assoc($result)) {
        //     $buah[] = $row;
        // }

        // return $buah;
        return $this->conn->query("SELECT * FROM $this->table");
    }

    // Di dalam buahApi.php pada function store
public function store($data) {
    $stmt = $this->conn->prepare("INSERT INTO $this->table(nama_buah) VALUES (?)");
    $stmt->bind_param("s", $data['nama_buah']);
    
    if ($stmt->execute()) {
        return [
            'status' => true,
            'message' => 'Buah berhasil disimpan ke AgriNexa!'
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Gagal simpan: ' . $this->conn->error
        ];
    }
}

    public function update($id, $data)
    {
        // $nama_buah = mysqli_real_escape_string($conn, $nama_buah);

        // $query = "UPDATE buah 
        //       SET nama_buah='$nama_buah'
        //       WHERE id=$id";

        // return mysqli_query($conn, $query);
        $stmt = $this->conn->prepare("UPDATE $this->table SET nama_buah=? WHERE id=?");
        $stmt->bind_param("si", $data['nama_buah'], $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM buah WHERE id='$id'";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$id])) {
            return [
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Gagal menghapus data'
            ];
        }
    }
    public function getBuahById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
