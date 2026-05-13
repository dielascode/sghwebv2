<?php
require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/pemesananApi.php';

class PemesananController
{
    private $api;

    public function __construct($conn)
    {
        $this->api = new PemesananApi($conn);
    }

    public function getSelectedProduk($id_costumer, $selected = [])
    {
        return $this->api->getSelectedProduk($id_costumer, $selected);
    }

    public function getTotal($items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['harga'] * $item['kuantitas'];
        }

        return $total;
    }
    public function getBuyNowProduk($id_produk)
{
    return $this->api->getBuyNowProduk($id_produk);
}
}