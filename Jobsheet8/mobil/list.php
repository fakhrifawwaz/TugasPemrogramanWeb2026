<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$daftarMobil = $pdo->query("SELECT * FROM mobil ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

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

    <div class="mb-3">
        <a href="tambah.php" class="btn btn-primary">Tambah Mobil Baru</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No. Plat</th>
                <th>Merek</th>
                <th>Tipe</th>
                <th>Tahun</th>
                <th>Tanggal Input</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarMobil)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada data mobil.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarMobil as $mobil): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mobil['no_mobil']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['merek']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['tipe']); ?></td>
                        <td><?php echo htmlspecialchars($mobil['tahun']); ?></td>
                        <td>
                            <?php 
                                if (!empty($mobil['created_at'])) {
                                    echo date('d-m-Y H:i', strtotime($mobil['created_at']));
                                } else {
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $mobil['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="hapus.php?id=<?php echo $mobil['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>