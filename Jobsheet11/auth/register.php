<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas SIRENMO";

// WAJIB: $base = "../" agar path CSS di header.php terbaca dari dalam folder auth/
$base = "../";

include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main>
    <div class="card" style="max-width: 450px; margin: 40px auto;">
        <h2>Registrasi Petugas SIRENMO</h2>

        <?php if (!empty($flash)): ?>
            <?php 
                $message = is_array($flash) ? ($flash['pesan'] ?? '') : $flash;
                $isSuccess = (isset($flash['type']) && $flash['type'] === 'success');
                $bgColor = $isSuccess ? '#d4edda' : '#f8d7da';
                $textColor = $isSuccess ? '#155724' : '#721c24';
            ?>
            <div style="padding: 10px 14px; margin-bottom: 20px; background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>; border-radius: 4px; font-size: 0.9rem;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="proses_register.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Masukkan username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" minlength="6" required placeholder="Masukkan password (min. 6 karakter)">
            </div>

            <div style="margin-top: 24px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-simpan">Daftar</button>
                <a href="login.php" class="btn btn-edit" style="background-color: transparent; color: var(--primary-blue); border: 1px solid var(--primary-blue);">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>