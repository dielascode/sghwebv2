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
    const basePath = "/sghwebv2/ec/images/";
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
    window.modalQty = 1;
    document.getElementById("modalQty").textContent = window.modalQty;
};

window.closeModal = function () {
    document.getElementById("modal").classList.add("hidden");
};

window.changeQty = function (delta) {
    window.modalQty = Math.max(1, window.modalQty + delta);
    document.getElementById("modalQty").textContent = window.modalQty;
};

window.addToCart = function () {
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
            console.log(res);
        }
    })
    .catch(err => {
        console.log(err);
        showToast('Terjadi error');
    });
};

window.buyNow = function () {
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