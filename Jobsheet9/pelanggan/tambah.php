<?php
session_start();
$page_title = "Tambah Pelanggan";
require __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Tambah Pelanggan</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>" style="margin-bottom: 15px; padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px;">
            <?php 
                echo $_SESSION['flash']['pesan']; 
                unset($_SESSION['flash']);
            ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
        <p>
            <label for="nama">Nama</label><br>
            <input type="text" id="nama" name="nama" required>
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat" required>
        </p>
        <p>
            <label for="no_telepon">No. Telepon</label><br>
            <input type="text" id="no_telepon" name="no_telepon" required>
        </p>
        <p>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="list.php" class="btn btn-secondary">Batal</a>
        </p>
    </form>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>