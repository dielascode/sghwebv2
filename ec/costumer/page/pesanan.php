<?php session_start(); ?>


<!-- WRAPPER BAWAH -->
<div class="container-pesanan d-flex">

    <!-- SIDEBAR -->
    <?php include "../elemen/sidebar_pesanan.php"; ?>

    <!-- KONTEN -->
    <div class="konten flex-grow-1 p-3">
        <div class="oh-wrap">

            <div class="oh-title">Order History</div>
            <div class="oh-count" id="totalOrder">0 orders</div>

            <div class="oh-cards" id="orderContainer">
                <!-- isi dari API -->
            </div>

        </div>
    </div>
</div>

<script>
const statusPage = "menunggu_konfirmasi"; 
// 🔥 ganti ini di file lain:
// dikirim.php  -> "dikirim"
// selesai.php  -> "selesai"
// dibatal.php  -> "dibatalkan"

fetch(`/sghwebv2/ec/logic/costumer/pesananApi.php?status=${statusPage}`)
.then(async res => {
    const text = await res.text();
    console.log(text); // 🔥 lihat error asli
    return JSON.parse(text);
})
.then(data => render(data))
.catch(err => {
    console.log("ERROR:", err);
    document.getElementById("orderContainer").innerHTML =
        "Gagal load data (cek console)";
});

    const container = document.getElementById("orderContainer");
    const total = document.getElementById("totalOrder");

    total.innerText = data.length + " orders";

    if (data.length === 0) {
        container.innerHTML = `
            <div style="padding:20px; text-align:center; color:#777;">
                Tidak ada pesanan
            </div>
        `;
        return;
    }

    container.innerHTML = data.map(p => `
        <div class="oh-card">

            <div class="card-status-bar">
                <span class="status-dot"></span>
                <span class="status-label">
                    ${p.status}
                </span>
            </div>

            <div class="card-inner">

                <div class="product-box">

                    <div class="melon-thumb">
                        <img src="/sghwebv2/ec/uploads/${p.foto}" class="thumb-img">
                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            ${p.nama_produk}
                        </div>

                        <div class="product-meta">

                            <div class="meta-row">
                                <span class="meta-lbl">Total Harga</span>
                                <span class="meta-val green">
                                    Rp ${Number(p.total).toLocaleString('id-ID')}
                                </span>
                            </div>

                            <div class="meta-row">
                                <span class="meta-lbl">QTY</span>
                                <span class="meta-val">
                                    ${p.qty}
                                </span>
                            </div>

                            <div class="meta-row">
                                <span class="meta-lbl">No. Pesanan</span>
                                <span class="meta-val muted">
                                    ${p.nomor_pesanan}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="btn-box">
                    <button class="btn-detail"
                        onclick="loadPage('/sghwebv2/ec/costumer/page/detailorder.php?nomor=${p.nomor_pesanan}')">
                        Order Detail
                    </button>

                    <button class="btn-struk">
                        Cetak Struk
                    </button>
                </div>

            </div>
        </div>
    `).join('');

});
</script>