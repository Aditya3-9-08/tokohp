<?php
session_start();
session_destroy(); // Menghancurkan semua sesi login
header("Location: login.php"); // Kembalikan ke halaman login
exit;
?>