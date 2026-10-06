<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/includes/koneksi.php';

// Ambil data jumlah mobil & pelanggan
$totalMobil = $pdo->query("SELECT COUNT(*) FROM mobil")->fetchColumn();
$totalPelanggan = $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SIRENMO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <div class="container my-4">
        <!-- Banner Selamat Datang -->
        <div class="card mb-4">
            <div class="card-body">
                <h2>Selamat Datang di Fakhri Rent Car</h2>
                <p class="text-muted">Website Pengelolaan data mobil dan pelanggan Fakhri Rent Car.</p>
            </div>
        </div>

        <!-- Ringkasan Grid 3 Kolom -->
        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">Ringkasan</h3>
                <div class="summary-grid">
                    <div class="summary-card">
                        <span class="summary-title">Total Mobil</span>
                        <span class="summary-value"><?= $totalMobil ?></span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-title">Total Pelanggan</span>
                        <span class="summary-value"><?= $totalPelanggan ?></span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-title">Status Sistem</span>
                        <span class="summary-value text-success">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>