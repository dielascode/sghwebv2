<?php include('../elemen/navbar_pesanan.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - SGH POLIJE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../style\costumer/ubahpassword.css">
</head>
<body>
    <div class="main-container" style="display: flex;">
        <?php include('../elemen/sidebar_profil.php'); ?>

        <main class="content">
            <div class="pw-card">
                <h2>Ubah Password</h2>
                <hr class="divider">

                <form action="proses_update_pw.php" method="POST">
                    <div class="form-group-pw">
                        <label>Password Lama</label>
                        <input type="password" name="old_password" required>
                    </div>

                    <div class="form-group-pw">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" required>
                    </div>

                    <div class="form-group-pw">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" required>
                    </div>

                    <div class="btn-container-center">
                        <button type="submit" class="btn-ubah">Ubah</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>