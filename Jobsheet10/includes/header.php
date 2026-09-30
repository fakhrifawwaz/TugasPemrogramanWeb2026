<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);

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
                <!-- Menu Publik -->
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>mobil/list.php">Daftar Mobil</a></li>

                <!-- Menu Khusus Petugas (Terproteksi) -->
                <?php if ($sudahLogin): ?>
                    <li><a href="<?php echo $base; ?>mobil/tambah.php">Tambah Mobil</a></li>
                    <li><a href="<?php echo $base; ?>pelanggan/list.php">Daftar Pelanggan</a></li>
                    <li><a href="<?php echo $base; ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span>Halo, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong></span>
                <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>