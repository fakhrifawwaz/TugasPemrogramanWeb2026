<?php
$page_title = "Edit Pelanggan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';
require __DIR__ . '/../includes/auth.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id");
$stmt->execute(['id' => $id]);
$pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelanggan) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Data Pelanggan</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <form id="form-edit" class="form-edit" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($pelanggan['id']); ?>">

        <p>
            <label for="nama">Nama Pelanggan:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pelanggan['nama']); ?>" required>
        </p>

        <p>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($pelanggan['alamat']); ?></textarea>
        </p>

        <p>
            <label for="no_hp">Nomor HP / WhatsApp:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pelanggan['no_hp']); ?>" required>
        </p>

        <p>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>