<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/pesananApi.php";


$db = new Database();
$conn = $db->getConnection();
$pesanan = new Pesanan($conn);

$result = $pesanan->getPesanan();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>
<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Manajemen Pesanan</h1>
            <p class="text-muted mb-0">Lacak pesanan, manajemen barang, analisa minat pembeli</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" @click="exportOrders()">
                <i class="bi bi-download me-2"></i>Export
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
                <i class="bi bi-arrow-repeat me-2"></i>Bulk Update
            </button>
        </div>
    </div>

    <!-- Order Management Container -->
    <div>

        <!-- Order Stats Widgets -->
        <div class="row g-4 g-lg-5 mb-5">
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Orders</h6>
                                <h3 class="mb-0" x-text="stats.total"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +12% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Pending</h6>
                                <h3 class="mb-0" x-text="stats.pending"></h3>
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-circle"></i> Needs attention
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Shipped</h6>
                                <h3 class="mb-0" x-text="stats.shipped"></h3>
                                <small class="text-info">
                                    <i class="bi bi-arrow-right"></i> In transit
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Revenue</h6>
                                <h3 class="mb-0" x-text="`$${stats.revenue.toLocaleString()}`"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +8% from last week
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Orders Table -->
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">Orders</h5>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            <div class="position-relative">
                                <input type="search"
                                    class="form-control form-control-sm"
                                    placeholder="Search orders..."
                                    style="width: 200px;">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                            </div>

                            <select class="form-select form-select-sm"
                                style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>

                            <select class="form-select form-select-sm"
                                style="width: 150px;">
                                <option value="">All Dates</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">

                <!-- Table -->
                <div class="table">
                    <table class="table ">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Customer</th>
                                <th>Bukti Bayar</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $p): ?>
                                <tr>
                                    <td><?= $p['nomor_pesanan'] ?></td>
                                    <td><?= $p['nama'] ?></td>
                                    <td><?= $p['bukti_bayar'] ?></td>
                                    <td><?= $p['metode'] ?></td>
                                    <td><?= $p['status_pesanan'] ?></td>
                                    <td><?= $p['tanggal_order'] ?></td>
                                    <td>
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="viewOrder('<?= $p['nomor_pesanan']; ?>')">
                                                        <i class="bi bi-eye me-2"></i>Tampilkan Detail
                                                    </a>
                                                </li>
                                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                                    <li><a class="dropdown-item" href="#" onclick="openStatusModal('<?= $p['nomor_pesanan']; ?>', '<?= $p['status_pesanan']; ?>')">
                                                            <i class="bi bi-truck me-2"></i>Ubah Status
                                                        </a></li>
                                                <?php endif; ?>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="printInvoice('<?= $p['nomor_pesanan']; ?>')">
                                                        <i class="bi bi-printer me-2"></i>Cetak Struk
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                                    <li><a class="dropdown-item text-danger" href="#" @click="cancelOrder(order)">
                                                            <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                                                        </a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3">
                    <div class="text-muted">
                        Showing <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> to
                        <span x-text="Math.min(currentPage * itemsPerPage, filteredOrders.length)"></span> of
                        <span x-text="filteredOrders.length"></span> results
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                            </li>
                            <template x-for="(page, index) in visiblePages" :key="`page-${index}`">
                                <li class="page-item" :class="{ 'active': page === currentPage }">
                                    <a class="page-link" href="#" @click.prevent="page !== '...' && goToPage(page)" x-text="page"></a>
                                </li>
                            </template>
                            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Pesanan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p><strong>No Pesanan:</strong> <span id="nomor_pesanan"></span></p>
                <p><strong>Customer:</strong> <span id="nama"></span></p>
                <p><strong>Alamat:</strong> <span id="order_alamat"></span></p>
                <hr>

                <h6>Produk:</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="order_items"></tbody>
                </table>

                <hr>

                <h6>Bukti Pembayaran:</h6>
                <div id="bukti_container">
                    <span class="text-muted">Tidak ada bukti</span>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Pesanan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="nomor_pesanan">

                <p>Status saat ini:
                    <strong id="current_status"></strong>
                </p>

                <label>Status Baru</label>
                <select class="form-select" id="new_status">
                    <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                    <option value="diproses">Diproses</option>
                    <option value="dikirim">Dikirim</option>
                </select>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="updateStatus()">Update</button>
            </div>

        </div>
    </div>
