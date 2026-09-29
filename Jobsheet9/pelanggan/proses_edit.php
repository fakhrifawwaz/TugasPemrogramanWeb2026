<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id         = $_POST['id'] ?? null;
$nama       = trim($_POST['nama'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_telepon = trim($_POST['no_telepon'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

if ($nama === '' || $alamat === '' || $no_telepon === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Semua kolom wajib diisi!'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE pelanggan
        SET nama = :nama, alamat = :alamat, no_telepon = :no_telepon
        WHERE id = :id
    ");
    $stmt->execute([
        'nama'       => $nama,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,
        'id'         => (int)$id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data pelanggan berhasil diperbarui!'];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}