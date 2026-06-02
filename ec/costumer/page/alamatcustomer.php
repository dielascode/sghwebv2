<?php
error_reporting(0);      // tambah ini
ini_set('display_errors', 0);  // dan ini
session_name('sghwebv2_session');
session_start();
require_once __DIR__ . '/../../config/connection.php';
$db          = (new Database())->getConnection();
$id_costumer = $_SESSION['id'];

$stmt = $db->prepare("SELECT * FROM alamat_costumer WHERE id_costumer = ? ORDER BY FIELD(status, 'utama', 'bukan'), id DESC");
$stmt->bind_param("s", $id_costumer);
$stmt->execute();
$alamat_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach ($alamat_list as &$row) {
    $row['data'] = json_decode($row['alamat'], true) ?? [];
}
unset($row);
?>
<body>

<div class="container-pesanan d-flex">
    <!-- SIDEBAR -->
    <?php include __DIR__ . "/../elemen/sidebar_profil.php"; ?>

    <main class="content-area flex-grow-1">
        <div class="address-card bg-white border rounded-1 shadow-sm">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="pw-header">
                    <h2 class="fw-semibold mb-0" style="font-size: 24px;">Alamat Saya</h2>
                    <p class="mb-0 text-muted">Kelola alamat pengiriman Anda untuk memudahkan proses checkout</p>
                </div>
                <button class="btn btn-sgh-primary rounded-pill"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAlamat"
                        id="btnTambah">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Alamat Baru
                </button>
            </div>
            <hr class="my-3">

            <!-- DAFTAR ALAMAT -->
            <?php if (empty($alamat_list)): ?>
                <p class="text-muted text-center py-4">Belum ada alamat tersimpan.</p>
            <?php endif; ?>

            <?php foreach ($alamat_list as $alamat):
                $d = $alamat['data'];
            ?>
            <div class="alamat-item">
                <div class="alamat-top">
                    <div class="user-info">
                        <i class="fa-regular fa-user icon"></i>
                        <span class="nama">Alamat Pengiriman</span>
                    </div>

                    <div class="aksi">
                        <!-- Tombol Ubah — kirim data ke modal via data-* -->
                        <a href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#modalAlamat"
                           data-id="<?= $alamat['id'] ?>"
                           data-provinsi-id="<?= htmlspecialchars($d['provinsi_id'] ?? '') ?>"
                           data-kota-id="<?= htmlspecialchars($d['kota_id'] ?? '') ?>"
                           data-kecamatan-id="<?= htmlspecialchars($d['kecamatan_id'] ?? '') ?>"
                           data-kelurahan-id="<?= htmlspecialchars($d['kelurahan_id'] ?? '') ?>"
                           data-jalan="<?= htmlspecialchars($d['jalan'] ?? '') ?>"
                           data-detail="<?= htmlspecialchars($d['detail'] ?? '') ?>">
                            <i class="fa-solid fa-pen"></i> Ubah
                        </a>

                        <!-- Hapus hanya muncul untuk alamat bukan utama -->
                        <?php if ($alamat['status'] !== 'utama'): ?>
                        <a href="logic/costumer/alamatApi.php?action=hapus&id=<?= $alamat['id'] ?>"
                           class="hapus"
                           onclick="return confirm('Yakin ingin menghapus alamat ini?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="alamat-middle">
                    <i class="fa-solid fa-location-dot icon"></i>
                    <p>
                        <?= htmlspecialchars($d['jalan'] ?? '') ?>,
                        <?= htmlspecialchars($d['kelurahan'] ?? '') ?>,
                        Kec. <?= htmlspecialchars($d['kecamatan'] ?? '') ?>,
                        <?= htmlspecialchars($d['kota'] ?? '') ?>,
                        <?= htmlspecialchars($d['provinsi'] ?? '') ?>
                    </p>
                </div>

                <div class="alamat-bottom">
                    <?php if ($alamat['status'] === 'utama'): ?>
                        <span class="badge-utama">
                            <i class="fa-solid fa-star"></i> Utama
                        </span>
                    <?php else: ?>
                        <button class="btn-outline"
                                onclick="window.location.href='logic/costumer/alamatApi.php?action=set_utama&id=<?= $alamat['id'] ?>'">
                            Atur Sebagai Utama
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>


            <!-- ===== MODAL TAMBAH / UBAH ALAMAT ===== -->
            <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-semibold" id="modalAlamatLabel">Tambah Alamat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formAlamat" action="logic/costumer/alamatApi.php?action=simpan" method="POST">

                                <!-- Hidden: id untuk mode ubah -->
                                <input type="hidden" name="id" id="inputId">
                                <!-- Hidden: JSON alamat lengkap yang dikirim ke server -->
                                <input type="hidden" name="alamat_json" id="hiddenAlamatJson">

                                <!-- Provinsi & Kota otomatis -->
                                <input type="hidden" name="provinsi_id" value="35">
                                <input type="hidden" name="provinsi" value="Jawa Timur">
                                <input type="hidden" name="kota_id" value="3508">
                                <input type="hidden" name="kota" value="Jember">

                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Provinsi</label>
                                        <input type="text" class="form-control custom-input" value="Jawa Timur" disabled>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kabupaten / Kota</label>
                                        <input type="text" class="form-control custom-input" value="Jember" disabled>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kecamatan</label>
                                        <input type="text" class="form-control custom-input" id="inputKecamatan" name="kecamatan"
                                               placeholder="Contoh: Kaliwates">
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kelurahan / Desa</label>
                                        <input type="text" class="form-control custom-input" id="inputKelurahan" name="kelurahan"
                                               placeholder="Contoh: Tegal Besar">
                                    </div>
                                </div>

                                <!-- Nama Jalan, Gedung, No. Rumah -->
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Nama Jalan, Gedung, No. Rumah</label>
                                        <textarea class="form-control custom-input" id="inputJalan"
                                                  name="jalan" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>

                                <!-- Detail Lainnya -->
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Detail Lainnya</label>
                                        <input type="text" id="inputDetail" name="detail" class="form-control custom-input"
                                               placeholder="Contoh: Patokan, warna pagar, dll">
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-nanti px-4"
                                            data-bs-dismiss="modal">Nanti Saja</button>
                                    <button type="submit" class="btn btn-ok px-5">Ok</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== END MODAL ===== -->

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ================================================================
// KONFIGURASI
// ================================================================
const DEFAULT_PROVINSI_ID = '35'; // Jawa Timur
const DEFAULT_KOTA_ID = '3508';   // Jember

