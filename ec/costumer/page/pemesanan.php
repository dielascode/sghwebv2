<?php
session_start();

require_once '../../config/connection.php';
require_once '../../logic/costumer/produkApi.php';
require_once '../../logic/costumer/pemesananApi.php';
require_once '../../costumer/controller/pemesananController.php';

$db   = new Database();
$conn = $db->getConnection();

$controller  = new PemesananController($conn);
$id_costumer = $_SESSION['id'] ?? null;
$selected    = $_SESSION['selected_cart'] ?? [];

if (!$id_costumer) die("SESSION TIDAK VALID");

// Baca dari buynow (yang di-set saat klik Beli Sekarang)
$buynow    = $_SESSION['buynow'] ?? null;
$id_produk = $buynow['id_produk'] ?? null;
$qty       = $buynow['qty'] ?? 1;

if ($id_produk) {
    $item              = $controller->getBuyNowProduk($id_produk);
    $item['kuantitas'] = (int) $qty;
    $items             = [$item];

    // Simpan ke konfirmasi_buynow untuk dipakai saat konfirmasi pembayaran
    $_SESSION['konfirmasi_buynow'] = [
        'id_produk' => $id_produk,
        'qty'       => (int) $qty
    ];
    unset($_SESSION['buynow']);
} else {
    $items = $controller->getSelectedProduk($id_costumer, $selected);
}

$total = 0;
foreach ($items as $item) {
    $total += $item['harga'] * $item['kuantitas'];
}
$_SESSION['total_bayar'] = $total;

$api            = new PemesananApi($conn);
$nama           = $api->getNamaUser($id_costumer);
$tanggal_pesan  = date('d-m-Y H:i');
$perkiraan_tiba = date('d-m-Y', strtotime('+2 days'));
?>
<body>

  <div class="container-pemesanan">

    <div class="d-flex justify-content-center mb-5">
      <div class="step-pemesanan">
        <div class="circle-pemesanan"><i class="bi bi-check"></i></div>
        <span>Detail orders</span>
      </div>
      <div class="line mx-3"></div>
      <div class="step-pemesanan inactive">
        <div class="circle-pemesanan inactive"><i class="bi bi-check"></i></div>
        <span>Pembayaran</span>
      </div>
      <div class="line mx-3"></div>
      <div class="step-pemesanan inactive">
        <div class="circle-pemesanan inactive"><i class="bi bi-check"></i></div>
        <span>Succes</span>
      </div>
    </div>

    <div class="body-pemesanan">

      <div class="left-pemesanan">
        <h2 class="judul-pemesanan">Detail Pesanan</h2>

        <?php foreach ($items as $item): ?>
          <?php
            $gambar = getGambarProduk($conn, $item['id_produk']);
            $img    = $gambar[0] ?? 'default.png';
          ?>
          <div class="item-card-pemesanan">
            <img src="/sghwebv2/ec/images/<?= $img ?>" class="item-img-pemesanan" />
            <div class="item-body-pemesanan">
              <p class="item-name-pemesanan"><?= $item['nama_produk'] ?></p>
              <p class="variety-label"><?= $item['nama_varietas'] ?></p>
              <p class="item-price-pemesanan">
                Rp <?= number_format($item['harga']) ?>
                <span class="per-unit">/ kg</span>
              </p>
              <p class="item-desc-pemesanan"><?= $item['deskripsi'] ?></p>
              <div class="item-footer-pemesanan">
                <span class="item-qty-pemesanan">× <?= $item['kuantitas'] ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="alamat-card-pemesanan">
          <div class="alamat-head-pemesanan">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="15" height="15"
              style="color:#2d8c62;flex-shrink:0;">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <span>Alamat Pengiriman</span>
          </div>
          <textarea class="alamat-input-pemesanan" rows="3" placeholder="Masukkan alamat lengkap Anda..."></textarea>
        </div>

        <p class="note-pemesanan">* Pastikan informasi di atas sudah benar sebelum melanjutkan ke proses selanjutnya.</p>
      </div>

      <div class="right-pemesanan">
        <div class="summary-card-pemesanan">
          <p class="summary-title-pemesanan">Rincian Pembayaran</p>
          <div class="summary-divider-pemesanan"></div>

          <div class="summary-info-pemesanan">
            <div class="summary-row-pemesanan">
              <span class="summary-label-pemesanan">Nama</span>
              <span class="summary-value-pemesanan"><?= htmlspecialchars($nama) ?></span>
            </div>
            <div class="summary-row-pemesanan">
              <span class="summary-label-pemesanan">Tanggal Pemesanan</span>
              <span class="summary-value-pemesanan"><?= $tanggal_pesan ?></span>
            </div>
            <div class="summary-row-pemesanan">
              <span class="summary-label-pemesanan">Perkiraan Tiba</span>
              <span class="summary-value-pemesanan"><?= $perkiraan_tiba ?></span>
            </div>
          </div>

          <div class="summary-divider-pemesanan"></div>

          <?php foreach ($items as $item): ?>
            <div class="summary-product-pemesanan">
              <p class="summary-product-name-pemesanan"><?= $item['nama_produk'] ?></p>
              <div class="summary-product-row-pemesanan">
                <span>Kuantitas</span>
                <span><?= $item['kuantitas'] ?> Kg</span>
              </div>
              <div class="summary-product-row-pemesanan">
                <span>Harga satuan</span>
                <span>Rp <?= number_format($item['harga'], 0, ',', '.') ?> /Kg</span>
              </div>
              <div class="summary-product-row-pemesanan">
                <span>Total harga</span>
                <span>Rp <?= number_format($item['harga'] * $item['kuantitas'], 0, ',', '.') ?></span>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="summary-divider-pemesanan"></div>

          <div class="summary-total-pemesanan">
            <span class="summary-total-label-pemesanan">Total Bayar</span>
            <span class="summary-total-value-pemesanan">Rp <?= number_format($total) ?></span>
          </div>

          <button class="btn-pemesanan" onclick="loadPage('costumer/page/pembayaran.php')">
            Selanjutnya
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </button>
        </div>
      </div>

    </div>
  </div>

</body>