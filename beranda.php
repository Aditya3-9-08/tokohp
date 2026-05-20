<?php 
session_start();
include 'koneksi.php'; 

// Logika Keranjang (Tetap sama)
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $stmt = $pdo->prepare("SELECT stok FROM handphone WHERE id = ?");
    $stmt->execute([$id]);
    $hp = $stmt->fetch();
    
    $qty_di_keranjang = isset($_SESSION['keranjang'][$id]) ? $_SESSION['keranjang'][$id] : 0;
    
    if ($hp && $hp['stok'] > $qty_di_keranjang) {
        $_SESSION['keranjang'][$id] = $qty_di_keranjang + 1;
        header("Location: beranda.php#katalog");
        exit;
    } else {
        echo "<script>alert('Maaf, stok tidak mencukupi!');</script>";
    }
}

$total_item_keranjang = 0;
if(isset($_SESSION['keranjang'])) {
    $total_item_keranjang = array_sum($_SESSION['keranjang']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Handphone Premium</title>
    <link rel="stylesheet" href="style_toko.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar-user">
        <a href="beranda.php" class="logo">
            <i class="fas fa-signal" style="color: #2563eb;"></i> Rismannet Phone
        </a>
        
        <div class="menu-center">
            <a href="beranda.php">Home</a>
            <a href="#katalog">Products</a>
            <a href="#features">About Us</a>
        </div>

        <div class="menu-right">
            <a href="keranjang.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if($total_item_keranjang > 0) { echo "<span class='cart-badge'>$total_item_keranjang</span>"; } ?>
            </a>
            <a href="index.php" class="btn-admin">Login Admin</a>
        </div>
    </nav>

    <div class="hero-section">
        <div class="hero-box">
            <div class="hero-text">
                <h1>Tingkatkan Perjalanan Teknologi Anda</h1>
                <p>Temukan handphone impianmu dengan harga terbaik. Kualitas terjamin, stok selalu update, dan nikmati pengalaman berbelanja yang mudah bersama kami.</p>
                <div class="hero-buttons">
                    <a href="#katalog" class="btn-primary">Belanja Sekarang</a>
                    <a href="#features" class="btn-outline">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hero-image">
                <i class="fas fa-mobile-alt" style="transform: rotate(15deg);"></i>
            </div>
        </div>
    </div>

    <div class="container" id="katalog">
        <div class="section-header">
            <h2>Produk Unggulan</h2>
            <a href="#katalog" class="btn-see-all">Lihat Semua Produk</a>
        </div>

        <div class="product-grid">
            <?php
            $query = $pdo->query("SELECT * FROM handphone ORDER BY id DESC");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="product-card">
                <div class="product-img-box">
                    <?php if($row['gambar'] != "") { ?>
                        <img src="images/<?php echo $row['gambar']; ?>" alt="Foto HP">
                    <?php } else { ?>
                        <i class="fas fa-mobile fa-5x" style="color:#cbd5e1;"></i>
                    <?php } ?>
                </div>
                
                <div class="product-info">
                    <div class="product-brand"><?php echo htmlspecialchars($row['merek']); ?></div>
                    <div class="product-name"><?php echo htmlspecialchars($row['tipe']); ?></div>
                    <div class="product-price"><?php echo number_format($row['harga'], 0, ',', '.'); ?> IDR</div>
                    
                    <?php 
                    if($row['stok'] == 0) { 
                        echo '<div class="stock-danger">Out of Stock</div>';
                        echo '<a href="#" class="btn-buy btn-disabled">Stok Habis</a>';
                    } elseif ($row['stok'] <= 3) {
                        echo '<div class="stock-warning">Only '.$row['stok'].' left in stock!</div>';
                        echo '<a href="beranda.php?add='.$row['id'].'" class="btn-buy">Add to Cart</a>';
                    } else {
                        echo '<div class="stock-safe">In Stock: '.$row['stok'].'</div>';
                        echo '<a href="beranda.php?add='.$row['id'].'" class="btn-buy">Add to Cart</a>';
                    }
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="features-section" id="features">
        <h3>Rasakan Pengalaman Berbelanja yang Lebih Mudah Bersama Kami</h3>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-box-open"></i>
                <h4>Gratis Pengantaran</h4>
                <p>Dapatkan gratis ongkir untuk wilayah tertentu tanpa minimum pembelian. Pesanan aman sampai tujuan.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-store"></i>
                <h4>Penjemputan Mandiri</h4>
                <p>Beli online dan ambil langsung di toko kami (Rismannet Phone) tanpa antre panjang.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <h4>Garansi Resmi</h4>
                <p>Semua produk yang kami jual memiliki garansi resmi pabrik 1 tahun. Belanja tenang, hati senang.</p>
            </div>
        </div>
    </div>

</body>
</html>