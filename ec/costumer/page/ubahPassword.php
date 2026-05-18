
<body>
    
    <div class="container-pesanan d-flex">
        <!-- SIDEBAR -->
        <?php include __DIR__ . "/../elemen/sidebar_profil.php"; ?>
        <main class="content">
    <div class="pw-card">
        
        <div class="pw-header">
            <h2>Ubah Password</h2>
            <p>Pastikan password Anda kuat dan aman</p>
        </div>

        <form action="/sghwebv2/ec/logic/costumer/handleubahPassword.php" method="POST">

            <div class="form-group-pw">
                <label>Password Lama</label>
                <input type="password" name="old_password" placeholder="Masukkan password lama" required>
            </div>

            <div class="form-group-pw">
                <label>Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan password baru" required>
                <small class="hint">Minimal 8 karakter.</small>
            </div>

            <div class="form-group-pw">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" placeholder="Konfirmasi password baru" required>
            </div>

            <div class="btn-container-center">
                <button type="submit" class="btn-ubah">
                    Simpan Password
                </button>
            </div>

        </form>
    </div>
</main>
    </div>

</body>
</html>