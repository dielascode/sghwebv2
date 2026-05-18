<?php
session_name('sghwebv2_session');
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

// Baca dari buynow
$buynow    = $_SESSION['konfirmasi_buynow'] ?? $_SESSION['buynow'] ?? null;
$id_produk = $buynow['id_produk'] ?? null;
$qty       = $buynow['qty'] ?? 1;

if ($id_produk) {
    $item              = $controller->getBuyNowProduk($id_produk);
    $item['kuantitas'] = (int) $qty;
    $items             = [$item];

    // Simpan ke konfirmasi_buynow, hapus buynow
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
date_default_timezone_set('Asia/Jakarta');
$api            = new PemesananApi($conn);
$nama           = $api->getNamaUser($id_costumer);
$tanggal_pesan  = date('d-m-Y H:i');
$perkiraan_tiba = date('d-m-Y', strtotime('+2 days'));

// ── Ambil alamat utama ──────────────────────────────────────────────────────
$alamatUtama = $api->getAlamatUtamaFormatted($id_costumer);
$_SESSION['id_alamat'] = $alamatUtama['id'] ?? null;
// ───────────────────────────────────────────────────────────────────────────
?>
<body>

  <div class="container-pemesanan">

    <!-- STEP INDICATOR -->
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

      <!-- KIRI: detail produk + alamat -->
      <div class="left-pemesanan">
        <h2 class="judul-pemesanan">Detail Pesanan</h2>

        <?php foreach ($items as $item): ?>
          <?php
            $gambar = getGambarProduk($conn, $item['id_produk']);
            $img    = $gambar[0] ?? 'default.png';
          ?>
          <div class="item-card-pemesanan">
            <img src="/sghwebv2/asset/image/produk/<?= $img ?>" class="item-img-pemesanan" />
            <div class="item-body-pemesanan">
              <p class="item-name-pemesanan"><?= htmlspecialchars($item['nama_produk']) ?></p>
              <p class="variety-label"><?= htmlspecialchars($item['nama_varietas']) ?></p>
              <p class="item-price-pemesanan">
                Rp <?= number_format($item['harga']) ?>
                <span class="per-unit">/ kg</span>
              </p>
              <p class="item-desc-pemesanan"><?= htmlspecialchars($item['deskripsi']) ?></p>
              <div class="item-footer-pemesanan">
                
                <span class="item-qty-pemesanan">× <?= $item['kuantitas'] ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- ALAMAT PENGIRIMAN -->
        <div class="alamat-card-pemesanan">
          <div class="alamat-head-pemesanan">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="15" height="15"
              style="color:#2d8c62;flex-shrink:0;">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Alamat Pengiriman</span>
          </div>

          <div class="alamat-divider-pemesanan"></div>

          <?php if ($alamatUtama): ?>
            <!-- Alamat ditemukan -->
            <div class="alamat-body-pemesanan">
              <div class="alamat-row-pemesanan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"
                  style="color:#2d8c62;flex-shrink:0;margin-top:2px;">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                  <circle cx="12" cy="10" r="3"/>
                </svg>
                <span class="alamat-teks-pemesanan">
                  <?= htmlspecialchars($alamatUtama['teks']) ?>
                </span>
              </div>
              <span class="alamat-badge-utama">
                <svg viewBox="0 0 24 24" fill="#fff" width="10" height="10" style="margin-right:4px;">
                  <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                </svg>
                Utama
              </span>
            </div>
          <?php else: ?>
            <!-- Belum ada alamat utama -->
            <div class="alamat-kosong-pemesanan">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="32" height="32"
                style="color:#ccc;">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <p>Belum ada alamat utama.</p>
              <a href="#" onclick="loadPage('/sghwebv2/ec/costumer/page/profile.php')" class="alamat-link-tambah">
                + Tambah alamat di Profil
              </a>
            </div>
          <?php endif; ?>
        </div>

        <p class="note-pemesanan">* Pastikan informasi di atas sudah benar sebelum melanjutkan ke proses selanjutnya.</p>
      </div>

      <!-- KANAN: ringkasan pembayaran -->
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
              <p class="summary-product-name-pemesanan"><?= htmlspecialchars($item['nama_produk']) ?></p>
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

          <?php if ($alamatUtama): ?>
            <button class="btn-pemesanan" onclick="loadPage('costumer/page/pembayaran.php')">
              Selanjutnya
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
          <?php else: ?>
            <!-- Disable tombol jika belum ada alamat -->
            <button class="btn-pemesanan btn-pemesanan-disabled" disabled title="Tambahkan alamat utama terlebih dahulu">
              Selanjutnya
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
            <p class="note-pemesanan" style="color:#e57373;margin-top:8px;">
              * Tambahkan alamat utama di Profil untuk melanjutkan.
            </p>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

  <style>
    /* Alamat card tambahan */
    .alamat-divider-pemesanan {
      height: 1px;
      background: #f0f0f0;
      margin: 10px 0;
    }

    .alamat-body-pemesanan {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .alamat-row-pemesanan {
      display: flex;
      align-items: flex-start;
      gap: 8px;
    }

    .alamat-teks-pemesanan {
      font-size: 13.5px;
      color: #444;
      line-height: 1.5;
    }

    .alamat-badge-utama {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(135deg, #21543c, #3d8c62);
      color: #fff;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 999px;
      width: fit-content;
    }

    .alamat-kosong-pemesanan {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      padding: 16px 0 8px;
      text-align: center;
    }

    .alamat-kosong-pemesanan p {
      font-size: 13px;
      color: #aaa;
      margin: 0;
    }

    .alamat-link-tambah {
      font-size: 13px;
      color: #2d8c62;
      font-weight: 600;
      text-decoration: none;
    }

    .alamat-link-tambah:hover {
      text-decoration: underline;
    }

    .btn-pemesanan-disabled {
      opacity: 0.45;
      cursor: not-allowed;
    }
  </style>

</body>