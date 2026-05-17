<div class="container-pembayaran ">
    <div class="d-flex justify-content-center mb-5">
        <div class="step-pembayaran">
            <div class="circle-pembayaran"><i class="bi bi-check"></i></div>
            <span>Detail orders</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step-pembayaran">
            <div class="circle-pembayaran"><i class="bi bi-check"></i></div>
            <span>Pembayaran</span>
        </div>

        <div class="line mx-3"></div>

        <div class="step-pembayaran inactive">
            <div class="circle-pembayaran"><i class="bi bi-check"></i></div>
            <span>Succes</span>
        </div>
    </div>




   

    <div class="grid-py">
       <?php if (session_status() === PHP_SESSION_NONE) session_start();
$total_bayar = $_SESSION['total_bayar'] ?? 0;
?>

        <!-- LANGKAH 1 -->
        <div class="card1">
            <div class="step-pembayaran-pill"> Langkah 1</div>
            <p class="card-title">Bayar via QRIS</p>
            <p class="card-desc">Silakan pindai kode QR di bawah ini menggunakan aplikasi pembayaran pilihan Anda
                (Gopay, OVO, Dana, atau Mobile Banking).</p>

            <div class="inner-box">
                <div class="qr-body">
                    <div class="qr-col">
                        <div class="qr-frame">
                            <!-- Ganti src dengan path gambar QRIS asli Anda -->
                            <img src="/sghwebv2/ec/images/qr.jpg" alt="QR Code">
                        </div>
                        <span class="qr-label">SCAN QR CODE</span>
                    </div>

                    <div class="step-pembayarans-col">
                        <div class="s-row">
                            <div class="s-num">1</div>
                            <p class="s-text"><strong>Scan QR Code</strong> — Buka aplikasi e-wallet atau bank kamu.</p>
                        </div>
                        <div class="s-row">
                            <div class="s-num">2</div>
                            <p class="s-text"><strong>Masukkan Nominal</strong> — Pastikan jumlah pembayaran sudah
                                sesuai.</p>
                        </div>
                        <div class="s-row">
                            <div class="s-num">3</div>
                            <p class="s-text"><strong>Simpan Bukti</strong> — Screenshot atau simpan struk pembayaran
                                sukses.</p>
                        </div>
                        <div class="s-row">
                            <div class="s-num">4</div>
                            <p class="s-text"><strong>Upload</strong> — Unggah bukti di kolom sebelah kanan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nominal-row">
                <div>
                    <p class="nom-label">Nominal yang dibayarkan</p>
                    <p class="nom-amount">Rp <?= number_format($total_bayar) ?></p>
                </div>
                <p class="nom-note">*Pastikan jumlah pembayaran sudah sesuai sebelum mengupload bukti pembayaran.</p>
            </div>
        </div>

        <!-- LANGKAH 2 -->
        <div class="card2">
            <div class="step-pembayaran-pill"> Langkah 2s</div>
            <p class="card-title">Upload bukti pembayaran</p>
            <p class="card-desc">Unggah screenshot atau struk pembayaran setelah transaksi berhasil dilakukan.</p>

            <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                <div class="upload-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1E4D1A" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 16 12 12 8 16" />
                        <line x1="12" y1="12" x2="12" y2="21" />
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3" />
                    </svg>
                </div>
                <p class="upload-title">Drag & drop atau klik untuk unggah</p>
                <p class="upload-sub">Format: JPG, PNG, PDF — maks. 5 MB</p>
                <span class="upload-btn-sm">Pilih file</span>
            </div>

            <input type="file" id="fileInput" accept="image/*,.pdf" style="display:none">

            <div class="preview-box" id="previewBox">
                <img class="preview-thumb" id="previewThumb" src="" alt="preview">
                <div>
                    <p class="preview-name" id="previewName"></p>
                    <p class="preview-size" id="previewSize"></p>
                </div>
                <button class="remove-btn" id="removeBtn">&#x2715;</button>
            </div>

            <button class="confirm-btn" id="confirmBtn" disabled onclick="handleConfirm()">Konfirmasi
                Pembayaran</button>

            <div class="success-msg" id="successMsg">
                <div class="success-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <p class="success-title">Pembayaran dikonfirmasi!</p>
                <p class="success-sub">Bukti pembayaran sedang kami verifikasi. Terima kasih.</p>
            </div>
        </div>

    </div>

</div>
<script>
(function() {
    const fileInput    = document.getElementById('fileInput');
    const previewBox   = document.getElementById('previewBox');
    const previewThumb = document.getElementById('previewThumb');
    const previewName  = document.getElementById('previewName');
    const previewSize  = document.getElementById('previewSize');
    const confirmBtn   = document.getElementById('confirmBtn');
    const removeBtn    = document.getElementById('removeBtn');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert('File terlalu besar, maksimal 5MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewThumb.src = e.target.result;
        };
        reader.readAsDataURL(file);

        previewName.textContent  = file.name;
        previewSize.textContent  = (file.size / 1024).toFixed(1) + ' KB';
        previewBox.style.display = 'flex';
        confirmBtn.disabled      = false;
    });

    removeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        fileInput.value          = '';
        previewBox.style.display = 'none';
        previewThumb.src         = '';
        confirmBtn.disabled      = true;
    });

    window.handleConfirm = function () {
        const file = fileInput.files[0];
        if (!file) { alert('Upload bukti bayar dulu'); return; }

        confirmBtn.disabled  = true;
        confirmBtn.innerText = 'Mengirim...';

        const formData = new FormData();
        formData.append('action', 'konfirmasi');
        formData.append('bukti_bayar', file);

        fetch('/sghwebv2/ec/costumer/controller/pesananController.php', {
            method: 'POST',
            credentials: 'include',
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            if (res.trim() === 'success') {
                document.getElementById('successMsg').style.display = 'flex';
                updateCartBadge();
                setTimeout(() => loadPage('costumer/page/dummysukses.php'), 2000);
            } else {
                alert('Gagal: ' + res);
                confirmBtn.disabled  = false;
                confirmBtn.innerText = 'Konfirmasi Pembayaran';
            }
        })
        .catch(err => {
            console.log(err);
            confirmBtn.disabled  = false;
            confirmBtn.innerText = 'Konfirmasi Pembayaran';
        });
    };
})();
</script>
