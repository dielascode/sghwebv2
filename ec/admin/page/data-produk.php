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
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal"
                                            @click="$dispatch('open-detail', { id: '<?= $b['id']; ?>' })">
                                            Detail
                                        </button>
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
                <!-- Alpine.js Logic -->
                <form x-data="productForm()">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" x-model="formData.nama_produk" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tipe Produk</label>
                            <!-- Saat tipe berubah, kita reset list buahnya -->
                            <select class="form-select" x-model="formData.tipe" @change="resetItems()" required>
                                <option value="satuan">Satuan</option>
                                <option value="bundling">Bundling</option>
                            </select>
                        </div>

                        <!-- Bagian Dinamis: Buah & Varietas -->
                        <div class="col-12">
                            <label class="form-label d-flex justify-content-between">
                                Komposisi Produk
                                <template x-if="formData.tipe === 'bundling'">
                                    <button type="button" class="btn btn-sm btn-success" @click="addItem()">+ Tambah Buah</button>
                                </template>
                            </label>

                            <template x-for="(item, index) in items" :key="index">
                                <div class="row g-2 mb-2 align-items-end">
                                    <div class="col-md-5">
                                        <label class="small text-muted">Buah</label>
                                        <select class="form-select" x-model="item.id_buah" required>
                                            <option value="">Pilih Buah</option>
                                            <?php foreach ($buah as $b): ?>
                                                <option value="<?= $b['id']; ?>"><?= $b['nama_buah']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="small text-muted">Varietas</label>
                                        <select class="form-select" x-model="item.id_varietas" required>
                                            <option value="">Pilih Varietas</option>
                                            <?php foreach ($varietas as $v): ?>
                                                <option value="<?= $v['id']; ?>"><?= $v['nama_varietas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2" x-show="formData.tipe === 'bundling' && items.length > 1">
                                        <button type="button" class="btn btn-outline-danger w-100" @click="removeItem(index)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" x-model="formData.harga" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" x-model="formData.stok" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" x-model="formData.deskripsi"></textarea>
                        </div>

                        <!-- Multiple Images -->
                        <div class="col-12">
                            <label class="form-label">Product Images (Bisa pilih banyak)</label>
                            <input type="file" class="form-control" @change="handleFiles" accept="image/*" multiple>
                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                <template x-for="(img, index) in imagePreviews" :key="index">
                                    <div class="position-relative">
                                        <img :src="img" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        <!-- Tombol Hapus -->
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0"
                                            style="width: 20px; height: 20px; line-height: 1;"
                                            @click="removeImage(index)">
                                            &times;
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="saveProduct">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" x-data="detailProduct" @open-detail.window="loadDetail($event.detail.id)">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk: <span x-text="data.nama_produk"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Galeri Gambar -->
                    <div class="col-md-5">
                        <div class="border rounded p-2 mb-2">
                            <template x-if="data.images && data.images.length > 0">
                                <img :src="'../assets/images/produk/' + data.images[0].gambar" class="img-fluid rounded shadow-sm">
                            </template>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <template x-for="img in data.images">
                                <img :src="'../assets/images/produk/' + img.gambar" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </template>
                        </div>
                    </div>

                    <!-- Info Produk -->
                    <div class="col-md-7">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">Tipe</th>
                                <td>: <span class="badge bg-info" x-text="data.tipe"></span></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>: <strong class="text-success">Rp <span x-text="parseInt(data.harga).toLocaleString()"></span></strong></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>: <span x-text="data.stok"></span> pcs</td>
                            </tr>
                        </table>

                        <h6>Komposisi Buah:</h6>
                        <ul class="list-group list-group-flush mb-3">
                            <template x-for="item in data.komposisi">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                                    <span x-text="item.nama_buah"></span>
                                    <span class="badge bg-secondary rounded-pill" x-text="item.nama_varietas"></span>
                                </li>
                            </template>
                        </ul>

                        <h6>Deskripsi:</h6>
                        <p class="text-muted small" x-text="data.deskripsi || 'Tidak ada deskripsi'"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function productForm() {
        return {
            formData: {
                nama_produk: '',
                tipe: 'satuan',
                harga: '',
                stok: '',
                deskripsi: ''
            },
            items: [{
                id_buah: '',
                id_varietas: ''
            }], // List komposisi buah
            images: [],
            imagePreviews: [],

            addItem() {
                this.items.push({
                    id_buah: '',
                    id_varietas: ''
                });
            },

            removeImage(index) {
                this.images.splice(index, 1);
                this.imagePreviews.splice(index, 1);
            },

            resetItems() {
                this.items = [{
                    id_buah: '',
                    id_varietas: ''
                }];
            },

            handleFiles(event) {
                const newFiles = Array.from(event.target.files);

                // Gunakan spread operator (...) untuk menggabungkan file lama dan baru
                this.images = [...this.images, ...newFiles];

                // Update preview juga agar tidak ter-replace
                const newPreviews = newFiles.map(file => URL.createObjectURL(file));
                this.imagePreviews = [...this.imagePreviews, ...newPreviews];
            },

            async saveProduct() {
                // Kita pakai FormData supaya bisa kirim File/Gambar
                let data = new FormData();

                // Masukkan data umum
                for (let key in this.formData) {
                    data.append(key, this.formData[key]);
                }

                // Masukkan list komposisi (buah & varietas) sebagai JSON string
                data.append('komposisi', JSON.stringify(this.items));

                // Masukkan file gambar
                this.images.forEach((file, index) => {
                    data.append(`images[${index}]`, file); // Memakai index agar jadi array
                });

                // Kirim ke API menggunakan fetch
                try {
                    // Gunakan path lengkap agar tidak bingung
                    const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/produkController.php';

                    let response = await fetch(`${baseUrl}?action=tambah`, {
                        method: 'POST',
                        body: data
                    });
                    let result = await response.json();

                    if (result.status) {
                        alert('Berhasil simpan!');
                        location.reload();
                    } else {
                        alert('Gagal: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('detailProduct', () => ({
            data: {},
            async loadDetail(id) {
                try {
                    let response = await fetch(`/sghwebv2/ec/admin/crud/produkController.php?action=get_detail&id=${id}`);
                    this.data = await response.json();
                } catch (error) {
                    console.error("Gagal ambil detail:", error);
                }
            }
        }));
    });
</script>