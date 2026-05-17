let produkData = [];
let currentPageProduk = 1;
const itemsPerPageProduk = 6;

function loadProduk() {
  fetch("data/produk.json")
    .then((res) => res.json())
    .then((data) => {
      produkData = data;
      currentPageProduk = 1;
      renderProduk();
      renderPaginationProduk();
      initPopupProduk(data);
    })
    .catch((err) => console.error("Error loading produk:", err));
}

function renderProduk() {
  const container = document.getElementById("produkContainer");
  if (!container) return;

  container.innerHTML = "";

  const start = (currentPageProduk - 1) * itemsPerPageProduk;
  const end = start + itemsPerPageProduk;

  const pageItems = produkData.slice(start, end);

  pageItems.forEach((item) => {
    container.innerHTML += `
        <div class="produk-child">
            <img src="${item.image}" alt="" srcset="">
            <div class="produk-child-desc d-flex" style="justify-content: space-between; align-items: center;">
                <p class="judul-produk-child">${item.nama}</p>
                <p class="judul-produk-child">${item.harga}/kg</p>
            </div>
            <div class="produk-child-btn d-flex" style="justify-content: space-evenly; align-items: center;">
                <button class="btn-main-hijau detail-produk" id="detail-produk" data-id="${item.id}">Detail Produk</button>
            </div>
            
            
        </div>
        `;
  });
}

function renderPaginationProduk() {
  const pag = document.getElementById("paginationProduk");
  if (!pag) return;

  pag.innerHTML = "";

  const totalPages = Math.ceil(produkData.length / itemsPerPageProduk);

  pag.innerHTML += `
        <button class="page-btn" ${currentPageProduk === 1 ? "disabled" : ""} onclick="goToPageProduk(${currentPageProduk - 1})">Prev</button>
    `;

  for (let i = 1; i <= totalPages; i++) {
    pag.innerHTML += `
            <button class="page-number ${currentPageProduk === i ? "active" : ""}" onclick="goToPageProduk(${i})">${i}</button>
        `;
  }

  pag.innerHTML += `
        <button class="page-btn" ${currentPageProduk === totalPages ? "disabled" : ""} onclick="goToPageProduk(${currentPageProduk + 1})">Next</button>
    `;
}

function goToPageProduk(page) {
  currentPageProduk = page;
  renderProduk();
  renderPaginationProduk();
}

function initPopupProduk(data) {
  const buttons = document.querySelectorAll(".detail-produk"); // FIX

  const popup = document.getElementById("popup-produk");
  const popupImg = document.getElementById("popup-img-produk");
  const popupNama = document.getElementById("popup-nama-produk");
  const popupDesc = document.getElementById("popup-desc-produk");
  const popupHarga = document.getElementById("popup-harga-produk");

  buttons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      const id = this.getAttribute("data-id");
      const item = data.find((x) => x.id == id);

      popupImg.src = item.image;
      popupNama.innerText = item.nama;
      popupDesc.innerHTML = item.deskirpsi;
      popupHarga.innerHTML = item.harga;

      popup.style.display = "flex";
    });
  });
}

function tutupPopup() {
  document.getElementById("popup-produk").style.display = "none";
}
