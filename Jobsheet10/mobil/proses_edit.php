<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id       = $_POST['id'] ?? null;
$no_mobil = trim($_POST['no_mobil'] ?? '');
$merek    = trim($_POST['merek'] ?? '');
$tipe     = trim($_POST['tipe'] ?? '');
$tahun    = $_POST['tahun'] ?? '';

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];

if (empty($no_mobil)) {
    $errors[] = "Nomor plat mobil wajib diisi.";
}
if (empty($merek)) {
    $errors[] = "Merek mobil wajib diisi.";
}
if (empty($tipe)) {
    $errors[] = "Tipe mobil wajib diisi.";
}
if (empty($tahun) || !is_numeric($tahun)) {
    $errors[] = "Tahun harus berupa angka.";
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
        UPDATE mobil 
        SET no_mobil = :no_mobil, 
            merek = :merek, 
            tipe = :tipe, 
            tahun = :tahun 
        WHERE id = :id
    ");

    $stmt->execute([
        'no_mobil' => $no_mobil,
        'merek'    => $merek,
        'tipe'     => $tipe,
        'tahun'    => (int) $tahun,
        'id'       => $id,
    ]);

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => 'Data mobil berhasil diperbarui!'
    ];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $msg = "Nomor plat '{$no_mobil}' sudah terdaftar! Gunakan nomor plat lain.";
    } else {
        $msg = 'Gagal memperbarui data: ' . $e->getMessage();
    }

    $_SESSION['flash'] = [
        'type'    => 'danger',
        'message' => $msg
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}