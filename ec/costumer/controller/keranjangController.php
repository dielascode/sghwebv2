<?php

if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/keranjangApi.php';

class KeranjangController
{
    private KeranjangApi $api;

    public function __construct($conn)
    {
        $this->api = new KeranjangApi($conn);
    }

    // ── Helper ambil session id ──────────────────────────────────────
    private function userId(): string
    {
        return $_SESSION['id'] ?? '';
    }

    // ── Tampil cart (dipanggil dari view) ────────────────────────────
    public function index(): array
    {
        $cart     = [];
        $subtotal = 0;
        $totalQty = 0;

        $result = $this->api->getCart($this->userId());

        while ($item = mysqli_fetch_assoc($result)) {
            $cart[]    = $item;
            $subtotal += $item['harga'] * $item['kuantitas'];
            $totalQty += $item['kuantitas'];
        }

        return [
            'cart'      => $cart,
            'subtotal'  => $subtotal,
            'totalQty'  => $totalQty,
            'totalItem' => count($cart),
        ];
    }

    // ── Handle AJAX request ──────────────────────────────────────────
    public function handleRequest(): void
    {
        $action = $_POST['action'] ?? null;

        match ($action) {
            'add'            => $this->add(),
            'get_total'      => $this->getTotal(),
            'kuantitas'      => $this->updateKuantitas(),
            'delete_selected'=> $this->deleteSelected(),
            'set_selected'   => $this->setSelected(),
            default          => http_response_code(400),
        };
    }

    // ── Add to cart ──────────────────────────────────────────────────
    public function add(): void
    {
        $uid       = $this->userId() ?: die("SESSION KOSONG");
        $id_detail = $_POST['id_detail'] ?? null ?: die("ID produk kosong");
        $kuantitas = (int) ($_POST['kuantitas'] ?? 1);

        if (!mysqli_fetch_assoc($this->api->getProduk($id_detail))) {
            die("produk tidak ditemukan");
        }

        $exists = mysqli_num_rows($this->api->checkCart($id_detail, $uid)) > 0;

        $exists
            ? $this->api->updateCart($kuantitas, $id_detail, $uid)
            : $this->api->insertCart($this->api->generateId(), $id_detail, $uid, $kuantitas);

        echo "success";
    }

    // ── Get total badge ──────────────────────────────────────────────
    public function getTotal(): void
    {
        $uid = $this->userId();

        if (!$uid) { echo 0; return; }

        $row = mysqli_fetch_assoc($this->api->getTotalCart($uid));

        echo $row['total'] ?? 0;
    }

    // ── Update kuantitas ─────────────────────────────────────────────
    public function updateKuantitas(): void
    {
        $uid       = $this->userId();
        $id_detail = $_POST['id_detail'] ?? null ?: die("ID kosong");
        $delta     = (int) ($_POST['kuantitas'] ?? 0);

        $item = mysqli_fetch_assoc(
            $this->api->getKuantitasCart($id_detail, $uid)
        ) ?: die("produk tidak ditemukan");

        $new = $item['kuantitas'] + $delta;

        $new <= 0
            ? $this->api->deleteCart($id_detail, $uid)
            : $this->api->setKuantitas($new, $id_detail, $uid);

        echo "success";
    }

    // ── Delete selected ──────────────────────────────────────────────
    public function deleteSelected(): void
    {
        $uid = $this->userId();
        $ids = json_decode($_POST['ids'] ?? '[]', true);

        if (!is_array($ids) || empty($ids)) die("data kosong");

        foreach ($ids as $id) {
            $this->api->deleteCart($id, $uid);
        }

        echo "success";
    }

    // ── Set selected ke session ──────────────────────────────────────
    public function setSelected(): void
    {
        $ids = json_decode($_POST['ids'] ?? '[]', true);

        if (!is_array($ids) || empty($ids)) { echo "invalid"; return; }

        $_SESSION['selected_cart'] = $ids;

        echo "success";
    }
}

// ── Endpoint AJAX ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db   = new Database();
    $ctrl = new KeranjangController($db->getConnection());
    $ctrl->handleRequest();
}