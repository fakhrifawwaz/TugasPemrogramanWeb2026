<?php
$page_title = "Tambah Pelanggan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/auth.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main>
    <div class="card">
        <h2>Tambah Data Pelanggan</h2>

        <?php if (!empty($flash)): ?>
            <?php 
                $message = is_array($flash) ? ($flash['message'] ?? $flash['pesan'] ?? '') : $flash;
            ?>
            <div style="padding: 10px; margin-bottom: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form id="form-tambah" method="post" action="proses_tambah.php">
            <div class="form-group">
                <label for="nama">Nama Pelanggan</label>
                <input type="text" id="nama" name="nama" placeholder="Contoh: Fakhri Fawwaz" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Soekarno Hatta No. 10, Malang" required></textarea>
            </div>

            <div class="form-group">
                <label for="no_hp">Nomor HP / WhatsApp</label>
                <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-simpan">Simpan</button>
                <a href="list.php" class="btn btn-batal">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>