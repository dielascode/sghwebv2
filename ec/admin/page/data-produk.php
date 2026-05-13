<?php
include __DIR__ . "/../../config/connection.php";
include __DIR__ . "/../../logic/admin/produkApi.php";

$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);

$result = $produk->getProduk();
$buah = $produk->getBuah();
$varietas = $produk->getVarietas();
$total_product = $produk->getTotalProductStats();
$total_product_min = $produk->getTotalProductMinStats();
$total_product_max = $produk->getTotalProductMaxStats();
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
            <!-- <button type="button" class="btn btn-outline-secondary" @click="exportProducts()">
                <i class="bi bi-download me-2"></i>Export
            </button> -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class="bi bi-plus-lg me-2"></i>Add Product
                </button>
            <?php endif; ?>

        </div>
    </div>

    <!-- Product Management Container -->
    <div>

        <!-- Product Stats Widgets -->
        <div class="row g-4 g-lg-5 mb-5">
            <div class="col-xl-4 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-box"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Products</h6>
                                <h3 class="mb-0"><?= $total_product['total_produk']; ?></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> +5% from last month
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">In Stock</h6>
                                <h3 class="mb-0"><?= $total_product_max['total_produk_max']; ?></h3>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> Well stocked
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card stats-card">
                    <div class="card-body p-3 p-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Low Stock</h6>
                                <h3 class="mb-0"><?= $total_product_min['total_produk_min']; ?></h3>
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-circle"></i> Needs attention
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
                                    <td><?= strlen($b['deskripsi']) > 30
                                            ? substr($b['deskripsi'], 0, 30) . '...'
                                            : $b['deskripsi']; ?></td>
                                    <?php if ($b['stok'] < 10): ?>
                                        <td><span class="badge badge-danger"><?= $b['stok']; ?></span></td>
                                    <?php else: ?>
                                        <td><span class="badge badge-success"><?= $b['stok']; ?></span></td>
                                    <?php endif; ?>
                                    <td><?= $b['harga']; ?></td>
                                    <td style="display: flex; gap: 10px;">
                                        
                                        <button
                                        class="btn btn-sm btn-primary"
                                        onclick="openDetail('<?= $b['id']; ?>')">
                                        Detail
                                    </button>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "admin"): ?>
                                            <button
                                                class="btn btn-sm btn-warning"
                                                onclick="openEdit('<?= $b['id']; ?>')">
                                                <i class="bi bi-pencil mr-0"></i>
                                            </button>

                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="deleteProduk('<?= $b['id']; ?>')">
                                                <i class="bi bi-trash mr-0"></i>
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
                <form id="productForm">

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" id="nama_produk" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tipe Produk</label>
                            <select id="tipe" class="form-select" onchange="resetItems()">
                                <option value="satuan">Satuan</option>
                                <option value="bundling">Bundling</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-flex justify-content-between">
                                Komposisi Produk
                                <button
                                    type="button"
                                    class="btn btn-sm btn-success"
                                    onclick="addItem()"
                                    id="btnAddItem">
                                    + Tambah
                                </button>
                            </label>

                            <div id="itemsContainer"></div>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" id="harga" class="form-control" required>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" id="stok" class="form-control" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control"></textarea>
                        </div>

                        <!-- Upload -->
                        <div class="col-12">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" multiple onchange="handleFiles(event)">
                            <div id="previewContainer" class="mt-2 d-flex gap-2 flex-wrap"></div>
                        </div>

                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveProduct()">Save</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Produk: <span id="detailNama"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-md-5">
                        <div class="border rounded p-2 mb-2 text-center">
                            <img id="detailMainImage" class="img-fluid rounded shadow-sm">
                        </div>

                        <div id="detailThumbnails" class="d-flex gap-2 flex-wrap"></div>
                    </div>

                    <div class="col-md-7">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">Tipe</th>
                                <td>: <span class="badge bg-info" id="detailTipe"></span></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>:
                                    <strong class="text-success">
                                        Rp <span id="detailHarga"></span>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>: <span id="detailStok"></span> pcs</td>
                            </tr>
                        </table>

                        <h6>Komposisi Buah:</h6>
                        <ul id="detailKomposisi" class="list-group list-group-flush mb-3"></ul>

                        <h6>Deskripsi:</h6>
                        <p id="detailDeskripsi" class="text-muted small" style="
                            max-height: 120px;
                            overflow-y: auto;
                            word-break: break-all;
                        ">
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let items = [{
        id_buah: '',
        id_varietas: ''
    }];
    let images = [];
    let oldImages = [];
    let editId = null;

    const semuaVarietas = <?= json_encode($varietas); ?>;
    console.log(semuaVarietas);

    async function deleteProduk(id) {
        if (!confirm("Yakin mau hapus produk ini?")) return;

        const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/produkController.php';

        let res = await fetch(`${baseUrl}?action=delete&id=${id}`);
        let result = await res.json();

        if (result.status) {
            alert("Berhasil dihapus!");
            location.reload();
        } else {
            alert("Gagal: " + result.message);
        }
    }

    async function openEdit(id) {
        editId = id;

        const res = await fetch(`/sghwebv2/ec/admin/crud/produkController.php?action=get_detail&id=${id}`);
        const data = await res.json();

        document.getElementById('nama_produk').value = data.nama_produk;
        document.getElementById('tipe').value = data.tipe;
        document.getElementById('harga').value = data.harga;
        document.getElementById('stok').value = data.stok;
        document.getElementById('deskripsi').value = data.deskripsi;

        items = data.komposisi.map(item => ({
            id_buah: item.id_buah,
            id_varietas: item.id_varietas
        }));

        oldImages = data.images || [];
        images = [];

        renderItems();
        renderImages();

        new bootstrap.Modal(document.getElementById('productModal')).show();
    }

    function renderItems() {
        const container = document.getElementById('itemsContainer');
        const tipe = document.getElementById('tipe').value;
        container.innerHTML = '';

        items.forEach((item, index) => {
            container.innerHTML += `
            <div class="row g-2 mb-2">

                <div class="col-md-5">
                    <select class="form-select" 
                        onchange="updateItem(${index}, 'buah', this.value)">
                        <option value="">Pilih Buah</option>
                        <?php foreach ($buah as $b): ?>
                            <option value="<?= $b['id']; ?>" 
                                ${item.id_buah == "<?= $b['id']; ?>" ? 'selected' : ''}>
                                <?= $b['nama_buah']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-5">
                    <select class="form-select" 
                        id="varietas-${index}"
                        onchange="updateItem(${index}, 'varietas', this.value)">
                        <option value="">Pilih Varietas</option>
                    </select>
                </div>

                <div class="col-md-2">
                    ${(items.length > 1 && tipe === 'bundling') 
                        ? `<button class="btn btn-danger w-100" onclick="removeItem(${index})">Hapus</button>` 
                        : ''}
                </div>

            </div>
            `;

            if (item.id_buah) {
                loadVarietas(index, item.id_buah, item.id_varietas);
            }
        });
    }

    function updateItem(index, field, value) {
        if (field === 'buah') {
            items[index].id_buah = value;
            items[index].id_varietas = '';
            loadVarietas(index, value);
        } else {
            items[index].id_varietas = value;
        }
    }

    function loadVarietas(index, id_buah, selectedVarietas = null) {
        const select = document.getElementById(`varietas-${index}`);

        select.innerHTML = `<option value="">Pilih Varietas</option>`;

        const filtered = semuaVarietas.filter(v => v.id_buah == id_buah);

        filtered.forEach(v => {
            select.innerHTML += `
                <option value="${v.id}" 
                    ${selectedVarietas == v.id ? 'selected' : ''}>
                    ${v.nama_varietas}
                </option>
            `;
        });
    }

    function addItem() {
        const tipe = document.getElementById('tipe').value;

        if (tipe === 'satuan') {
            alert('Produk satuan hanya boleh 1 komposisi');
            return;
        }

        items.push({
            id_buah: '',
            id_varietas: ''
        });
        renderItems();
    }

    function removeItem(index) {
        items.splice(index, 1);
        renderItems();
    }

    function resetItems() {
        const tipe = document.getElementById('tipe').value;

        if (tipe === 'satuan') {
            items = [{
                id_buah: '',
                id_varietas: ''
            }];
        }

        renderItems();
        toggleAddButton();
    }

    function toggleAddButton() {
        const tipe = document.getElementById('tipe').value;
        const btn = document.getElementById('btnAddItem');

        btn.style.display = (tipe === 'satuan') ? 'none' : 'inline-block';
    }

    function handleFiles(event) {
        const newFiles = Array.from(event.target.files);
        images = [...images, ...newFiles];
        renderImages();
    }

    function renderImages() {
        const preview = document.getElementById('previewContainer');
        preview.innerHTML = '';

        oldImages.forEach((img, index) => {
            preview.innerHTML += `
            <div class="position-relative">
                <img src="../admin/assets/images/produk/${img.gambar}" 
                    class="img-thumbnail"
                    style="width:80px;height:80px;object-fit:cover;">
                <button class="btn btn-danger btn-sm position-absolute top-0 end-0"
                    onclick="removeOldImage(${index})">×</button>
            </div>`;
        });

        images.forEach((file, index) => {
            const url = URL.createObjectURL(file);

            preview.innerHTML += `
            <div class="position-relative">
                <img src="${url}" 
                    class="img-thumbnail"
                    style="width:80px;height:80px;object-fit:cover;">
                <button class="btn btn-danger btn-sm position-absolute top-0 end-0"
                    onclick="removeImage(${index})">×</button>
            </div>`;
        });
    }

    function removeOldImage(index) {
        oldImages.splice(index, 1);
        renderImages();
    }

    function removeImage(index) {
        images.splice(index, 1);
        renderImages();
    }

    async function saveProduct() {
        let data = new FormData();

        data.append('nama_produk', nama_produk.value);
        data.append('tipe', tipe.value);
        data.append('harga', harga.value);
        data.append('stok', stok.value);
        data.append('deskripsi', deskripsi.value);
        data.append('komposisi', JSON.stringify(items));

        images.forEach((file, i) => data.append(`images[${i}]`, file));
        data.append('oldImages', JSON.stringify(oldImages));

        if (editId) data.append('id', editId);

        let action = editId ? 'update' : 'tambah';

        const baseUrl = window.location.origin + '/sghwebv2/ec/admin/crud/produkController.php';

        let res = await fetch(`${baseUrl}?action=${action}`, {
            method: 'POST',
            body: data
        });

        let result = await res.json();

        if (result.status) {
            alert('Berhasil!');
            location.reload();
        } else {
            alert(result.message);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderItems();
        toggleAddButton();
    });
