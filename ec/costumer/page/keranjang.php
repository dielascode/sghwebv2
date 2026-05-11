<?php

require_once __DIR__ . "/../../config/connection.php";
require_once __DIR__ . "/../../logic/costumer/produkApi.php";

$db = new Database();
$conn = $db->getConnection();


$query = "
SELECT 
    keranjang.qty,
    detail_produk.id AS id_detail,
    produk.id AS id_produk,
    produk.nama_produk,
    produk.harga,
    varietas.nama_varietas
FROM keranjang
JOIN detail_produk 
    ON keranjang.id_detail_produk = detail_produk.id
JOIN produk 
    ON detail_produk.id_produk = produk.id
JOIN varietas 
    ON detail_produk.id_varietas = varietas.id
";

$result = mysqli_query($conn, $query);


// total jenis produk
$totalQty = mysqli_num_rows($result);


// subtotal
$subtotal = 0;


// simpan data ke array biar bisa dipake ulang
$cart = [];

while ($item = mysqli_fetch_assoc($result)) {

    $cart[] = $item;

    $subtotal += $item['harga'] * $item['qty'];

}

?>

<main class="cart-wrapper">
    <div class="container-keranjang">

        <h1 class="page-title1">Keranjang Saya</h1>

        <p class="product-count">
            <?= $totalQty ?> Produk
        </p>

        <div class="cart-grid">

            <section class="cart-items-section">

                <?php if (empty($cart)): ?>

                    <div class="empty-cart">

                        <div class="empty-cart-icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>

                        <h2>Keranjang Masih Kosong</h2>

                        <p>
                            Yuk tambahkan produk favorit kamu ke keranjang
                            dan mulai belanja sekarang.
                        </p>

                        <button class="btn-shop" onclick="loadPage('costumer/page/katalog.php')">

                            Belanja Sekarang

                        </button>

                    </div>

                <?php else: ?>

                    <div class="select-all-bar">

                        <label class="checkbox-container-keranjang">

                            <input type="checkbox" id="check-all">

                            <span class="checkmark-keranjang"></span>

                            Pilih Semua

                        </label>

                        <button type="button" class="btn-delete-selected" onclick="deleteSelected()">

                            Hapus Dipilih

                        </button>

                    </div>

                    <?php foreach ($cart as $item): ?>

                        <div class="cart-card" data-price="<?= $item['harga'] ?>" data-qty="<?= $item['qty'] ?>">

                            <label class="checkbox-container-keranjang">

                                <input type="checkbox" class="product-check" value="<?= $item['id_detail'] ?>">

                                <span class="checkmark-keranjang"></span>

                            </label>

                            <div class="product-img">

                                <?php
                                $gambar = getGambarProduk($conn, $item['id_produk']);
                                $img = $gambar[0] ?? 'default.png';
                                ?>
                                <img src="/sghwebv2/ec/images/<?= $img ?>">

                            </div>

                            <div class="product-info">

                                <h3>
                                    <?= $item['nama_produk'] ?>
                                </h3>

                                <p class="variety-label">
                                    <?= $item['nama_varietas'] ?>
                                </p>

                                <div class="action-row">

                                    <div class="qty-picker">

                                        <button type="button" onclick="updateQty(<?= $item['id_detail'] ?>, -1, event)">

                                            -

                                        </button>

                                        <input type="text" value="<?= $item['qty'] ?>" readonly>

                                        <button type="button" onclick="updateQty(<?= $item['id_detail'] ?>, 1, event)">

                                            +

                                        </button>

                                    </div>

                                    <span class="badge-stock">

                                        Stok Tersedia

                                    </span>

                                </div>

                            </div>

                            <div class="product-price">

                                Rp <?= number_format(
                                    $item['harga'] * $item['qty'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </section>

            <aside class="cart-summary-keranjang">

                <div class="summary-card-keranjang">

                    <h2 class="summary-title-keranjang">
                        Ringkasan Pesanan
                    </h2>

                    <div class="summary-divider-keranjang"></div>

                    <div class="summary-details-keranjang">

                        <div class="summary-line-keranjang">

                            <span id="summary-item-count">
                                0 Item
                            </span>

                            <span id="summary-subtotal">
                                Rp 0
                            </span>

                        </div>

                    </div>

                    <div class="summary-divider-keranjang"></div>

                    <div class="summary-total-keranjang">

                        <span class="summary-total-label-keranjang">
                            Total Pembayaran
                        </span>

                        <span class="summary-total-price-keranjang" id="summary-total">

                            Rp 0

                        </span>

                    </div>

                    <button onclick="lanjutPemesanan()" class="btn-next-keranjang">

                        Selanjutnya

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14"
                            height="14">

                            <line x1="5" y1="12" x2="19" y2="12" />

                            <polyline points="12 5 19 12 12 19" />

                        </svg>

                    </button>

                </div>

            </aside>

        </div>
    </div>
</main>