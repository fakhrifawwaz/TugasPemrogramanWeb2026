<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require __DIR__ . '/includes/koneksi.php';

if (!isset($pdo)) {
    die("Error: Objek koneksi \$pdo tidak ditemukan. Pastikan koneksi.php berjalan dengan benar.");
}

$totalMobil = $pdo->query("SELECT COUNT(*) FROM mobil")->fetchColumn();
$totalPelanggan = $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();

$page_title = "Beranda - SIRENMO";
require __DIR__ . '/includes/header.php';
?>

<main>
    <div class="card">
        <h2>Selamat Datang di Fakhri Rent Car</h2>
        <p>Website Pengelolaan data mobil dan pelanggan Fakhri Rent Car.</p>
    </div>

    <div class="card">
        <h2>Ringkasan</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <p>Total Mobil</p>
                <div class="number"><?php echo $totalMobil; ?></div>
            </div>
            <div class="stat-card">
                <p>Total Pelanggan</p>
                <div class="number"><?php echo $totalPelanggan; ?></div>
            </div>
            <div class="stat-card">
                <p>Status Sistem</p>
                <div class="number" style="font-size: 1.2rem; color: #2e7d32; margin-top: 10px;">Aktif</div>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>