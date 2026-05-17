<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <?php $b = __DIR__ . '/style/costumer/'; ?>
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/katalog.css?v=<?= filemtime($b.'katalog.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/sidebar.css?v=<?= filemtime($b.'sidebar.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pesanan.css?v=<?= filemtime($b.'pesanan.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pembayaran.css?v=<?= filemtime($b.'pembayaran.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pemesanan.css?v=<?= filemtime($b.'pemesanan.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/ubahpassword.css?v=<?= filemtime($b.'ubahpassword.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/alamatcustomer.css?v=<?= filemtime($b.'alamatcustomer.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/keranjangStyles.css?v=<?= filemtime($b.'keranjangStyles.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/profil.css?v=<?= filemtime($b.'profil.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/sidebarprofil.css?v=<?= filemtime($b.'sidebarprofil.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/popupproduk.css?v=<?= filemtime($b.'popupproduk.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/detailorder.css?v=<?= filemtime($b.'detailorder.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pengaduanStyles.css?v=<?= filemtime($b.'pengaduanStyles.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/dummysukses.css?v=<?= filemtime($b.'dummysukses.css') ?>">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/footer.css?v=<?= filemtime($b.'footer.css') ?>">
</head>
<body class="m-0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php 
        include "costumer/elemen/navbar.php"
    ?>
    <main class="main">
        <div id="conten">
    <?php 
        $page = $_GET['page'] ?? 'katalog';

        if ($page == 'profile') {
            include "costumer/page/profile.php";
        } elseif ($page == 'alamat') {
            include "costumer/page/alamatcustomer.php";
        } elseif ($page == 'password') {
            include "costumer/page/ubahPassword.php";
        } else {
            include "costumer/page/katalog.php";
        }
    ?>
</div>
        
    </main>
    <?php 
        include "costumer/elemen/footer.php"
    ?>
    <script src="/sghwebv2/ec/js/loadnavbar.js"></script>
    <script src="/sghwebv2/ec/js/keranjang.js"></script>
    <script src="/sghwebv2/ec/js/katalog.js"></script>
    <script src="/sghwebv2/ec/js/profile.js"></script>
    <script src="/sghwebv2/ec/js/pesanan-nilai-invoice.js"></script>
</body>
</html>