<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

// Cek status login petugas
$is_logged_in = isset($_SESSION['user_id']);

$page_title = "Daftar Mobil";
$base = "../";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Paginasi & Pencarian
$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
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

include __DIR__ . '/../includes/header.php';
?>

<main class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Mobil</h2>

            <?php if ($is_logged_in): ?>
                <a href="tambah.php" class="btn btn-simpan">+ Tambah Mobil</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($flash)): ?>
            <?php 
                $type = is_array($flash) ? ($flash['type'] ?? 'success') : 'success';
                $message = is_array($flash) ? ($flash['message'] ?? $flash['pesan'] ?? '') : $flash;
                $bgColor = ($type === 'danger' || $type === 'error') ? '#f8d7da' : '#d4edda';
                $textColor = ($type === 'danger' || $type === 'error') ? '#721c24' : '#155724';
            ?>
            <div style="padding: 10px; margin-bottom: 15px; background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>; border-radius: 4px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <form method="get" action="list.php">
                <input type="text" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari No. Mobil, Merek, Tipe, atau Tahun..." style="padding: 8px; width: 300px; border: 1px solid #cbd5e0; border-radius: 4px;">
                <button type="submit" class="btn btn-edit">Cari</button>
                <?php if ($keyword !== ''): ?>
                    <a href="list.php" class="btn btn-hapus">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-container">
            <table class="data-table" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Mobil</th>
                        <th>Merek</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <?php if ($is_logged_in): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarMobil)): ?>
                        <tr>
                            <td colspan="<?php echo $is_logged_in ? 6 : 5; ?>" style="text-align: center;">Data mobil tidak ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarMobil as $index => $mobil): ?>
                            <tr>
                                <td><?php echo $offset + $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($mobil['no_mobil'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($mobil['merek'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($mobil['tipe'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($mobil['tahun'] ?? ''); ?></td>
                                
                                <?php if ($is_logged_in): ?>
                                    <td>
                                        <div class="action-btns">
                                            <a href="edit.php?id=<?php echo $mobil['id']; ?>" class="btn btn-edit">Edit</a>
                                            
                                            <form method="post" action="hapus.php" style="display:inline;" onsubmit="return confirm('Yakin menghapus data ini?');">
                                                <input type="hidden" name="id" value="<?php echo $mobil['id']; ?>">
                                                <button type="submit" class="btn btn-hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif; ?>
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