<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Agro Smart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../style/costumer/keranjangStyles.css">
</head>
<body>

    <?php include('../elemen/navbar.php'); ?>

    <main class="cart-wrapper">
        <div class="container">
            <h1 class="page-title">Keranjang Saya</h1>
            <p class="product-count">4 Produk</p>

            <div class="cart-grid">
                <section class="cart-items-section">
                    <div class="select-all-bar">
                        <label class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            Pilih Semua
                        </label>
                        <button class="btn-delete-selected">Hapus Dipilih</button>
                    </div>

                    <div class="cart-card">
                        <label class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>
                        <div class="product-img">
                            <img src="../../../images/melon1.jpg" alt="Melon Honey Globe">
                        </div>
                        <div class="product-info">
                            <h3>Melon</h3>
                            <p class="sub-name">Honey Globe</p>
                            <div class="action-row">
                                <div class="qty-picker">
                                    <button>-</button>
                                    <input type="text" value="1">
                                    <button>+</button>
                                </div>
                                <span class="badge-stock">Stok Tersedia</span>
                            </div>
                        </div>
                        <div class="product-price">
                            Rp 30.000
                        </div>
                    </div>

                    <div class="cart-card">
                        <label class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>
                        <div class="product-img">
                            <img src="../../../images/melon1.jpg" alt="Melon0">
                        </div>
                        <div class="product-info">
                            <h3>Melon</h3>
                            <p class="sub-name">Premium Quality</p>
                            <div class="action-row">
                                <div class="qty-picker">
                                    <button>-</button>
                                    <input type="text" value="2">
                                    <button>+</button>
                                </div>
                                <span class="badge-stock">Stok Tersedia</span>
                            </div>
                        </div>
                        <div class="product-price">
                            Rp 45.000
                        </div>
                    </div>

                    <div class="cart-card">
                        <label class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>
                        <div class="product-img">
                            <img src="../../../images/melon1.jpg" alt="Melon1">
                        </div>
                        <div class="product-info">
                            <h3>Melon</h3>
                            <p class="sub-name">Manis & Segar</p>
                            <div class="action-row">
                                <div class="qty-picker">
                                    <button>-</button>
                                    <input type="text" value="1">
                                    <button>+</button>
                                </div>
                                <span class="badge-stock">Stok Tersedia</span>
                            </div>
                        </div>
                        <div class="product-price">
                            Rp 25.000
                        </div>
                    </div>

                    <div class="cart-card">
                        <label class="checkbox-container">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                        </label>
                        <div class="product-img">
                            <img src="../../../images/melon1.jpg" alt="Melon2">
                        </div>
                        <div class="product-info">
                            <h3>Melon</h3>
                            <p class="sub-name">Pilihan Utama</p>
                            <div class="action-row">
                                <div class="qty-picker">
                                    <button>-</button>
                                    <input type="text" value="3">
                                    <button>+</button>
                                </div>
                                <span class="badge-stock">Stok Tersedia</span>
                            </div>
                        </div>
                        <div class="product-price">
                            Rp 20.000
                        </div>
                    </div>

                    </section>

                <aside class="cart-summary">
                    <div class="summary-card">
                        <h2>Ringkasan Pesanan</h2>
                        <div class="summary-details">
                            <div class="summary-line">
                                <span>Subtotal (7 Item)</span>
                                <span>Rp. 205.000</span>
                            </div>
                            <hr class="divider">
                            <div class="summary-line total">
                                <span>Total Pembayaran</span>
                                <span class="total-price">Rp. 205.000</span>
                            </div>
                        </div>
                        <button class="btn-next">Selanjutnya</button>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>