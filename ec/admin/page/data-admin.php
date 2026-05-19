<?php
include __DIR__ . "/../../config/connection.php"; //conection
include __DIR__ . "/../../logic/admin/adminApi.php"; //apinya


$db = new Database(); //reate oblej dari class database
$conn = $db->getConnection(); //trus ambil koneksi
$admin = new Admin($conn); //create objek admin
$result = $admin->getAdmin(); //manggil function ngambil data
if (!$result) {
    die("ERROR: " . $conn->error); //kalo ga ada eror
}
?>

<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Data Admin</h1>
            <p class="text-muted mb-0">Manajemen pengelola anda</p>
        </div>
        <div class="d-flex gap-4">
            <!-- kalo sesionya superadmin tombolnya ga tampil -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "superadmin"): ?> 
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Admin
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Order Management Container -->
    <div>
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">Tabel Admin</h5>
            </div>

            <!-- Orders Table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- isisiani no 1 -->
                            <?php $no = 1; ?> 
                            <!-- di forearch di ulang ulang alias a -->
                            <?php foreach ($result as $a): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= $a['nama']; ?></td>
                                    <td><?= $a['email']; ?></td>
                                    <td><?= $a['username']; ?></td>
                                    <td><span class="badge badge-primary"><?= $a['role']; ?></span></td>

                                    <td>
                                        <?php if ($a['status'] === 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>

                                    <td style="display: flex; gap: 10px;">
                                        <button
                                            class="btn btn-sm btn-primary"
                                            onclick="openEditModal(<?= $a['id']; ?>, '')"> 
                                            <!-- pake js -->
                                            Lihat Detail
                                        </button>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "superadmin"): ?>
                                            <!-- pake js ngirim parameter ke jsnya -->
                                            <button
                                                class="btn btn-sm btn-warning"
                                                onclick="openEditModal(
                                                    '<?= $a['id']; ?>',
                                                    '<?= $a['nama']; ?>',
                                                    '<?= $a['username']; ?>',
                                                    '<?= $a['email']; ?>',
                                                    '<?= $a['nomor_telepon']; ?>'
                                                )">
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="toggleStatus('<?= $a['id']; ?>', '<?= $a['status']; ?>')">
                                                <?= $a['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'; ?>
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

    </div> <!-- End Order Management Container -->

</div>


<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahAdmin">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="nomor_telepon" id="nomor_telepon" required>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditAdmin">
                    <div class="row g-3 mb-3">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="edit_nama" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="edit_username" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="edit_password">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="nomor_telepon" id="edit_nomor_telepon" required>
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

<script>
    function openEditModal(id, nama, username, email, nomor_telepon) { 
        // fungsi edit modal
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_nomor_telepon').value = nomor_telepon; //nempatin vlue

        document.getElementById('edit_password').value = '';

        const modal = new bootstrap.Modal(document.getElementById('editModal')); //nembuka (menampilkan) modal dengan ID editModal
        modal.show();
    }

    async function toggleStatus(id, currentStatus) {

        const confirmText = currentStatus === 'aktif' ?
            "Yakin mau nonaktifkan admin ini?" :
            "Yakin mau aktifkan admin ini?";

        if (!confirm(confirmText)) return;

        try {
            const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/adminController.php'; //ke controller

            let res = await fetch(`${baseUrl}?action=toggle_status&id=${id}&status=${currentStatus}`); //ke action di controller

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
    document.getElementById('formTambahAdmin').addEventListener('submit', function(e) {
        e.preventDefault(); //ngambil form, klik submit scriptnya jalan

        const formData = new FormData(this); //ngambil yang diinputkan

        fetch('../../../../sghwebv2/ec/admin/crud/adminController.php?action=tambah', { //request server ke controller
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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('formEditAdmin').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('../../../../sghwebv2/ec/admin/crud/adminController.php?action=update', {
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
                        console.error("Gagal Parse JSON:", text);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

    });
</script>