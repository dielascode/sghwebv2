<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/katalog.css?v=16">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/sidebar.css?v=8">
    <link rel="stylesheet" href="/sghwebv2/ec/style/costumer/pemesanan.css?v=1">
</head>
<body class="m-0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php 
        include "components/costumer/elemen/navbar.php"
    ?>
    <main class="main">
        <div id="conten">
            <?php 
                include "components/costumer/page/katalog.php"
            ?>
        </div>
    </main>
    <script src="/sghwebv2/ec/js/loadnavbar.js"></script>
</body>
</html>