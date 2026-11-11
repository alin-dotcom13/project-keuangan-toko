<?php
require_once 'config.php';
$pesan = isset($_GET['daftar']) ? 'Pendaftaran berhasil. Silakan login.' : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM kasir WHERE username = ?');
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $kasir = $stmt->fetch();

    if ($kasir && password_verify($_POST['password'] ?? '', $kasir['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_kasir'] = $kasir['id_kasir'];
        $_SESSION['nama_kasir'] = $kasir['nama_kasir'];
        header('Location: index.php');
        exit;
    }
    $pesan = 'Username atau password salah.';
}
require 'header.php';
?>
<section class="auth-container">
<h1>Login Kasir</h1>
<p>Sistem Pencatatan Transaksi & Manajemen Produk.</p>
<?php if ($pesan): ?><div class="alert"><?= e($pesan) ?></div><?php endif; ?>
<form method="post">
    <label>Username</label><input name="username" required>
    <label>Password</label><input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
<p>Belum punya akun? <a href="daftar.php">Daftar kasir</a></p>
</section>
<?php require 'footer.php'; ?>
