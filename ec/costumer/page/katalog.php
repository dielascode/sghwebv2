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



<!-- <section class="bg-[#FAFDF8]">
    <div class="container2-katalog">
      <img src="/sghwebv2/ec/images/banner3.png" alt="Produk 3" class="img-katalog">
    </div>

  </section> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

  <div class="bg-white rounded-xl w-[500px] p-5 relative">

    <!-- CLOSE -->
    <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500">✖</button>

    <div class="flex gap-4">

      <!-- KIRI (gambar) -->
      <img id="modalImg" class="w-1/2 h-52 object-cover rounded-lg">

      <!-- KANAN (detail) -->
      <div class="flex-1">
        <h2 id="modalTitle" class="text-lg font-bold"></h2>
        <p id="modalDesc" class="text-sm text-gray-600 mt-1"></p>

        <p id="modalPrice" class="text-green-700 font-semibold mt-2"></p>
        <p id="modalStock" class="text-sm text-gray-500"></p>

        <!-- QTY -->
        <div class="mt-3">
          <label class="text-sm">Jumlah:</label>
          <input type="number" value="1" class="border w-16 ml-2">
        </div>

        <!-- BUTTON -->
        <div class="flex gap-2 mt-4">
          <button class="bg-green-700 text-white px-4 py-2 rounded">Beli</button>
          <button class="border px-4 py-2 rounded">+ Keranjang</button>
        </div>
      </div>

    </div>

    <!-- ULASAN -->
    <div class="mt-5 border-t pt-3">
      <h3 class="font-semibold text-sm mb-2">Ulasan</h3>
      <div id="reviewList" class="text-sm text-gray-600">
        <p>⭐ 5 - Mantap banget!</p>
        <p>⭐ 4 - Manis & segar</p>
      </div>
    </div>

  </div>

</div>
<script>
  function openModal(data) {
    document.getElementById("modal").classList.remove("hidden");

    document.getElementById("modalTitle").innerText = data.title;
    document.getElementById("modalDesc").innerText = data.desc;
    document.getElementById("modalPrice").innerText = "Rp " + data.price;
    document.getElementById("modalStock").innerText = "Stok: " + data.stock;
    document.getElementById("modalImg").src = data.img;
  }

  function closeModal() {
    document.getElementById("modal").classList.add("hidden");
  }

  // klik luar = close
  window.onclick = function (e) {
    const modal = document.getElementById("modal");
    if (e.target === modal) {
      modal.classList.add("hidden");
    }
  }
</script>
</body>

</html>