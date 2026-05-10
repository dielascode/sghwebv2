<body>


    <div class="container-pesanan d-flex">
        <!-- SIDEBAR -->
        <?php include "../elemen/sidebar_profil.php"; ?>
        <main class="content-profil">
            <div class="header-content">
                <h1>Informasi Akun</h1>
                <p>Kelola Informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
            </div>

            <form action="update_profil.php" method="POST" enctype="multipart/form-data" class="profile-grid">
                <div class="card-profil photo-card">
                    <div class="photo-container">
                        <img src="/sghwebv2/ec/images/profil.jpg" alt="Foto Profil">
                    </div>
                    <p class="display-name">Faiq Imup</p>
                    <label for="upload-photo" class="btn-photo">
                        <i class="fa-solid fa-camera"></i> Ganti Foto
                    </label>
                    <input type="file" id="upload-photo" name="profile_image" hidden>
                </div>

                <div class="ps-card">

                    <div class="ps-head">
                        <p class="ps-title">Profil Saya</p>
                        <button type="button" class="ps-edit-btn" id="editBtn" onclick="toggleEdit()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                <path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4z" />
                            </svg>
                            Edit Profil
                        </button>
                    </div>

                    <div class="ps-divider"></div>

                    <!-- VIEW MODE -->
                    <div class="ps-fields" id="viewMode">
                        <div class="ps-row">
                            <span class="ps-row__label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                                Username
                            </span>
                            <span class="ps-row__value" id="v-username">faiqimup</span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-row__label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                                Nama Lengkap
                            </span>
                            <span class="ps-row__value" id="v-nama">Faiq Imup</span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-row__label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                Email
                            </span>
                            <span class="ps-row__value" id="v-email">faiqimup@email.com</span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-row__label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 012 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L6.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0122 16.92z" />
                                </svg>
                                Nomor Telepon
                            </span>
                            <span class="ps-row__value" id="v-telepon">+62 812-3456-7890</span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-row__label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="9" r="5" />
                                    <path d="M12 14v7M9 18h6" />
                                </svg>
                                Jenis Kelamin
                            </span>
                            <span class="ps-pill" id="v-gender">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11"
                                    height="11">
                                    <circle cx="12" cy="9" r="5" />
                                    <path d="M12 14v7M9 18h6" />
                                </svg>
                                Laki-laki
                            </span>
                        </div>
                    </div>

                    <!-- EDIT MODE -->
                    <div id="editMode" style="display:none;">
                        <div class="ps-fields">
                            <div class="ps-edit-row">
                                <span class="ps-edit-row__label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                    </svg>
                                    Username
                                </span>
                                <input class="ps-input" id="e-username" type="text" value="faiqimup" />
                            </div>
                            <div class="ps-edit-row">
                                <span class="ps-edit-row__label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                    Nama Lengkap
                                </span>
                                <input class="ps-input" id="e-nama" type="text" value="Faiq Imup" />
                            </div>
                            <div class="ps-edit-row">
                                <span class="ps-edit-row__label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                    Email
                                </span>
                                <input class="ps-input" id="e-email" type="email" value="faiqimup@email.com" />
                            </div>
                            <div class="ps-edit-row">
                                <span class="ps-edit-row__label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 012 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L6.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0122 16.92z" />
                                    </svg>
                                    Nomor Telepon
                                </span>
                                <input class="ps-input" id="e-telepon" type="tel" value="+62 812-3456-7890" />
                            </div>
                            <div class="ps-edit-row">
                                <span class="ps-edit-row__label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="9" r="5" />
                                        <path d="M12 14v7M9 18h6" />
                                    </svg>
                                    Jenis Kelamin
                                </span>
                                <div class="ps-gender-wrap">
                                    <label class="ps-radio checked" id="r-laki" onclick="selectGender('Laki-laki')">
                                        <span class="ps-radio__dot"></span>
                                        Laki-laki
                                    </label>
                                    <label class="ps-radio" id="r-perempuan" onclick="selectGender('Perempuan')">
                                        <span class="ps-radio__dot"></span>
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="ps-actions">
                            <button type="button" class="ps-btn ps-btn--ghost" onclick="toggleEdit()">Batal</button>
                            <button type="button" class="ps-btn ps-btn--primary" onclick="simpan()">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </div>    
            </form>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let editing = false;
        let gender = 'Laki-laki';

        function toggleEdit() {
            editing = !editing;
            document.getElementById('viewMode').style.display = editing ? 'none' : 'flex';
            document.getElementById('editMode').style.display = editing ? 'block' : 'none';
            const btn = document.getElementById('editBtn');
            if (editing) {
                btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Batal`;
                btn.classList.add('cancel');
            } else {
                btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4z"/></svg> Edit Profil`;
                btn.classList.remove('cancel');
            }
        }

        function selectGender(val) {
            gender = val;
            document.getElementById('r-laki').classList.toggle('checked', val === 'Laki-laki');
            document.getElementById('r-perempuan').classList.toggle('checked', val === 'Perempuan');
        }

        function simpan() {
            document.getElementById('v-username').textContent = document.getElementById('e-username').value;
            document.getElementById('v-nama').textContent = document.getElementById('e-nama').value;
            document.getElementById('v-email').textContent = document.getElementById('e-email').value;
            document.getElementById('v-telepon').textContent = document.getElementById('e-telepon').value;
            const icon = gender === 'Laki-laki'
                ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><circle cx="12" cy="9" r="5"/><path d="M12 14v7M9 18h6"/></svg>`
                : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><circle cx="12" cy="9" r="5"/><path d="M12 14v4"/><path d="M9 16.5h6"/></svg>`;
            document.getElementById('v-gender').innerHTML = icon + ' ' + gender;
            toggleEdit();
        }
    </script>
</body>