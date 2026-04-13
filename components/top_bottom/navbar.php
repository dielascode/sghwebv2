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

            <a class="navbar-brand d-none d-lg-block" href="#">
                <img src="images/navbar/logo-polije.png" alt="Logo Polije" style="height: 50px;">
            </a>
            <a class="navbar-brand d-none d-lg-block" href="#">
                <img src="images/navbar/logo-blu.png" alt="Logo Polije" style="height: 50px;">
            </a>
            <a class="navbar-brand d-none d-lg-block" href="#">
                <img src="images/navbar/dikti.png" alt="Logo Polije" style="height: 50px;">
            </a>
        </div>

    </div>
</nav>

