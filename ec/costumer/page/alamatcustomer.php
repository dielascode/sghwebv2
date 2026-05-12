<?php
session_start();
require '../../config/connection.php';

$db          = (new Database())->getConnection();
$id_costumer = $_SESSION['id_costumer'];

$stmt = $db->prepare("SELECT * FROM alamat_costumer WHERE id_costumer = ? ORDER BY FIELD(status, 'utama', 'bukan')");
$stmt->bind_param("i", $id_costumer);
$stmt->execute();
$alamat_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach ($alamat_list as &$row) {
    $row['data'] = json_decode($row['alamat'], true) ?? [];
}
unset($row);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Saya</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container-pesanan d-flex">
    <!-- SIDEBAR -->
    <?php include "../elemen/sidebar_profil.php"; ?>

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
                        <span class="nama"><?= htmlspecialchars($d['nama_lengkap'] ?? '') ?></span>
                        <span class="phone">| <?= htmlspecialchars($d['no_telp'] ?? '') ?></span>
                    </div>

                    <div class="aksi">
                        <!-- Tombol Ubah — kirim data ke modal via data-* -->
                        <a href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#modalAlamat"
                           data-id="<?= $alamat['id'] ?>"
                           data-nama="<?= htmlspecialchars($d['nama_lengkap'] ?? '') ?>"
                           data-telp="<?= htmlspecialchars($d['no_telp'] ?? '') ?>"
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
                        <a href="proses_alamat.php?action=hapus&id=<?= $alamat['id'] ?>"
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
                                onclick="window.location.href='proses_alamat.php?action=set_utama&id=<?= $alamat['id'] ?>'">
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
                            <form id="formAlamat" action="proses_alamat.php?action=simpan" method="POST">

                                <!-- Hidden: id untuk mode ubah -->
                                <input type="hidden" name="id" id="inputId">
                                <!-- Hidden: JSON alamat lengkap yang dikirim ke server -->
                                <input type="hidden" name="alamat_json" id="hiddenAlamatJson">

                                <!-- Nama & Telepon -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" id="inputNama"
                                                   class="form-control custom-input" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Nomor Telepon</label>
                                            <input type="text" name="no_telp" id="inputTelp"
                                                   class="form-control custom-input" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Provinsi -->
                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Provinsi</label>
                                        <select class="form-select custom-input" id="selectProvinsi">
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kota/Kabupaten -->
                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kabupaten / Kota</label>
                                        <select class="form-select custom-input" id="selectKota" disabled>
                                            <option value="">-- Pilih Kabupaten/Kota --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="mb-3">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kecamatan</label>
                                        <select class="form-select custom-input" id="selectKecamatan" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kelurahan -->
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Kelurahan / Desa</label>
                                        <select class="form-select custom-input" id="selectKelurahan" disabled>
                                            <option value="">-- Pilih Kelurahan --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Jalan + Autocomplete Nominatim -->
                                <div class="mb-4" style="position: relative;">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Nama Jalan, Gedung, No. Rumah</label>
                                        <!-- FIX BUG 1: Tambah name="jalan" -->
                                        <textarea class="form-control custom-input" id="inputJalan"
                                                  name="jalan" rows="2" autocomplete="off"></textarea>
                                    </div>
                                    <!-- Dropdown hasil autocomplete -->
                                    <ul id="autocompleteList" style="
                                        display: none;
                                        position: absolute;
                                        z-index: 9999;
                                        background: #fff;
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        width: 100%;
                                        max-height: 200px;
                                        overflow-y: auto;
                                        list-style: none;
                                        padding: 0;
                                        margin: 0;
                                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                                    "></ul>
                                </div>

                                <!-- Detail Lainnya -->
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Detail Lainnya</label>
                                        <!-- FIX BUG 1: Tambah name="detail" -->
                                        <input type="text" id="inputDetail" name="detail" class="form-control custom-input"
                                               placeholder="Contoh: Patokan, warna pagar, dll">
                                    </div>
                                </div>

                                <!-- Peta (OpenStreetMap embed) -->
                                <div class="mb-4">
                                    <div class="map-container border overflow-hidden"
                                         style="height: 200px; position: relative;">
                                        <iframe id="mapFrame"
                                            src="https://www.openstreetmap.org/export/embed.html?bbox=113.5800,-8.2200,113.7800,-8.0800&layer=mapnik"
                                            width="100%" height="100%" style="border:0;"
                                            allowfullscreen="" loading="lazy">
                                        </iframe>
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
// FIX BUG 3: Ganti emsifa.com (sering down) ke mirror ibnux yang lebih stabil
// ================================================================
const BASE_WILAYAH = 'https://wilayah.id/api';
// Elemen dropdown
const selProvinsi  = document.getElementById('selectProvinsi');
const selKota      = document.getElementById('selectKota');
const selKecamatan = document.getElementById('selectKecamatan');
const selKelurahan = document.getElementById('selectKelurahan');

