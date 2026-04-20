<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #e9efec;
            font-family: 'Poppins', sans-serif;
        }

        .card-custom {
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            border: none;
        }


        .step {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .step .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2e7d59;
            color: white;
        }

        .step.inactive .circle {
            background: #ccc;
        }

        .line {
            width: 80px;
            height: 2px;
            background: #2e7d59;
            margin-top: 17px;
        }

        .btn-green {
            background: linear-gradient(to right, #1d5c3c, #4cc38a);
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            border: none;
        }

        .summary-box {
            background: #dfe9e4;
            border-radius: 15px;
            padding: 15px;
        }
    </style>
</head>

<body>

<div class="container py-5">

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

            <h4 class="mb-3">Detail Pesanan</h4>

            <!-- PRODUK -->
            <div class="card card-custom mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="http://localhost/semester%202/proyek%20SGH/sghwebv2/ec/images/melon1.jpg" class="img-fluid">
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
                    <button class="btn btn-green">Selanjutnya</button>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>