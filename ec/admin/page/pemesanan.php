<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/pesananApi.php";


$db = new Database();
$conn = $db->getConnection();
$pesanan = new Pesanan($conn);

$result = $pesanan->getPesanan();
$total_order = $pesanan->getTotalOrdersStats();
$total_order_waiting = $pesanan->getTotalOrdersWaitingStats();
$total_order_process = $pesanan->getTotalOrdersProcessStats();
$total_order_send = $pesanan->getTotalOrdersSendStats();
$total_order_done = $pesanan->getTotalOrdersDoneStats();
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
            <button type="button" class="btn btn-outline-secondary" onclick="exportOrders()">
                <i class="bi bi-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Order Management Container -->
    <div>

        <!-- Order Stats Widgets -->
        <div class="row g-3 g-lg-4 mb-5 row-cols-1 row-cols-md-3 row-cols-xl-5">
            <!-- Total Pesanan -->
            <div class="col filter-card" onclick="filterOrder('all')" style="cursor:pointer;">
                <div class="card stats-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted small">Total Pesanan</h6>
                                <h3 class="mb-0 fs-4"><?= $total_order['total_order'] ?></h3>
                                <small class="text-success" style="font-size: 0.75rem;">
                                    <i class="bi bi-arrow-up"></i> +12%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menunggu Konfirmasi -->
            <div class="col filter-card" onclick="filterOrder('menunggu_konfirmasi')" style="cursor:pointer;">
                <div class="card stats-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted small">Konfirmasi</h6>
                                <h3 class="mb-0 fs-4"><?= $total_order_waiting['total_order_waiting'] ?></h3>
                                <small class="text-warning" style="font-size: 0.75rem;">
                                    <i class="bi bi-exclamation-circle"></i> Pending
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diproses -->
            <div class="col filter-card" onclick="filterOrder('diproses')" style="cursor:pointer;">
                <div class="card stats-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted small">Diproses</h6>
                                <h3 class="mb-0 fs-4"><?= $total_order_process['total_order_process'] ?></h3>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-arrow-repeat"></i> In progress
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dikirim -->
            <div class="col filter-card" onclick="filterOrder('dikirim')" style="cursor:pointer;">
                <div class="card stats-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted small">Dikirim</h6>
                                <h3 class="mb-0 fs-4"><?= $total_order_send['total_order_send'] ?></h3>
                                <small class="text-info" style="font-size: 0.75rem;">
                                    <i class="bi bi-arrow-right"></i> Transit
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col filter-card" onclick="filterOrder('selesai')" style="cursor:pointer;">
                <div class="card stats-card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted small">Selesai</h6>
                                <h3 class="mb-0 fs-4"><?= $total_order_done['total_order_done'] ?></h3>
                                <small class="text-success" style="font-size: 0.75rem;">
                                    <i class="bi bi-arrow-up"></i> +8%
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
                                    id="searchInput"
                                    class="form-control form-control-sm"
                                    placeholder="Search orders..."
                                    style="width: 200px;">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                            </div>

                            <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="menunggu_konfirmasi">Menunggu</option>
                                <option value="diproses">Diproses</option>
                                <option value="dikirim">Dikirim</option>
                                <option value="selesai">Selesai</option>
                            </select>

                            <select id="dateFilter" class="form-select form-select-sm" style="width: 150px;">
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
                                <tr data-status="<?= $p['status_pesanan'] ?>" data-date="<?= $p['tanggal_order'] ?>">
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
                                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin" && $p['status_pesanan'] !== 'dikirim' && $p['status_pesanan'] !== 'dibatalkan'): ?>
                                                    <li><a class="dropdown-item" href="#" onclick="openStatusModal('<?= $p['nomor_pesanan']; ?>', '<?= $p['status_pesanan']; ?>')">
                                                            <i class="bi bi-truck me-2"></i>Ubah Status
                                                        </a></li>
                                                <?php endif; ?>
                                                <?php if ($p['status_pesanan'] !== 'menunggu_konfirmasi'): ?>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="printInvoice('<?= $p['nomor_pesanan']; ?>')">
                                                            <i class="bi bi-printer me-2"></i>Cetak Struk
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin" && $p['status_pesanan'] === 'menunggu_konfirmasi'): ?>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="cancelOrder('<?= $p['nomor_pesanan']; ?>')">
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
                        Showing <span id="startItem"></span> to
                        <span id="endItem"></span> of
                        <span id="totalItem"></span> results
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="pagination">
                            <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <template>
                                <li class="page-item" :class="{ 'active': page === currentPage }">
                                    <a class="page-link" href="#" x-text="page"></a>
                                </li>
                            </template>
                            <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                                <a class="page-link" href="#">Next</a>
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
    document.querySelectorAll('.filter-card').forEach(card => {
        card.classList.remove('active');
    });
    event.currentTarget.classList.add('active');

    function filterOrder(status) {
        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            let rowStatus = row.getAttribute("data-status");

            if (status === 'all') {
                row.style.display = '';
            } else if (rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
<script>
    const rows = Array.from(document.querySelectorAll("tbody tr"));

    let currentPage = 1;
    let itemsPerPage = 5;
    let filteredRows = [...rows];

    document.getElementById('searchInput').addEventListener('input', applyFilter);
    document.getElementById('statusFilter').addEventListener('change', applyFilter);
    document.getElementById('dateFilter').addEventListener('change', applyFilter);

    function applyFilter() {
        let keyword = document.getElementById('searchInput').value.toLowerCase();
        let status = document.getElementById('statusFilter').value;
        let date = document.getElementById('dateFilter').value;

        filteredRows = rows.filter(row => {
            let text = row.innerText.toLowerCase();
            let rowStatus = row.dataset.status;
            let rowDate = new Date(row.dataset.date);

            let match = true;

            if (!text.includes(keyword)) match = false;

            if (status && rowStatus !== status) match = false;

            if (date) {
                let now = new Date();

                if (date === 'today') {
                    if (rowDate.toDateString() !== now.toDateString()) match = false;
                }

                if (date === 'week') {
                    let weekAgo = new Date();
                    weekAgo.setDate(now.getDate() - 7);
                    if (rowDate < weekAgo) match = false;
                }

                if (date === 'month') {
                    let monthAgo = new Date();
                    monthAgo.setMonth(now.getMonth() - 1);
                    if (rowDate < monthAgo) match = false;
                }
            }

            return match;
        });

        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        let start = (currentPage - 1) * itemsPerPage;
        let end = start + itemsPerPage;

        rows.forEach(row => row.style.display = 'none');

        filteredRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        renderPagination();
        updateInfo();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        const pagination = document.getElementById('pagination');

        pagination.innerHTML = '';

        pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
        </li>
    `;

        for (let i = 1; i <= totalPages; i++) {
            pagination.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
            </li>
        `;
        }

        pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
        </li>
    `;
    }

    function goPage(page) {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

        if (page < 1 || page > totalPages) return;

        currentPage = page;
        renderTable();
    }

    function updateInfo() {
        let start = (currentPage - 1) * itemsPerPage + 1;
        let end = Math.min(currentPage * itemsPerPage, filteredRows.length);

        document.getElementById('startItem').innerText = filteredRows.length ? start : 0;
        document.getElementById('endItem').innerText = end;
        document.getElementById('totalItem').innerText = filteredRows.length;
    }
    renderTable();
</script>
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

    async function cancelOrder(nomor_pesanan) {

        const confirmText =
            "Yakin mau merubah status pesanan menjadi dibatalkan?";

        if (!confirm(confirmText)) return;

        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

            let res = await fetch(`${baseUrl}?action=cancel_status&nomor_pesanan=${nomor_pesanan}`);

            let result = await res.json();

            if (result.status) {
                alert(result.message);
                location.reload();
            } else {
                alert("Gagal: " + result.message);
            }

        } catch (err) {
            console.error(err);
            alert("Terjadi error");
        }
    }
</script>
<script>
    async function exportOrders() {
        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/pesananController.php';

            let res = await fetch(`${baseUrl}?action=get_all_detail`);
            let orders = await res.json();

            let html = `
        <div style="font-family: Arial; padding:20px;">
            <h2 style="text-align:center;">LAPORAN PESANAN</h2>
            <hr>
        `;

            orders.forEach(order => {

                html += `
            <div style="margin-bottom:20px;">
                <strong>No:</strong> ${order.nomor_pesanan}<br>
                <strong>Customer:</strong> ${order.nama}<br>
                <strong>Tanggal:</strong> ${order.tanggal_order}<br>
                <strong>Status:</strong> ${order.status}<br>

                <table border="1" cellspacing="0" cellpadding="5" width="100%" style="margin-top:10px;">
                    <thead>
                        <tr style="background:#f2f2f2;">
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                let total = 0;

                order.items.forEach(item => {
                    let subtotal = item.kuantitas * item.harga;
                    total += subtotal;

                    html += `
                    <tr>
                        <td>${item.nama_produk}</td>
                        <td>${item.kuantitas}</td>
                        <td>Rp ${parseInt(item.harga).toLocaleString()}</td>
                        <td>Rp ${parseInt(subtotal).toLocaleString()}</td>
                    </tr>
                `;
                });

                html += `
                    </tbody>
                </table>

                <div style="text-align:right; margin-top:5px;">
                    <strong>Total: Rp ${total.toLocaleString()}</strong>
                </div>
            </div>
            `;
            });

            html += `</div>`;

            let element = document.createElement('div');
            element.innerHTML = html;

            html2pdf()
                .from(element)
                .set({
                    margin: 10,
                    filename: 'laporan_pesanan.pdf',
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                })
                .save();

        } catch (error) {
            console.error("Error export:", error);
        }
    }
</script>