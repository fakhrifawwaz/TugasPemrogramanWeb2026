<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// 1. Ambil & bersihkan input
$no_mobil = trim($_POST['no_mobil'] ?? '');
$merek    = trim($_POST['merek'] ?? '');
$tipe     = trim($_POST['tipe'] ?? '');
$tahun    = trim($_POST['tahun'] ?? '');

// 2. Validasi Server-Side
if ($no_mobil === '' || $merek === '' || $tipe === '' || $tahun === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Semua kolom wajib diisi.'];
    header('Location: tambah.php');
    exit;
}

if (!is_numeric($tahun) || (int)$tahun < 1900 || (int)$tahun > 2026) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Tahun harus di antara 1900–2026.'];
    header('Location: tambah.php');
    exit;
}

// 3. Simpan ke Database PostgreSQL (Ganti logika Session ke SQL)
try {
    $stmt = $pdo->prepare(
        "INSERT INTO mobil (no_mobil, merek, tipe, tahun)
         VALUES (:no_mobil, :merek, :tipe, :tahun)
         RETURNING id"
    );

    $stmt->execute([
        'no_mobil' => $no_mobil,
        'merek'    => $merek,
        'tipe'     => $tipe,
        'tahun'    => (int) $tahun,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data mobil berhasil ditambahkan.'];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data: Plat nomor sudah terdaftar.'];
    header('Location: tambah.php');
    exit;
}