<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Mobil - SIRENMO";
include __DIR__ . '/../includes/header.php';
?>

<main>
    <div class="card">
        <h2>Tambah Mobil</h2>

        <?php if (isset($_SESSION['flash'])): ?>
            <div style="padding: 10px; margin-bottom: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px;">
                <?php echo $_SESSION['flash']['pesan']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form id="form-tambah" method="post" action="proses_tambah.php">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="no_mobil">No. Mobil</label>
                <input type="text" id="no_mobil" name="no_mobil" required placeholder="Contoh: N 001 SIB">
            </div>

            <div class="form-group">
                <label for="merek">Merek</label>
                <input type="text" id="merek" name="merek" required placeholder="Contoh: Toyota">
            </div>

            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" id="tipe" name="tipe" required placeholder="Contoh: Avanza">
            </div>

            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" id="tahun" name="tahun" min="2000" max="2026" required placeholder="2020">
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-simpan">Simpan</button>
                <a href="list.php" class="btn btn-batal">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>