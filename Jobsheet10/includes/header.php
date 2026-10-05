<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);

if (!isset($base)) {
    $scriptDir = trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $base = ($scriptDir !== '') ? '../' : '';
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'SIRENMO'; ?></title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Beranda</a></li>
                <li><a href="<?php echo $base; ?>mobil/list.php" class="<?php echo ($currentPage == 'list.php' && strpos($_SERVER['PHP_SELF'], 'mobil') !== false) ? 'active' : ''; ?>">Daftar Mobil</a></li>

                <?php if ($sudahLogin): ?>
                    <li><a href="<?php echo $base; ?>mobil/tambah.php" class="<?php echo ($currentPage == 'tambah.php' && strpos($_SERVER['PHP_SELF'], 'mobil') !== false) ? 'active' : ''; ?>">Tambah Mobil</a></li>
                    <li><a href="<?php echo $base; ?>pelanggan/list.php" class="<?php echo ($currentPage == 'list.php' && strpos($_SERVER['PHP_SELF'], 'pelanggan') !== false) ? 'active' : ''; ?>">Daftar Pelanggan</a></li>
                    <li><a href="<?php echo $base; ?>pelanggan/tambah.php" class="<?php echo ($currentPage == 'tambah.php' && strpos($_SERVER['PHP_SELF'], 'pelanggan') !== false) ? 'active' : ''; ?>">Tambah Pelanggan</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="brand">
            <h1>FAKHRI RENT CAR</h1>
            <p>SIRENMO — Sistem Informasi Rental Mobil</p>
            <?php if ($sudahLogin): ?>
                <div style="font-size: 0.8rem; margin-top: 4px;">
                    <span>Halo, <strong><?php echo htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></strong></span> | 
                    <a href="<?php echo $base; ?>auth/logout.php" style="color: #ffc107; text-decoration: none;">Logout</a>
                </div>
            <?php else: ?>
                <div style="font-size: 0.8rem; margin-top: 4px;">
                    <a href="<?php echo $base; ?>auth/login.php" style="color: #ffffff; text-decoration: none;">Login Petugas</a>
                </div>
            <?php endif; ?>
        </div>
    </header>