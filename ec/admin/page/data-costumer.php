<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/costumerApi.php";


$db = new Database();
$conn = $db->getConnection();
$costumer = new Costumer($conn);
$stats = $costumer->getCustomerStats();
$userBaru = $costumer->getTotalUserBaruBulanIni();
$result = $costumer->getCustomers();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>

<div class="container-fluid p-4 p-lg-5">
    <!-- Order Management Container -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5 mb-xl-6">
        <div>
            <h1 class="h3 mb-0">Manajemen Costumer</h1>
            <p class="text-muted mb-0">Kelola costumer anda disini</p>
        </div>
        <div class="d-flex gap-2">
            <!-- <button type="button" id="btnExportPDF" class="btn btn-outline-secondary">
                <i class="bi bi-download me-2"></i>Export
            </button> -->
        </div>
    </div>

    <!-- Users Management Container -->
    <div>

        <!-- User Stats Widgets -->
        <div class="row g-4 g-lg-5 g-xl-6 mb-5 mb-lg-5 mb-xl-6">
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Users</h6>
                                <h3 class="mb-0"><?= $stats['total_pelanggan'] ?></h3>
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
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Active Users</h6>
                                <h3 class="mb-0"><?= $stats['total_aktif'] ?></h3>
                                <!-- <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +8% from last week
                                </small> -->
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
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">New This Month</h6>
                                <h3 class="mb-0"><?= $userBaru ?></h3>
                                <!-- <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +15% growth
                                </small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Users Table -->

        <!-- Products Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tabel Costumer</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelUser" class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <!-- <th>Nomor Telepon</th> di taruh di detail
                                <th>Jenis Kelamin</th>
                                <th>Foto Profil</th> -->
                                <th>Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($result as $c): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= $c['nama']; ?></td>
                                    <td><?= $c['email']; ?></td>
                                    <td><?= $c['username']; ?></td>
                                    <td><span class="badge badge-primary"><?= $c['role']; ?></span></td>

                                    <td>
                                        <?php if ($c['status'] === 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td style="display: flex; gap: 10px;">
                                        <button
                                            class="btn btn-sm btn-primary"
                                            onclick="openDetail('<?= $c['id']; ?>')">
                                            Lihat Detail
                                        </button>

                                        <?php if ($_SESSION['role'] === "admin" && $c['status'] === 'aktif'): ?>
                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="nonaktifkanCustomer('<?= $c['id']; ?>')">
                                                Nonaktifkan
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- End Users Management Container -->

</div>
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Customer</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><b>Nama:</b> <span id="d_nama"></span></p>
                <p><b>Email:</b> <span id="d_email"></span></p>
                <p><b>Username:</b> <span id="d_username"></span></p>
                <p><b>No HP:</b> <span id="d_hp"></span></p>
                <p><b>Status:</b> <span id="d_status"></span></p>
                <p><b>Tanggal Daftar:</b> <span id="d_tanggal"></span></p>
            </div>
        </div>
    </div>
</div>
<script>
    const BASE = window.location.origin;
async function openDetail(id) {
    try {
        const res = await fetch(`crud/costumerController.php?action=detail&id=${id}`);
        const data = await res.json();

        document.getElementById('d_nama').innerText = data.nama;
        document.getElementById('d_email').innerText = data.email;
        document.getElementById('d_username').innerText = data.username;
        document.getElementById('d_hp').innerText = data.nomor_telepon;
        document.getElementById('d_status').innerText = data.status;
        document.getElementById('d_tanggal').innerText = data.tanggal_daftar;

        new bootstrap.Modal(document.getElementById('detailModal')).show();

    } catch (err) {
        console.error(err);
        alert("Gagal ambil data");
    }
}

// NONAKTIFKAN
async function nonaktifkanCustomer(id) {

    let konfirmasi = confirm("Yakin mau nonaktifkan customer ini?");
    if (!konfirmasi) return;

    try {
        const res = await fetch(`crud/costumerController.php?action=nonaktifkan`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}`
        });

        const result = await res.json();

        if (result.status) {
            alert("Berhasil dinonaktifkan!");
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
    document.getElementById('btnExportPDF').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        doc.text("Laporan Data Pelanggan AgriNexa", 14, 15);
        doc.setFontSize(10);
        doc.text("Dicetak pada: " + new Date().toLocaleString(), 14, 22);

        doc.autoTable({
            html: '#tabelUser',
            startY: 30,
            theme: 'grid',
            headStyles: {
                fillColor: [40, 167, 69]
            },
        });

        doc.save('Laporan_Pelanggan_AgriNexa.pdf');
    });
</script>