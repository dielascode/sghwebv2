<section class="bg-[#FAFDF8]">

  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <img src="/sghwebv2/ec/images/banner2.png" class="d-block w-100">
      </div>

      <div class="carousel-item">
        <img src="/sghwebv2/ec/images/banner2.png" class="d-block w-100">
      </div>

      <div class="carousel-item">
        <img src="/sghwebv2/ec/images/banner2.png" class="d-block w-100">
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
      <button type="button" class="btn-all">All</button>
      <button type="button" class="btn-bundling">Bundling</button>

      <div class="search-box">
        <i class="fa fa-search"></i>
        <input type="text" placeholder="Search">
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
  ?>



  <div class="grid">
    <?php foreach ($produk as $p): ?>
      <div class="product-card">

        <div class="img1-area">
          <?php
          $gambar = getGambarProduk($conn, $p['id_produk']);
          ?>

          <img src="/sghwebv2/ec/images/<?= $gambar[0] ?>" width="200" alt="Melon" class="product1-img">
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
  id: "<?= $p["id_detail"] ?>",
  variety: "<?= $p["nama_varietas"] ?>",
  title: "<?= $p["nama_produk"] ?>",
  desc: "<?= $p["deskripsi"] ?>",
  price: "<?= number_format($p["harga"], 0, ",", ".") ?>",
  stock: "<?= $p["stok"] ?? 0 ?>",
  images: <?= json_encode($gambar) ?>
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
            <span class="modal-review-count">9 ulasan</span>
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
            <button class="modal-btn-buy">Beli Sekarang</button>
            <button class="modal-btn-cart" onclick="addToCart()">+ Keranjang</button>
          </div>

        </div>
      </div>

      <!-- ULASAN -->
      <div class="modal-reviews">
        <!-- <p class="modal-reviews-title">Ulasan pembeli</p> -->
        <div class="modal-reviews-grid">
          <div class="modal-review-card">
            <div class="modal-review-stars">
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
            </div>
            <p class="modal-review-text">Baru pertama kali beli melon di sini dan ternyata kualitasnya bagus. Buahnya
              segar, rasanya manis, dan aromanya juga harum. Pengemasannya rapi jadi sampai dengan kondisi baik.
              Recommended!</p>
            <div class="modal-review-footer">
              <div class="modal-reviewer">
                <div class="modal-reviewer-avatar">NS</div>
                <span class="modal-reviewer-name">Nguyen Shane</span>
              </div>
              <span class="modal-review-date">13 Okt 2017</span>
            </div>
          </div>
          <div class="modal-review-card">
            <div class="modal-review-stars">
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
              <svg viewBox="0 0 24 24" width="12" height="12">
                <polygon
                  points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                  fill="#f5a623" />
              </svg>
            </div>
            <p class="modal-review-text">Baru pertama kali beli melon di sini dan ternyata kualitasnya bagus. Buahnya
              segar, rasanya manis, dan aromanya juga harum. Pengemasannya rapi jadi sampai dengan kondisi baik.
              Recommended!</p>
            <div class="modal-review-footer">
              <div class="modal-reviewer">
                <div class="modal-reviewer-avatar">NS</div>
                <span class="modal-reviewer-name">Nguyen Shane</span>
              </div>
              <span class="modal-review-date">13 Okt 2017</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {

    let modalQty = 1;
    let selectedProductId = null;

    // =========================
    // OPEN MODAL (FIXED)
    // =========================
    window.openModal = function (data) {

      console.log("OPEN MODAL DATA:", data);

      selectedProductId = data.id;

      const modal = document.getElementById("modal");
      modal.classList.remove("hidden");

      const images = data.images || []; // 🔥 FIX UTAMA BIAR GA ERROR

      document.getElementById("modalTitle").innerText = data.title;
      document.getElementById("modalVariety").innerText = data.variety;
      document.getElementById("modalDesc").innerText = data.desc;
      document.getElementById("modalPrice").innerText = "Rp " + data.price;
      document.getElementById("modalStock").innerText = data.stock;

      const basePath = "/sghwebv2/ec/images/";

      const mainImg = document.getElementById("modalImg");

      // =========================
      // MAIN IMAGE
      // =========================
      if (images.length > 0) {
        mainImg.src = basePath + images[0];
      } else {
        mainImg.src = "";
      }

      // =========================
      // THUMBNAIL (FIXED SAFE)
      // =========================
     const thumbsContainer = document.getElementById("modalThumbs");
thumbsContainer.innerHTML = "";

(images || []).forEach((img) => {

  if (!img) return; // 🔥 skip null / undefined

  img = String(img); // 🔥 paksa jadi string biar aman

  const div = document.createElement("div");
  div.className = "modal-thumb";

  const image = document.createElement("img");
  image.src = basePath + img;

  div.appendChild(image);
  thumbsContainer.appendChild(div);

  div.onclick = () => {

    mainImg.src = image.src;

    document.querySelectorAll(".modal-thumb")
      .forEach(t => t.classList.remove("active"));

    div.classList.add("active");
  };

});

      // reset qty
      modalQty = 1;
      document.getElementById("modalQty").textContent = modalQty;
    };

    // =========================
    // CLOSE MODAL
    // =========================
    window.closeModal = function () {
      document.getElementById("modal").classList.add("hidden");
    };

    // =========================
    // QTY
    // =========================
    window.changeQty = function (delta) {
      modalQty = Math.max(1, modalQty + delta);
      document.getElementById("modalQty").textContent = modalQty;
    };

    // =========================
    // CLICK OUTSIDE MODAL
    // =========================
    window.addEventListener("click", function (e) {
      const modal = document.getElementById("modal");
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    });

    // =========================
    // ADD TO CART
    // =========================
    window.addToCart = function () {

      fetch('/sghwebv2/ec/logic/costumer/keranjangApi.php', {
  method: 'POST',
  credentials: 'include', // 🔥 INI YANG HILANG
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  },
  body: `action=add&id_detail=${selectedProductId}&qty=${modalQty}`
})
        .then(res => res.text())
        .then(res => {

          res = res.trim();

          if (res === 'success') {
            showToast('Produk berhasil ditambahkan ke keranjang')
             updateCartBadge(); ;
          } else {
            showToast('Gagal menambahkan produk');
            console.log(res);
          }

        })
        .catch(err => {
          console.log(err);
          showToast('Terjadi error');
        });

    };

    // =========================
    // TOAST
    // =========================
    function showToast(message) {

      let toast = document.createElement('div');
      toast.classList.add('custom-toast');

      toast.innerHTML = `
      <i class="fa-solid fa-circle-check"></i>
      <span>${message}</span>
    `;

      document.body.appendChild(toast);

      setTimeout(() => toast.classList.add('show'), 100);

      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
      }, 2500);

    }

  });
</script>