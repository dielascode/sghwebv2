<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/pengaduanApi.php";


$db = new Database();
$conn = $db->getConnection();
$pengaduan = new Pengaduan($conn);

$result = $pengaduan->getPengaduan();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>

<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Data Pengaduan</h1>
            <p class="text-muted mb-0">Respon pengaduan dari costumer anda</p>
        </div>
    </div>

    <!-- Order Management Container -->
    <div>

        <!-- Orders Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tabel Pengaduan</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Costumer</th>
                                <th>Subjek</th>
                                <th>Pesan</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                    <th style="width: 120px;">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($result as $pg): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $pg['nama'] ?></td>
                                    <td><?= $pg['subjek'] ?></td>
                                    <td><?= strlen($pg['pesan']) > 20
                                            ? substr($pg['pesan'], 0, 20) . '...'
                                            : $pg['pesan']; ?></td>
                                    <td><?= $pg['status_pengaduan'] ?></td>
                                    <td><?= $pg['tanggal_masuk'] ?></td>

                                    <td style="display: flex; gap: 10px;">
                                        <button
                                            class="btn btn-sm btn-primary"
                                            onclick="openDetail(<?= $pg['id']; ?>)">
                                            Detail
                                        </button>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                            <?php
                                            $nextStatus = '';
                                            $label = '';

                                            if ($pg['status'] === 'diterima') {
                                                $nextStatus = 'diproses';
                                                $label = 'Proses';
                                            } elseif ($pg['status'] === 'diproses') {
                                                $nextStatus = 'selesai';
                                                $label = 'Selesaikan';
                                            }
                                            ?>

                                            <?php if ($pg['status'] !== 'selesai'): ?>
                                                <button
                                                    class="btn btn-sm btn-warning"
                                                    onclick="ubahStatus('<?= $pg['id']; ?>', '<?= $nextStatus; ?>')">
                                                    <?= $label; ?>
                                                </button>
                                            <?php endif; ?>


                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- End Order Management Container -->

</div>

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Subjek: <span id="detailSubjek"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="200">Nama Costumer</th>
                        <td>: <span id="detailNama"></span></td>
                    </tr>

                    <tr>
                        <th width="200">Tanggal Pelaporan</th>
                        <td>: <span id="detailTanggal"></span></td>
                    </tr>
                    <tr>
                        <th width="200">Status Pelaporan</th>
                        <td>: <span class="badge bg-info" id="detailStatus"></span></td>
                    </tr>
                </table>

                <h6>Pesan:</h6>
                <p id="detailPesan" class="text-muted small" style="
                    
                        max-height: 120px;
                        overflow-y: auto;
                        word-break: break-all;
                    ">
                </p>

            </div>

        </div>
    </div>
</div>

<script>
    async function openDetail(id) {
        try {
            const response = await fetch(`crud/pengaduanController.php?action=get_detail&id=${id}`);
            const data = await response.json();

            document.getElementById('detailSubjek').innerText = data.subjek;
            document.getElementById('detailNama').innerText = data.nama;
            document.getElementById('detailTanggal').innerText = data.tanggal_masuk;
            document.getElementById('detailStatus').innerText = data.status_pengaduan;
            document.getElementById('detailPesan').innerText = data.pesan || 'Tidak ada deskripsi';

            let modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();

        } catch (error) {
            console.error("Gagal ambil detail:", error);
            alert("Gagal mengambil data produk");
        }
    }
</script>
<script>
    async function ubahStatus(id, statusBaru) {

        let konfirmasi = confirm(`Yakin ingin mengubah status menjadi "${statusBaru}"?`);

        if (!konfirmasi) return;

        try {
            const baseUrl = window.location.origin + 'crud/pengaduanController.php';

            let res = await fetch(`crud/pengaduanController.php?action=update_status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&status=${statusBaru}`
            });

            let result = await res.json();

            if (result.status) {
                alert("Status berhasil diubah!");
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