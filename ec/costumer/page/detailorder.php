<div class="container-pesanan d-flex">
    <!-- SIDEBAR -->
    <?php include "../elemen/sidebar_pesanan.php"; ?>
    <div class="container-detailorder">

        <!-- Header -->
        <div class="header-detailorder">
            <h1 class="title-detailorder">Detail order</h1>
            <p class="order-id-detailorder">#SGP20260012</p>
            <p class="order-date-detailorder">Dibuat pada: 13 Januari 2026, 08:30 WIB</p>
        </div>

        <!-- Status Badge -->
        <!-- <div class="status-wrapper-detailorder">
            <span class="status-badge-detailorder">
                <span class="status-dot-detailorder"></span>
                Menunggu Konfirmasi Admin
            </span>
        </div> -->

        <!-- Order Items Table -->
        <div class="card-detailorder">
            <table class="table-detailorder">
                <div class="card-status-bar">
                    <span class="status-dot"></span>
                    <span class="status-label">Menunggu Konfirmasi Admin</span>
                </div>
                <thead>
                    <tr>
                        <th class="th-detailorder">Produk</th>
                        <th class="th-detailorder th-right-detailorder">subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td-detailorder">
                            <div class="product-row-detailorder">
                                <div class="product-img-wrap-detailorder">
                                    <!-- Melon emoji placeholder -->
                                    <span class="product-emoji-detailorder">🍈</span>
                                </div>
                                <div class="product-info-detailorder">
                                    <p class="product-name-detailorder">Melom Honey Globe</p>
                                    <p class="product-qty-detailorder">Jumlah: 2 Kg</p>
                                </div>
                            </div>
                        </td>
                        <td class="td-detailorder td-right-detailorder">Rp 60,000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="tfoot-label-detailorder">Total Bayar</td>
                        <td class="tfoot-total-detailorder">Rp 60,000</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Bottom Grid: 3 Columns -->
        <div class="grid-detailorder">

            <!-- Kolom 1: Detail Pengiriman -->
            <div class="info-card-detailorder">
                <h3 class="info-card-title-detailorder">Detail Pengiriman</h3>
                <p class="info-card-sub-detailorder">Perkiraan Sampai: 13 Januari 2026</p>

                <ul class="info-list-detailorder">
                    <li class="info-item-detailorder">
                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 12c2.7 0 4-1.79 4-4s-1.3-4-4-4-4 1.79-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </span>
                        <span>Aril Gantenk</span>
                    </li>
                    <li class="info-item-detailorder">
                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                            </svg>
                        </span>
                        <span>0878-5584-4023</span>
                    </li>
                    <li class="info-item-detailorder">
                        <span class="info-icon-detailorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                            </svg>
                        </span>
                        <span>JL Raya Polije No7<br />Jember, Jawa Timur</span>
                    </li>
                </ul>
            </div>

            <!-- Kolom 2: Informasi Pembayaran + Pelanggan -->
            <div class="info-card-detailorder">
                <div class="payment-section-detailorder">
                    <h3 class="info-card-title-detailorder">Informasi Pembayaran</h3>
                    <ul class="info-list-detailorder">
                        <li class="info-item-detailorder">
                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V10h16v8zm0-10H4V6h16v2z" />
                                </svg>
                            </span>
                            <span class="payment-method-detailorder">Qris</span>
                        </li>
                        <li class="info-item-detailorder">
                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                                </svg>
                            </span>
                            <span>Rp 60,000</span>
                        </li>
                        <li class="info-item-detailorder">
                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z" />
                                </svg>
                            </span>
                            <span>13 Januari 2026, 08:30 WIB</span>
                        </li>
                    </ul>
                </div>

                <div class="divider-detailorder"></div>

                <div class="customer-section-detailorder">
                    <h3 class="info-card-title-detailorder">Informasi Pelanggan</h3>
                    <ul class="info-list-detailorder">
                        <li class="info-item-detailorder">
                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 12c2.7 0 4-1.79 4-4s-1.3-4-4-4-4 1.79-4 4 1.3 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </span>
                            <span>ID Pelanggan: SGP20260012</span>
                        </li>
                        <li class="info-item-detailorder">
                            <span class="info-icon-detailorder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                                </svg>
                            </span>
                            <span>0878-5584-4023</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Kolom 3: Bukti Pembayaran -->
            <div class="info-card-detailorder">
                <h3 class="info-card-title-detailorder">Bukti Pembayaran</h3>
                <div class="proof-img-detailorder">
                    <img src="/sghwebv2/ec/images/tf.jpg" alt="Bukti Pembayaran" class="proof-image-detailorder" />
                </div>
            </div>

        </div><!-- end grid -->

    </div><!-- end container -->
</div>