// Elemen input
const inputKecamatan   = document.getElementById('inputKecamatan');
const inputKelurahan   = document.getElementById('inputKelurahan');
const inputJalan       = document.getElementById('inputJalan');
const inputDetail      = document.getElementById('inputDetail');
const inputId          = document.getElementById('inputId');
const hiddenAlamatJson = document.getElementById('hiddenAlamatJson');

// Objek penampung data wilayah yang dipilih
let wilayah = {
    provinsi_id: DEFAULT_PROVINSI_ID,
    provinsi   : 'Jawa Timur',
    kota_id    : DEFAULT_KOTA_ID,
    kota       : 'Jember',
    kecamatan_id: '',
    kecamatan   : '',
    kelurahan_id: '',
    kelurahan   : ''
};

// ================================================================
// MODAL EVENTS
// ================================================================
const modalEl    = document.getElementById('modalAlamat');
const modalTitle = document.getElementById('modalAlamatLabel');

modalEl.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    hiddenAlamatJson.value = '';

    inputId.value        = '';
    inputJalan.value     = '';
    inputDetail.value    = '';
    inputKecamatan.value = '';
    inputKelurahan.value = '';

    wilayah = {
        provinsi_id: DEFAULT_PROVINSI_ID,
        provinsi   : 'Jawa Timur',
        kota_id    : DEFAULT_KOTA_ID,
        kota       : 'Jember',
        kecamatan_id: '',
        kecamatan   : '',
        kelurahan_id: '',
        kelurahan   : ''
    };

    if (btn && btn.dataset.id) {
        modalTitle.innerText = 'Ubah Alamat';
        inputId.value        = btn.dataset.id;
        inputJalan.value     = btn.dataset.jalan;
        inputDetail.value    = btn.dataset.detail;
        inputKecamatan.value = btn.dataset.kecamatan || '';
        inputKelurahan.value = btn.dataset.kelurahan || '';

        wilayah.kecamatan_id = inputKecamatan.value.trim();
        wilayah.kecamatan    = inputKecamatan.value.trim();
        wilayah.kelurahan_id = inputKelurahan.value.trim();
        wilayah.kelurahan    = inputKelurahan.value.trim();
    } else {
        modalTitle.innerText = 'Tambah Alamat';
    }
});

// ================================================================
// SUBMIT FORM — Gabung semua jadi JSON lalu kirim
// ================================================================
document.getElementById('formAlamat').addEventListener('submit', function (e) {
    e.preventDefault();

    const kecamatanValue = inputKecamatan.value.trim();
    const kelurahanValue = inputKelurahan.value.trim();

    if (!kecamatanValue) {
        alert('Mohon isi Kecamatan terlebih dahulu.');
        inputKecamatan.focus();
        return;
    }
    if (!kelurahanValue) {
        alert('Mohon isi Kelurahan terlebih dahulu.');
        inputKelurahan.focus();
        return;
    }
    if (!inputJalan.value.trim()) {
        alert('Mohon isi Nama Jalan / Alamat terlebih dahulu.');
        inputJalan.focus();
        return;
    }

    wilayah.kecamatan_id = kecamatanValue;
    wilayah.kecamatan    = kecamatanValue;
    wilayah.kelurahan_id = kelurahanValue;
    wilayah.kelurahan    = kelurahanValue;

    const alamatJSON = JSON.stringify({
        provinsi_id  : wilayah.provinsi_id,
        provinsi     : wilayah.provinsi,
        kota_id      : wilayah.kota_id,
        kota         : wilayah.kota,
        kecamatan_id : wilayah.kecamatan_id,
        kecamatan    : wilayah.kecamatan,
        kelurahan_id : wilayah.kelurahan_id,
        kelurahan    : wilayah.kelurahan,
        jalan        : inputJalan.value.trim(),
        detail       : inputDetail.value.trim(),
    });

    hiddenAlamatJson.value = alamatJSON;
    this.submit();
});
</script>

</body>

