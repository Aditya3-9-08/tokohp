<?php
session_start();
include 'koneksi.php';

// Jika tidak ada barang di keranjang, kembalikan ke beranda
if(empty($_SESSION['keranjang'])) {
    header("Location: beranda.php");
    exit;
}

$total_belanja = 0;
$daftar_barang = []; // Array untuk menampung nama-nama barang yang dibeli

// Proses loop untuk menghitung total dan mengurangi stok
foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
    // Ambil data produk berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM handphone WHERE id = ?");
    $stmt->execute([$id_produk]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Hitung subtotal dan total belanja
    $subtotal = $row['harga'] * $jumlah;
    $total_belanja += $subtotal;
    
    // Gabungkan merek, tipe, dan jumlahnya menjadi teks teks rapi
    // Contoh hasil: "Samsung Galaxy S24 (2 Pcs)"
    $daftar_barang[] = $row['merek'] . " " . $row['tipe'] . " (" . $jumlah . " Pcs)";
    
    // Kurangi stok di database
    $sql_stok = "UPDATE handphone SET stok = stok - ? WHERE id = ?";
    $stmt_stok = $pdo->prepare($sql_stok);
    $stmt_stok->execute([$jumlah, $id_produk]);
}

// Mengubah array daftar barang menjadi satu teks string panjang yang dipisahkan tanda koma
// Contoh hasil akhir: "Samsung Galaxy S24 (2 Pcs), iPhone 15 (1 Pcs)"
$item_dibeli = implode(", ", $daftar_barang);

// SIMPAN KE TABEL PESANAN
// Status otomatis diatur 'Pending' (Menunggu diproses oleh Admin)
$sql_pesanan = "INSERT INTO pesanan (item_dibeli, total_bayar, status) VALUES (?, ?, 'Pending')";
$stmt_pesanan = $pdo->prepare($sql_pesanan);
$stmt_pesanan->execute([$item_dibeli, $total_belanja]);

// Setelah berhasil mencatat ke database, kosongkan keranjang belanja
unset($_SESSION['keranjang']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Berhasil - iStore SMK</title>
    <link rel="stylesheet" href="style_toko.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container" style="text-align: center; margin-top: 100px;">
        <i class="fas fa-check-circle fa-5x" style="color: #10b981; margin-bottom: 20px;"></i>
        <h1 style="color: #1e293b;">Checkout Berhasil!</h1>
        <p style="color: #64748b; font-size: 18px; margin-top: 10px;">Terima kasih telah berbelanja di iStore SMK.<br>Pesanan Anda telah diteruskan ke Admin untuk diproses.</p>
        
        <br><br>
        <a href="beranda.php" class="btn-buy" style="display:inline-block; width:200px;">Kembali Belanja</a>
    </div>
</body>
</html>