// Elemen input
const inputJalan  = document.getElementById('inputJalan');
const inputDetail = document.getElementById('inputDetail');
const inputNama   = document.getElementById('inputNama');
const inputTelp   = document.getElementById('inputTelp');
const inputId     = document.getElementById('inputId');
const acList      = document.getElementById('autocompleteList');
const mapFrame    = document.getElementById('mapFrame');

// Objek penampung data wilayah yang dipilih
let wilayah = {
    provinsi_id: '', provinsi: '',
    kota_id: '',     kota: '',
    kecamatan_id: '', kecamatan: '',
    kelurahan_id: '', kelurahan: ''
};

// ================================================================
// FUNGSI LOAD API WILAYAH
// FIX BUG 3: Sesuaikan endpoint dengan format ibnux.github.io
// ================================================================
const BASE_WILAYAH = 'https://wilayah.id/api';

async function loadProvinsi() {
    try {
        const res  = await fetch(`${BASE_WILAYAH}/provinces.json`);
        const json = await res.json();
        const data = json.data;
        selProvinsi.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
        data.forEach(p => {
            selProvinsi.innerHTML += `<option value="${p.code}">${p.name}</option>`;
        });
    } catch(e) {
        console.error('Gagal load provinsi:', e);
        alert('Gagal memuat data provinsi. Coba refresh halaman.');
    }
}

async function loadKota(provinsiCode) {
    try {
        selKota.innerHTML = '<option value="">Memuat...</option>';
        const res  = await fetch(`${BASE_WILAYAH}/regencies/${provinsiCode}.json`);
        const json = await res.json();
        const data = json.data;
        selKota.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
        data.forEach(k => {
            selKota.innerHTML += `<option value="${k.code}">${k.name}</option>`;
        });
        selKota.disabled = false;
    } catch(e) {
        console.error('Gagal load kota:', e);
    }
}

async function loadKecamatan(kotaCode) {
    try {
        selKecamatan.innerHTML = '<option value="">Memuat...</option>';
        const res  = await fetch(`${BASE_WILAYAH}/districts/${kotaCode}.json`);
        const json = await res.json();
        const data = json.data;
        selKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        data.forEach(k => {
            selKecamatan.innerHTML += `<option value="${k.code}">${k.name}</option>`;
        });
        selKecamatan.disabled = false;
    } catch(e) {
        console.error('Gagal load kecamatan:', e);
    }
}

async function loadKelurahan(kecamatanCode) {
    try {
        selKelurahan.innerHTML = '<option value="">Memuat...</option>';
        const res  = await fetch(`${BASE_WILAYAH}/villages/${kecamatanCode}.json`);
        const json = await res.json();
        const data = json.data;
        selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
        data.forEach(k => {
            selKelurahan.innerHTML += `<option value="${k.code}">${k.name}</option>`;
        });
        selKelurahan.disabled = false;
    } catch(e) {
        console.error('Gagal load kelurahan:', e);
    }
}
    selKelurahan.innerHTML = '<option value="">Memuat...</option>';
    const data = await fetch(`${BASE_WILAYAH}/kelurahan/${kecamatanId}.json`).then(r => r.json());
    selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    data.forEach(k => {
        selKelurahan.innerHTML += `<option value="${k.id}">${k.nama}</option>`;
    });
    selKelurahan.disabled = false;
}

