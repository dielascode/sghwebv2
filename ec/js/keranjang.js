// ============================================================
//  keranjang.js
// ============================================================

const CART_URL = '/sghwebv2/ec/costumer/controller/keranjangController.php';

// ── Helper: fetch POST ke controller ────────────────────────
function postData(body) {
    return fetch(CART_URL, {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: typeof body === 'string' ? body : body.toString()
    }).then(r => r.text());
}

// ── Update qty produk di keranjang ───────────────────────────
function updateQty(id, delta, event) {
    if (event) event.preventDefault();

    const params = new URLSearchParams({
        action: 'kuantitas',
        id_detail: id,
        kuantitas: delta
    });

    postData(params).then(res => {
        if (!res.includes('success')) return;

        const card     = document.querySelector(`.product-check[value="${id}"]`).closest('.cart-card');
        const qtyInput = card.querySelector('.qty-picker input');
        const newQty   = parseInt(qtyInput.value) + delta;

        if (newQty <= 0) {
            card.remove();
        } else {
            qtyInput.value      = newQty;
            card.dataset.qty    = newQty;
            const totalHarga    = parseInt(card.dataset.price) * newQty;
            card.querySelector('.product-price').innerText = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        }

        updateSummary();
        updateCartBadge();
    });
}

// ── Hapus produk yang dicentang ──────────────────────────────
function deleteSelected() {
    const ids = [...document.querySelectorAll('.product-check:checked')]
        .map(el => el.value);

    if (!ids.length) { alert('Pilih produk dulu'); return; }

    const params = new URLSearchParams({
        action: 'delete_selected',
        ids: JSON.stringify(ids)
    });

    postData(params).then(res => {
        if (res.includes('success')) {
            loadPage('costumer/page/keranjang.php');
            updateCartBadge();
        }
    });
}

// ── Update badge jumlah item di navbar ───────────────────────
function updateCartBadge() {
    postData('action=get_total').then(total => {
        total = parseInt(total) || 0;

        const wrapper = document.querySelector('.cart-icon-wrapper');
        if (!wrapper) return;

        let badge = wrapper.querySelector('.cart-badge');

        if (total > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'cart-badge';
                wrapper.appendChild(badge);
            }
            badge.innerText = total;
        } else {
            badge?.remove();
        }
    });
}

// ── Hitung ulang summary sidebar ─────────────────────────────
function updateSummary() {
    let total     = 0;
    let totalItem = 0;

    document.querySelectorAll('.product-check:checked').forEach(el => {
        const card = el.closest('.cart-card');
        total     += parseInt(card.dataset.price) * parseInt(card.dataset.qty);
        totalItem++;
    });

    document.getElementById('summary-item-count').innerText = `${totalItem} Item`;
    document.getElementById('summary-subtotal').innerText   = `Rp ${total.toLocaleString('id-ID')}`;
    document.getElementById('summary-total').innerText      = `Rp ${total.toLocaleString('id-ID')}`;
}

// ── Lanjut ke pemesanan ───────────────────────────────────────
window.lanjutPemesanan = function () {
    const selected = [...document.querySelectorAll('.product-check:checked')]
        .map(el => el.value);

    if (!selected.length) { alert('Pilih minimal 1 produk'); return; }

    postData(`action=set_selected&ids=${JSON.stringify(selected)}`).then(res => {
        if (res.trim() === 'success') loadPage('costumer/page/pemesanan.php');
    });
};

// ── Checkbox: check-all + update summary ─────────────────────
document.addEventListener('change', function (e) {
    const t = e.target;

    if (t.id === 'check-all') {
        document.querySelectorAll('.product-check')
            .forEach(el => el.checked = t.checked);
    }

    if (t.id === 'check-all' || t.classList.contains('product-check')) {
        updateSummary();
    }
});