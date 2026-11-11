<?php
const CAESAR_KEY = 3;

function caesarEncrypt($plainText) {
    $hasil = '';
    for ($i = 0; $i < strlen($plainText); $i++) {
        $hasil .= chr((ord($plainText[$i]) + CAESAR_KEY) % 256);
    }
    return base64_encode($hasil);
}

function caesarDecrypt($cipherText) {
    $hasil = base64_decode($cipherText, true);
    if ($hasil === false) return '';
    $plain = '';
    for ($i = 0; $i < strlen($hasil); $i++) {
        $plain .= chr((ord($hasil[$i]) - CAESAR_KEY + 256) % 256);
    }
    return $plain;
}
