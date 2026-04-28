

<div class="container-pemesanan ">

    <!-- STEP -->
    <div class="d-flex justify-content-center mb-5">
        <div class="step">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Detail orders</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Pembayaran</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step inactive">
            <div class="circle"><i class="bi bi-check"></i></div>
            <span>Succes</span>
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT -->
        <div class="col-lg-8">

            <h4 class=" judul-pesanan mb-3">Detail Pesanan</h4>

            <!-- PRODUK -->
            <div class="card card-custom mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="/sghwebv2/ec/images/produk2.png" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <h4>Melon Honey Globe</h4>
                        <h5 class="fw-bold">Rp 30.000 /Kg</h5>
                        <p>Melon segar berkualitas tinggi hasil budidaya terkontrol dengan standar pertanian modern.</p>

                        <p class="mb-1"><b>Kuantitas :</b></p>
                        <div class="d-flex justify-content-between">
                            <span>Rp 30.000 /Kg</span>
                            <span>x3</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-custom mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="/sghwebv2/ec/images/produk2.png" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <h4>Melon Honey Globe</h4>
                        <h5 class="fw-bold">Rp 30.000 /Kg</h5>
                        <p>Melon segar berkualitas tinggi hasil budidaya terkontrol dengan standar pertanian modern.</p>

                        <p class="mb-1"><b>Kuantitas :</b></p>
                        <div class="d-flex justify-content-between">
                            <span>Rp 30.000 /Kg</span>
                            <span>x3</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALAMAT -->
            <div class="card card-custom">
                <h5><i class="bi bi-geo-alt-fill text-success"></i> Alamat Pengiriman</h5>

                
                <textarea class="form-control" rows="3" placeholder="Masukkan alamat lengkap Anda..."></textarea>
            </div>

            <small class="text-muted d-block mt-3">
                *Pastikan informasi diatas sudah benar sebelum anda melanjutkan ke proses selanjutnya
            </small>

        </div>

        <!-- RIGHT -->
        <div class="col-lg-4"><br><br>

            <div class="card card-custom">
                <h5 class="mb-3">Rincian Pembayaran</h5>

                <div class="mb-2 d-flex justify-content-between">
                    <span>Nama :</span>
                    <span>alexxx bhizer</span>
                </div>

                <div class="mb-2 d-flex justify-content-between">
                    <span>Tanggal Pemesanan :</span>
                    <span>22-01-2026 02:00</span>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <span>Perkiraan waktu tiba :</span>
                    <span>22-01-2026</span>
                </div>

                <div class="summary-box">
                    <div class="d-flex justify-content-between">
                        <span>Melon honey globe</span>
                        <span>3 Kg</span>
                    </div>

                    <div class="d-flex justify-content-end">
                        <span>30.000 /Kg</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Bayar</span>
                        <span>30.000</span>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-green"  href="#" onclick="loadPage('costumer/page/pembayaran.php')">Selanjutnya</button>
                </div>

            </div>

        </div>

    </div>

</div>

