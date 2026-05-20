<?php
$host = "localhost";
$user = "ojokerro_chale"; 
$pass = "chaleya0319";     
$db   = "ojokerro_tokohp";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>