</script>
<script>
    async function openDetail(id) {
        try {
            const response = await fetch(`/sghwebv2/ec/admin/crud/produkController.php?action=get_detail&id=${id}`);
            const data = await response.json();

            document.getElementById('detailNama').innerText = data.nama_produk;
            document.getElementById('detailTipe').innerText = data.tipe;
            document.getElementById('detailHarga').innerText = data.harga ?
                parseInt(data.harga).toLocaleString() :
                0;
            document.getElementById('detailStok').innerText = data.stok;
            document.getElementById('detailDeskripsi').innerText = data.deskripsi || 'Tidak ada deskripsi';

            let mainImage = document.getElementById('detailMainImage');
            let thumbnails = document.getElementById('detailThumbnails');

            thumbnails.innerHTML = '';

            if (data.images && data.images.length > 0) {
                mainImage.src = '../admin/assets/images/produk/' + data.images[0].gambar;

                data.images.forEach(img => {
                    let el = document.createElement('img');
                    el.src = '../admin/assets/images/produk/' + img.gambar;
                    el.className = 'img-thumbnail';
                    el.style.width = '60px';
                    el.style.height = '60px';
                    el.style.objectFit = 'cover';

                    el.onclick = () => {
                        mainImage.src = el.src;
                    };

                    thumbnails.appendChild(el);
                });

            } else {
                mainImage.src = '';
            }

            let komposisi = document.getElementById('detailKomposisi');
            komposisi.innerHTML = '';

            if (data.komposisi && data.komposisi.length > 0) {
                data.komposisi.forEach(item => {
                    let li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center p-1';

                    li.innerHTML = `
                    <span>${item.nama_buah}</span>
                    <span class="badge bg-secondary rounded-pill">${item.nama_varietas}</span>
                `;

                    komposisi.appendChild(li);
                });
            } else {
                komposisi.innerHTML = '<li class="list-group-item">Tidak ada komposisi</li>';
            }

            let modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();

        } catch (error) {
            console.error("Gagal ambil detail:", error);
            alert("Gagal mengambil data produk");
        }
    }
</script>