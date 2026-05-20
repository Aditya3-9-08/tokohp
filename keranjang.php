<?php
session_start();
include 'koneksi.php';

// Logika untuk menghapus barang dari keranjang
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['keranjang'][$id]);
    header("Location: keranjang.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Rismannet Phone</title>
    <link rel="stylesheet" href="style_toko.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar-user">
        <a href="beranda.php" class="logo"><i class="fas fa-mobile-alt"></i> Rismannet Phone</a>
        <div class="menu-center">
            <a href="beranda.php">Home</a>
    </nav>

    <div class="container">
        <h2 class="section-title" style="margin-top: 40px;">Keranjang Belanja Anda</h2>

        <div class="cart-container">
            <?php if(empty($_SESSION['keranjang'])) { ?>
                <div style="text-align: center; padding: 50px;">
                    <i class="fas fa-shopping-cart fa-4x" style="color: #cbd5e1; margin-bottom:20px;"></i>
                    <h3>Keranjang Anda masih kosong.</h3>
                    <p>Ayo cari handphone impianmu!</p>
                    <a href="beranda.php" class="btn-buy" style="display:inline-block; margin-top:20px;">Mulai Belanja</a>
                </div>
            <?php } else { ?>
                <table class="cart-table">
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $total_belanja = 0;
                    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                        $stmt = $pdo->prepare("SELECT * FROM handphone WHERE id = ?");
                        $stmt->execute([$id_produk]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $subtotal = $row['harga'] * $jumlah;
                        $total_belanja += $subtotal;
                    ?>
                    <tr>
                        <td><strong><?php echo $row['merek']; ?></strong> - <?php echo $row['tipe']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        <td>
                            <a href="keranjang.php?hapus=<?php echo $id_produk; ?>" style="color: #ef4444; text-decoration: none;">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" class="total-row">Total Pembayaran:</td>
                        <td colspan="2" class="total-row" style="color: #2563eb;">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></td>
                    </tr>
                </table>
                <div style="text-align: right;">
                    <a href="checkout.php" class="btn-checkout"><i class="fas fa-check-circle"></i> Proses Checkout</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>