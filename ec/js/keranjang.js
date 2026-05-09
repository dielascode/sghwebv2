function updateQty(id, delta, event) {

    if (event) {
        event.preventDefault();
    }

    const formData = new URLSearchParams();

    formData.append('action', 'qty');
    formData.append('id_detail', id);
    formData.append('qty', delta);

    fetch('/sghwebv2/ec/logic/costumer/updatecart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.toString()
    })
    .then(response => response.text())
    .then(data => {

        if (data.includes('success')) {

            loadPage('costumer/page/keranjang.php');

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

    fetch('/sghwebv2/ec/logic/costumer/updatecart.php', {
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

    fetch('/sghwebv2/ec/logic/costumer/updatecart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'action': 'get_total'
        })
    }  )
    .then(res => res.text())
    .then(total => {

        const badge = document.querySelector('.cart-badge');

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

