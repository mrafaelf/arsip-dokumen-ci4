<?php
$password = readline('Password baru (min. 8 karakter): ');
if (strlen($password) < 8) {
    exit("Password terlalu pendek.\n");
}
$db   = new mysqli('127.0.0.1', 'root', '', 'arsip_db');
$hash = password_hash($password, PASSWORD_DEFAULT);
$mail = 'admin@arsip.test';
$stmt = $db->prepare('UPDATE users SET password = ? WHERE email = ?');
$stmt->bind_param('ss', $hash, $mail);
$stmt->execute();
echo $stmt->affected_rows > 0 ? "Berhasil! Password admin sudah diganti.\n" : "Tidak ada baris yang berubah.\n";
