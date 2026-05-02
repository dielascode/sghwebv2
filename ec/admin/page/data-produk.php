<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/produkApi.php";


$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);

$result = $produk->getProduk();
$buah = $produk->getBuah();
$varietas = $produk->getVarietas();
if (!$result) {
    die("ERROR: " . $conn->error);
}
?>
<div class="container-fluid p-4 p-lg-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 mb-lg-5">
        <div>
            <h1 class="h3 mb-0">Manajemen Produk</h1>
            <p class="text-muted mb-0">Kelola manajemen produk dan inventoris</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" @click="exportProducts()">
                <i class="bi bi-download me-2"></i>Export
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                <i class="bi bi-plus-lg me-2"></i>Add Product
            </button>
        </div>
    </div>

    <!-- Product Management Container -->
    <div>

        <!-- Product Stats Widgets -->
        <div class="row g-4 g-lg-5 mb-5">
            <div class="col-xl-3 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-box"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Products</h6>
                                <h3 class="mb-0" x-text="stats.total"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +5% from last month
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
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">In Stock</h6>
                                <h3 class="mb-0" x-text="stats.inStock"></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> Well stocked
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
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Low Stock</h6>
                                <h3 class="mb-0" x-text="stats.lowStock"></h3>
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
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Value</h6>
                                <h3 class="mb-0" x-text="`$${stats.totalValue.toLocaleString()}`"></h3>
                                <small class="text-info">
                                    <i class="bi bi-info-circle"></i> Inventory value
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                <th>Nama Produk</th>
                                <th>Tipe Produk</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($result as $b): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= $b['nama_produk']; ?></td>
                                    <td><?= $b['tipe']; ?></td>
                                    <td><?= $b['deskripsi']; ?></td>
                                    <td><?= $b['stok']; ?></td>
                                    <td><?= $b['harga']; ?></td>

                                    <td style="display: flex; gap: 10px;">
                                        
                                        <button
                                            class="btn btn-sm btn-warning"
                                            onclick="openEditModal(<?= $b['id']; ?>, '<?= $b['nama_buah']; ?>')">
                                            Edit
                                        </button>

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
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form x-data="productForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tipe Produk</label>
                            <select class="form-select" name="tipe" id="tipe" required>
                                <option value="">Pilih Tipe Produk</option>
                                <option value="satuan">Satuan</option>
                                <option value="bundling">Bundling</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Buah</label>
                            <select class="form-select" name="id_buah" id="id_buah" required>
                                <option value="">Pilih jenis buah</option>

                                <?php foreach ($buah as $b): ?>
                                    <option value="<?= $b['id']; ?>">
                                        <?= $b['nama_buah']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Varietas</label>
                            <select class="form-select" name="id_varietas" id="id_buah" required>
                                <option value="">Pilih Varietas</option>

                                <?php foreach ($varietas as $b): ?>
                                    <option value="<?= $b['id']; ?>">
                                        <?= $b['nama_varietas']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" x-model="form.stock" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi"></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Product Image</label>
                            <input type="file" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" @click="saveProduct()">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Upload CSV File</label>
                    <input type="file" class="form-control" accept=".csv">
                    <div class="form-text">Upload a CSV file with columns: name, sku, category, price, stock, status</div>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>CSV Format:</strong> name, sku, category, price, stock, status<br>
                    <small>Example: iPhone 14, IPHONE14-128, electronics, 799.99, 50, published</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Import Products</button>
            </div>
        </div>
    </div>
</div>