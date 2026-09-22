<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fakhri Rent Car<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <div class="brand-group">
            <h1>FAKHRI RENT CAR</h1>
            <p class="subtitle">SIRENMO &mdash; Sistem Informasi Rental Mobil</p>
        </div>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>mobil/list.php">Daftar Mobil</a></li>
                <li><a href="<?php echo $base; ?>mobil/tambah.php">Tambah Mobil</a></li>
                <li><a href="<?php echo $base; ?>pelanggan/list.php">Daftar Pelanggan</a></li>
                <li><a href="<?php echo $base; ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
            </ul>
        </nav>
    </header>

    <main>