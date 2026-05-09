<body>
    <div class="container-pesanan d-flex">
        <!-- SIDEBAR -->
        <?php include "../elemen/sidebar_profil.php"; ?>


        <main class="content-area flex-grow-1 ">
            <div class="address-card bg-white  border rounded-1 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="pw-header">
                        <h2 class="fw-semibold mb-0" style="font-size: 24px;">Alamat Saya</h2>
                        <p class="mb-0 text-muted">Kelola alamat pengiriman Anda untuk memudahkan proses checkout</p>
                    </div>
                    <button class="btn btn-sgh-primary rounded-pill " data-bs-toggle="modal"
                        data-bs-target="#modalAlamat">
                        <i class="fa-solid fa-plus me-2"></i> Tambah Alamat Baru
                    </button>
                </div>
                <hr class="my-3">

                

                <div class="alamat-item ">
                    <div class="alamat-top">
                        <div class="user-info">
                            <i class="fa-regular fa-user icon"></i>
                            <span class="nama">Aril Ganteng</span>
                            <span class="phone">| 0822334455</span>
                        </div>

                        <div class="aksi">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAlamat">
                                <i class="fa-solid fa-pen"></i> Ubah
                            </a>
                        </div>
                    </div>

                    <hr>

                    <div class="alamat-middle">
                        <i class="fa-solid fa-location-dot icon"></i>
                        <p>Jl. sultan agung arjasa, rumah yang paling bagus</p>
                    </div>

                    <div class="alamat-bottom">
                        <span class="badge-utama">
                            <i class="fa-solid fa-star"></i> Utama
                        </span>

                        <button class="btn-outline">Atur Sebagai Utama</button>
                    </div>
                </div>



                <div class="alamat-item">
                    <div class="alamat-top">
                        <div class="user-info">
                            <i class="fa-regular fa-user icon"></i>
                            <span class="nama">Faiq Ulumuddin</span>
                            <span class="phone">| 0812345678</span>
                        </div>

                        <div class="aksi">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAlamat">
                                <i class="fa-solid fa-pen"></i> Ubah
                            </a>
                            <a href="#" class="hapus">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>

                    <hr>

                    <div class="alamat-middle">
                        <i class="fa-solid fa-location-dot icon"></i>
                        <p>Jl. Mastrip No. 164, Kec. Sumbersari, Kabupaten Jember</p>
                    </div>

                    <div class="alamat-bottom">
                        <button class="btn-outline">Atur Sebagai Utama</button>
                    </div>
                </div>


                <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-semibold" id="modalAlamatLabel">Tambah Alamat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formAlamat" action="proses_alamat.php" method="POST">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="form-floating-custom">
                                                <label class="label-floating">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap"
                                                    class="form-control custom-input">
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
                                            <label class="label-floating">Provinsi Jawa Timur, Kabupaten Jember,
                                                Kecamatan</label>

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
                                            <textarea class="form-control custom-input" name="jalan"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-floating-custom">
                                            <label class="label-floating">Detail Lainnya</label>
                                            <input type="text" name="detail" class="form-control custom-input">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="map-container border overflow-hidden"
                                            style="height: 200px; position: relative;">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126383.123456789!2d113.6300!3d-8.1700!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69438992a544f%3A0x3030bfbc20165c0!2sKabupaten%20Jember%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                                width="100%" height="100%" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="button" class="btn btn-nanti px-4" data-bs-dismiss="modal">Nanti
                                            Saja</button>
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