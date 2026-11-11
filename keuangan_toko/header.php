<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="id">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Sistem Pencatatan Keuangan Toko</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>
      <header class="top">
          <div><strong>KasirKita - Keuangan Toko</strong></div>
          <?php if (!empty($_SESSION['id_kasir'])): ?>
      <nav>
      <a href="index.php">Dashboard</a>
      <a href="produk.php">Produk</a>
      <a href="transaksi.php">Transaksi</a>
      <a href="laporan.php">Laporan</a>
      <a href="logout.php">Keluar</a>
      </nav>
  <?php endif; ?>
</header>
<main class="container">
