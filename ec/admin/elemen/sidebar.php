<!-- Sidebar -->
<aside class="admin-sidebar" id="admin-sidebar">
    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="?page=dashboard.php">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=pemesanan.php">
                        <i class="bi bi-bag-check"></i>
                        <span>Data Pemesanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#elementsSubmenu" aria-expanded="false">
                        <i class="bi bi-puzzle"></i>
                        <span>Master Data</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="elementsSubmenu">
                        <ul class="nav nav-submenu">
                            <li class="nav-item">
                                <a class="nav-link" href="?page=data-costumer.php">
                                    <i class="bi bi-grid"></i>
                                    <span>Data Costumer</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=data-produk.php">
                                    <i class="bi bi-grid"></i>
                                    <span>Data Produk</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=data-buah.php">
                                    <i class="bi bi-grid"></i>
                                    <span>Data Buah</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=data-varietas.php">
                                    <i class="bi bi-grid"></i>
                                    <span>Data Varietas</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=data-pengaduan.php">
                        <i class="bi bi-graph-up"></i>
                        <span>Data Pengaduan</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "superadmin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=data-admin.php">
                            <i class="bi bi-person"></i>
                            <span>Data Admin</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item mt-3">
                    <small class="text-muted px-3 text-uppercase fw-bold">Admin</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./settings.html">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./security.html">
                        <i class="bi bi-shield-check"></i>
                        <span>Security</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./help.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Help & Support</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Sidebar Backdrop (mobile overlay) -->
<div class="sidebar-backdrop" aria-hidden="true"></div>