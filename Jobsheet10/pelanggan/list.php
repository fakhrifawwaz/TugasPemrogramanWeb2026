<?php
$page_title = "Daftar Pelanggan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';
require __DIR__ . '/../includes/auth.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
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

<main>
    <div class="card">
        <h2>Daftar Pelanggan</h2>

        <?php if (!empty($flash)): ?>
            <?php 
                $type = is_array($flash) ? ($flash['type'] ?? 'success') : 'success';
                $message = is_array($flash) ? ($flash['message'] ?? $flash['pesan'] ?? '') : $flash;
            ?>
            <div style="padding: 10px; margin-bottom: 15px; background-color: #d4edda; color: #155724; border-radius: 4px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <form method="get" action="list.php">
                <input type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama, alamat, atau No HP..." style="padding: 8px; width: 300px; border: 1px solid #cbd5e0; border-radius: 4px;">
                <button type="submit" class="btn btn-edit">Cari</button>
                <?php if ($keyword !== ''): ?>
                    <a href="list.php" class="btn btn-hapus">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-container">
            <table>
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
                                <td><?php echo htmlspecialchars($pelanggan['no_telepon'] ?? $pelanggan['no_hp'] ?? ''); ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="edit.php?id=<?php echo $pelanggan['id']; ?>" class="btn btn-edit">Edit</a>
                                        
                                        <form method="post" action="hapus.php" style="display:inline;" onsubmit="return confirm('Yakin menghapus pelanggan ini?');">
                                            <input type="hidden" name="id" value="<?php echo $pelanggan['id']; ?>">
                                            <button type="submit" class="btn btn-hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div style="margin-top: 20px; display: flex; gap: 5px;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>" 
                       class="btn <?php echo $i === $page ? 'btn-edit' : 'btn-secondary'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>