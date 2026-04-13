<!-- Halaman Percobaan -->

<?php
include __DIR__ . "../../../logic/admin/produkController.php";

$produk = getProduk($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Proddkjkjkhkjhsakdkjhaskdhjjhkasdjhjhasdbbasdbhb uk Sementara</title>
</head>

<body>
    <h2>Data Produk</h2>
    <table>
        <tr>
            <th>no</th>
            <th>nama barang</th>
            <th>jumlah</th>
            <th>harga</th>
        </tr>
        <tr>
            <?php foreach ($produk as $p): ?>
                <td>
                    <?php echo $p['nama_buah']; ?>
                    - <?php echo $p['nama_varietas']; ?>
                    - Rp <?php echo $p['harga']; ?>
                </td>
            <?php endforeach; ?>
            
        </tr>
    </table>
</body>

</html>
<h2>Daftar Produk</h2>
