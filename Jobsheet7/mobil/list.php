<?php
$page_title = "Daftar Mobil";
include __DIR__ . '/../includes/header.php';

// 1. Ambil pesan flash lalu langsung hapus agar hanya tampil sekali (unset)
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// 2. Ambil data mobil dari session
$daftarMobil = $_SESSION['mobil'] ?? [];
?>

<section>
    <h2>Daftar Mobil</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Mobil</label>
        <input type="text" id="search-input" placeholder="Ketik merek atau tipe mobil...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Plat</th>
                    <th>Merek</th>
                    <th>Tipe</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarMobil)): ?>
                    <tr>
                        <td colspan="5">Belum ada data mobil. Silakan tambah lewat menu "Tambah Mobil".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarMobil as $mobil): ?>
                        <tr>
                            <td><?php echo $mobil['no_mobil']; ?></td>
                            <td><?php echo $mobil['merek']; ?></td>
                            <td><?php echo $mobil['tipe']; ?></td>
                            <td><?php echo $mobil['tahun']; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>