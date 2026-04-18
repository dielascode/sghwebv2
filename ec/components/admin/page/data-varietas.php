<?php
include __DIR__ . "/../logic/admin/varietasController.php";
$varietas = getVarietas($conn);
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
    <div x-data="productTable" x-init="init()">

        <!-- Products Table -->
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">Tabel Varietas</h5>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            <!-- Search -->
                            <div class="position-relative">
                                <input type="search"
                                    class="form-control form-control-sm"
                                    placeholder="Search products..."
                                    x-model="searchQuery"
                                    @input="filterProducts()"
                                    style="width: 200px;">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                            </div>

                            <!-- Category Filter -->
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
                <!-- Bulk Actions Bar -->
                <div class="bulk-actions-bar p-3 bg-light border-bottom" x-show="selectedProducts.length > 0" x-transition>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <span x-text="selectedProducts.length"></span> product(s) selected
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" @click="bulkAction('publish')">
                                <i class="bi bi-eye me-1"></i>Publish
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" @click="bulkAction('unpublish')">
                                <i class="bi bi-eye-slash me-1"></i>Unpublish
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Varietas</th>
                                <th @click="sortBy('buah')" class="sortable">Buah</th>
                                <th @click="sortBy('created')" class="sortable">Created</th>
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
                                                <li><a class="dropdown-item" href="#" @click="editProduct(product)"> <i class="bi bi-pencil me-2"></i>Edit </a></li>
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

                <!-- Pagination -->
                <!-- <div class="d-flex justify-content-between align-items-center p-3">
                    <div class="text-muted">
                        Showing <span x-text="(currentPage - 1) * itemsPerPage + 1"></span> to
                        <span x-text="Math.min(currentPage * itemsPerPage, filteredProducts.length)"></span> of
                        <span x-text="filteredProducts.length"></span> results
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
                </div> -->
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

<script>
    document.getElementById('formVarietas').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('/sghwebv2/ec/components/admin/crud/tambahVarietas.php', {
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
    
    async function deleteVarietas(id) {
        if (!confirm('Yakin mau hapus data ini?')) return;

        try {
            const response = await fetch('/sghwebv2/ec/components/admin/crud/deleteVarietas.php', {
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