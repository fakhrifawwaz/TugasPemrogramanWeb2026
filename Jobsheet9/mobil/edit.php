<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$page_title = "Edit Mobil";
require __DIR__ . '/../includes/header.php';
?>

<section class="form-container">
    <h2>Edit Data Mobil</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php" novalidate>
        <input type="hidden" name="id" value="<?php echo $mobil['id']; ?>">
        <p>
            <label for="no_mobil">Nomor Polisi / Plat:</label>
            <input type="text" id="no_mobil" name="no_mobil" required
                   value="<?php echo htmlspecialchars($mobil['no_mobil']); ?>">
        </p>
        <p>
            <label for="merek">Merek:</label>
            <input type="text" id="merek" name="merek" required
                   value="<?php echo htmlspecialchars($mobil['merek']); ?>">
        </p>
        <p>
            <label for="tipe">Tipe:</label>
            <input type="text" id="tipe" name="tipe" required
                   value="<?php echo htmlspecialchars($mobil['tipe']); ?>">
        </p>
        <p>
            <label for="tahun">Tahun:</label>
            <input type="number" id="tahun" name="tahun" min="2010" max="2026" required
                   value="<?php echo (int)$mobil['tahun']; ?>">
        </p>
        <p>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>