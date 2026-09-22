<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Ambil keyword pencarian dari URL (?q=...)
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    // Pencarian case-insensitive dengan ILIKE di PostgreSQL
    $stmt = $pdo->prepare("
        SELECT * FROM mobil 
        WHERE merek ILIKE :q 
           OR tipe ILIKE :q 
           OR no_mobil ILIKE :q 
        ORDER BY id DESC
    ");
    $stmt->execute(['q' => "%$keyword%"]);
    $daftarMobil = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Ambil semua data jika tidak ada pencarian
    $daftarMobil = $pdo->query("SELECT * FROM mobil ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

$title = "Daftar Mobil";
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <h2>Daftar Mobil</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
            <?php 
                echo $_SESSION['flash']['pesan']; 
                unset($_SESSION['flash']);
            ?>
        </div>
    <?php endif; ?>

    <div class="mb-3" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="tambah.php" class="btn btn-primary">Tambah Mobil Baru</a>

        <!-- Form Pencarian Server-side -->
        <form method="GET" action="list.php" style="display: flex; gap: 5px;">
            <input 
                type="text" 
                name="q" 
                value="<?php echo htmlspecialchars($keyword); ?>" 
                placeholder="Ketik merek, tipe, atau plat..." 
                style="padding: 6px 10px;"
            >
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php" class="btn btn-secondary" style="text-decoration: none; padding: 6px 10px; background: #6c757d; color: white; border-radius: 4px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No. Plat</th>
                <th>Merek</th>
                <th>Tipe</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarMobil)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <?php echo $keyword !== '' ? 'Data mobil tidak ditemukan.' : 'Belum ada data mobil.'; ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarMobil as $mobil): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mobil['no_mobil']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['merek']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['tipe']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['tahun']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>