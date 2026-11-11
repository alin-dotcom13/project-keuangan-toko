<?php
require_once 'config.php';
wajibLogin();
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_produk'] ?? '');
    $harga = (float)($_POST['harga'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);

    if ($nama !== '' && $harga > 0 && $stok >= 0) {
        $stmt = $pdo->prepare('INSERT INTO produk (nama_produk, harga, stok) VALUES (?, ?, ?)');
        $stmt->execute([$nama, $harga, $stok]);
        $pesan = 'Produk berhasil ditambahkan.';
    } else { 
        $pesan = 'Periksa kembali nama, harga, dan stok.';
    }
}

$cari = trim($_GET['cari'] ?? '');
$stmt = $pdo->prepare('SELECT * FROM produk WHERE nama_produk LIKE ? ORDER BY id_produk DESC');
$stmt->execute(['%'.$cari.'%']);
$produk = $stmt->fetchAll();

require 'header.php';
?>

<h1>Data Produk</h1>

<?php if ($pesan): ?>
    <div class="success"><?= e($pesan) ?></div>
<?php endif; ?>

<div class="card">
    <h2>Tambah Produk</h2>
    <form method="post" class="form-grid">
        <div>
            <label>Nama produk</label>
            <input name="nama_produk" required>
        </div>
        <div>
            <label>Harga</label>
            <input type="number" name="harga" min="1" required>
        </div>
        <div>
            <label>Stok</label>
            <input type="number" name="stok" min="0" required>
        </div>
        <div class="end">
            <button type="submit">Simpan Produk</button>
        </div>
    </form>
</div>

<div class="card">
    <h2>Cari Produk</h2>
    <form method="get" class="search">
        <input name="cari" value="<?= e($cari) ?>" placeholder="Masukkan nama produk">
        <button>Cari</button>
    </form>

<div class="table-wrap">
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

            <?php foreach ($produk as $p): ?>
                <tr>
                    <td><?= $p['id_produk'] ?></td>
                    <td><?= e($p['nama_produk']) ?></td>
                    <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td><a href="hapus_produk.php?id=<?= $p['id_produk'] ?>"onclick="return confirm('Yakin ingin menghapus produk ini?')" 
                            class="btn-hapus" title="Hapus Produk">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php require 'footer.php'; ?>
