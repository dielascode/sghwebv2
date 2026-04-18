<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SGH POLIJE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../style/costumer/profil.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="../../../images/logo.png" alt="SGH POLIJE"> 
            </div>
            <ul class="nav-links">
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Produk</a></li>
            </ul>
            <div class="user-dropdown">
                <div class="user-info">
                    <i class="fa-regular fa-circle-user profile-icon"></i>
                    <span>Aril Gantenk</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <aside class="sidebar">
            <div class="sidebar-user">
                <img src="../../../images/contohprofil.jpeg" alt="User">
                <div class="user-text">
                    <p class="username">Username123</p>
                    <a href="#" class="edit-link"><i class="fa-solid fa-pen"></i> Ubah Profil</a>
                </div>
            </div>
            
            <ul class="menu-list">
                <li class="active">
                    <a href="#"><i class="fa-solid fa-user"></i> Akun Saya</a>
                    <ul class="sub-menu">
                        <li class="active-sub"><a href="#">Profil</a></li>
                        <li><a href="alamatcustomer.php">Alamat</a></li>
                        <li><a href="ubahpassword.php">Ubah Password</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa-regular fa-file-lines"></i> Pesanan Saya</a></li>
            </ul>
        </aside>

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

</body>
</html>