const products = [
  { id: 1, name: "Melon Honey Globe",    variety: "Varietas", price: 30000, stok: 48, color: "#eaf3de", rind: "#97c459", vein: "#3b6d11", flesh: "#c0dd97" },
  { id: 2, name: "Melon Sky Rocket",     variety: "Varietas", price: 28000, stok: 30, color: "#fef3e2", rind: "#e9a825", vein: "#9a6600", flesh: "#f9d97e" },
  { id: 3, name: "Melon Action",         variety: "Varietas", price: 32000, stok: 12, color: "#e8f5e9", rind: "#66bb6a", vein: "#2e7d32", flesh: "#a5d6a7" },
  { id: 4, name: "Melon Golden Langkawi",variety: "Varietas", price: 35000, stok: 55, color: "#fffde7", rind: "#fdd835", vein: "#8d6e00", flesh: "#fff9c4" },
  { id: 5, name: "Melon Jade Dew",       variety: "Varietas", price: 27000, stok: 20, color: "#e8f5e9", rind: "#4caf50", vein: "#1b5e20", flesh: "#b9f6ca" },
  { id: 6, name: "Melon Cantaloup",      variety: "Varietas", price: 33000, stok: 8,  color: "#fff3e0", rind: "#ef6c00", vein: "#bf360c", flesh: "#ffcc80" },
  { id: 7, name: "Melon Apollo",         variety: "Varietas", price: 29000, stok: 62, color: "#f3e5f5", rind: "#ab47bc", vein: "#6a1b9a", flesh: "#e1bee7" },
  { id: 8, name: "Melon Inthanon",       variety: "Varietas", price: 31000, stok: 35, color: "#e3f2fd", rind: "#42a5f5", vein: "#0d47a1", flesh: "#bbdefb" },
];

const stokMap = {};
products.forEach(p => stokMap[p.id] = p.stok);

function melonSVG(p) {
  return `
    <svg class="melon-svg" viewBox="0 0 130 130" xmlns="http://www.w3.org/2000/svg">
      <ellipse cx="65" cy="70" rx="52" ry="48" fill="${p.rind}"/>
      <ellipse cx="65" cy="70" rx="52" ry="48" fill="none" stroke="${p.vein}" stroke-width="1.5" stroke-dasharray="8 6" stroke-dashoffset="3"/>
      <ellipse cx="65" cy="70" rx="38" ry="35" fill="none" stroke="${p.vein}" stroke-width="1" stroke-dasharray="6 5"/>
      <ellipse cx="65" cy="24" rx="10" ry="7" fill="${p.flesh}"/>
      <path d="M65 18 Q72 10 80 8 Q75 14 65 18Z" fill="${p.vein}"/>
      <path d="M65 18 Q58 12 52 11 Q57 16 65 18Z" fill="${p.vein}"/>
      <ellipse cx="65" cy="70" rx="28" ry="25" fill="#ffffff" opacity="0.25"/>
    </svg>`;
}

function renderGrid() {
  const grid = document.getElementById('productGrid');
  grid.innerHTML = products.map(p => {
    const s = stokMap[p.id];
    const isLow = s <= 15;
    return `
      <div class="product-card">
        <div class="img-area" style="background:${p.color}">
          ${melonSVG(p)}
        </div>
        <div class="card-body">
          <p class="variety-label">${p.variety}</p>
          <h2 class="product-name">${p.name}</h2>
          <div class="price-row">
            <span class="price">Rp ${p.price.toLocaleString('id-ID')}</span>
            <span class="per-unit">/ kg</span>
          </div>
          <div class="stock-row">
            <span class="stock-dot${isLow ? ' low' : ''}"></span>
            <span class="stock-text">Stok: <span class="stock-num" id="stok-${p.id}">${s} kg</span></span>
          </div>
          <div class="btn-row">
            <button class="btn-buy" onclick="handleBuy(${p.id})">Beli Sekarang</button>
            <button class="btn-cart" onclick="handleCart(${p.id})">+ Keranjang</button>
          </div>
        </div>
      </div>`;
  }).join('');
}

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2200);
}

function handleBuy(id) {
  if (stokMap[id] <= 0) { showToast('Stok habis!'); return; }
  stokMap[id]--;
  document.getElementById('stok-' + id).textContent = stokMap[id] + ' kg';
  showToast('Melanjutkan ke pembayaran...');
}

function handleCart(id) {
  if (stokMap[id] <= 0) { showToast('Stok habis!'); return; }
  stokMap[id]--;
  document.getElementById('stok-' + id).textContent = stokMap[id] + ' kg';
  showToast('Ditambahkan ke keranjang!');
}


function openModal(el) {
  document.getElementById("modal").style.display = "block";

  document.getElementById("modal-title").innerText = el.dataset.title;
  document.getElementById("modal-desc").innerText = el.dataset.desc;
  document.getElementById("modal-price").innerText = "Rp " + el.dataset.price;
  document.getElementById("modal-stock").innerText = "Stok: " + el.dataset.stock + " kg";
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
}


renderGrid();
