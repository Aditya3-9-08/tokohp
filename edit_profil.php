<?php
include 'koneksi.php';

// Ambil data profil toko saat ini (Asumsinya hanya ada 1 toko dengan ID = 1)
$query = $pdo->query("SELECT * FROM profil_toko WHERE id = 1");
$toko = $query->fetch(PDO::FETCH_ASSOC);

// Proses update saat tombol simpan ditekan
if (isset($_POST['update'])) {
    $nama_toko = $_POST['nama_toko'];
    $deskripsi = $_POST['deskripsi'];
    $alamat    = $_POST['alamat'];
    $kontak    = $_POST['kontak'];
    $email     = $_POST['email'];
    $jam_kerja = $_POST['jam_kerja'];

    $sql = "UPDATE profil_toko SET nama_toko=?, deskripsi=?, alamat=?, kontak=?, email=?, jam_kerja=? WHERE id=1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_toko, $deskripsi, $alamat, $kontak, $email, $jam_kerja]);

    // Kembali ke halaman office jika sukses
    header("Location: office.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Toko - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <h1 class="page-title">Edit Profil Toko</h1>
            <div class="user-profile">
    <i class="fas fa-user-circle"></i> Admin SMK 
    <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        <div class="card" style="max-width: 600px;">
            <h3 class="card-title"><i class="fas fa-store" style="color: #0d47a1;"></i> Konfigurasi Data Toko</h3>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Toko</label>
                    <input type="text" name="nama_toko" value="<?php echo htmlspecialchars($toko['nama_toko']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Slogan / Deskripsi Singkat</label>
                    <input type="text" name="deskripsi" value="<?php echo htmlspecialchars($toko['deskripsi']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" required><?php echo htmlspecialchars($toko['alamat']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Nomor HP / Telepon (Kontak)</label>
                    <input type="text" name="kontak" value="<?php echo htmlspecialchars($toko['kontak']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Email Toko</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($toko['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Jam Kerja</label>
                    <input type="text" name="jam_kerja" value="<?php echo htmlspecialchars($toko['jam_kerja']); ?>" placeholder="Contoh: 08:00 - 17:00" required>
                </div>
                
                <div style="margin-top: 30px;">
                    <button type="submit" name="update" class="btn-dark" style="background-color: #3b82f6; margin-bottom: 0;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="office.php" style="margin-left:15px; color:#ef4444; text-decoration:none; font-weight: 500;">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>