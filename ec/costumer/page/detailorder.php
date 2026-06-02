<?php

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/pesananApi.php';

$db = new Database();
$conn = $db->getConnection();

$api = new PesananApi($conn);

$nomor_pesanan = $_GET['nomor_pesanan'] ?? null;

if (!$nomor_pesanan) {
    die("Nomor pesanan tidak ditemukan");
}

$data = $api->getDetailOrder($nomor_pesanan);

if (!$data) {
    die("Data pesanan tidak ditemukan");
}

$header = $data[0];

$total = 0;
?>

<div class="container-pesanan d-flex">

    <!-- SIDEBAR -->
    <?php include __DIR__ . '/../elemen/sidebar_pesanan.php'; ?>

    <div class="container-detailorder">

        <!-- Header -->
        <div class="header-detailorder">

            <h1 class="title-detailorder">
                Detail Order
            </h1>

            <p class="order-id-detailorder">
                <?= $header['nomor_pesanan'] ?>
            </p>

            <p class="order-date-detailorder">
                Dibuat pada:
                <?= date('d F Y H:i', strtotime($header['tanggal_order'])) ?> WIB
            </p>

        </div>

        <!-- CARD TABLE -->
        <div class="card-detailorder">

            <div class="card-status-bar">



                <span class="status-label">
                    <div style="
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    background: <?= $data[0]['status_bg'] ?>;
    color: <?= $data[0]['status_color'] ?>;
    font-size:13px;
    font-weight:bold;
">
                        <?= $data[0]['status_label'] ?>
                    </div>
                </span>

            </div>

            <table class="table-detailorder">

                <thead>

                    <tr>

                        <th class="th-detailorder">
                            Produk
                        </th>

                        <th class="th-detailorder th-right-detailorder">
                            Subtotal
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($data as $item): ?>

                        <?php
                        $subtotal = $item['kuantitas'] * $item['harga'];
                        $total += $subtotal;
                        ?>

                        <tr>

                            <td class="td-detailorder">

                                <div class="product-row-detailorder">

                                    <div class="product-img-wrap-detailorder">

                                        <img src="../asset/image/produk/<?= $item['gambar'] ?? 'melon1.jpg' ?>"
                                            width="70" style="border-radius:7px;">

                                    </div>

                                    <div class="product-info-detailorder">

                                        <p class="product-name-detailorder">
                                            <?= $item['nama_produk'] ?>
                                        </p>

                                        <p class="product-qty-detailorder">
                                            Jumlah:
                                            <?= $item['kuantitas'] ?> Kg
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="td-detailorder td-right-detailorder">

                                Rp <?= number_format($subtotal, 0, ',', '.') ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

                <tfoot>

                    <tr>

                        <td class="tfoot-label-detailorder">
                            Total Bayar
                        </td>

                        <td class="tfoot-total-detailorder">

                            Rp <?= number_format($total, 0, ',', '.') ?>

                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

        <!-- GRID -->
        <div class="grid-detailorder">

            <!-- DETAIL PENGIRIMAN -->
            <div class="info-card-detailorder">

                <h3 class="info-card-title-detailorder">
                    Detail Pengiriman
                </h3>

                <p class="info-card-sub-detailorder">
                    Perkiraan Sampai:
                    <?= date('d F Y', strtotime($header['tanggal_order'] . ' +2 days')) ?>
                </p>

                <ul class="info-list-detailorder">

                    <li class="info-item-detailorder">

                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 12c2.7 0 4-1.79 4-4s-1.3-4-4-4-4 1.79-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </span>

                        <span>
                            <?= $header['nama'] ?>
                        </span>

                    </li>

                    <li class="info-item-detailorder">

                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                            </svg>
                        </span>

                        <span>
                            <?= $header['no_hp'] ?>
                        </span>

                    </li>

                    <li class="info-item-detailorder">

                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                            </svg>
                        </span>

                        <span>
                            <?= $data[0]['alamat_lengkap'] ?>
                        </span>

                    </li>

                </ul>

            </div>

            <!-- PEMBAYARAN -->
            <div class="info-card-detailorder">

                <div class="payment-section-detailorder">

                    <h3 class="info-card-title-detailorder">
                        Informasi Pembayaran
                    </h3>

                    <ul class="info-list-detailorder">

                        <li class="info-item-detailorder">

                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V10h16v8zm0-10H4V6h16v2z" />
                                </svg>
                            </span>

                            <span class="payment-method-detailorder">
                                <?= $header['metode'] ?>
                            </span>

                        </li>

                        <li class="info-item-detailorder">

                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                                </svg>
                            </span>

                            <span>
                                Rp <?= number_format($total, 0, ',', '.') ?>
                            </span>

                        </li>

                        <li class="info-item-detailorder">

                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z" />
                                </svg>
                            </span>

                            <span>
                                <?= date('d F Y H:i', strtotime($header['tanggal_order'])) ?>
                            </span>

                        </li>

                    </ul>

                </div>

                <div class="divider-detailorder"></div>

                <!-- CUSTOMER -->
                <div class="customer-section-detailorder">

                    <h3 class="info-card-title-detailorder">
                        Informasi Pelanggan
                    </h3>

                    <ul class="info-list-detailorder">

                        <li class="info-item-detailorder">

                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 12c2.7 0 4-1.79 4-4s-1.3-4-4-4-4 1.79-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </span>

                            <span>
                                ID Pelanggan:
                                <?= $header['id_costumer'] ?>
                            </span>

                        </li>

                        <li class="info-item-detailorder">

                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                                </svg>
                            </span>

                            <span>
                                <?= $header['no_hp'] ?>
                            </span>

                        </li>

                    </ul>

                </div>

            </div>

            <!-- BUKTI BAYAR -->
            <div class="info-card-detailorder">

                <h3 class="info-card-title-detailorder">
                    Bukti Pembayaran
                </h3>

                <div class="proof-img-detailorder">

                    <img src="../asset/image/bukti_bayar/<?= $header['bukti_bayar'] ?>" alt="Bukti Pembayaran"
                        class="proof-image-detailorder" />

                </div>

            </div>

        </div>

    </div>

</div>