<?php include('../elemen/navbar.php'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SGH POLIJE</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../style/costumer/profil.css">
</head>
<body>

    <div class="main-container" style="display: flex;">
        <?php include('../elemen/sidebar_profil.php'); ?>
     
        <main class="content">
            <div class="header-content">
                <h1>Profil saya</h1>
                <p>Kelola Informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
            </div>

            <form action="update_profil.php" method="POST" enctype="multipart/form-data" class="profile-grid">
                <div class="card photo-card">
                    <div class="photo-container">
                        <img src="profile_photo.jpg" alt="Foto Profil">
                    </div>
                    <p class="display-name">Aril Punk123</p>
                    <label for="upload-photo" class="btn-photo">
                        <i class="fa-solid fa-camera"></i> Ganti Foto
                    </label>
                    <input type="file" id="upload-photo" name="profile_image" hidden>
                </div>

                <div class="card info-card">
                    <h2>Informasi Akun</h2>
                    
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
</html>