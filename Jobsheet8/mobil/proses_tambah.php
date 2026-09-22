<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_mobil = trim($_POST['no_mobil'] ?? '');
    $merek    = trim($_POST['merek'] ?? '');
    $tipe     = trim($_POST['tipe'] ?? '');
    $tahun    = (int)($_POST['tahun'] ?? 0);

    // 1. Validasi Input Kosong
    if (empty($no_mobil) || empty($merek) || empty($tipe) || $tahun <= 0) {
        $_SESSION['flash'] = [
            'type'  => 'danger',
            'pesan' => 'Semua bidang form wajib diisi dengan benar!'
        ];
        header('Location: tambah.php');
        exit;
    }

    // 2. Eksekusi Query dengan try-catch
    try {
        $stmt = $pdo->prepare("
            INSERT INTO mobil (no_mobil, merek, tipe, tahun) 
            VALUES (:no_mobil, :merek, :tipe, :tahun)
        ");
        
        $stmt->execute([
            'no_mobil' => $no_mobil,
            'merek'    => $merek,
            'tipe'     => $tipe,
            'tahun'    => $tahun
        ]);

        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Data mobil berhasil ditambahkan.'
        ];
        header('Location: list.php');
        exit;

    } catch (PDOException $e) {
        // Kode '23505' adalah SQLSTATE PostgreSQL khusus untuk pelanggaran UNIQUE constraint
        if ($e->getCode() === '23505') {
            $pesanError = "Nomor plat '{$no_mobil}' sudah terdaftar! Gunakan nomor plat lain.";
        } else {
            $pesanError = "Terjadi kesalahan database: " . $e->getMessage();
        }

        $_SESSION['flash'] = [
            'type'  => 'danger',
            'pesan' => $pesanError
        ];
        
        // Kembalikan pengguna ke form tambah
        header('Location: tambah.php');
        exit;
    }
}