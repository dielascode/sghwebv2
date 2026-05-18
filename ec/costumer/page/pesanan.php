<?php
session_name('sghwebv2_session');
                              session_start();

require_once '../../config/connection.php';
require_once '../../logic/costumer/pesananApi.php';

$db = new Database();
$conn = $db->getConnection();

$api = new PesananAPI($conn);

$id_costumer = $_SESSION['id'] ?? null;

if (!$id_costumer) {
    die("UNAUTHORIZED");
}

$data = $api->getOrderHistory($id_costumer);

$totalMenungguKonfirmasi = 0;

foreach ($data as $item) {
    if ($item['status'] == 'menunggu_konfirmasi') {
        $totalMenungguKonfirmasi++;
    }
}
?>

<!-- ================= UI ================= -->
<div class="container-pesanan d-flex">

    <?php include "../elemen/sidebar_pesanan.php"; ?>

    <div class="konten flex-grow-1 p-3">

        <div class="oh-wrap">

            <div class="oh-title">Order History</div>
            <div class="oh-count">
                <?= $totalMenungguKonfirmasi ?> orders
            </div>

            <div class="oh-cards">

                <?php foreach ($data as $row): ?>
                    <?php if ($row['status'] != 'menunggu_konfirmasi')
                        continue; ?>

                    <div class="oh-card">

                        <div class="card-status-bar">
                            <span class="status-dot"></span>
                            <span class="status-label">Menunggu Konfirmasi</span>
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

                            <div class="btn-box">
                                <button class="btn-detail"
                                    onclick="loadPage('/sghwebv2/ec/costumer/page/detailOrder.php?nomor_pesanan=<?= $row['nomor_pesanan'] ?>')">
                                    Order Detail
                                </button>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>