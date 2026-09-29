<?php
$page_title = "Daftar Mobil";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    // Sesuaikan nama kolom: no_mobil, merek, tipe, tahun
    $hitung = $pdo->prepare("
        SELECT COUNT(*) 
        FROM mobil 
        WHERE no_mobil ILIKE :kw 
           OR merek ILIKE :kw 
           OR tipe ILIKE :kw
           OR CAST(tahun AS TEXT) ILIKE :kw
    ");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("
        SELECT * 
        FROM mobil 
        WHERE no_mobil ILIKE :kw 
           OR merek ILIKE :kw 
           OR tipe ILIKE :kw
           OR CAST(tahun AS TEXT) ILIKE :kw
        ORDER BY id DESC 
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM mobil")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM mobil ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarMobil = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section class="container my-4">
    <h2>Daftar Mobil</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <div class="search-container">
        <form method="get" action="list.php">
            <label for="q">Cari Mobil:</label>
            <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari No. Mobil, Merek, Tipe, atau Tahun...">
            <button type="submit">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php" class="btn-reset">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Mobil</th>
                    <th>Merek</th>
                    <th>Tipe</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarMobil)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Data mobil tidak ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarMobil as $index => $mobil): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($mobil['no_mobil'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($mobil['merek'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($mobil['tipe'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($mobil['tahun'] ?? ''); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $mobil['id']; ?>" class="btn btn-warning btn-sm btn-edit">Edit</a>
                                
                                <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $mobil['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>" 
                   class="<?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>