<?php

class KeranjangApi
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ── Helper: prepare → bind → execute → result ──────────────────
    private function query(string $sql, string $types = '', array $params = [])
    {
        $stmt = mysqli_prepare($this->conn, $sql);

        if ($types && $params) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    private function exec(string $sql, string $types, array $params): bool
    {
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        return mysqli_stmt_execute($stmt);
    }

    // ── Cart ────────────────────────────────────────────────────────
    public function getCart(string $id_costumer)
    {
        return $this->query("
           SELECT 
                k.kuantitas,
                p.id AS id_produk,
                p.nama_produk,
                p.harga,
                v.nama_varietas
            FROM keranjang k
            JOIN produk p ON k.id_produk = p.id
            JOIN detail_produk dp ON p.id = dp.id_produk
            JOIN varietas v ON dp.id_varietas = v.id
            WHERE k.id_costumer = ?
        ", 's', [$id_costumer]);
    }

    public function checkCart(string $id_produk, string $id_costumer)
    {
        return $this->query(
            "SELECT kuantitas FROM keranjang WHERE id_produk = ? AND id_costumer = ?",
            'ss',
            [$id_produk, $id_costumer]
        );
    }

  public function getProduk(string $id_produk)
{
    return $this->query(
        "SELECT id, stok FROM produk WHERE id = ?", // tambah stok
        's',
        [$id_produk]
    );
}

    public function getTotalCart(string $id_costumer)
    {
        return $this->query(
            "SELECT COUNT(*) as total FROM keranjang WHERE id_costumer = ?",
            's',
            [$id_costumer]
        );
    }

    public function getKuantitasCart(string $id_produk, string $id_costumer)
    {
        return $this->query(
            "SELECT kuantitas FROM keranjang WHERE id_produk = ? AND id_costumer = ?",
            'ss',
            [$id_produk, $id_costumer]
        );
    }

    // ── Write ───────────────────────────────────────────────────────
    public function insertCart(string $id, $id_produk, string $id_costumer, int $kuantitas): bool
    {
        return $this->exec(
            "INSERT INTO keranjang (id, id_produk, id_costumer, kuantitas) VALUES (?, ?, ?, ?)",
            'sssi',
            [$id, $id_produk, $id_costumer, $kuantitas]
        );
    }

    public function updateCart(int $kuantitas, $id_produk, string $id_costumer): bool
    {
        return $this->exec(
            "UPDATE keranjang SET kuantitas = kuantitas + ? WHERE id_produk = ? AND id_costumer = ?",
            'iss',
            [$kuantitas, $id_produk, $id_costumer]
        );
    }

    public function setKuantitas(int $kuantitas, $id_produk, string $id_costumer): bool
    {
        return $this->exec(
            "UPDATE keranjang SET kuantitas = ? WHERE id_produk = ? AND id_costumer = ?",
            'iss',
            [$kuantitas, $id_produk, $id_costumer]
        );
    }

    public function deleteCart($id_produk, string $id_costumer): bool
    {
        return $this->exec(
            "DELETE FROM keranjang WHERE id_produk = ? AND id_costumer = ?",
            'ss',
            [$id_produk, $id_costumer]
        );
    }

    // ── Generate ID ─────────────────────────────────────────────────
    public function generateId(): string
    {
        $row = mysqli_fetch_assoc(
            mysqli_query($this->conn, "SELECT id FROM keranjang ORDER BY id DESC LIMIT 1")
        );

        $next = $row ? (int) substr($row['id'], 3) + 1 : 1;

        return 'KRJ' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}