function resetDropdownBawah(dari) {
    if (dari === 'provinsi') {
        selKota.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
        selKota.disabled = true;
    }
    selKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
    selKecamatan.disabled = true;
    selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    selKelurahan.disabled = true;
}

// ================================================================
// EVENT CHANGE DROPDOWN
// ================================================================
selProvinsi.addEventListener('change', async function () {
    wilayah.provinsi_id = this.value;
    wilayah.provinsi    = this.options[this.selectedIndex].text;
    resetDropdownBawah('provinsi');
    if (this.value) await loadKota(this.value);
});

selKota.addEventListener('change', async function () {
    wilayah.kota_id = this.value;
    wilayah.kota    = this.options[this.selectedIndex].text;
    selKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
    selKecamatan.disabled = true;
    selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    selKelurahan.disabled = true;
    if (this.value) await loadKecamatan(this.value);
});

selKecamatan.addEventListener('change', async function () {
    wilayah.kecamatan_id = this.value;
    wilayah.kecamatan    = this.options[this.selectedIndex].text;
    selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    selKelurahan.disabled = true;
    if (this.value) await loadKelurahan(this.value);
});

selKelurahan.addEventListener('change', function () {
    wilayah.kelurahan_id = this.value;
    wilayah.kelurahan    = this.options[this.selectedIndex].text;
});

// ================================================================
// MODAL EVENTS
// ================================================================
const modalEl    = document.getElementById('modalAlamat');
const modalTitle = document.getElementById('modalAlamatLabel');

modalEl.addEventListener('show.bs.modal', async function (event) {
    const btn = event.relatedTarget;

    if (btn && btn.dataset.id) {
        // ── MODE UBAH ──────────────────────────────
        modalTitle.innerText = 'Ubah Alamat';

        inputId.value     = btn.dataset.id;
        inputNama.value   = btn.dataset.nama;
        inputTelp.value   = btn.dataset.telp;
        inputJalan.value  = btn.dataset.jalan;
        inputDetail.value = btn.dataset.detail;

        const pId = btn.dataset.provinsiId;
        const kId = btn.dataset.kotaId;
        const cId = btn.dataset.kecamatanId;
        const lId = btn.dataset.kelurahanId;

        // FIX BUG 2: Load provinsi dulu sebelum set value,
        // lalu load bertahap dengan urutan yang benar agar
        // nama wilayah terbaca dengan tepat dari selectedIndex
        await loadProvinsi();
        selProvinsi.value       = pId;
        wilayah.provinsi_id     = pId;
        wilayah.provinsi        = selProvinsi.options[selProvinsi.selectedIndex]?.text ?? '';

        await loadKota(pId);
        selKota.value       = kId;
        wilayah.kota_id     = kId;
        wilayah.kota        = selKota.options[selKota.selectedIndex]?.text ?? '';

        await loadKecamatan(kId);
        selKecamatan.value       = cId;
        wilayah.kecamatan_id     = cId;
        wilayah.kecamatan        = selKecamatan.options[selKecamatan.selectedIndex]?.text ?? '';

        await loadKelurahan(cId);
        selKelurahan.value       = lId;
        wilayah.kelurahan_id     = lId;
        wilayah.kelurahan        = selKelurahan.options[selKelurahan.selectedIndex]?.text ?? '';

    } else {
        // ── MODE TAMBAH ────────────────────────────
        modalTitle.innerText = 'Tambah Alamat';

        inputId.value     = '';
        inputNama.value   = '';
        inputTelp.value   = '';
        inputJalan.value  = '';
        inputDetail.value = '';
        resetDropdownBawah('provinsi');
        selProvinsi.value = '';

        // Load provinsi pertama kali saja
        if (selProvinsi.options.length <= 1) {
            selProvinsi.innerHTML = '<option value="">Memuat provinsi...</option>';
            await loadProvinsi();
        }

        wilayah = {
            provinsi_id: '', provinsi: '',
            kota_id: '',     kota: '',
            kecamatan_id: '', kecamatan: '',
            kelurahan_id: '', kelurahan: ''
        };

        // Reset peta ke Jember
        mapFrame.src = 'https://www.openstreetmap.org/export/embed.html?bbox=113.5800,-8.2200,113.7800,-8.0800&layer=mapnik';
    }
});

