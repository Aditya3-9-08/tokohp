<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cari nama file gambarnya dulu
    $query = $pdo->prepare("SELECT gambar FROM handphone WHERE id = ?");
    $query->execute([$id]);
    $data = $query->fetch(PDO::FETCH_ASSOC);
    
    // Hapus file gambar dari folder jika ada
    if(is_file("images/".$data['gambar'])) {
        unlink("images/".$data['gambar']);
    }
    
    // Hapus data dari database
    $sql = "DELETE FROM handphone WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}
header("Location: produk.php");
exit;
?>