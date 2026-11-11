<?php
require_once 'config.php';
wajibLogin();

// Mengambil data statistik
$totalProduk = (int)$pdo->query('SELECT COUNT(*) FROM produk')->fetchColumn();
$totalTransaksi = (int)$pdo->query('SELECT COUNT(*) FROM transaksi')->fetchColumn();
$totalPemasukan = (float)$pdo->query('SELECT COALESCE(SUM(total_harga),0) FROM transaksi')->fetchColumn();

// Mengambil 5 data transaksi terakhir untuk ditampilkan di dashboard
$stmt = $pdo->query('SELECT * FROM transaksi ORDER BY id_transaksi DESC LIMIT 5');
$transaksiTerakhir = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<h1>Dashboard</h1>
<p>Selamat datang, <strong><?= e($_SESSION['nama_kasir']) ?></strong>.</p>

<div class="grid">
    <div class="stat">
        <span>Jumlah Produk</span>
        <strong><?= $totalProduk ?></strong>
    </div>
    <div class="stat">
        <span>Jumlah Transaksi</span>
        <strong><?= $totalTransaksi ?></strong>
    </div>
    <div class="stat">
        <span>Total Pemasukan</span>
        <strong>Rp <?= number_format($totalPemasukan,0,',','.') ?></strong>
    </div>
</div>

<!-- Tabel Transaksi Terakhir -->
<div class="card" style="background: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 25px;">
    <h2 style="margin-top: 0; font-size: 18px; color: #312e81;">Transaksi Terbaru</h2>
    <?php if (count($transaksiTerakhir) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($transaksiTerakhir as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= e($t['nama_produk']) ?></td>
                    <td><?= e($t['jumlah']) ?></td>
                    <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                    <td><?= e($t['tanggal']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #64748b; font-style: italic; margin-bottom: 0;">Belum ada transaksi yang tercatat.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>