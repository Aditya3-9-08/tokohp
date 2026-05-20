<?php
include 'koneksi.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Proses hapus data dari tabel karyawan
    $sql = "DELETE FROM karyawan WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

// Kembali ke halaman office
header("Location: office.php");
exit;
?>