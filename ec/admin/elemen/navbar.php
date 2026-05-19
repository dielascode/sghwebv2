<!-- Header -->
<header class="admin-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <!-- Logo/Brand - Now first on the left -->
            <a class="navbar-brand d-flex align-items-center" href="./index.html">
                <img src="./assets/images/logo.jpeg" alt="Logo" height="32" class="d-inline-block align-text-top me-2">
                <h1 class="h4 mb-0 fw-bold text-primary">AgriNexa</h1>
            </a>

            <!-- Sidebar Toggle -->
            <button class="hamburger-menu" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>


            <!-- Right Side Icons -->
            <div class="navbar-nav flex-row">
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary d-flex align-items-center"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="./assets/images/avatar-placeholder.svg"
                            alt="User Avatar"
                            width="24"
                            height="24"
                            class="rounded-circle me-2">

                        <!-- Nama User Dinamis -->
                        <span class="d-none d-md-inline">
                           <?= htmlspecialchars($_SESSION['nama'] ?? 'Guest'); ?>
                        </span>

                        <i class="bi bi-chevron-down ms-1"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?page=profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!-- Arahkan ke file logout yang menghapus session -->
                        <li><a class="dropdown-item text-danger" href="../../../sghwebv2/ec/logoutAdmin.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>