<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username dan password wajib diisi!'];
    header('Location: login.php');
    exit;
}

try {
    // Query data user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $isPasswordValid = false;

        // Cek apakah password dicocokkan dengan password_verify atau plain-text
        if (password_verify($password, $user['password'])) {
            $isPasswordValid = true;
        } elseif ($password === $user['password']) {
            $isPasswordValid = true;
        }

        if ($isPasswordValid) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'] ?? $user['username'];
            $_SESSION['username'] = $user['username'];

            header('Location: ../index.php');
            exit;
        }
    }

    // Jika username atau password tidak cocok
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username atau password salah!'];
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    // Tangkap error jika tabel 'users' belum ada di PostgreSQL Railway
    error_log("Login Error: " . $e->getMessage());
    $_SESSION['flash'] = [
        'type' => 'danger', 
        'pesan' => 'Gagal terhubung ke data user. Pastikan tabel "users" sudah dibuat di Database Railway.'
    ];
    header('Location: login.php');
    exit;
}