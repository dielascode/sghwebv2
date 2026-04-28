
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
                <div class="card photo-card">
                    <div class="photo-container">
                        <img src="/sghwebv2/ec/images/profil.jpg" alt="Foto Profil">
                    </div>
                    <p class="display-name">Faiq Imup</p>
                    <label for="upload-photo" class="btn-photo">
                        <i class="fa-solid fa-camera"></i> Ganti Foto
                    </label>
                    <input type="file" id="upload-photo" name="profile_image" hidden>
                </div>

                <div class="card info-card">
                    <h2>Profil Saya</h2>
                    
                    <div class="input-group">
                        <label><i class="fa-solid fa-user"></i> Username</label>
                        <input type="text" name="username" placeholder="">
                    </div>

                    <div class="input-group">
                        <label><i class="fa-solid fa-user-tag"></i> Nama</label>
                        <input type="text" name="nama" placeholder="">
                    </div>

                    <div class="input-group">
                        <label><i class="fa-solid fa-envelope"></i> Email</label>
                        <input type="email" name="email" placeholder="">
                    </div>

                    <div class="input-group">
                        <label><i class="fa-solid fa-phone"></i> Nomor Telepon</label>
                        <input type="text" name="telepon" placeholder="">
                    </div>

                    <div class="input-group">
                        <label>Jenis Kelamin:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="gender" value="Laki-laki"> Laki-Laki</label>
                            <label><input type="radio" name="gender" value="Perempuan"> Perempuan</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
