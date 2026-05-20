<?php 
session_start();
// Cek apakah ada sesi login. Jika tidak, tendang ke login.php!
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 

// LOGIKA UPDATE STATUS PESANAN
// Jika admin mengklik tombol centang/proses, ubah status di database menjadi 'Completed'
if (isset($_GET['proses_id'])) {
    $id_pesanan = $_GET['proses_id'];
    $stmt = $pdo->prepare("UPDATE pesanan SET status = 'Completed' WHERE id = ?");
    $stmt->execute([$id_pesanan]);
    header("Location: order.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php" class="active"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="statistic.php"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Incoming Orders</h1>
           <div class="user-profile">
    <i class="fas fa-user-circle"></i> Admin SMK 
    <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        <div class="card" style="margin-top: 0;">
            <h3 class="card-title">Tabel Daftar Pesanan Masuk</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Date & Time</th>
                    <th>Items Ordered</th>
                    <th>Total Payment</th>
                    <th>Status</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                <?php
                // Ambil data pesanan, urutkan dari yang paling baru masuk
                $query = $pdo->query("SELECT * FROM pesanan ORDER BY id DESC");
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td>#ORD-<?php echo $row['id']; ?></td>
                    <td style="color: #64748b; font-size: 13px;"><?php echo $row['tanggal']; ?></td>
                    <td><span style="font-weight: 500;"><?php echo htmlspecialchars($row['item_dibeli']); ?></span></td>
                    <td style="font-weight: 600; color: #2563eb;">Rp <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                    <td>
                        <?php if($row['status'] == 'Pending') { ?>
                            <span style="background-color: #fef3c7; color: #d97706; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;"><i class="fas fa-clock"></i> Pending</span>
                        <?php } else { ?>
                            <span style="background-color: #d1fae5; color: #059669; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;"><i class="fas fa-check-circle"></i> Completed</span>
                        <?php } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if($row['status'] == 'Pending') { ?>
                            <a href="order.php?proses_id=<?php echo $row['id']; ?>" class="btn-icon" style="background-color: #10b981;" title="Mark as Completed">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php } else { ?>
                            <span style="color: #cbd5e1;"><i class="fas fa-check-double"></i> Done</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>