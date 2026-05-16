<?php
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

$totalSelesai = 0;

foreach ($data as $item) {
    if ($item['status'] == 'selesai') {
        $totalSelesai++;
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
                <?= $totalSelesai ?> orders
            </div>

            <div class="oh-cards">

                <?php foreach ($data as $row): ?>
                    <?php if ($row['status'] != 'selesai')
                        continue; ?>

                    <div class="oh-card">

                        <div class="card-status-bar">
                            <span class="status-dot done"></span>
                            <span class="status-label done">Selesai</span>
                        </div>

                        <div class="card-inner">

                            <div class="product-box">

                                <div class="melon-thumb">
                                    <img src="/sghwebv2/asset/image/produk/<?= $data['foto'] ?? 'melon1.jpg' ?>"
                                        class="thumb-img">
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
                                <button class="btn-struk" onclick="printInvoice('<?= $row['nomor_pesanan'] ?>')">
                                    Cetak Struk
                                </button>
                                <button class="btn-nilai" onclick="openNilaiPopup(
                                    '<?= $row['nama_produk'] ?>',
                                    '/sghwebv2/asset/image/produk/<?= $row['gambar'] ?>',
                                    '<?= $row['nomor_pesanan'] ?>'
                                        )">
                                    Nilai Produk
                                </button>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>




<!-- ===================================================== -->
<!--  MODAL NILAI PRODUK                                    -->
<!-- ===================================================== -->
<div class="overlay-nilai" id="overlay-nilai" onclick="handleNilaiOverlay(event)">
    <div class="modal-nilai">

        <button class="modal-nilai-close" onclick="closeNilaiPopup()">&#x2715;</button>

        <h2>Nilai produk</h2>

        <!-- hidden -->
        <input type="hidden" id="nilai-nomor-pesanan">

        <!-- Info produk -->
        <div class="nilai-product-row">

            <div class="nilai-product-icon">
                <img id="nilai-img" src="" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
            </div>

            <div class="nilai-product-name" id="nilai-nama">
                -
            </div>

        </div>

        <!-- Rating -->
        <div class="nilai-rating-row">

            <span class="nilai-rating-label">
                Kualitas Produk
            </span>

            <div class="nilai-stars">

                <span class="nilai-star" onclick="nilaiSetRating(1)" onmouseover="nilaiHover(1)"
                    onmouseout="nilaiResetHover()">
                    &#9733;
                </span>

                <span class="nilai-star" onclick="nilaiSetRating(2)" onmouseover="nilaiHover(2)"
                    onmouseout="nilaiResetHover()">
                    &#9733;
                </span>

                <span class="nilai-star" onclick="nilaiSetRating(3)" onmouseover="nilaiHover(3)"
                    onmouseout="nilaiResetHover()">
                    &#9733;
                </span>

                <span class="nilai-star" onclick="nilaiSetRating(4)" onmouseover="nilaiHover(4)"
                    onmouseout="nilaiResetHover()">
                    &#9733;
                </span>

                <span class="nilai-star" onclick="nilaiSetRating(5)" onmouseover="nilaiHover(5)"
                    onmouseout="nilaiResetHover()">
                    &#9733;
                </span>

            </div>

            <span class="nilai-rating-desc" id="nilai-rating-desc"></span>

        </div>

        <!-- textarea -->
        <div class="nilai-input-box">

            <div class="nilai-input-group">

                <label for="nilai-quality">
                    Deskripsi:
                </label>

                <textarea id="nilai-quality"
                    placeholder="Saya merasa produk ini sangat baik dari segi luarnya"></textarea>

            </div>

        </div>

        <!-- upload -->
        <div class="nilai-upload-row">

            <label class="nilai-upload-btn">

                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <polyline points="21 15 16 10 5 21" />
                </svg>

                Tambah Foto

                <input type="file" id="nilai-photo" name="photos[]" accept="image/*" multiple
                    onchange="nilaiHandleFiles(this,'photo')">

            </label>

        </div>

        <!-- preview -->
        <div id="nilai-preview-area"></div>

        <!-- footer -->
        <div class="nilai-modal-footer">

            <button class="nilai-btn-cancel" onclick="closeNilaiPopup()">
                Nanti Saja
            </button>

            <button class="nilai-btn-ok" onclick="nilaiSubmit()">
                OK
            </button>

        </div>

    </div>
</div>

<!-- toast -->
<div id="nilai-toast"></div>