<?php
$page_title = "Tambah Mobil";
include __DIR__ . '/../includes/header.php';

// Ambil pesan flash jika ada
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section class="form-container">
    <h2>Tambah Data Mobil</h2>
    
    <!-- Tampilkan pesan error jika ada -->
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <!-- Tambahkan 'novalidate' jika ingin mematikan validasi HTML5 untuk testing -->
    <form id="form-tambah" method="post" action="proses_tambah.php" novalidate> 
        <div class="form-group">
            <label for="no_mobil">Nomor Polisi / Plat:</label>
            <input type="text" id="no_mobil" name="no_mobil" required placeholder="Contoh: N 001 SIB">
        </div>

        <div class="form-group">
            <label for="merek">Merek:</label>
            <input type="text" id="merek" name="merek" required placeholder="Contoh: Toyota">
        </div>

        <div class="form-group">
            <label for="tipe">Tipe:</label>
            <input type="text" id="tipe" name="tipe" required placeholder="Contoh: Avanza">
        </div>

        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="number" id="tahun" name="tahun" min="2010" max="2026" required placeholder="2022">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>