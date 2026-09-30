<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id     = $_POST['id'] ?? null;
$nama   = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp  = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];

if (empty($nama)) {
    $errors[] = "Nama pelanggan wajib diisi.";
}
if (empty($alamat)) {
    $errors[] = "Alamat wajib diisi.";
}
if (empty($no_hp)) {
    $errors[] = "Nomor HP wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'danger',
        'message' => implode(' ', $errors)
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE pelanggan 
        SET nama = :nama, 
            alamat = :alamat, 
            no_hp = :no_hp 
        WHERE id = :id
    ");

    $stmt->execute([
        'nama'   => $nama,
        'alamat' => $alamat,
        'no_hp'  => $no_hp,
        'id'     => $id,
    ]);

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => 'Data pelanggan berhasil diperbarui!'
    ];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['flash'] = [
        'type'    => 'danger',
        'message' => 'Gagal memperbarui data: ' . $e->getMessage()
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}