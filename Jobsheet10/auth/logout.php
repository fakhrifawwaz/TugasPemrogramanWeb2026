<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hancurkan semua data session pengguna
session_destroy();

// Redirect kembali ke halaman login
header('Location: login.php');
exit;