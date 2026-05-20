<?php
session_start();
include 'koneksi.php';

// Jika admin sudah login, langsung arahkan ke index (tidak perlu login lagi)
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Menyandikan password yang diketik agar cocok dengan database

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    
    // Cek apakah data ditemukan
    if ($stmt->rowCount() > 0) {
        // Buat sesi login
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        
        // Pindah ke dashboard
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - iStore SMK</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Desain Khusus Halaman Login */
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #0d47a1, #1e3a8a); margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); width: 100%; max-width: 400px; text-align: center; }
        .login-logo { font-size: 50px; color: #0d47a1; margin-bottom: 10px; }
        .login-box h2 { color: #1e293b; margin-bottom: 30px; font-size: 24px; }
        .form-group { text-align: left; margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #64748b; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 15px; }
        .form-group input:focus { border-color: #0d47a1; }
        .btn-login { width: 100%; background-color: #0d47a1; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-login:hover { background-color: #1e3a8a; }
        .error-msg { background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="login-logo"><i class="fas fa-store"></i></div>
        <h2>Admin Panel Login</h2>
        
        <?php if($error != "") { ?>
            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn-login"><i class="fas fa-sign-in-alt"></i> Masuk Sekarang</button>
        </form>
        
        <div style="margin-top: 20px; font-size: 13px; color: #94a3b8;">
            <a href="beranda.php" style="color: #0d47a1; text-decoration: none;"><i class="fas fa-arrow-left"></i> Kembali ke Toko Utama</a>
        </div>
    </div>

</body>
</html>