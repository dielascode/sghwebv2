
<body>

<div class="container-pemesanan">

  <!-- STEP PROGRESS -->
  <div class="d-flex justify-content-center mb-5">
        <div class="step">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Detail orders</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Pembayaran</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step inactive">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Succes</span>
        </div>
    </div>

  <!-- BODY -->
  <div class="body-pemesanan">

    <!-- LEFT -->
    <div class="left-pemesanan">
      <h2 class="judul-pemesanan">Detail Pesanan</h2>

      <!-- ITEM 1 -->
      <div class="item-card-pemesanan">
        <img src="/sghwebv2/ec/images/produk2.png" alt="Produk" class="item-img-pemesanan" />
        <div class="item-body-pemesanan">
          <p class="item-name-pemesanan">Melon Honey Globe</p>
          <p class="item-price-pemesanan">Rp 30.000 <span>/Kg</span></p>
          <p class="item-desc-pemesanan">Melon segar berkualitas tinggi hasil budidaya terkontrol dengan standar pertanian modern.</p>
          <div class="item-footer-pemesanan">
            <span class="item-unit-price-pemesanan">Rp 30.000 /Kg</span>
            <span class="item-qty-pemesanan">× 3</span>
          </div>
        </div>
      </div>

      <!-- ITEM 2 -->
      <div class="item-card-pemesanan">
        <img src="/sghwebv2/ec/images/produk2.png" alt="Produk" class="item-img-pemesanan" />
        <div class="item-body-pemesanan">
          <p class="item-name-pemesanan">Melon Honey Globe</p>
          <p class="item-price-pemesanan">Rp 30.000 <span>/Kg</span></p>
          <p class="item-desc-pemesanan">Melon segar berkualitas tinggi hasil budidaya terkontrol dengan standar pertanian modern.</p>
          <div class="item-footer-pemesanan">
            <span class="item-unit-price-pemesanan">Rp 30.000 /Kg</span>
            <span class="item-qty-pemesanan">× 3</span>
          </div>
        </div>
      </div>

      <!-- ALAMAT -->
      <div class="alamat-card-pemesanan">
        <div class="alamat-head-pemesanan">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="15" height="15" style="color:#2d8c62;flex-shrink:0;">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
          </svg>
          <span>Alamat Pengiriman</span>
        </div>
        <textarea class="alamat-input-pemesanan" rows="3" placeholder="Masukkan alamat lengkap Anda..."></textarea>
      </div>

      <p class="note-pemesanan">* Pastikan informasi di atas sudah benar sebelum melanjutkan ke proses selanjutnya.</p>
    </div>

    <!-- RIGHT -->
    <div class="right-pemesanan">
      <div class="summary-card-pemesanan">
        <p class="summary-title-pemesanan">Rincian Pembayaran</p>
        <div class="summary-divider-pemesanan"></div>

        <div class="summary-info-pemesanan">
          <div class="summary-row-pemesanan">
            <span class="summary-label-pemesanan">Nama</span>
            <span class="summary-value-pemesanan">alexxx bhizer</span>
          </div>
          <div class="summary-row-pemesanan">
            <span class="summary-label-pemesanan">Tanggal Pemesanan</span>
            <span class="summary-value-pemesanan">22-01-2026 02:00</span>
          </div>
          <div class="summary-row-pemesanan">
            <span class="summary-label-pemesanan">Perkiraan Tiba</span>
            <span class="summary-value-pemesanan">22-01-2026</span>
          </div>
        </div>

        <div class="summary-divider-pemesanan"></div>

        <div class="summary-product-pemesanan">
          <p class="summary-product-name-pemesanan">Melon Honey Globe</p>
          <div class="summary-product-row-pemesanan">
            <span>Kuantitas</span>
            <span>3 Kg</span>
          </div>
          <div class="summary-product-row-pemesanan">
            <span>Harga satuan</span>
            <span>Rp 30.000 /Kg</span>
          </div>
        </div>

        <div class="summary-divider-pemesanan"></div>

        <div class="summary-total-pemesanan">
          <span class="summary-total-label-pemesanan">Total Bayar</span>
          <span class="summary-total-value-pemesanan">Rp 90.000</span>
        </div>

        <button class="btn-pemesanan" onclick="loadPage('costumer/page/pembayaran.php')">
          Selanjutnya
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </div>
    </div>

  </div>
</div>

</body>
