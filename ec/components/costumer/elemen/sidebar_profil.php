<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidebar Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
    width: 250px;
    padding: 20px;
    }

        .sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 30px;
    }

        .sidebar-user img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    }

        .username { font-weight: 600; font-size: 14px; }
        .edit-link { font-size: 12px; color: var(--text-muted); text-decoration: none; }

        .menu-list { list-style: none; }
        .menu-list li a {
    text-decoration: none;
    color: #333;
    display: block;
    padding: 10px 0;
    font-weight: 500;
    }

        .sub-menu {
    list-style: none;
    padding-left: 25px;
    }

        .sub-menu li a {
    font-weight: 400;
    font-size: 13px;
    color: #555;
    padding: 8px 0;
    }

    .active-sub a {
    color: #45a778 !important;
    font-weight: 600 !important;
    }
    </style>
</head>

<body>

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
</body>

</html>