<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id");
$stmt->execute(['id' => $id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$page_title = "Edit Pelanggan";
require __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Edit Pelanggan</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
        <p>
            <label for="nama">Nama</label><br>
            <input type="text" id="nama" name="nama" required value="<?php echo htmlspecialchars($p['nama']); ?>">
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat" required value="<?php echo htmlspecialchars($p['alamat']); ?>">
        </p>
        <p>
            <label for="no_telepon">No. Telepon</label><br>
            <input type="text" id="no_telepon" name="no_telepon" required value="<?php echo htmlspecialchars($p['no_telepon']); ?>">
        </p>
        <p>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>