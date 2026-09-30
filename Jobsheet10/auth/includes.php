<?php
// Mencegah error "session already started" jika session sudah aktif sebelumnya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika belum login (tidak ada user_id di session), lemparkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}