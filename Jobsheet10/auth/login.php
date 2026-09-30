<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login SIRENMO";
include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <h2>Login SIRENMO</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'error' ? 'danger' : 'success'; ?>">
            <?= $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="proses_login.php" method="POST" class="mt-3">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Masuk</button>
        <a href="register.php" class="btn btn-link">Belum punya akun? Registrasi</a>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>