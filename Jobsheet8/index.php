<?php
session_start();
require __DIR__ . '/includes/koneksi.php';

// Hitung jumlah data langsung dari PostgreSQL
$totalMobil = $pdo->query("SELECT COUNT(*) FROM mobil")->fetchColumn();
$totalPelanggan = $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();

$title = "Beranda";
require __DIR__ . '/includes/header.php';
?>

<div class="container">
    <h1>Selamat Datang di SIRENMO</h1>
    <p>Sistem Informasi Rental Mobil - Fakhri Rent Car</p>

    <div class="dashboard-cards" style="display: flex; gap: 20px; margin-top: 20px;">
        <div class="card" style="padding: 20px; border: 1px solid #ccc; border-radius: 8px; flex: 1;">
            <h3>Total Mobil</h3>
            <p style="font-size: 2em; font-weight: bold;"><?php echo $totalMobil; ?></p>
            <a href="mobil/list.php">Lihat Daftar Mobil &rarr;</a>
        </div>

        <div class="card" style="padding: 20px; border: 1px solid #ccc; border-radius: 8px; flex: 1;">
            <h3>Total Pelanggan</h3>
            <p style="font-size: 2em; font-weight: bold;"><?php echo $totalPelanggan; ?></p>
            <a href="pelanggan/list.php">Lihat Daftar Pelanggan &rarr;</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>