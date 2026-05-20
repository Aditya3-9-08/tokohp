<?php 
session_start();
// Cek apakah ada sesi login. Jika tidak, tendang ke login.php!
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; 

// --- 1. AMBIL DATA UNTUK GRAFIK STOK HP (BAR CHART) ---
// Kita ambil maksimal 7 HP agar grafiknya tidak terlalu berdesakan
$query_stok = $pdo->query("SELECT merek, tipe, stok FROM handphone ORDER BY stok DESC LIMIT 7");
$nama_hp = [];
$jumlah_stok = [];
while ($row = $query_stok->fetch(PDO::FETCH_ASSOC)) {
    // Menggabungkan merek dan tipe (Contoh: "Samsung Galaxy S24")
    $nama_hp[] = $row['merek'] . ' ' . $row['tipe'];
    $jumlah_stok[] = $row['stok'];
}

// --- 2. AMBIL DATA UNTUK GRAFIK STATUS PESANAN (DOUGHNUT CHART) ---
$query_status = $pdo->query("SELECT status, COUNT(*) as total FROM pesanan GROUP BY status");
$label_status = [];
$jumlah_status = [];
while ($row = $query_status->fetch(PDO::FETCH_ASSOC)) {
    $label_status[] = $row['status'];
    $jumlah_status[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik - Admin</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 20px; }
        .chart-card { background: #ffffff; padding: 25px; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .chart-title { font-size: 16px; color: #1e293b; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">eProduct</div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Order</a></li>
            <li><a href="produk.php"><i class="fas fa-box"></i> Product</a></li>
            <li><a href="statistic.php" class="active"><i class="fas fa-chart-pie"></i> Statistic</a></li>
            <li><a href="office.php"><i class="fas fa-building"></i> Office</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Analytics & Reports</h1>
            <div class="user-profile"><i class="fas fa-user-circle"></i> Admin SMK</div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-bar" style="color: #2563eb;"></i> Ketersediaan Stok Produk (Top 7)</div>
                <canvas id="barChart" height="120"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-pie" style="color: #10b981;"></i> Rasio Status Pesanan</div>
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // --- 1. MENGGAMBAR BAR CHART (STOK) ---
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                // Mengambil data dari PHP dan mengubahnya ke Javascript
                labels: <?php echo json_encode($nama_hp); ?>,
                datasets: [{
                    label: 'Jumlah Stok (Unit)',
                    data: <?php echo json_encode($jumlah_stok); ?>,
                    backgroundColor: '#3b82f6', // Warna Biru Premium
                    borderRadius: 6, // Ujung batang melengkung
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // --- 2. MENGGAMBAR DOUGHNUT CHART (STATUS PESANAN) ---
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($label_status); ?>,
                datasets: [{
                    data: <?php echo json_encode($jumlah_status); ?>,
                    // Warna: Kuning untuk Pending, Hijau untuk Completed
                    backgroundColor: ['#f59e0b', '#10b981', '#3b82f6'], 
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                cutout: '70%', // Ketebalan lingkaran
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

</body>
</html>