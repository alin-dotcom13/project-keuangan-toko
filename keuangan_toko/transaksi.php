<?php
require_once 'config.php';
wajibLogin();
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduk = (int)($_POST['id_produk'] ?? 0);
    $jumlah = (int)($_POST['jumlah'] ?? 0);
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT * FROM produk WHERE id_produk = ? FOR UPDATE');
        $stmt->execute([$idProduk]);
        $p = $stmt->fetch();
        if (!$p || $jumlah < 1 || $jumlah > (int)$p['stok']) {
            throw new Exception('Produk tidak ditemukan atau stok tidak mencukupi.');
        }
        $total = $jumlah * (float)$p['harga'];
        $stmt = $pdo->prepare('INSERT INTO transaksi (id_kasir, id_produk, jumlah, total_harga) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_SESSION['id_kasir'], $idProduk, $jumlah, $total]);
        $stmt = $pdo->prepare('UPDATE produk SET stok = stok - ? WHERE id_produk = ?');
        $stmt->execute([$jumlah, $idProduk]);
        $pdo->commit();
        $pesan = 'Transaksi berhasil disimpan dan stok produk diperbarui.';
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $pesan = $e->getMessage();
    }
}
$produk = $pdo->query('SELECT * FROM produk ORDER BY nama_produk')->fetchAll();
$riwayat = $pdo->query('SELECT t.*, p.nama_produk, k.nama_kasir FROM transaksi t JOIN produk p ON t.id_produk=p.id_produk JOIN kasir k ON t.id_kasir=k.id_kasir ORDER BY t.id_transaksi DESC LIMIT 20')->fetchAll();
require 'header.php';
?>
<h1>Transaksi Penjualan</h1>
<?php if ($pesan): ?><div class="success"><?= e($pesan) ?></div><?php endif; ?>
<div class="card">
<h2>Catat Transaksi</h2>
<form method="post">
<label>Produk</label><select name="id_produk" required><option value="">-- Pilih produk --</option>
<?php foreach ($produk as $p): ?><option value="<?= $p['id_produk'] ?>"><?= e($p['nama_produk']) ?> — Rp <?= number_format($p['harga'],0,',','.') ?> (stok <?= $p['stok'] ?>)</option><?php endforeach; ?>
</select>
<label>Jumlah terjual</label><input type="number" name="jumlah" min="1" required>
<button type="submit">Simpan Transaksi</button>
</form>
</div>
<div class="card">
<h2>Riwayat Transaksi Terbaru</h2>
<div class="table-wrap"><table><tr><th>ID</th><th>Tanggal</th><th>Kasir</th><th>Produk</th><th>Jumlah</th><th>Total</th></tr>
<?php foreach ($riwayat as $t): ?><tr><td><?= $t['id_transaksi'] ?></td><td><?= e($t['tanggal']) ?></td><td><?= e($t['nama_kasir']) ?></td><td><?= e($t['nama_produk']) ?></td><td><?= $t['jumlah'] ?></td><td>Rp <?= number_format($t['total_harga'],0,',','.') ?></td></tr><?php endforeach; ?>
</table></div>
</div>
<?php require 'footer.php'; ?>
