<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $merek = $_POST['merek'];
    $tipe = $_POST['tipe'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    
    $gambar = $_FILES['gambar']['name'];
    
    if($gambar != "") {
        $x = explode('.', $gambar);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar']['tmp_name'];   
        $nama_gambar_baru = rand(1,999).'-'.$gambar; 
        
        move_uploaded_file($file_tmp, 'images/'.$nama_gambar_baru); 
        $sql = "INSERT INTO handphone (merek, tipe, gambar, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$merek, $tipe, $nama_gambar_baru, $harga, $stok, $deskripsi]);
    } else {
        $sql = "INSERT INTO handphone (merek, tipe, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$merek, $tipe, $harga, $stok, $deskripsi]);
    }
    header("Location: produk.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Toko HP</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php" class="active"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="#"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header"><span><i class="fas fa-user-circle"></i> Admin SMK</span></div>
        <div class="content-body">
            <h1 class="page-title">Tambah Produk Baru</h1>
            <div class="card" style="max-width: 600px;">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group"><label>Merek Handphone</label><input type="text" name="merek" required></div>
                    <div class="form-group"><label>Tipe / Model</label><input type="text" name="tipe" required></div>
                    <div class="form-group"><label>Foto Produk (Opsional)</label><input type="file" name="gambar" style="padding: 5px;"></div>
                    <div class="form-group"><label>Harga (Rp)</label><input type="number" name="harga" required></div>
                    <div class="form-group"><label>Stok</label><input type="number" name="stok" required></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" rows="4"></textarea></div>
                    <button type="submit" name="simpan" class="btn-dark">Simpan Produk</button>
                    <a href="produk.php" style="margin-left:10px; color:#ef4444; text-decoration:none;">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>