</div>
<script>
    async function viewOrder(nomor_pesanan) {
        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

            let res = await fetch(`${baseUrl}?action=get_detail&nomor_pesanan=${nomor_pesanan}`);
            let data = await res.json();

            document.getElementById('nomor_pesanan').innerText = data.nomor_pesanan;
            document.getElementById('nama').innerText = data.nama;
            document.getElementById('order_alamat').innerText = data.alamat ?? 'Belum ada alamat';

            let itemsHTML = '';
            data.items.forEach(item => {
                itemsHTML += `
                <tr>
                    <td>${item.nama_produk}</td>
                    <td>${item.kuantitas}</td>
                    <td>Rp ${parseInt(item.harga).toLocaleString()}</td>
                </tr>
            `;
            });

            document.getElementById('order_items').innerHTML = itemsHTML;

            let buktiHTML = '';

            if (data.bukti_bayar) {
                buktiHTML = `
                <img src="../assets/images/bukti/${data.bukti_bayar}" 
                     class="img-fluid rounded shadow"
                     style="max-height:300px; cursor:pointer;"
                     onclick="window.open(this.src)">
            `;
            } else {
                buktiHTML = `<span class="text-muted">Belum upload bukti</span>`;
            }

            document.getElementById('bukti_container').innerHTML = buktiHTML;

            new bootstrap.Modal(document.getElementById('orderModal')).show();

        } catch (err) {
            console.error(err);
        }
    }
</script>
<script>
    async function printInvoice(nomor_pesanan) {
        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

            let res = await fetch(`${baseUrl}?action=get_detail&nomor_pesanan=${nomor_pesanan}`);
            let data = await res.json();

            let itemsHTML = '';
            let total = 0;

            data.items.forEach(item => {
                let subtotal = item.kuantitas * item.harga;
                total += subtotal;

                itemsHTML += `
                <tr>
                    <td>${item.nama_produk}</td>
                    <td>${item.kuantitas}</td>
                    <td>Rp ${parseInt(item.harga).toLocaleString()}</td>
                    <td>Rp ${parseInt(subtotal).toLocaleString()}</td>
                </tr>
            `;
            });

            let html = `
        <html>
        <head>
            <title>Invoice ${data.nomor_pesanan}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 30px;
                    color: #333;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 30px;
                }
                .title {
                    font-size: 24px;
                    font-weight: bold;
                }
                .box {
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background: #f5f5f5;
                }
                .text-end {
                    text-align: right;
                }
                .total {
                    font-size: 18px;
                    font-weight: bold;
                }
                .footer {
                    margin-top: 40px;
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                }
                @media print {
                    button { display: none; }
                }
            </style>
        </head>

        <body>

            <div class="header">
                <div>
                    <div class="title">INVOICE</div>
                    <div>No: ${data.nomor_pesanan}</div>
                    <div>Tanggal: ${data.tanggal_order}</div>
                </div>
                <div>
                    <strong>Smart Greenhouse</strong><br>
                    Agrinexa Store
                </div>
            </div>

            <div class="box">
                <strong>Dikirim ke:</strong><br>
                ${data.nama}<br>
                ${data.nomor_telepon}<br>
                ${data.alamat ?? '-'}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHTML}
                </tbody>
            </table>

            <table style="margin-top:20px;">
                <tr>
                    <td class="text-end total">Total</td>
                    <td class="text-end total">Rp ${total.toLocaleString()}</td>
                </tr>
            </table>

            <div class="footer">
                Terima kasih telah berbelanja 🌱
            </div>

            <script>
                window.print();
                window.onafterprint = () => window.close();
            <\/script>

        </body>
        </html>
        `;

            let printWindow = window.open('', '', 'width=900,height=700');
            printWindow.document.write(html);
            printWindow.document.close();

        } catch (error) {
            console.error("Error:", error);
        }
    }
</script>
<script>
function openStatusModal(nomor_pesanan, status) {
    document.getElementById('nomor_pesanan').value = nomor_pesanan;
    document.getElementById('current_status').innerText = status;
    document.getElementById('new_status').value = status;

    new bootstrap.Modal(document.getElementById('statusModal')).show();
}
</script>
<script>
async function updateStatus() {
    let nomor_pesanan = document.getElementById('nomor_pesanan').value;
    let status = document.getElementById('new_status').value;

    try {
        const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

        let response = await fetch(`${baseUrl}?action=update_status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `nomor_pesanan=${nomor_pesanan}&status=${status}`
        });

        let result = await response.json();

        if (result.status) {
            alert("Status berhasil diupdate!");
            location.reload();
        } else {
            alert("Gagal update!");
        }

    } catch (error) {
        console.error(error);
    }
}
</script>