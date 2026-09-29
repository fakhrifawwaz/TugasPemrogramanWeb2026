<?php
$page_title = "Daftar Pelanggan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    // Pencarian berdasarkan nama, alamat, atau no_telepon (dengan operator OR)
    $hitung = $pdo->prepare("
        SELECT COUNT(*) 
        FROM pelanggan 
        WHERE nama ILIKE :kw 
           OR alamat ILIKE :kw 
           OR no_telepon ILIKE :kw
    ");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("
        SELECT * 
        FROM pelanggan 
        WHERE nama ILIKE :kw 
           OR alamat ILIKE :kw 
           OR no_telepon ILIKE :kw
        ORDER BY id DESC 
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM pelanggan ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarPelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section class="container my-4">
    <h2>Daftar Pelanggan</h2>

    <?php if (!empty($flash)): ?>
        <?php 
            $type = is_array($flash) ? ($flash['type'] ?? 'success') : 'success';
            $message = is_array($flash) ? ($flash['message'] ?? $flash['pesan'] ?? '') : $flash;
        ?>
        <div class="alert alert-<?php echo htmlspecialchars($type); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="search-container">
        <form method="get" action="list.php">
            <label for="q">Cari Pelanggan:</label>
            <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama, alamat, atau HP...">
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
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarPelanggan)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Data pelanggan tidak ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarPelanggan as $index => $pelanggan): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($pelanggan['nama'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($pelanggan['alamat'] ?? ''); ?></td>
                            <!-- Menggunakan no_telepon sesuai kolom DB pgAdmin -->
                            <td><?php echo htmlspecialchars($pelanggan['no_telepon'] ?? $pelanggan['no_hp'] ?? ''); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $pelanggan['id']; ?>" class="btn btn-warning btn-sm btn-edit">Edit</a>
                                
                                <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $pelanggan['id']; ?>">
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