<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Fitur Pencarian Server-Side (Operator ILIKE PostgreSQL)
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM pelanggan 
        WHERE nama ILIKE :q 
           OR alamat ILIKE :q 
           OR no_telepon ILIKE :q 
        ORDER BY id DESC
    ");
    $stmt->execute(['q' => "%$keyword%"]);
    $daftarPelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $daftarPelanggan = $pdo->query("SELECT * FROM pelanggan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

$page_title = "Daftar Pelanggan";
require __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Daftar Pelanggan</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
            <?php 
                echo htmlspecialchars($_SESSION['flash']['pesan']); 
                unset($_SESSION['flash']);
            ?>
        </div>
    <?php endif; ?>

    <div class="search-box" style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px;">
        <a href="tambah.php" class="btn btn-primary">Tambah Pelanggan Baru</a>

        <form method="GET" action="list.php" style="display: flex; gap: 5px;">
            <input 
                type="text" 
                name="q" 
                value="<?php echo htmlspecialchars($keyword); ?>" 
                placeholder="Cari nama, alamat, no. telp..." 
                style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;"
            >
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarPelanggan)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            <?php echo $keyword !== '' ? 'Data pelanggan tidak ditemukan.' : 'Belum ada data pelanggan.'; ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarPelanggan as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['nama']); ?></td>
                            <td><?php echo htmlspecialchars($p['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($p['no_telepon']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $p['id']; ?>" class="btn btn-primary">Edit</a>
                                <form action="hapus.php" method="post" style="display:inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>