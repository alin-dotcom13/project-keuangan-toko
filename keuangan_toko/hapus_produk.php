<?php
require_once 'config.php';
wajibLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM produk WHERE id_produk = ?');
    $stmt->execute([$id]);
}

header('Location: produk.php');
exit;