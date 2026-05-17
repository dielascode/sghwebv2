<?php

require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../logic/costumer/pesananApi.php';

$db = new Database();
$conn = $db->getConnection();

$api = new PesananAPI($conn);

$id_costumer = $_SESSION['id'] ?? null;

if (!$id_costumer) {
    die("UNAUTHORIZED");
}

$data = $api->getOrderHistory($id_costumer);

$totalDibatalkan = 0;

foreach ($data as $item) {
    if ($item['status'] == 'dibatalkan') {
        $totalDibatalkan++;
    }
}
?>

<!-- ================= UI ================= -->
<div class="container-pesanan d-flex">

    <?php include __DIR__ ."/../elemen/sidebar_pesanan.php"; ?>

    <div class="konten flex-grow-1 p-3">

        <div class="oh-wrap">

            <div class="oh-title">Order History</div>
            <div class="oh-count">
                <?= $totalDibatalkan ?> orders
            </div>

            <div class="oh-cards">

                <?php foreach ($data as $row): ?>
                    <?php if ($row['status'] != 'dibatalkan')
                        continue; ?>

                    <div class="oh-card-cancel">

                        <div class="card-status-bar">
                            <span class="status-dot cancel"></span>
                            <span class="status-label cancel">Dibatalkan</span>
                        </div>

                        <div class="card-inner">

                            <div class="product-box">

                                <div class="melon-thumb">
                                    <img src="/sghwebv2/asset/image/produk/<?= $row['gambar'] ?>" class="thumb-img">
                                </div>

                                <div class="product-info">

                                    <div class="product-name">
                                        <?= $row['nama_produk'] ?>
                                    </div>

                                    <div class="product-meta">

                                        <div class="meta-row">
                                            <span class="meta-lbl">Total Harga</span>
                                            <span class="meta-val green">
                                                Rp <?= number_format($row['total_harga']) ?>
                                            </span>
                                        </div>

                                        <div class="meta-row">
                                            <span class="meta-lbl">QTY</span>
                                            <span class="meta-val">
                                                <?= $row['total_qty'] ?> kg
                                            </span>
                                        </div>

                                        <div class="meta-row">
                                            <span class="meta-lbl">No. Pesanan</span>
                                            <span class="meta-val muted">
                                                <?= $row['nomor_pesanan'] ?>
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

