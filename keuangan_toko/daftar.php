<?php
require_once 'config.php';
require_once 'crypto.php';
$pesan = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kasir'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nohp = trim($_POST['no_hp'] ?? '');

    if ($nama === '' || $username === '' || $password === '' || $nohp === '') {
        $pesan = 'Semua kolom wajib diisi.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO kasir (nama_kasir, username, password, no_hp) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT), caesarEncrypt($nohp)]);
            header('Location: login.php?daftar=berhasil');
            exit;
        } catch (PDOException $e) {
            $pesan = 'Pendaftaran gagal. Username mungkin sudah digunakan.';
        }
    }
}
require 'header.php';
?>
<section class="auth-container">
<h1>Daftar Kasir</h1>
<p>Buat akun kasir untuk mulai menggunakan aplikasi.</p>
<?php if ($pesan): ?><div class="alert"><?= e($pesan) ?></div><?php endif; ?>
    <form method="post">
        <label>Nama kasir</label><input name="nama_kasir" required>
        <label>Username</label><input name="username" required>
        <label>Password</label><input type="password" name="password" required>
        <label>Nomor HP</label><input name="no_hp" required>
        <button type="submit">Daftar</button>
    </form>
<p>Sudah punya akun? <a href="login.php">Login</a></p>
</section>
<?php require 'footer.php'; ?>
