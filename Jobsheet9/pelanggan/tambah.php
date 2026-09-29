<?php
$page_title = "Tambah Pelanggan";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Data Pelanggan</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="nama">Nama Pelanggan:</label>
            <input type="text" id="nama" name="nama" placeholder="Contoh: Ahmad Subagyo" required>
        </p>

        <p>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Mawar No. 12, Pasuruan" required></textarea>
        </p>

        <p>
            <label for="no_hp">Nomor HP / WhatsApp:</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
        </p>

        <p>
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="list.php" class="btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>