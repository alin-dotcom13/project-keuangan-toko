<?php
require_once 'config.php';
wajibLogin();
$rows = $pdo->query('SELECT DATE(t.tanggal) AS tanggal, COUNT(*) AS jumlah_transaksi, SUM(t.total_harga) AS pemasukan FROM transaksi t GROUP BY DATE(t.tanggal) ORDER BY tanggal DESC')->fetchAll();
$total = (float)$pdo->query('SELECT COALESCE(SUM(total_harga),0) FROM transaksi')->fetchColumn();
require 'header.php';
?>
<h1>Laporan Pemasukan</h1>
<div class="stat"><span>Total pemasukan keseluruhan</span><strong>Rp <?= number_format($total,0,',','.') ?></strong></div>
<div class="card">
<div class="table-wrap"><table><tr><th>Tanggal</th><th>Jumlah Transaksi</th><th>Total Pemasukan</th></tr>
<?php foreach ($rows as $r): ?><tr><td><?= e($r['tanggal']) ?></td><td><?= $r['jumlah_transaksi'] ?></td><td>Rp <?= number_format($r['pemasukan'],0,',','.') ?></td></tr><?php endforeach; ?>
</table></div>
</div>
<?php require 'footer.php'; ?>
