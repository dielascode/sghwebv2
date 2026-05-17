// ── Global functions — harus di luar DOMContentLoaded ──────────
window.modalQty = 1;
window.selectedProductId = null;

window.openModal = function (data) {
    window.selectedProductId = data.id;
    const modal = document.getElementById("modal");
    modal.classList.remove("hidden");
    const images = data.images || [];
    document.getElementById("modalTitle").innerText = data.title;
    document.getElementById("modalVariety").innerText = data.variety;
    document.getElementById("modalDesc").innerText = data.desc;
    document.getElementById("modalPrice").innerText = "Rp " + data.price;
    document.getElementById("modalStock").innerText = data.stock;
    const basePath = "/sghwebv2/asset/image/produk/";
    const mainImg = document.getElementById("modalImg");
    if (images.length > 0) {
        mainImg.src = basePath + images[0];
    } else {
        mainImg.src = "";
    }
    const thumbsContainer = document.getElementById("modalThumbs");
    thumbsContainer.innerHTML = "";
    (images || []).forEach((img) => {
        if (!img) return;
        img = String(img);
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

    // Render review
const grid = document.querySelector('.modal-reviews-grid');
grid.innerHTML = '';

const reviews = data.reviews || [];
if (reviews.length > 0) {
   reviews.forEach(r => {
    const bintang = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
    const inisial = r.nama.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
    const tanggal = new Date(r.tanggal_review).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric'
    });

    const fotoHtml = r.file
        ? `<img src="/sghwebv2/asset/image/review/${r.file}" 
               style="width:60px;height:60px;object-fit:cover;border-radius:8px;margin-top:6px;border:1px solid #e0e0e0;">`
        : '';

    grid.innerHTML += `
        <div class="modal-review-card">
            <div class="modal-review-stars" style="color:#f5a623;font-size:14px;letter-spacing:2px;">${bintang}</div>
            <p class="modal-review-text">${r.komentar}</p>
            ${fotoHtml}
            <div class="modal-review-footer">
                <div class="modal-reviewer">
                    <div class="modal-reviewer-avatar">${inisial}</div>
                    <span class="modal-reviewer-name">${r.nama}</span>
                </div>
                <span class="modal-review-date">${tanggal}</span>
            </div>
        </div>`;
});
} else {
    grid.innerHTML = '<p style="color:#aaa;font-size:13px;padding:8px 0;grid-column:1/-1;">Belum ada ulasan.</p>';
}
    window.modalQty = 1;
    document.getElementById("modalQty").textContent = window.modalQty;
};

window.closeModal = function () {
    document.getElementById("modal").classList.add("hidden");
};

window.changeQty = function (delta) {
    const stock = parseInt(document.getElementById("modalStock").innerText) || 0;
    window.modalQty = Math.min(Math.max(1, window.modalQty + delta), stock);
    document.getElementById("modalQty").textContent = window.modalQty;
};

window.addToCart = function () {
    const stock = parseInt(document.getElementById("modalStock").innerText) || 0;
    if (window.modalQty > stock) {
        showToast('Jumlah melebihi stok tersedia');
        return;
    }

    fetch('/sghwebv2/ec/costumer/controller/keranjangController.php', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add&id_produk=${window.selectedProductId}&kuantitas=${window.modalQty}`
    })
    .then(res => res.text())
    .then(res => {
        res = res.trim();
        if (res === 'success') {
            showToast('Produk berhasil ditambahkan ke keranjang');
            updateCartBadge();
        } else {
            showToast('Gagal menambahkan produk');
        }
    })
    .catch(() => showToast('Terjadi error'));
};

window.buyNow = function () {
    const stock = parseInt(document.getElementById("modalStock").innerText) || 0;
    if (window.modalQty > stock) {
        showToast('Jumlah melebihi stok tersedia');
        return;
    }

    fetch('/sghwebv2/ec/costumer/controller/keranjangController.php', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=set_buynow&id_produk=${window.selectedProductId}&qty=${window.modalQty}`
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === 'success') {
            window.closeModal();
            loadPage('costumer/page/pemesanan.php');
        }
    });
};

// ── Click outside modal — hanya perlu sekali saat load awal ──
document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("click", function (e) {
        const modal = document.getElementById("modal");
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});

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