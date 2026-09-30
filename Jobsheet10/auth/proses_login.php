<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Ambil data user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi keberadaan user dan kecocokan hash password
    if ($user && password_verify($password, $user['password'])) {
        // Simpan data identitas utama ke $_SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];

        header('Location: ../index.php');
        exit;
    }

    // Pesan error umum (tidak memberitahu spesifik mana yang salah demi keamanan)
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
    header('Location: login.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}