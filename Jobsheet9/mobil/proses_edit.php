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
$tahun    = (int)($_POST['tahun'] ?? 0);

if (!$id) {
    header('Location: list.php');
    exit;
}

if ($no_mobil === '' || $merek === '' || $tipe === '' || $tahun <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Semua bidang wajib diisi dengan benar!'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE mobil
        SET no_mobil = :no_mobil, merek = :merek, tipe = :tipe, tahun = :tahun
        WHERE id = :id
    ");
    $stmt->execute([
        'no_mobil' => $no_mobil,
        'merek'    => $merek,
        'tipe'     => $tipe,
        'tahun'    => $tahun,
        'id'       => (int)$id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data mobil berhasil diperbarui.'];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $pesan = ($e->getCode() === '23505')
        ? "Nomor plat '{$no_mobil}' sudah dipakai mobil lain!"
        : 'Terjadi kesalahan database: ' . $e->getMessage();
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => $pesan];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}