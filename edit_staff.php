<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data karyawan lama dari database
$query = $pdo->prepare("SELECT * FROM karyawan WHERE id = ?");
$query->execute([$id]);
$data = $query->fetch(PDO::FETCH_ASSOC);

// Jika tombol 'update' ditekan
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $posisi = $_POST['posisi'];
    $no_hp = $_POST['no_hp'];

    // Update data di database
    $sql = "UPDATE karyawan SET nama=?, posisi=?, no_hp=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $posisi, $no_hp, $id]);

    header("Location: office.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-group select {
            width: 100%; padding: 10px; border: 1px solid #cbd5e1;
            border-radius: 6px; font-family: 'Poppins', sans-serif;
            outline: none; background-color: white;
        }
        .form-group select:focus { border-color: #4f46e5; }
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
            <h1 class="page-title">Update Data Pegawai</h1>
            <div class="user-profile">
    <i class="fas fa-user-circle"></i> Admin SMK 
    <a href="logout.php" style="margin-left: 15px; color: #ef4444; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        <div class="card" style="max-width: 600px;">
            <h3 class="card-title"><i class="fas fa-user-edit" style="color: #0d47a1;"></i> Form Edit Pegawai</h3>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Posisi / Jabatan</label>
                    <select name="posisi" required>
                        <option value="Manager Toko" <?php if($data['posisi'] == 'Manager Toko') echo 'selected'; ?>>Manager Toko</option>
                        <option value="Admin / Kasir" <?php if($data['posisi'] == 'Admin / Kasir') echo 'selected'; ?>>Admin / Kasir</option>
                        <option value="Kurir" <?php if($data['posisi'] == 'Kurir') echo 'selected'; ?>>Kurir</option>
                        <option value="Teknisi Handphone" <?php if($data['posisi'] == 'Teknisi Handphone') echo 'selected'; ?>>Teknisi Handphone</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Nomor HP / WhatsApp</label>
                    <input type="number" name="no_hp" value="<?php echo htmlspecialchars($data['no_hp']); ?>" required>
                </div>
                
                <div style="margin-top: 30px;">
                    <button type="submit" name="update" class="btn-dark" style="background-color: #3b82f6; margin-bottom: 0;">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                    <a href="office.php" style="margin-left:15px; color:#ef4444; text-decoration:none; font-weight: 500;">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>