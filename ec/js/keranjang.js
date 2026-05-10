function updateQty(id, delta, event) {

    if (event) {
        event.preventDefault();
    }

    const formData = new URLSearchParams();

    formData.append('action', 'qty');
    formData.append('id_detail', id);
    formData.append('qty', delta);

    fetch('/sghwebv2/ec/logic/costumer/keranjangApi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.text())
    .then(data => {

        if (data.includes('success')) {

            const card = document
                .querySelector(`.product-check[value="${id}"]`)
                .closest('.cart-card');

            const qtyInput = card.querySelector('.qty-picker input');

            let currentQty = parseInt(qtyInput.value);

            currentQty += delta;

            if(currentQty <= 0){

                card.remove();

            }else{

                qtyInput.value = currentQty;

                // update data qty
                card.dataset.qty = currentQty;

                // update harga
                const price = parseInt(card.dataset.price);

                const totalHarga = price * currentQty;

                card.querySelector('.product-price')
                    .innerText =
                    `Rp ${totalHarga.toLocaleString('id-ID')}`;

            }

            // update summary
            updateSummary();

            // update badge
            updateCartBadge();

        }

    });

}



function deleteSelected() {

    let checked = document.querySelectorAll('.product-check:checked');

    let ids = [];

    checked.forEach(item => {
        ids.push(item.value);
    });

    if (ids.length == 0) {
        alert('Pilih produk dulu');
        return;
    }

    const formData = new URLSearchParams();

    formData.append('action', 'delete_selected');
    formData.append('ids', JSON.stringify(ids));

    fetch('/sghwebv2/ec/logic/costumer/keranjangApi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(res => res.text())
    .then(res => {

        if (res.includes('success')) {

            loadPage('costumer/page/keranjang.php');

            updateCartBadge();

        }

    });

}



/* =========================
   CHECK ALL
========================= */

document.addEventListener('change', function (e) {

    // checkbox atas
    if (e.target.id === 'check-all') {

        const checked = e.target.checked;

        document.querySelectorAll('.product-check').forEach(item => {

            item.checked = checked;

        });

    }

});



function updateCartBadge(){

    fetch('/sghwebv2/ec/logic/costumer/keranjangApi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'action': 'get_total'
        })
    })
    .then(res => res.text())
    .then(total => {

        const badge = document.querySelector('.cart-badge');

        total = parseInt(total);

        if(total > 0){

            if(badge){

                badge.innerText = total;

            }else{

                const wrapper = document.querySelector('.cart-icon-wrapper');

                wrapper.innerHTML += `
                    <span class="cart-badge">${total}</span>
                `;

            }

        }else{

            if(badge){
                badge.remove();
            }

        }

    });

}



function updateSummary() {

    let checkedItems = document.querySelectorAll('.product-check:checked');

    let total = 0;
    let totalItem = 0;

    checkedItems.forEach(item => {

        const card = item.closest('.cart-card');

        const price = parseInt(card.dataset.price);
        const qty = parseInt(card.dataset.qty);

        total += price * qty;
        totalItem++;

    });

    document.getElementById('summary-item-count')
        .innerText = `${totalItem} Item`;

    document.getElementById('summary-subtotal')
        .innerText = `Rp ${total.toLocaleString('id-ID')}`;

    document.getElementById('summary-total')
        .innerText = `Rp ${total.toLocaleString('id-ID')}`;

}



/* =========================
   CHECKBOX CHANGE
========================= */

document.addEventListener('change', function(e){

    if(
        e.target.classList.contains('product-check') ||
        e.target.id === 'check-all'
    ){

        updateSummary();

    }

});