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
            SELECT k.kuantitas, dp.id AS id_detail,
                   p.id AS id_produk, p.nama_produk, p.harga,
                   v.nama_varietas
            FROM keranjang k
            JOIN detail_produk dp ON k.id_detail_produk = dp.id
            JOIN produk p         ON dp.id_produk = p.id
            JOIN varietas v       ON dp.id_varietas = v.id
            WHERE k.id_costumer = ?
        ", 's', [$id_costumer]);
    }

    public function checkCart(string $id_detail, string $id_costumer)
    {
        return $this->query(
            "SELECT kuantitas FROM keranjang WHERE id_detail_produk = ? AND id_costumer = ?",
            'is', [$id_detail, $id_costumer]
        );
    }

    public function getProduk(string $id_detail)
    {
        return $this->query(
            "SELECT id FROM detail_produk WHERE id = ?",
            'i', [$id_detail]
        );
    }

    public function getTotalCart(string $id_costumer)
    {
        return $this->query(
            "SELECT COUNT(*) as total FROM keranjang WHERE id_costumer = ?",
            's', [$id_costumer]
        );
    }

    public function getKuantitasCart(string $id_detail, string $id_costumer)
    {
        return $this->query(
            "SELECT kuantitas FROM keranjang WHERE id_detail_produk = ? AND id_costumer = ?",
            'is', [$id_detail, $id_costumer]
        );
    }

    // ── Write ───────────────────────────────────────────────────────
    public function insertCart(string $id, $id_detail, string $id_costumer, int $kuantitas): bool
    {
        return $this->exec(
            "INSERT INTO keranjang (id, id_detail_produk, id_costumer, kuantitas) VALUES (?, ?, ?, ?)",
            'sisi', [$id, $id_detail, $id_costumer, $kuantitas]
        );
    }

    public function updateCart(int $kuantitas, $id_detail, string $id_costumer): bool
    {
        return $this->exec(
            "UPDATE keranjang SET kuantitas = kuantitas + ? WHERE id_detail_produk = ? AND id_costumer = ?",
            'iis', [$kuantitas, $id_detail, $id_costumer]
        );
    }

    public function setKuantitas(int $kuantitas, $id_detail, string $id_costumer): bool
    {
        return $this->exec(
            "UPDATE keranjang SET kuantitas = ? WHERE id_detail_produk = ? AND id_costumer = ?",
            'iis', [$kuantitas, $id_detail, $id_costumer]
        );
    }

    public function deleteCart($id_detail, string $id_costumer): bool
    {
        return $this->exec(
            "DELETE FROM keranjang WHERE id_detail_produk = ? AND id_costumer = ?",
            'is', [$id_detail, $id_costumer]
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