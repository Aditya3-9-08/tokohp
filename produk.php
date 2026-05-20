<?php 
session_start();
// Cek apakah ada sesi login. Jika tidak, tendang ke login.php!
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>function konfirmasiHapus() { return confirm("Yakin ingin menghapus produk ini?"); }</script>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php" class="active"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="statistic.php"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Manage Products</h1>
            <div class="user-profile">
    <i class="fas fa-user-circle"></i> Admin SMK 
    <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        <a href="tambah.php" class="btn-dark"><i class="fas fa-plus"></i> Add New Product</a>

        <table>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Brand & Model</th>
                <th>Price</th>
                <th>Stock</th>
                <th style="text-align: center;">Action</th>
            </tr>
            <?php
            $query = $pdo->query("SELECT * FROM handphone ORDER BY id DESC");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td>
                    <?php if($row['gambar'] != "") { ?>
                        <img src="images/<?php echo $row['gambar']; ?>" class="img-thumbnail">
                    <?php } else { ?>
                        <div style="width:50px; height:50px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-image" style="color:#cbd5e1;"></i></div>
                    <?php } ?>
                </td>
                <td>
                    <strong><?php echo htmlspecialchars($row['merek']); ?></strong><br>
                    <small style="color: #64748b;"><?php echo htmlspecialchars($row['tipe']); ?></small>
                </td>
                <td style="font-weight: 500;">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td>
                    <?php if($row['stok'] <= 3) { ?>
                        <span style="color: #dc2626; font-weight:bold;"><i class="fas fa-circle" style="font-size:8px;"></i> <?php echo $row['stok']; ?> left</span>
                    <?php } else { ?>
                        <span style="color: #059669; font-weight:bold;"><i class="fas fa-circle" style="font-size:8px;"></i> <?php echo $row['stok']; ?> Pcs</span>
                    <?php } ?>
                </td>
                <td style="text-align: center;">
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-icon bg-blue"><i class="fas fa-cog"></i></a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-icon bg-red" onclick="return konfirmasiHapus()"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>