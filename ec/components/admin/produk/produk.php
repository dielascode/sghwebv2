<!-- Halaman Percobaan -->

<?php
include "../../../logic/admin/produkController.php";

$produk = getProduk($conn);
?>


<h2>Daftar Produk</h2>

<?php foreach($produk as $p): ?>
    <p>
        <?php echo $p['nama_buah']; ?> 
        - <?php echo $p['nama_varietas']; ?>
        - Rp <?php echo $p['harga']; ?>
    </p>
<?php endforeach; ?>