<?php
require_once 'crypto.php';
$contoh = '081234567890';
$terenkripsi = caesarEncrypt($contoh);
$terbuka = caesarDecrypt($terenkripsi);
echo '<h3>Uji Caesar ASCII (kunci 3)</h3>';
echo 'Data asli: ' . htmlspecialchars($contoh) . '<br>';
echo 'Hasil enkripsi (Base64): ' . htmlspecialchars($terenkripsi) . '<br>';
echo 'Hasil dekripsi: ' . htmlspecialchars($terbuka) . '<br>';
