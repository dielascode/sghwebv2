<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - SGH POLIJE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../style/costumer/ubahpassword.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="SGH POLIJE"> 
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
                <img src="../../images/contohprofil.jpeg" alt="User">
                <div class="user-text">
                    <p class="username">Username123</p>
                    <a href="profil.php" class="edit-link"><i class="fa-solid fa-pen"></i> Ubah Profil</a>
                </div>
            </div>
            
            <ul class="menu-list">
                <li class="active">
                    <a href="#"><i class="fa-solid fa-user"></i> Akun Saya</a>
                    <ul class="sub-menu">
                        <li><a href="profile.php">Profil</a></li>
                        <li><a href="alamatcustomer.php">Alamat</a></li>
                        <li class="active-sub"><a href="ubahpassword.php">Ubah Password</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa-regular fa-file-lines"></i> Pesanan Saya</a></li>
            </ul>
        </aside>

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