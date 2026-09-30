<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghubungkan ke koneksi.php di dalam folder includes
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];

        // Redirect keluar dari folder auth ke index.php utama
        header('Location: ../index.php');
        exit;
    }

    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
    header('Location: login.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}