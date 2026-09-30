<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = trim($_POST['nama'] ?? '');
    $alamat     = trim($_POST['alamat'] ?? '');
    $no_telepon = trim($_POST['no_hp'] ?? $_POST['no_telepon'] ?? '');

    if (empty($nama) || empty($alamat) || empty($no_telepon)) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Semua kolom wajib diisi!'
        ];
        header('Location: tambah.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO pelanggan (nama, alamat, no_telepon) 
            VALUES (:nama, :alamat, :no_telepon)
        ");
        
        $stmt->execute([
            'nama'       => $nama,
            'alamat'     => $alamat,
            'no_telepon' => $no_telepon
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Data pelanggan berhasil ditambahkan!'
        ];
        
        header('Location: list.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data: ' . $e->getMessage()
        ];
        header('Location: tambah.php');
        exit;
    }
} else {
    header('Location: list.php');
    exit;
}