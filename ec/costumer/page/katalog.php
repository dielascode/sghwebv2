<section class="bg-[#FAFDF8]">

  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <img src="images/banner2.png" class="d-block w-100">
      </div>

      <div class="carousel-item">
        <img src="images/banner2.png" class="d-block w-100">
      </div>

      <div class="carousel-item">
        <img src="images/banner2.png" class="d-block w-100">
      </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

</section>
<section class="bg-[#FAFDF8]">
  <div class="container1-katalog">
    <div class="judul-flex">
      <h2>Our Products</h2>
    </div>

    <div class="search-flex">

      <button type="button" class="btn-filter" data-filter="satuan">Satuan</button>
      <button type="button" class="btn-filter" data-filter="bundling">Bundling</button>
      <button type="button" class="btn-filter active" data-filter="all">Semua</button>

      <div class="search-box">
        <i class="fa fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search">
      </div>
    </div>
  </div>
</section>

<section class="bg-[#FAFDF8]">
  <?php
  require_once __DIR__ . "/../../config/connection.php"; // Menghubungkan ke database
  require_once __DIR__ . "/../../logic/costumer/produkApi.php";

  // bikin object database
  $db = new Database();

  // ambil koneksi
  $conn = $db->getConnection();

  // ambil data
  $produk = getProduk($conn);
  // var_dump($produk);
  ?>



  <div class="grid">
    <?php foreach ($produk as $p): ?>


      <div class="product-card" data-tipe="<?= $p['tipe'] ?>">

        <div class="img1-area">
          <?php
          $gambar = getGambarProduk($conn, $p['id_produk']);
          ?>

          <img src="../asset/image/produk/<?= $gambar[0] ?>" width="200" alt="Melon"
            class="product1-img">
        </div>

        <div class="card-body">
          <p class="variety-label"><?= $p['nama_varietas'] ?></p>
          <h2 class="product-name"><?= $p['nama_produk'] ?></h2>

          <div class="price-row">
            <span class="price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
            <span class="per-unit">/ kg</span>
          </div>

          <div class="stock-row">
            <span class="stock-dot"></span>
            <span class="stock-text">
              Stok: <span class="stock-num"><?= $p['stok'] ?? 0 ?> kg</span>
            </span>
          </div>

          <div class="btn-row">
            <button class="btn-buy" onclick='openModal({
  id: "<?= $p["id_produk"] ?>",
  variety: "<?= $p["nama_varietas"] ?>",
  title: "<?= $p["nama_produk"] ?>",
  desc: "<?= $p["deskripsi"] ?>",
  price: "<?= number_format($p["harga"], 0, ",", ".") ?>",
  stock: "<?= $p["stok"] ?? 0 ?>",
  
  images: <?= json_encode($gambar) ?>,
  reviews: <?= json_encode(getReviewProduk($conn, $p["id_produk"])) ?>
})'>
              Beli Sekarang
            </button>

          </div>
        </div>

      </div>
    <?php endforeach; ?>

  </div>

  </div>
  </div>
</section>

<!-- <section class="bg-[#FAFDF8]">
    <div class="container2-katalog">
      <img src="/sghwebv2/ec/images/banner3.png" alt="Produk 3" class="img-katalog">
    </div>

  </section> -->



<div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

  <div class="modal-overlay ">
    <div class="modal-box">

      <button onclick="closeModal()" class="modal-close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>

      <div class="modal-top">

        <!-- KIRI: gambar + thumbnail -->
        <div class="modal-gallery">
          <div class="modal-main-img">
            <img id="modalImg" src="" alt="Foto Produk" />
          </div>

          <div class="modal-thumbs" id="modalThumbs">
            <!-- thumbnail akan di-inject lewat JS -->
          </div>
        </div>

        <!-- KANAN: detail -->
        <div class="modal-info">

          <div>

            <h2 id="modalTitle" class="modal-title"></h2>
            <p id="modalVariety" class="modal-varietas"></p>
          </div>

          <div class="modal-price-row">
            <span id="modalPrice" class="modal-price"></span>
            <span class="modal-unit">/ Kg</span>
          </div>

          <div class="modal-rating">
            <div class="modal-stars">
              <svg viewBox="0 0 24 24" width="14" height="14">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="14" height="14">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="14" height="14">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="14" height="14">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="14" height="14">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
            </div>
          </div>

          <div class="modal-divider"></div>

          <div>
            <p class="modal-desc-title">Deskripsi produk</p>
            <p id="modalDesc" class="modal-desc-text"></p>
            <div class="modal-storage">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"
                style="flex-shrink:0;margin-top:2px;">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
              </svg>
              <span>Simpan di suhu ruang sebelum dipotong, dan di dalam kulkas setelah dibuka.</span>
            </div>
          </div>

          <div class="modal-stock-row">
            <span class="modal-stock-dot"></span>
            <span>Stok: <span id="modalStock" class="modal-stock-num"></span></span>
          </div>

          <div class="modal-qty-buy">
            <div class="modal-qty">
              <button class="modal-qty-btn" onclick="changeQty(-1)">−</button>
              <span class="modal-qty-num" id="modalQty">1</span>
              <button class="modal-qty-btn" onclick="changeQty(1)">+</button>
            </div>
            <button type="button" class="modal-btn-buy" onclick="buyNow()">
              Beli Sekarang
            </button>
            <button class="modal-btn-cart" onclick="addToCart()">+ Keranjang</button>
          </div>

        </div>
      </div>

      <!-- ULASAN -->
      <!-- ULASAN -->
      <div class="modal-reviews">
        <div class="modal-reviews-grid">
          <!-- diisi JS saat openModal -->
        </div>
      </div>
    </div>
  </div>

</div>
<script>
  // ========================= 
  // FILTER TIPE + SEARCH
  // =========================
  (function() {
    const cards = document.querySelectorAll('.product-card');
    const filterBtns = document.querySelectorAll('.btn-filter');
    const searchInput = document.getElementById('searchInput');

    let activeFilter = 'all';

    function applyFilter() {
      const keyword = searchInput.value.toLowerCase().trim();
      cards.forEach(card => {
        const tipe = card.dataset.tipe?.toLowerCase() ?? '';
        const nama = card.querySelector('.product-name')?.innerText.toLowerCase() ?? '';
        const matchTipe = activeFilter === 'all' || tipe === activeFilter;
        const matchSearch = nama.includes(keyword);
        card.style.display = (matchTipe && matchSearch) ? '' : 'none';
      });
    }

    filterBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        activeFilter = this.dataset.filter;
        applyFilter();
      });
    });

    searchInput.addEventListener('input', applyFilter);
  })();
</script>