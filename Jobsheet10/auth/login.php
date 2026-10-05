<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke beranda jika pengguna sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login - SIRENMO";

// KUNCI: Menetapkan path relatif mundur 1 folder untuk subfolder auth/
$base = "../"; 

include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main>
    <div class="card" style="max-width: 420px; margin: 40px auto;">
        <h2>Login SIRENMO</h2>

        <?php if (!empty($flash)): ?>
            <?php 
                $message = is_array($flash) ? ($flash['message'] ?? $flash['pesan'] ?? '') : $flash;
                $isSuccess = (isset($flash['type']) && $flash['type'] === 'success');
                $bgColor = $isSuccess ? '#d4edda' : '#f8d7da';
                $textColor = $isSuccess ? '#155724' : '#721c24';
            ?>
            <div style="padding: 10px 14px; margin-bottom: 20px; background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>; border-radius: 4px; font-size: 0.9rem;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="proses_login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Masukkan username" autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
            </div>

            <div style="margin-top: 24px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-simpan">Masuk</button>
                <a href="register.php" class="btn btn-edit" style="background-color: transparent; color: var(--primary-blue); border: 1px solid var(--primary-blue);">Belum punya akun? Registrasi</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>