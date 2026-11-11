<?php
session_start();

$host = 'localhost';
$db   = 'keuangan_toko';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('Koneksi database gagal. Periksa pengaturan config.php dan MySQL.');
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function wajibLogin() {
    if (empty($_SESSION['id_kasir'])) {
        header('Location: login.php');
        exit;
    }
}
