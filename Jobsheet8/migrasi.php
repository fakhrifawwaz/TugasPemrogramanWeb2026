<?php
require __DIR__ . '/includes/koneksi.php';

$jsonFile = __DIR__ . '/data/mobil.json';

// 1. Cek apakah file JSON ada
if (!file_exists($jsonFile)) {
    die("File JSON tidak ditemukan di: " . $jsonFile);
}

// 2. Baca dan decode isi file JSON
$jsonData = file_get_contents($jsonFile);
$dataMobil = json_decode($jsonData, true);

if (empty($dataMobil)) {
    die("Data JSON kosong atau format tidak valid.");
}

// 3. Siapkan Prepared Statement
$stmt = $pdo->prepare("
    INSERT INTO mobil (no_mobil, merek, tipe, tahun) 
    VALUES (:no_mobil, :merek, :tipe, :tahun)
");

$berhasil = 0;
$gagal = 0;

echo "<h2>Proses Migrasi Data...</h2><ul>";

// 4. Looping data JSON dan masukkan ke database
foreach ($dataMobil as $mobil) {
    try {
        $stmt->execute([
            'no_mobil' => $mobil['no_mobil'],
            'merek'    => $mobil['merek'],
            'tipe'     => $mobil['tipe'],
            'tahun'    => $mobil['tahun']
        ]);
        echo "<li><span style='color:green;'>[BERHASIL]</span> Mobil {$mobil['merek']} {$mobil['tipe']} ({$mobil['no_mobil']}) diimpor.</li>";
        $berhasil++;
    } catch (PDOException $e) {
        $gagal++;
        if ($e->getCode() === '23505') {
            echo "<li><span style='color:orange;'>[Dilewati]</span> Plat {$mobil['no_mobil']} sudah ada di database.</li>";
        } else {
            echo "<li><span style='color:red;'>[GAGAL]</span> Plat {$mobil['no_mobil']}: {$e->getMessage()}</li>";
        }
    }
}

echo "</ul>";
echo "<p><strong>Selesai!</strong> Total berhasil: {$berhasil}, Dilewati/Gagal: {$gagal}.</p>";
echo "<a href='mobil/list.php'>Lihat Daftar Mobil</a>";