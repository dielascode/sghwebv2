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

                                    <td><span class="badge badge-success">Aktif</span></td>

                                    <td style="display: flex; gap: 10px;">
                                        <button
                                            class="btn btn-sm btn-primary"
                                            onclick="openEditModal(<?= $c['id']; ?>, '')">
                                            Lihat Detail
                                        </button>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteVarietas(<?= $c['id']; ?>)">
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