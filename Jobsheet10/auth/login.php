<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login - SIRENMO";
include __DIR__ . '/../includes/header.php';
?>

<main>
    <section>
        <h2>Login SIRENMO</h2>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash flash-<?php echo $_SESSION['flash']['type'] === 'error' ? 'danger' : 'success'; ?>">
                <?php echo $_SESSION['flash']['pesan']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_login.php" method="post">
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required autocomplete="username">
            </p>

            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </p>

            <p>
                <button type="submit">Masuk</button>
                <a href="register.php" class="btn-secondary">Belum punya akun? Registrasi</a>
            </p>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>