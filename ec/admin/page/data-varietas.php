<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/varietasApi.php";


$db = new Database();
$conn = $db->getConnection();
$varietas = new Varietas($conn);

$result = $varietas->getVarietas();
$buah_result = $varietas->getBuah();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>
<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Manajemen Varietas</h1>
            <p class="text-muted mb-0">Kelola varietas anda disini</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Varietas
            </button>
        </div>
    </div>

    <!-- Product Management Container -->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tabel Varietas</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Varietas</th>
                                <th>Buah</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($result as $v): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= $v['nama_varietas']; ?></td>

                                    <td>
                                        <span class="badge bg-success">
                                            <?= $v['nama_buah']; ?>
                                        </span>
                                    </td>

                                    <td style="display: flex; gap: 10px;">
                                        <!-- tombol edit -->
                                        <button
                                            class="btn btn-sm btn-warning"
                                            onclick="openEditModal(<?= $v['id']; ?>, '<?= $v['nama_varietas']; ?>', <?= $v['id_buah']; ?>)">
                                            Edit
                                        </button>

                                        <!-- tombol delete -->
                                        <button
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteVarietas(<?= $v['id']; ?>)">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- End Product Management Container -->

</div>
<!-- Product Modal (Add/Edit) -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Varietas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahVarietas">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Varietas</label>
                            <input type="text" class="form-control" name="nama_varietas" id="nama_varietas" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Buah</label>
                            <select class="form-select" name="id_buah" id="id_buah" required>
                                <option value="">Pilih jenis buah</option>

                                <?php foreach ($buah_result as $b): ?>
                                    <option value="<?= $b['id']; ?>">
                                        <?= $b['nama_buah']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Varietas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formEditVarietas">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label>Nama Varietas</label>
                        <input type="text" id="edit_nama" name="nama_varietas" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Jenis Buah</label>
                        <select id="edit_buah" name="id_buah" class="form-select">
                            <?php foreach ($buah_result as $b): ?>
                                <option value="<?= $b['id']; ?>">
                                    <?= $b['nama_buah']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ini buat nampilin modal edit yh -->
<script>
    function openEditModal(id, nama, id_buah) {
        console.log(id, id_buah, nama); //mmastikan
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_buah').value = id_buah;

        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    }
</script>
<!-- bagian dibawah ini proses crudnya yh, kcali read nya -->
<script>
    //ini buat ngirim data dari form ke itu dh pokoknya
    document.getElementById('formTambahVarietas').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('../../../../sghwebv2/ec/admin/crud/varietasController.php?action=tambah', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log("respon:", text);
                try {
                    const data = JSON.parse(text);
                    if (data.status) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Gagal: " + data.message);
                    }
                } catch (err) {
                    console.error("Gagal Parse JSON. Teks yang diterima:", text);
                    alert("Server tidak mengirim JSON. Cek console!");
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // yg ini ngedit yhh
    document.getElementById('formEditVarietas').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('../../../../sghwebv2/ec/admin/crud/varietasController.php?action=update', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            console.log("respon:", text);

            const data = JSON.parse(text);

            if (data.status) {
                alert(data.message);
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
            }

        } catch (err) {
            console.error("Error Detail:", err);
            alert('Terjadi kesalahan sistem!');
        }
    });

    //ini ngedelet
    async function deleteVarietas(id) {
        if (!confirm('Yakin mau hapus data buah ini?')) return;

        try {
            const formData = new FormData();
            formData.append('id', id);

            const response = await fetch('../../../../sghwebv2/ec/admin/crud/varietasController.php?action=delete', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            console.log("Respon Hapus:", text);

            const data = JSON.parse(text);

            if (data.status) {
                alert(data.message);
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
            }

        } catch (error) {
            console.error("Error Detail:", error);
            alert('Terjadi kesalahan pada server!');
        }
    }
</script>