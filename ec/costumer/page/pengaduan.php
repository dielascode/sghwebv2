<main class="pengaduan-main">
    <div class="page-header-pengaduan">
        <h1>Formulir Pengaduan</h1>
        <p>Berikan pendapat Anda dengan jujur tentang apa yang Anda pikirkan</p>
    </div>

    <div class="divider-pengaduan"></div>

    <div class="form-card-pengaduan">
        <div class="field-group-pengaduan">
            <label>Subjek <span class="required-pengaduan">*</span></label>
            <input type="text" id="subjek" placeholder="Masukkan subjek pengaduan..." />
        </div>

        <div class="field-group-pengaduan">
            <label>Pesan Pengaduan <span class="required-pengaduan">*</span></label>
            <textarea id="pesan" placeholder="Ketik disini..."></textarea>
        </div>

        <div class="field-grid-pengaduan">
            <div class="field-group-pengaduan">
                <label>Nama Lengkap <span class="required-pengaduan">*</span></label>
                <div class="input-wrap-pengaduan">
                    <svg class="icon-pengaduan" width="15" height="15">...</svg>
                    <input type="text" id="nama" placeholder="Nama Anda" />
                </div>
            </div>

            <div class="field-group-pengaduan">
                <label>No Telepon</label>
                <div class="input-wrap-pengaduan">
                    <svg class="icon-pengaduan" width="15" height="15">...</svg>
                    <input type="tel" id="telepon" placeholder="08xx-xxxx-xxxx" />
                </div>
            </div>

            <div class="field-group-pengaduan">
                <label>E-mail</label>
                <div class="input-wrap-pengaduan">
                    <svg class="icon-pengaduan" width="15" height="15">...</svg>
                    <input type="email" id="email" placeholder="contoh: xxxtenta@contoh.com" />
                </div>
            </div>

            <div class="field-group-pengaduan">
                <label>Alamat</label>
                <div class="input-wrap-pengaduan">
                    <svg class="icon-pengaduan" width="15" height="15">...</svg>
                    <input type="text" id="alamat" placeholder="Jalan, Kota, Provinsi" />
                </div>
            </div>
        </div>

        <div id="successMsg" class="success-msg-pengaduan">
            ✅ Pengaduan Anda berhasil dikirim!
        </div>

        <button class="btn-submit-pengaduan" onclick="handleSubmit()">Kirim</button>
    </div>
</main>