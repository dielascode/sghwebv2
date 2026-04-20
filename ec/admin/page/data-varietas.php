<?php
include __DIR__ . "/../../logic/admin/varietasController.php";
$varietas = getVarietas($conn); //ini ni tampilnya, apa ws getnya ituch
$buah = getBuah($conn);
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

        <!-- Products Table -->
        <!-- <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">Tabel Varietas</h5>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            <div class="position-relative">
                                <input type="search"
                                    class="form-control form-control-sm"
                                    placeholder="Search products..."
                                    style="width: 200px;">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                            </div>

                            <select class="form-select form-select-sm"
                                x-model="categoryFilter"
                                @change="filterProducts()"
                                style="width: 150px;">
                                <option value="">Semua Buah</option>
                                <option value="electronics">Electronics</option>
                                <option value="clothing">Clothing</option>
                                <option value="books">Books</option>
                                <option value="home">Home & Garden</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Varietas</th>
                                <th class="sortable">Buah</th>
                                <th class="sortable">Created</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($varietas as $v): ?>
                                <tr>
                                    <td>
                                        <div class="fw-medium">
                                            <?= $v['id']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">
                                            <?= $v['nama_varietas']; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <?= $v['nama_buah']; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= date('Y-m-d'); ?>
                                    </td>

                                    <td>
                                        <div class="dropdown"> <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"> <i class="bi bi-three-dots"></i> </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="openEditModal(<?= $v['id']; ?>, '<?= $v['nama_varietas']; ?>', <?= $v['id_buah']; ?>)">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item btn-outline-danger" onclick="deleteVarietas(<?= $v['id']; ?>)">
                                                        <i class="bi bi-trash me-1"></i>Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div> -->
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
                            <?php foreach ($varietas as $v): ?>
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
                <form id="formVarietas">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Varietas</label>
                            <input type="text" class="form-control" name="nama_varietas" id="nama_varietas" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Buah</label>
                            <select class="form-select" name="id_buah" id="id_buah" required>
                                <option value="">Pilih jenis buah</option>

                                <?php foreach ($buah as $b): ?>
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
                <form id="formEdit">
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label>Nama Varietas</label>
                        <input type="text" id="edit_nama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Jenis Buah</label>
                        <select id="edit_buah" class="form-select">
                            <?php foreach ($buah as $b): ?>
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
    document.getElementById('formVarietas').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('/sghwebv2/ec/admin/crud/tambahVarietas.php', { //yg ini lho
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert('Berhasil ditambahkan!');

                this.reset();

                location.reload();

            } else {
                alert('Gagal!');
            }

        } catch (error) {
            console.error(error);
            alert('Error server!');
        }
    });

    // yg ini ngedit yhh
    document.getElementById('formEdit').addEventListener('submit', async function(e) {
        e.preventDefault();

        const data = {
            id: document.getElementById('edit_id').value,
            nama: document.getElementById('edit_nama').value,
            id_buah: document.getElementById('edit_buah').value
        };

        try {
            const response = await fetch('/sghwebv2/ec/admin/crud/editVarietas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Berhasil diupdate!');
                location.reload();
            } else {
                alert('Gagal update!');
            }

        } catch (err) {
            console.error(err);
            alert('Error server!');
        }
    });

    //ini ngedelet
    async function deleteVarietas(id) {
        if (!confirm('Yakin mau hapus data ini?')) return;

        try {
            const response = await fetch('/sghwebv2/ec/admin/crud/deleteVarietas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('Berhasil dihapus!');
                location.reload();
            } else {
                alert('Gagal hapus!');
            }

        } catch (error) {
            console.error(error);
            alert('Error server!');
        }
    }
</script>