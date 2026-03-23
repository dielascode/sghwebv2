let galeriData = [];
let currentPageGaleri = 1;
const itemsPerPageGaleri = 9;

function loadGaleri() {
  fetch("data/galeri.json")
    .then((res) => res.json())
    .then((data) => {
      galeriData = data;
      currentPageGaleri = 1;
      renderGaleri();
      renderPaginationGaleri();
      console.log(data);
    })
    .catch((err) => console.error("Error loading GALERI:", err));
}

function renderGaleri() {
  const container = document.getElementById("galeriContainer");
  if (!container) return;

  container.innerHTML = "";

  const start = (currentPageGaleri - 1) * itemsPerPageGaleri;
  const end = start + itemsPerPageGaleri;

  const pageItems = galeriData.slice(start, end);

  pageItems.forEach((item) => {
    container.innerHTML += `
        <div class="gallery-item">
            <img src="${item.image}" alt="Memetik Melon">
            <p class="caption">${item.caption}</p>
        </div>
        `;
  });
}

function renderPaginationGaleri() {
  const pag = document.getElementById("paginationGaleri");
  if (!pag) return;

  pag.innerHTML = "";

  const totalPages = Math.ceil(galeriData.length / itemsPerPageGaleri);

  pag.innerHTML += `
        <button class="page-btn" ${currentPageGaleri === 1 ? "disabled" : ""} onclick="goToPageGaleri(${currentPageGaleri - 1})">Prev</button>
    `;

  for (let i = 1; i <= totalPages; i++) {
    pag.innerHTML += `
            <button class="page-number ${currentPageGaleri === i ? "active" : ""}" onclick="goToPageGaleri(${i})">${i}</button>
        `;
  }

  pag.innerHTML += `
        <button class="page-btn" ${currentPageGaleri === totalPages ? "disabled" : ""} onclick="goToPageGaleri(${currentPageGaleri + 1})">Next</button>
    `;
}

function goToPageGaleri(page) {
  currentPageGaleri = page;
  renderGaleri();
  renderPaginationGaleri();
}
