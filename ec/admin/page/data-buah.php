<?php
// include __DIR__ . "/../../logic/admin/buahController.php";
// $buah = getBuah($conn); 
?>
<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/buahApi.php";


$db = new Database();
$conn = $db->getConnection();
$buah = new Buah($conn);

$result = $buah->getBuah();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>
<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Manajemen Buah</h1>
            <p class="text-muted mb-0">Kelola jenis buah anda disini</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Buah
            </button>
        </div>
    </div>

    <!-- Product Management Container -->
    <div>

        <!-- Products Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tabel Buah</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Buah</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($result as $b): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= $b['nama_buah']; ?></td>

                                    <td style="display: flex; gap: 10px;">
                                        <!-- tombol edit -->
                                        <button
                                            class="btn btn-sm btn-warning"
                                            onclick="openEditModal(<?= $b['id']; ?>, '<?= $b['nama_buah']; ?>')">
                                            Edit
                                        </button>

                                        <!-- tombol delete -->
                                        <button
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteBuah(<?= $b['id']; ?>)">
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
                <h5 class="modal-title">Tambah Buah Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahBuah">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Buah</label>
                            <input type="text" class="form-control" name="nama_buah" id="nama_buah" required>
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

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Buah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formEditBuah">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label>Nama Buah</label>
                        <input type="text" name="nama_buah" id="edit_nama" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, nama_buah) {
        console.log(id, nama_buah); //mmastikan
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama_buah;

        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    }
</script>
<script>
    //ini buat ngirim data dari form ke itu dh pokoknya
    document.getElementById('formTambahBuah').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('../../../../sghwebv2/ec/admin/crud/buahController.php?action=tambah', {
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
    document.getElementById('formEditBuah').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('../../../../sghwebv2/ec/admin/crud/buahController.php?action=update', {
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
    async function deleteBuah(id) {
        if (!confirm('Yakin mau hapus data buah ini?')) return;

        try {
            const formData = new FormData();
            formData.append('id', id);

            const response = await fetch('../../../../sghwebv2/ec/admin/crud/buahController.php?action=delete', {
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