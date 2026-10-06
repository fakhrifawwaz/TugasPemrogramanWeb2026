<?php
$page_title = "Edit Mobil";
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

$stmt = $pdo->prepare("SELECT * FROM mobil WHERE id = :id");
$stmt->execute(['id' => $id]);
$mobil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mobil) {
    header('Location: list.php');
    exit;
}
?>

<section class="container my-4">
    <h2>Edit Data Mobil</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo e($flash['type']); ?>">
            <?php echo e($flash['message']); ?>
        </div>
    <?php endif; ?>

    <form id="form-edit" class="form-edit" method="post" action="proses_edit.php">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int) $mobil['id']; ?>">

        <p>
            <label for="no_mobil">Nomor Plat (No. Mobil)</label><br>
            <input type="text" id="no_mobil" name="no_mobil" value="<?php echo e($mobil['no_mobil']); ?>" required>
        </p>

        <p>
            <label for="merek">Merek Mobil</label><br>
            <input type="text" id="merek" name="merek" value="<?php echo e($mobil['merek']); ?>" required>
        </p>

        <p>
            <label for="tipe">Tipe Mobil</label><br>
            <input type="text" id="tipe" name="tipe" value="<?php echo e($mobil['tipe']); ?>" required>
        </p>

        <p>
            <label for="tahun">Tahun Pembuatan</label><br>
            <input type="number" id="tahun" name="tahun" value="<?php echo $mobil['tahun']; ?>" required>
        </p>

        <p>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>