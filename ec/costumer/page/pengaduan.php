<!-- NAVBAR -->
<?php include "../elemen/navbar_pesanan.php"; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Pengaduan – SGH POLIJE</title>
    <link rel="stylesheet"
        href="http://localhost/semester%202/proyek%20SGH/sghwebv2/ec/style/costumer/pengaduanStyles.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet" />

</head>

<body>



    <!-- ── MAIN ── -->
    <main>
        <div class="page-header">
            <h1>Formulir Pengaduan</h1>
            <p>Berikan pendapat Anda dengan jujur tentang apa yang Anda pikirkan</p>
        </div>

        <div class="divider"></div>

        <div class="form-card">
            <div class="field-group">
                <label>Subjek <span class="required">*</span></label>
                <input type="text" id="subjek" placeholder="Masukkan subjek pengaduan..." />
            </div>

            <div class="field-group">
                <label>Pesan Pengaduan <span class="required">*</span></label>
                <textarea id="pesan" placeholder="Ketik disini..."></textarea>
            </div>

            <div class="field-grid">
                <div class="field-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <div class="input-wrap">
                        <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <input type="text" id="nama" placeholder="Nama Anda" />
                    </div>
                </div>

                <div class="field-group">
                    <label>No Telepon</label>
                    <div class="input-wrap">
                        <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.28h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.29 6.29l.95-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <input type="tel" id="telepon" placeholder="08xx-xxxx-xxxx" />
                    </div>
                </div>

                <div class="field-group">
                    <label>E-mail</label>
                    <div class="input-wrap">
                        <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <input type="email" id="email" placeholder="contoh: xxxtenta@contoh.com" />
                    </div>
                </div>

                <div class="field-group">
                    <label>Alamat</label>
                    <div class="input-wrap">
                        <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <input type="text" id="alamat" placeholder="Jalan, Kota, Provinsi" />
                    </div>
                </div>
            </div>

            <div id="successMsg" class="success-msg">
                ✅ Pengaduan Anda berhasil dikirim! Kami akan segera menindaklanjutinya.
            </div>

            <button class="btn-submit" onclick="handleSubmit()">Kirim</button>
        </div>
    </main>

    <script>
        function handleSubmit() {
            const subjek = document.getElementById('subjek').value.trim();
            const pesan = document.getElementById('pesan').value.trim();
            const nama = document.getElementById('nama').value.trim();

            if (!subjek || !pesan || !nama) {
                alert('Harap lengkapi field yang wajib diisi (Subjek, Pesan Pengaduan, Nama Lengkap).');
                return;
            }

            document.getElementById('successMsg').classList.add('show');
            document.getElementById('successMsg').scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Reset after 3s
            setTimeout(() => {
                ['subjek', 'pesan', 'nama', 'telepon', 'email', 'alamat'].forEach(id => {
                    document.getElementById(id).value = '';
                });
                document.getElementById('successMsg').classList.remove('show');
            }, 3500);
        }
    </script>

</body>

</html>