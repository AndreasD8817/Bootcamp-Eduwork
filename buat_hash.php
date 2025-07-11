<?php

// --- GANTI BAGIAN INI ---
// Masukkan password yang ingin Anda buatkan hash-nya di sini
$passwordAsli = '123456';
// -------------------------


// Kode ini akan membuat hash dari password di atas
$hash = password_hash($passwordAsli, PASSWORD_DEFAULT);

// Kode ini akan menampilkan hasilnya di layar browser
echo "Password Asli: " . $passwordAsli . "<br>";
echo "Hasil Hash: " . $hash;

?>