// ================================================================
// SUBMIT FORM — Gabung semua jadi JSON lalu kirim
// FIX BUG 4: Tambah validasi wilayah sebelum submit
// ================================================================
document.getElementById('formAlamat').addEventListener('submit', function (e) {
    e.preventDefault();

    // Validasi: pastikan semua dropdown wilayah sudah dipilih
    if (!wilayah.provinsi_id) {
        alert('Mohon pilih Provinsi terlebih dahulu.');
        selProvinsi.focus();
        return;
    }
    if (!wilayah.kota_id) {
        alert('Mohon pilih Kabupaten/Kota terlebih dahulu.');
        selKota.focus();
        return;
    }
    if (!wilayah.kecamatan_id) {
        alert('Mohon pilih Kecamatan terlebih dahulu.');
        selKecamatan.focus();
        return;
    }
    if (!wilayah.kelurahan_id) {
        alert('Mohon pilih Kelurahan terlebih dahulu.');
        selKelurahan.focus();
        return;
    }
    if (!inputJalan.value.trim()) {
        alert('Mohon isi Nama Jalan / Alamat terlebih dahulu.');
        inputJalan.focus();
        return;
    }

    const alamatJSON = JSON.stringify({
        nama_lengkap : inputNama.value.trim(),
        no_telp      : inputTelp.value.trim(),
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

    document.getElementById('hiddenAlamatJson').value = alamatJSON;
    this.submit();
});

// ================================================================
// AUTOCOMPLETE NAMA JALAN — Nominatim OpenStreetMap
// ================================================================
let debounceTimer;

inputJalan.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const q = this.value.trim();

    if (q.length < 3) {
        acList.style.display = 'none';
        return;
    }

    debounceTimer = setTimeout(async () => {
        // Sertakan nama kota agar hasil lebih relevan
        const kotaQ = wilayah.kota || 'Indonesia';

        try {
            const res  = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q + ' ' + kotaQ)}&countrycodes=id&limit=5&addressdetails=1`,
                { headers: { 'Accept-Language': 'id' } }
            );
            const data = await res.json();

            if (!data.length) {
                acList.style.display = 'none';
                return;
            }

            acList.innerHTML = '';
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.display_name;
                li.style.cssText = 'padding:10px 14px; cursor:pointer; font-size:13px; border-bottom:1px solid #f0f0f0;';
                li.addEventListener('mouseenter', () => li.style.background = '#f5f5f5');
                li.addEventListener('mouseleave', () => li.style.background = '#fff');
                li.addEventListener('click', () => {
                    inputJalan.value       = item.display_name;
                    acList.style.display   = 'none';

                    // Update peta ke lokasi yang dipilih
                    const lat = parseFloat(item.lat);
                    const lon = parseFloat(item.lon);
                    const delta = 0.005;
                    mapFrame.src = `https://www.openstreetmap.org/export/embed.html?bbox=${lon - delta},${lat - delta},${lon + delta},${lat + delta}&layer=mapnik&marker=${lat},${lon}`;
                });
                acList.appendChild(li);
            });

            acList.style.display = 'block';
        } catch (err) {
            console.error('Autocomplete error:', err);
        }
    }, 500);
});

// Tutup autocomplete saat klik di luar
document.addEventListener('click', function (e) {
    if (!inputJalan.contains(e.target) && !acList.contains(e.target)) {
        acList.style.display = 'none';
    }
});
</script>

</body>
</html>
