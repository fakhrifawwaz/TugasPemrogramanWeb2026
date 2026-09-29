<?php
require __DIR__ . '/includes/koneksi.php';

$jsonFile = __DIR__ . '/data/pelanggan.json';

if (!file_exists($jsonFile)) {
    die("File pelanggan.json tidak ditemukan!");
}

$dataPelanggan = json_decode(file_get_contents($jsonFile), true);

$stmt = $pdo->prepare("
    INSERT INTO pelanggan (nama, alamat, no_telepon) 
    VALUES (:nama, :alamat, :no_telepon)
");

$berhasil = 0;
foreach ($dataPelanggan as $p) {
    try {
        $stmt->execute([
            'nama'       => $p['nama'],
            'alamat'     => $p['alamat'],
            'no_telepon' => $p['no_telepon'] ?? $p['no_telp'] ?? $p['telepon'] ?? '-'
        ]);
        $berhasil++;
    } catch (PDOException $e) {
        // Abaikan jika data duplikat/error
    }
}

echo "<h3>Migrasi Pelanggan Selesai!</h3>";
echo "Jumlah data berhasil dimasukkan ke PostgreSQL: <strong>$berhasil</strong><br><br>";
echo "<a href='index.php'>Kembali ke Beranda</a>";