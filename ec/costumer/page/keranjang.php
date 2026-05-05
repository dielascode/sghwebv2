<main class="cart-wrapper">
    <div class="container-keranjang">
        <h1 class="page-title1">Keranjang Saya</h1>
        <p class="product-count">4 Produk</p>

        <div class="cart-grid">
            <section class="cart-items-section">
                <div class="select-all-bar">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        Pilih Semua
                    </label>
                    <button class="btn-delete-selected">Hapus Dipilih</button>
                </div>

                <div class="cart-card">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                    </label>
                    <div class="product-img">
                        <img src="/sghwebv2/ec/images/produk6.png" alt="Melon Honey Globe">
                    </div>
                    <div class="product-info">
                        <h3>Melon</h3>
                        <p class="sub-name">Honey Globe</p>
                        <div class="action-row">
                            <div class="qty-picker">
                                <button>-</button>
                                <input type="text" value="1">
                                <button>+</button>
                            </div>
                            <span class="badge-stock">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="product-price">
                        Rp 30.000
                    </div>
                </div>

                <div class="cart-card">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                    </label>
                    <div class="product-img">
                        <img src="/sghwebv2/ec/images/produk3.png" alt="Melon0">
                    </div>
                    <div class="product-info">
                        <h3>Melon</h3>
                        <p class="sub-name">Premium Quality</p>
                        <div class="action-row">
                            <div class="qty-picker">
                                <button>-</button>
                                <input type="text" value="2">
                                <button>+</button>
                            </div>
                            <span class="badge-stock">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="product-price">
                        Rp 45.000
                    </div>
                </div>

                <div class="cart-card">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                    </label>
                    <div class="product-img">
                        <img src="/sghwebv2/ec/images/produk2.png" alt="Melon1">
                    </div>
                    <div class="product-info">
                        <h3>Melon</h3>
                        <p class="sub-name">Manis & Segar</p>
                        <div class="action-row">
                            <div class="qty-picker">
                                <button>-</button>
                                <input type="text" value="1">
                                <button>+</button>
                            </div>
                            <span class="badge-stock">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="product-price">
                        Rp 25.000
                    </div>
                </div>

                <div class="cart-card">
                    <label class="checkbox-container">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                    </label>
                    <div class="product-img">
                        <img src="/sghwebv2/ec/images/produk5.png" alt="Melon2">
                    </div>
                    <div class="product-info">
                        <h3>Melon</h3>
                        <p class="sub-name">Pilihan Utama</p>
                        <div class="action-row">
                            <div class="qty-picker">
                                <button>-</button>
                                <input type="text" value="3">
                                <button>+</button>
                            </div>
                            <span class="badge-stock">Stok Tersedia</span>
                        </div>
                    </div>
                    <div class="product-price">
                        Rp 20.000
                    </div>
                </div>

            </section>

            <aside class="cart-summary-keranjang">
                <div class="summary-card-keranjang">

                    <h2 class="summary-title-keranjang">Ringkasan Pesanan</h2>
                    <div class="summary-divider-keranjang"></div>

                    <div class="summary-details-keranjang">
                        <div class="summary-line-keranjang">
                            <span>Subtotal (7 Item)</span>
                            <span>Rp 205.000</span>
                        </div>
                    </div>

                    <div class="summary-divider-keranjang"></div>

                    <div class="summary-total-keranjang">
                        <span class="summary-total-label-keranjang">Total Pembayaran</span>
                        <span class="summary-total-price-keranjang">Rp 205.000</span>
                    </div>

                    <button class="btn-next-keranjang" onclick="loadPage('costumer/page/pemesanan.php')">
                        Selanjutnya
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14"
                            height="14">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>

                </div>
            </aside>
        </div>
    </div>
</main>