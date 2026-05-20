<?php 
session_start();
// Cek apakah ada sesi login. Jika tidak, tendang ke login.php!
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 

// 1. Menghitung Total Jenis Handphone
$query_produk = $pdo->query("SELECT COUNT(*) as total FROM handphone");
$total_produk = $query_produk->fetch()['total'];

// 2. Menghitung Total Semua Fisik Stok HP
$query_stok = $pdo->query("SELECT SUM(stok) as total_stok FROM handphone");
$total_stok = $query_stok->fetch()['total_stok'] ?? 0; // Jika kosong, tampilkan 0

// 3. Menghitung Jumlah HP yang stoknya menipis (di bawah 3)
$query_kritis = $pdo->query("SELECT COUNT(*) as stok_kritis FROM handphone WHERE stok <= 3");
$stok_kritis = $query_kritis->fetch()['stok_kritis'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - iStore</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <body>
    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="statistic.php"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Dashboard Overview</h1>
            <div class="user-profile">
                <i class="fas fa-user-circle"></i> Admin SMK 
                <a href="logout.php" style="color: #ef4444; margin-left: 10px;">Logout</a>
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon icon-blue"><i class="fas fa-mobile-alt"></i></div>
                <div class="summary-info">
                    <p>Total Products</p>
                    <h3>0 Items</h3>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon icon-green"><i class="fas fa-boxes"></i></div>
                <div class="summary-info">
                    <p>Total Stock Unit</p>
                    <h3>0 Pcs</h3>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon icon-red"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="summary-info">
                    <p>Low Stock Alert</p>
                    <h3>0 Items</h3>
                </div>
            </div>
        </div>
    </div>
</body>

</body>
</html>