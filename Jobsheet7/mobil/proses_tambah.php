<?php
session_start();

// 1. Menerima & membersihkan input dari form ($_POST)
$no_mobil = trim($_POST['no_mobil'] ?? '');
$merek    = trim($_POST['merek'] ?? '');
$tipe     = trim($_POST['tipe'] ?? '');
$tahun    = $_POST['tahun'] ?? '';

// 2. Validasi di sisi server (Server-side validation)
$errors = [];

if ($no_mobil === '') {
    $errors[] = "Nomor mobil/plat wajib diisi.";
}
if ($merek === '') {
    $errors[] = "Merek wajib diisi.";
}
if ($tipe === '') {
    $errors[] = "Tipe wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 2010 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 2010–2026.";
}

// 3. Jika ada error: simpan pesan ke flash session & kembalikan ke form
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

// 4. Jika valid: inisialisasi array session jika belum ada
if (!isset($_SESSION['mobil'])) {
    $_SESSION['mobil'] = [];
}

// 5. Simpan data baru ke dalam session
$_SESSION['mobil'][] = [
    'no_mobil' => $no_mobil,
    'merek'    => $merek,
    'tipe'     => $tipe,
    'tahun'    => (int) $tahun
];

// 6. Set pesan sukses & alihkan ke halaman daftar mobil
$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Data mobil berhasil ditambahkan.'
];

header('Location: list.php');
exit;