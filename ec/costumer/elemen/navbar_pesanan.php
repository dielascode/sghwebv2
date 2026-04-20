<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navbar Profil</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .navbar-custom {
            background-color: #114029;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            padding: 12px 30px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            font-size: 20px;
            color: #ffffff;
            margin: 0 15px;
        }

        .navbar-nav .nav-link.active {
            font-weight: 500;
            font-size: 20px;
            color: #ffffff;
            margin: 0 15px;
        }

        .profile-btn {
            background: #F1FAF4;
            border-radius: 20px;
            padding: 2px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
        }

        .profile-btn:hover {
            background: #dce8df;
        }

        .logo-img {
            height: 35px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">

            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="http://localhost/semester%202/proyek%20SGH/sghwebv2/ec/images/navbar/logosgh.png" alt="Logo SGH" style="height:50px;">
            </a>

            <!-- Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Tengah -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Produk</a>
                    </li>
                </ul>
            </div>

            <!-- Profil Dropdown -->
            <div class="dropdown">
                <button class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-4"></i>
                    Aril Ganteng
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                    <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>