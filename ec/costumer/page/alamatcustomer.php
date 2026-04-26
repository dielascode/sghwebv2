<?php include('../elemen/navbar_pesanan.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Saya - SGH POLIJE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../style/costumer/profil.css">
    <style>
        /* CSS Khusus Modal agar terlihat lebih bagus dan tidak perlu ke css eksternal */
        .form-floating-custom { position: relative; margin-top: 10px; }
        .label-floating {
            position: absolute; top: -12px; left: 12px;
            background-color: white; padding: 0 8px;
            font-size: 13px; color: #666; z-index: 2;
        }
        .custom-input {
            border: 1px solid #333 !important; border-radius: 4px !important;
            padding: 12px !important; font-size: 15px;
        }
        .btn-nanti { background-color: #45a778; color: white; border-radius: 20px; border: none; }
        .btn-ok { background: linear-gradient(to right, #114029, #45a778); color: white; border-radius: 20px; border: none; }
        .btn-nanti:hover, .btn-ok:hover { color: white; opacity: 0.9; }
    </style>
</head>
<body>
    <div class="main-container" style="display: flex; background-color: #f5f5f5; min-height: 100vh;">
        <?php include('../elemen/sidebar_profil.php'); ?>

        <main class="content-area flex-grow-1 p-4">
            <div class="address-card bg-white p-4 border rounded-1 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-semibold mb-0" style="font-size: 24px;">Alamat Saya</h2>
                    <button class="btn btn-sgh-primary rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalAlamat">
                        <i class="fa-solid fa-plus me-2"></i> Tambah Alamat Baru
                    </button>
                </div>
                <hr class="my-3">

                <h6 class="fw-normal mb-4">Alamat</h6>

                <div class="address-item d-flex justify-content-between mb-4">
                    <div class="address-left flex-grow-1">
                        <p class="contact-info fw-medium mb-2" style="font-size: 18px;">
                            Aril Ganteng &nbsp; | &nbsp; 0822334455
                        </p>
                        <div class="address-box p-3 border border-dark mb-2" style="max-width: 80%; min-height: 80px;">
                            Jl. sultan agung arjasa, rumah yang paling bagus
                        </div>
                        <span class="badge rounded-pill bg-sgh-primary px-3 py-1" style="font-size: 12px; font-weight: 400;">Utama</span>
                    </div>
                    <div class="address-right text-end d-flex flex-column justify-content-start gap-2">
                        <div class="action-links">
                            <a href="#" class="text-dark text-decoration-none small" data-bs-toggle="modal" data-bs-target="#modalAlamat">Ubah</a>
                        </div>
                        <button class="btn btn-sgh-primary btn-sm rounded-pill px-3 py-1" style="font-size: 11px;">Atur Sebagai Utama</button>
                    </div>
                </div>

                <hr class="text-secondary opacity-25">

                <div class="address-item d-flex justify-content-between mb-4">
                    <div class="address-left flex-grow-1">
                        <p class="contact-info fw-medium mb-2" style="font-size: 18px;">
                            Faiq Ulumuddin &nbsp; | &nbsp; 0812345678
                        </p>
                        <div class="address-box p-3 border border-dark mb-2" style="max-width: 80%; min-height: 80px;">
                            Jl. Mastrip No. 164, Kec. Sumbersari, Kabupaten Jember
                        </div>
                    </div>
                    <div class="address-right text-end d-flex flex-column justify-content-start gap-2">
                        <div class="action-links d-flex justify-content-end gap-3">
                            <a href="#" class="text-dark text-decoration-none small" data-bs-toggle="modal" data-bs-target="#modalAlamat">Ubah</a>
                            <a href="#" class="text-dark text-decoration-none small" onclick="return confirm('Hapus alamat ini?')">Hapus</a>
                        </div>
                        <button class="btn btn-sgh-primary btn-sm rounded-pill px-3 py-1" style="font-size: 11px;">Atur Sebagai Utama</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-semibold" id="modalAlamatLabel">Tambah Alamat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formAlamat" action="proses_alamat.php" method="POST">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control custom-input">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Nomor Telepon</label>
                                            <input type="text" name="no_telp" class="form-control custom-input">
                                        </div>
                                    </div>
                                </div>
                            <div class="mb-4">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Provinsi Jawa Timur, Kabupaten Jember, Kecamatan</label>
                                            
                                            <select class="form-select custom-input" name="kecamatan" required>
                                                <option value="Arjasa" selected>Arjasa</option>
                                                <option value="Ajung">Ajung</option>
                                                <option value="Ambulu">Ambulu</option>
                                                <option value="Balung">Balung</option>
                                                <option value="Bangsalsari">Bangsalsari</option>
                                                <option value="Gumukmas">Gumukmas</option>
                                                <option value="Jelbuk">Jelbuk</option>
                                                <option value="Jenggawah">Jenggawah</option>
                                                <option value="Jombang">Jombang</option>
                                                <option value="Kalisat">Kalisat</option>
                                                <option value="Kaliwates">Kaliwates</option>
                                                <option value="Kencong">Kencong</option>
                                                <option value="Ledokombo">Ledokombo</option>
                                                <option value="Mayang">Mayang</option>
                                                <option value="Mumbulsari">Mumbulsari</option>
                                                <option value="Panti">Panti</option>
                                                <option value="Pakusari">Pakusari</option>
                                                <option value="Patrang">Patrang</option>
                                                <option value="Puger">Puger</option>
                                                <option value="Rambipuji">Rambipuji</option>
                                                <option value="Semboro">Semboro</option>
                                                <option value="Silo">Silo</option>
                                                <option value="Sukorambi">Sukorambi</option>
                                                <option value="Sukowono">Sukowono</option>
                                                <option value="Sumberbaru">Sumberbaru</option>
                                                <option value="Sumberjambe">Sumberjambe</option>
                                                <option value="Sumbersari">Sumbersari</option>
                                                <option value="Tanggul">Tanggul</option>
                                                <option value="Tempurejo">Tempurejo</option>
                                                <option value="Umbulsari">Umbulsari</option>
                                                <option value="Wuluhan">Wuluhan</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Nama Jalan, Gedung, No. Rumah</label>
                                        <textarea class="form-control custom-input" name="jalan" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-floating-custom">
                                        <label class="label-floating">Detail Lainnya</label>
                                        <input type="text" name="detail" class="form-control custom-input">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="map-container border overflow-hidden" style="height: 200px; position: relative;">
                                        <iframe 
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126383.123456789!2d113.6300!3d-8.1700!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69438992a544f%3A0x3030bfbc20165c0!2sKabupaten%20Jember%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-nanti px-4" data-bs-dismiss="modal">Nanti Saja</button>
                                    <button type="submit" class="btn btn-ok px-5">Ok</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalAlamat = document.getElementById('modalAlamat');
        const modalTitle = document.getElementById('modalAlamatLabel');

        modalAlamat.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            // Jika teks yang diklik adalah 'Ubah', ganti judul modal
            if (button.innerText.trim() === 'Ubah') {
                modalTitle.innerText = 'Ubah Alamat';
            } else {
                modalTitle.innerText = 'Tambah Alamat';
            }
        });
    </script>
</body>
</html>