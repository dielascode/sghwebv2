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
   
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/katalog.css?v=25">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/sidebar.css?v=8">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pesanan.css?v=4">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pembayaran.css?v=6">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pemesanan.css?v=7">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/ubahpassword.css?v=6">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/alamatcustomer.css?v=7">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/keranjangStyles.css?v=22">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/profil.css?v=23">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/sidebarprofil.css?v=22">
</head>
<body class="m-0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php 
        include "costumer/elemen/navbar.php"
    ?>
    <main class="main">
        <div id="conten" >
            <?php 
                include "costumer/page/katalog.php"
            ?>
        </div>
    </main>
    <script src="/sghwebv2/ec/js/loadnavbar.js"></script>
</body>
</html>