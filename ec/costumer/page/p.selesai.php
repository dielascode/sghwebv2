<!-- WRAPPER BAWAH -->
<div class="container-pesanan d-flex">
    <!-- SIDEBAR -->
    <?php include "../elemen/sidebar_pesanan.php"; ?>

    <!-- KONTEN -->
    <div class="konten flex-grow-1 p-3">
        <div class="oh-wrap">
            <div class="oh-title">Order History</div>
            <div class="oh-count">3 orders</div>

            <div class="oh-cards">

                <!-- CARD 2 -->
                <div class="oh-card">
                    <div class="card-status-bar">
                        <span class="status-dot done"></span>
                        <span class="status-label done">Pesanan Selesai</span>
                    </div>

                    <div class="card-inner">
                        <div class="product-box">
                            <div class="melon-thumb">
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
                            <button class="btn-nilai"
                                    onclick="openNilaiPopup('Melon Sky Rocket', '/sghwebv2/ec/images/produk4.png')">
                                Nilai Produk
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- ===================================================== -->
<!--  MODAL NILAI PRODUK                                    -->
<!-- ===================================================== -->
<div class="overlay-nilai" id="overlay-nilai" onclick="handleNilaiOverlay(event)">
    <div class="modal-nilai">

        <button class="modal-nilai-close" onclick="closeNilaiPopup()">&#x2715;</button>

        <h2>Nilai produk</h2>

        <!-- Info produk (diisi JS saat tombol diklik) -->
        <div class="nilai-product-row">
            <div class="nilai-product-icon">
                <img id="nilai-img" src="" alt=""
                     style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
            </div>
            <div class="nilai-product-name" id="nilai-nama">-</div>
        </div>

        <!-- Rating bintang -->
        <div class="nilai-rating-row">
            <span class="nilai-rating-label">Kualitas Produk</span>
            <div class="nilai-stars">
                <span class="nilai-star" onclick="nilaiSetRating(1)" onmouseover="nilaiHover(1)" onmouseout="nilaiResetHover()">&#9733;</span>
                <span class="nilai-star" onclick="nilaiSetRating(2)" onmouseover="nilaiHover(2)" onmouseout="nilaiResetHover()">&#9733;</span>
                <span class="nilai-star" onclick="nilaiSetRating(3)" onmouseover="nilaiHover(3)" onmouseout="nilaiResetHover()">&#9733;</span>
                <span class="nilai-star" onclick="nilaiSetRating(4)" onmouseover="nilaiHover(4)" onmouseout="nilaiResetHover()">&#9733;</span>
                <span class="nilai-star" onclick="nilaiSetRating(5)" onmouseover="nilaiHover(5)" onmouseout="nilaiResetHover()">&#9733;</span>
            </div>
            <span class="nilai-rating-desc" id="nilai-rating-desc"></span>
        </div>

        <!-- Textarea ulasan -->
        <div class="nilai-input-box">
            <div class="nilai-input-group">
                <label for="nilai-quality">Kualitas:</label>
                <textarea id="nilai-quality"
                          placeholder="Saya merasa produk ini sangat baik dari segi luarnya"></textarea>
            </div>
            <div class="nilai-input-group">
                <label for="nilai-taste">Rasa:</label>
                <textarea id="nilai-taste"
                          placeholder="Saya merasa produk ini lebih enak dari yang lain"></textarea>
            </div>
        </div>

        <!-- Upload foto & video -->
        <div class="nilai-upload-row">
            <label class="nilai-upload-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                Tambah Foto
                <input type="file" accept="image/*" multiple
                       onchange="nilaiHandleFiles(this,'photo')">
            </label>
            <label class="nilai-upload-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="15" height="10" rx="2"/>
                    <polyline points="17 9 22 5 22 19 17 15"/>
                </svg>
                Tambah Video
                <input type="file" accept="video/*"
                       onchange="nilaiHandleFiles(this,'video')">
            </label>
        </div>

        <!-- Preview thumbnail -->
        <div id="nilai-preview-area"></div>

        <!-- Footer -->
        <div class="nilai-modal-footer">
            <button class="nilai-btn-cancel" onclick="closeNilaiPopup()">Nanti Saja</button>
            <button class="nilai-btn-ok"     onclick="nilaiSubmit()">OK</button>
        </div>

    </div>
</div>

<!-- Toast -->
<div id="nilai-toast"></div>