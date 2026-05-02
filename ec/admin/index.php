<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../loginAdmin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modern Bootstrap 5 Admin Template - Clean, responsive dashboard">
    <meta name="keywords" content="bootstrap, admin, dashboard, template, modern, responsive">
    <meta name="author" content="Bootstrap Admin Template">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Modern Bootstrap Admin Template">
    <meta property="og:description" content="Clean and modern admin dashboard template built with Bootstrap 5">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="./assets/icons/favicon.svg">
    <link rel="icon" type="image/png" href="./assets/icons/favicon.png">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Title -->
    <title>Dashboard - Modern Bootstrap Admin</title>

    <!-- Theme Color -->
    <meta name="theme-color" content="#21543C">
    <style>
    .table thead {
        background-color: #21543C;
        color: white;
    }

    .badge.bg-success {
        background-color: #21543C !important;
    }
</style>

    <!-- PWA Manifest -->
     <script>
    // Override ApexCharts SEBELUM chart dirender
    window.Apex = {
        colors: ['#21543C', '#10b981', '#f59e0b', '#ef4444', '#2d7a56', '#06b6d4']
    };
</script>
    <link rel="manifest" href="./assets/manifest-DTaoG9pG.json">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" crossorigin src="./assets/vendor-charts-DGwYAWel.js"></script>
    <script type="module" crossorigin src="./assets/vendor-ui-CflGdlft.js"></script>
    <script type="module" crossorigin src="./assets/main-B24LRf0x.js"></script>
    <link rel="stylesheet" crossorigin href="./assets/main-BQhM7myw.css">
    <link rel="stylesheet" href="./assets/theme-override.css">
</head>

<body data-page="dashboard" class="admin-layout">
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="admin-wrapper" id="admin-wrapper">
        <?php
        include "elemen/navbar.php";
        include "elemen/sidebar.php";
        ?>



        <!-- Main Content -->
        <main class="admin-main">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard.php';


            if ($page) {
                include "page/" . $page;
            } else {
                include "page/dashboard.php"; 
            }
            ?>
        </main>

        <?php
        include "elemen/footer.php";
        ?>
    </div> <!-- /.admin-wrapper -->
    </div>

    <!-- Toast Container -->
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toast-container"></div>
    </div>
    
</body>

</html>