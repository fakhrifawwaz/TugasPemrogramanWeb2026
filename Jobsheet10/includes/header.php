<?php
// Pengaman session agar tidak bentrok jika sudah dipanggil di auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simpan status login ke satu variabel
$sudahLogin = isset($_SESSION['user_id']);

// Perhitungan $base otomatis untuk path relatif (dari Jobsheet 7)
if (!isset($base)) {
    $depth = substr_count($_SERVER['SCRIPT_NAME'], '/') - substr_count(dirname($_SERVER['SCRIPT_NAME']), '/');
    $base = str_repeat('../', max(0, $depth - 1));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'SIRENMO'; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>css/style.css">
</head>
<body>
    <header>
        <h1>SIRENMO</h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <!-- Menu Publik (Selalu Tampil) -->
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Data</a></li>

                <!-- Menu Terkunci (Hanya Tampil Jika Sudah Login) -->
                <?php if ($sudahLogin): ?>
                    <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Data</a></li>
                    <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                    <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Area Status Autentikasi Pojok Kanan Header -->
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span>Halo, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong></span>
                <a href="<?php echo $base; ?>auth/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php" class="btn-login">Login</a>
            <?php endif; ?>
        </div>
    </header>