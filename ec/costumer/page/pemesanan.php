<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../config/connection.php';
require_once __DIR__ . "/../../logic/costumer/produkApi.php";

$db = new Database();
$conn = $db->getConnection();

$id_users = $_SESSION['id']; // 🔥 FIX PENTING

$selected = $_SESSION['selected_cart'] ?? [];

if (empty($selected)) {
    die("Tidak ada item dipilih");
}

// 🔥 bikin IN aman (integer)
$ids = implode(",", array_map('intval', $selected));

$query = "
SELECT
    keranjang.qty,
    detail_produk.id AS id_detail,
    produk.id AS id_produk,
    produk.nama_produk,
    produk.harga,
    produk.deskripsi,
    varietas.nama_varietas
FROM keranjang
JOIN detail_produk 
    ON keranjang.id_detail_produk = detail_produk.id
JOIN produk 
    ON detail_produk.id_produk = produk.id
JOIN varietas 
    ON detail_produk.id_varietas = varietas.id
WHERE keranjang.id_detail_produk IN ($ids)
AND keranjang.id_users = '$id_users'
";

$result = mysqli_query($conn, $query);
?>

<body>

  <div class="container-pemesanan">

    <!-- step-pemesanan PROGRESS -->
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

    <!-- BODY -->
    <div class="body-pemesanan">

      <!-- LEFT -->
      <div class="left-pemesanan">
        <h2 class="judul-pemesanan">Detail Pesanan</h2>

        <!-- ITEM 1 -->

        <?php
        $total = 0;
        while ($item = mysqli_fetch_assoc($result)): ?>

          <div class="item-card-pemesanan">

            <?php
            $gambar = getGambarProduk($conn, $item['id_produk']);
            $img = $gambar[0] ?? 'default.png';
            ?>

            <img src="/sghwebv2/ec/images/<?php echo $img; ?>" class="item-img-pemesanan" />

            <div class="item-body-pemesanan">

              <p class="item-name-pemesanan">
                <?php echo $item['nama_produk']; ?>
              </p>
              <p class="variety-label">
                <?= $item['nama_varietas'] ?>
              </p>

              <p class="item-price-pemesanan">
                Rp <?php echo number_format($item['harga']); ?>
                <span class="per-unit">/ kg</span>
              </p>
              

              <p class="item-desc-pemesanan">
                <?php echo $item['deskripsi']; ?>
              </p>

              <div class="item-footer-pemesanan">

                <!-- <span class="item-unit-price-pemesanan">
                  Rp <?php echo number_format($item['harga']); ?>
                </span> -->

                <span class="item-qty-pemesanan">
                  × <?php echo $item['qty']; ?>
                </span>

              </div>

            </div>

          </div>
          <?php $total += $item['harga'] * $item['qty']; ?>
        <?php endwhile; ?>




        <!-- ALAMAT -->
        <div class="alamat-card-pemesanan">
          <div class="alamat-head-pemesanan">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="15" height="15"
              style="color:#2d8c62;flex-shrink:0;">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" /><circle-pemesanan cx="12" cy="10" r="3" />
            </svg>
            <span>Alamat Pengiriman</span>
          </div>
          <textarea class="alamat-input-pemesanan" rows="3" placeholder="Masukkan alamat lengkap Anda..."></textarea>
        </div>

        <p class="note-pemesanan">* Pastikan informasi di atas sudah benar sebelum melanjutkan ke proses selanjutnya.
        </p>
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

          
          <?php
mysqli_data_seek($result, 0); // reset pointer biar bisa dipakai ulang
?>

<?php while ($item = mysqli_fetch_assoc($result)): ?>

  <div class="summary-product-pemesanan">

    <p class="summary-product-name-pemesanan">
      <?= $item['nama_produk'] ?>
    </p>

    <div class="summary-product-row-pemesanan">
      <span>Kuantitas</span>
      <span><?= $item['qty'] ?> Kg</span>
    </div>

    <div class="summary-product-row-pemesanan">
      <span>Harga satuan</span>
      <span>Rp <?= number_format($item['harga'], 0, ',', '.') ?> /Kg</span>
    </div>
    <div class="summary-product-row-pemesanan">
      <span>Total harga</span>
      <span>Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></span>
    </div>

  </div>

<?php endwhile; ?>


          <div class="summary-divider-pemesanan"></div>

          <div class="summary-total-pemesanan">
            <span class="summary-total-label-pemesanan">Total Bayar</span>
            <span class="summary-total-value-pemesanan">
              Rp <?php echo number_format($total); ?>
            </span>
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