

    
    <!-- WRAPPER BAWAH -->
    <div class="container-pesanan d-flex">
        <!-- SIDEBAR -->
        <?php include "../elemen/sidebar_pesanan.php"; ?>

        <!-- KONTEN (kalau ada nanti) -->
        <div class="konten flex-grow-1 p-3">
            <div class="oh-wrap">
                <div class="oh-title">Order History</div>
                <div class="oh-count">3 orders</div>

                <div class="oh-cards">

                    <!-- CARD 1 -->
                    <div class="oh-card">
                        <div class="card-status-bar">
                            <span class="status-dot"></span>
                            <span class="status-label">Menunggu Konfirmasi Admin</span>
                        </div>

                        <div class="card-inner">
                            <div class="product-box">
                                <div class="melon-thumb" >
                                    <img src="/sghwebv2/ec/images/produk2.png" class="thumb-img">
                                </div>

                                <div class="product-info">
                                    <div class="product-name">Melon Honey Globe</div>

                                    <div class="product-meta">
                                        <div class="meta-row">
                                            <span class="meta-lbl">Total Harga</span>
                                            <span class="meta-val green">Rp 60.000</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">QTY</span>
                                            <span class="meta-val">2 kg</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">No. Pesanan</span>
                                            <span class="meta-val muted">ORD-001</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-box">
                                <button href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/detailorder.php')" class="btn-detail">Order Detail</button>
                                <button class="btn-struk">Cetak Struk</button>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2 -->
                    <div class="oh-card">
                        <div class="card-status-bar">
                            <span class="status-dot ship"></span>
                            <span class="status-label ship">Sedang Dikirim</span>
                        </div>

                        <div class="card-inner">
                            <div class="product-box">
                                <div class="melon-thumb" >
                                    <img src="/sghwebv2/ec/images/produk4.png" class="thumb-img">
                                </div>

                                <div class="product-info">
                                    <div class="product-name">Melon Sky Rocket</div>

                                    <div class="product-meta">
                                        <div class="meta-row">
                                            <span class="meta-lbl">Total Harga</span>
                                            <span class="meta-val green">Rp 84.000</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">QTY</span>
                                            <span class="meta-val">3 kg</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">No. Pesanan</span>
                                            <span class="meta-val muted">ORD-002</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-box">
                                <button class="btn-detail">Order Detail</button>
                                <button class="btn-struk">Cetak Struk</button>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3 -->
                    <div class="oh-card">
                        <div class="card-status-bar">
                            <span class="status-dot done"></span>
                            <span class="status-label done">Pesanan Selesai</span>
                        </div>

                        <div class="card-inner">
                            <div class="product-box">
                                <div class="melon-thumb" >
                                    <img src="/sghwebv2/ec/images/produk6.png" class="thumb-img">
                                </div>

                                <div class="product-info">
                                    <div class="product-name">Melon Golden Langkawi</div>

                                    <div class="product-meta">
                                        <div class="meta-row">
                                            <span class="meta-lbl">Total Harga</span>
                                            <span class="meta-val green">Rp 35.000</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">QTY</span>
                                            <span class="meta-val">1 kg</span>
                                        </div>
                                        <div class="meta-row">
                                            <span class="meta-lbl">No. Pesanan</span>
                                            <span class="meta-val muted">ORD-003</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-box">
                                <button class="btn-detail">Order Detail</button>
                                <button class="btn-struk">Cetak Struk</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</body>

</html>