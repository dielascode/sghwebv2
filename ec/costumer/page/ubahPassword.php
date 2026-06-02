
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

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 0.75rem 1rem; border: 1px solid #e3342f; color: #e3342f; background: #fcebea; border-radius: 0.5rem;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: 1rem; padding: 0.75rem 1rem; border: 1px solid #38c172; color: #38c172; background: #e3fcec; border-radius: 0.5rem;">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="logic/costumer/handleubahPassword.php" method="POST">

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