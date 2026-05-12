
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

      fetch('/sghwebv2/ec/costumer/controller/keranjangController.php', {
    method: 'POST',
    credentials: 'include',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `action=add&id_detail=${selectedProductId}&kuantitas=${modalQty}`
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
