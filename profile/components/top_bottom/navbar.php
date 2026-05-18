<?php
session_name('sghwebv2_session');
session_start();

$sudah_login = isset($_SESSION['id']);
// // DEBUG sementara
// var_dump($sudah_login);  
// var_dump($_SESSION);
?>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <img src="images/navbar/logosgh.png" alt="Logo SGH" style="height: 50px;">
        </a>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSGH">
    <i class="fa-solid fa-bars"></i>
</button>



        <div class="collapse navbar-collapse" id="navbarSGH">
            <ul class="navbar-nav mx-auto gap-2">

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('components/pages/main.php')">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('components/pages/tentang.php')">Tentang</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Layanan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"
                                onclick="loadPage('components/pages/layanan-magang.php')">Magang</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="loadPage('components/pages/layanan-penelitian.php')">Penelitian</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="loadPage('components/pages/layanan-praktik.php')">Praktikum</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="loadPage('components/pages/layanan-studibanding.php')">Studi Banding</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('components/pages/produk.php')">Produk</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"
                                onclick="loadPage('components/pages/mitra-daftar.php')">Mitra</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"
                                onclick="loadPage('components/pages/berita.php')">Berita</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('components/pages/galeri.php')">Galeri</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadPage('components/pages/hubungi.php')">Hubungi Kami</a>
                </li>
            </ul>

        </div>
 <!-- Hapus 3 logo kanan yang lama, ganti dengan ini -->
<div class="d-none d-lg-flex align-items-center gap-3 ms-3">
    
    <!-- Logo kecil saja tanpa brand wrapper -->
    <img src="images/navbar/logo-polije.png" style="height: 35px; opacity: 0.85;">
    <img src="images/navbar/logo-blu.png"    style="height: 35px; opacity: 0.85;">
    <img src="images/navbar/dikti.png"       style="height: 35px; opacity: 0.85;">

    <!-- Garis pemisah -->
    <div style="width: 1px; height: 30px; background: #ccc;"></div>

    <!-- Button minimalis -->
   <?php if ($sudah_login): ?>
    <!-- Sudah login, tampilkan tombol ke e-commerce -->
    <a href="../../../sghwebv2/ec/index.php" 
        style="background: #2d6a4f; color: #fff; font-weight: 600; font-size: 0.88rem;
                padding: 6px 18px; border-radius: 20px; text-decoration: none;">
        E-Commerce
    </a>
<?php else: ?>
    <!-- Belum login -->
    <a href="../../../sghwebv2/ec/login.php" 
        style="color: #2d6a4f; font-weight: 600; font-size: 0.88rem; text-decoration: none;">
        Login
    </a>
    <a href="../../../sghwebv2/ec/registrasi.php"   
        style="background: #2d6a4f; color: #fff; font-weight: 600; font-size: 0.88rem;
                padding: 6px 18px; border-radius: 20px; text-decoration: none;">
        Daftar
    </a>
<?php endif; ?>

    </div>
</nav>
