let beritaData = [];
let currentPageBerita = 1;
const itemsPerPageBerita = 6;

function loadBerita() {
  fetch("data/berita.json")
    .then((res) => res.json())
    .then((data) => {
      beritaData = data;
      currentPageBerita = 1;
      renderBerita();
      renderPaginationBarita();
      initPopupBerita(data);
    })
    .catch((err) => console.error("Error loading berita:", err));
}

function renderBerita() {
  const container = document.getElementById("beritaContainer");
  if (!container) return;

  container.innerHTML = "";

  const start = (currentPageBerita - 1) * itemsPerPageBerita;
  const end = start + itemsPerPageBerita;

  const pageItems = beritaData.slice(start, end);

  pageItems.forEach((item) => {
    container.innerHTML += `
            <div class="news-card">
                <div class="news-image-wrapper">
                    <img src="${item.image}" alt="Foto kegiatan" class="news-image">
                </div>

                <div class="news-content">
                    <h2 class="news-title">${item.title}</h2>
                    <p class="news-description">
                        ${
                          item.description.length > 120
                            ? item.description.substring(0, 120) + "..."
                            : item.description
                        }
                    </p>

                    <div class="news-footer">
                        <a href="#" class="news-button" id="detail-news" data-id="${item.id}">Selengkapnya</a>
                    </div>
                </div>
            </div>
        `;
  });
}

function renderPaginationBarita() {
  const pag = document.getElementById("paginationBerita");
  if (!pag) return;

  pag.innerHTML = "";

  const totalPages = Math.ceil(beritaData.length / itemsPerPageBerita);

  pag.innerHTML += `
        <button class="page-btn" ${currentPageBerita === 1 ? "disabled" : ""} onclick="goToPageBerita(${currentPageBerita - 1})">Prev</button>
    `;

  for (let i = 1; i <= totalPages; i++) {
    pag.innerHTML += `
            <button class="page-number ${currentPageBerita === i ? "active" : ""}" onclick="goToPageBerita(${i})">${i}</button>
        `;
  }

  pag.innerHTML += `
        <button class="page-btn" ${currentPageBerita === totalPages ? "disabled" : ""} onclick="goToPageBerita(${currentPageBerita + 1})">Next</button>
    `;
}

function goToPageBerita(page) {
  currentPageBerita = page;
  renderBerita();
  renderPaginationBarita();
}

function initPopupBerita(data) {
  const buttons = document.querySelectorAll(".news-button");

  const popup = document.getElementById("popup-detail-berita");
  const popupImg = document.getElementById("popup-img");
  const popupTitle = document.getElementById("popup-title");
  const popupDesc = document.getElementById("popup-desc");

  buttons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      const id = this.getAttribute("data-id");
      const item = data.find((x) => x.id == id);

      popupImg.src = item.image;
      popupTitle.innerText = item.title;
      popupDesc.innerHTML = item.description;

      popup.style.display = "flex";
    });
  });
}

function tutupPopupProduk() {
  document.getElementById("popup-detail-berita").style.display = "none";
}
