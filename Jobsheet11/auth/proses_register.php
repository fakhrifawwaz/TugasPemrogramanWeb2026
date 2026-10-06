<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];
    if ($nama === '') {
        $errors[] = "Nama wajib diisi.";
    }
    if ($username === '') {
        $errors[] = "Username wajib diisi.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }

    if (!empty($errors)) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode('<br>', $errors)];
        header('Location: register.php');
        exit;
    }

    // Cek username unik
    $cek = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $cek->execute(['username' => $username]);
    if ($cek->fetch()) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
        header('Location: register.php');
        exit;
    }

    // Simpan data user dengan hashing
    $stmt = $pdo->prepare(
        "INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'petugas')"
    );

    $simpan = $stmt->execute([
        'nama' => $nama,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    if ($simpan) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil! Silakan login.'];
        header('Location: login.php');
        exit;
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mendaftar, terjadi kesalahan sistem.'];
        header('Location: register.php');
        exit;
    }
} else {
    header('Location: register.php');
    exit;
}