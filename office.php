<?php 
session_start();
// Cek apakah ada sesi login. Jika tidak, tendang ke login.php!
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 

// Mengambil data profil toko dari database (id 1)
$query_toko = $pdo->query("SELECT * FROM profil_toko WHERE id = 1");
$toko = $query_toko->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office & HRD - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .office-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-top: 20px; }
        .store-profile { background: #f8fafc; padding: 30px; border-radius: 16px; border: 1px dashed #cbd5e1; text-align: center; }
        .store-logo { width: 100px; height: 100px; background: #0d47a1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px auto; }
        .info-list { text-align: left; margin-top: 20px; list-style: none; padding:0; }
        .info-list li { padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #475569; font-size: 14px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="statistic.php"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php" class="active"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Back Office & HRD</h1>
            <div class="user-profile">
    <i class="fas fa-user-circle"></i> Admin SMK 
    <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        <div class="office-grid">
            <div class="store-profile">
                <div class="store-logo">
                    <i class="fas fa-store"></i>
                </div>
                <h2 style="color: #1e293b; margin-bottom: 5px;"><?php echo htmlspecialchars($toko['nama_toko']); ?></h2>
                <p style="color: #64748b; font-size: 14px;"><?php echo htmlspecialchars($toko['deskripsi']); ?></p>
                
                <ul class="info-list">
                    <li><strong><i class="fas fa-map-marker-alt" style="width: 20px;"></i> Alamat:</strong> <span style="text-align: right;"><?php echo htmlspecialchars($toko['alamat']); ?></span></li>
                    <li><strong><i class="fas fa-phone" style="width: 20px;"></i> Kontak:</strong> <span><?php echo htmlspecialchars($toko['kontak']); ?></span></li>
                    <li><strong><i class="fas fa-envelope" style="width: 20px;"></i> Email:</strong> <span><?php echo htmlspecialchars($toko['email']); ?></span></li>
                    <li><strong><i class="fas fa-clock" style="width: 20px;"></i> Jam Kerja:</strong> <span><?php echo htmlspecialchars($toko['jam_kerja']); ?></span></li>
                </ul>
                
                <a href="edit_profil.php" class="btn-dark" style="display:block; text-align:center; width: 100%; margin-top: 20px; background-color: #3b82f6; text-decoration:none;">Edit Profile</a>
            </div>

            <div class="card" style="margin-top: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 class="card-title" style="margin-bottom: 0;">Daftar Pegawai (Staff)</h3>
                    <a href="tambah_staff.php" class="btn-dark" style="margin-bottom: 0; padding: 8px 15px;"><i class="fas fa-user-plus"></i> Tambah Staff</a>
                </div>
                
                <table>
                    <tr>
                        <th>ID Pegawai</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan / Posisi</th>
                        <th>Nomor HP</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                    <?php
                    $query = $pdo->query("SELECT * FROM karyawan ORDER BY id ASC");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td>#EMP-00<?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['nama']); ?></strong></td>
                        <td>
                            <?php if($row['posisi'] == 'Manager Toko') { ?>
                                <span style="background-color: #e0eafe; color: #0d47a1; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;"><?php echo $row['posisi']; ?></span>
                            <?php } else { ?>
                                <span style="background-color: #f1f5f9; color: #475569; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;"><?php echo $row['posisi']; ?></span>
                            <?php } ?>
                        </td>
                        <td style="color: #64748b;"><?php echo htmlspecialchars($row['no_hp']); ?></td>
                        <td style="text-align: center;">
                            <a href="edit_staff.php?id=<?php echo $row['id']; ?>" class="btn-icon bg-blue" title="Edit"><i class="fas fa-pen"></i></a>
                            <a href="hapus_staff.php?id=<?php echo $row['id']; ?>" class="btn-icon bg-red" title="Hapus" onclick="return confirm('Yakin hapus data pegawai ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</body>
</html>