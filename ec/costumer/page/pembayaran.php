<!-- NAVBAR -->
<?php include "../elemen/navbar_pesanan.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #eef2f1;
    margin: 0;
}

/* Container */
.container {
    width: 90%;
    margin: 40px auto;
}

/* ===== STEP ===== */
.steps {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}

.step {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #999;
}

.circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.step.active .circle {
    background: #2f7d5a;
}

.step.active {
    color: #2f7d5a;
    font-weight: 600;
}

.line {
    width: 40px;
    height: 2px;
    background: #ccc;
}

.step.active + .line {
    background: #2f7d5a;
}

/* ===== TITLE ===== */
h2 {
    margin-bottom: 20px;
}

/* ===== LAYOUT ===== */
.content {
    display: flex;
    gap: 25px;
}

/* CARD */
.card {
    background: #f8f8f8;
    padding: 20px;
    border-radius: 12px;
    flex: 1;
}

/* INNER BOX */
.inner {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #ddd;
}

/* QR + TEXT */
.flex {
    display: flex;
    gap: 70px;
    align-items: center;
}

.qr {
    width: 180px;
}

/* TEXT */
ol {
    padding-left: 18px;
    font-size: 14px;
    color: #444;
}

.timer {
    text-align: center;
    margin: 15px 0;
    color: #666;
}

/* UPLOAD */
.upload-box {
    text-align: center;
}

.upload-area {
    border: 2px dashed #ccc;
    border-radius: 12px;
    padding: 30px;
    background: #fafafa;
}

.upload-icon {
    font-size: 50px;
    color: #4a3f8f;
}

.btn {
    margin-top: 15px;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    background: linear-gradient(90deg, #2f7d5a, #4bb07a);
    color: white;
    cursor: pointer;
}

/* CONFIRM BUTTON */
.btn-confirm {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    border-radius: 25px;
    border: none;
    background: linear-gradient(90deg, #2f7d5a, #4bb07a);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

/* RESPONSIVE */
@media(max-width: 768px) {
    .content {
        flex-direction: column;
    }

    .flex {
        flex-direction: column;
    }
}
</style>

</head>
<body>

<div class="container">

    <!-- STEP -->


    <h2>Selesaikan Pembayaran Anda</h2>

    <div class="content">

        <!-- LEFT -->
        <div class="card">
            <h3>Langkah 1</h3>
            <div class="inner">

                <p>Silakan pindai kode QR di bawah ini menggunakan aplikasi pembayaran pilihan Anda.</p><br>

                <div class="flex">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=payment" class="qr">

                    <ol>
                        <li>Scan QR Code: Buka aplikasi e-wallet atau bank kamu.</li>
                        <li>Masukkan Nominal: Pastikan jumlah pembayaran sudah sesuai.</li>
                        <li>Simpan Bukti: Screenshot atau simpan struk pembayaran sukses.</li>
                        <li>Upload: Unggah bukti pembayaran pada kolom yang tersedia di sebelah kanan.</li>
                    </ol>
                </div>

                <p class="timer">Selesaikan pembayaran dalam : 03:59</p>

                <b>Nominal yang dibayarkan : Rp. 30.000</b><br><br>
                <small>*Pastikan jumlah sesuai sebelum upload</small>

            </div>
        </div>

        <!-- RIGHT -->
    <div class="col-lg-4">
        <div class="card">
            <h3>Langkah 2</h3>
            <div class="inner upload-box">

                <p><b>Unggah Bukti Pembayaran Kamu</b></p>

                <div class="upload-area">
                    <div class="upload-icon">☁⬆</div>
                    <input type="file" id="upload" hidden>
                    <p>Unggah atau seret & lepas</p>
                    <button class="btn" onclick="document.getElementById('upload').click()">Unggah bukti pembayaran</button>
                    <br><br>
                    <small>Upload screenshot atau foto bukti pembayaran</small>
                </div>

                <button class="btn-confirm">Konfirmasi pembayaran</button>

            </div>
        </div>

    </div>

</div>

</body>
</html>