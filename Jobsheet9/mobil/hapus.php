<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM mobil WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $_SESSION['flash'] = $stmt->rowCount() > 0
            ? ['type' => 'success', 'pesan' => 'Data mobil berhasil dihapus.']
            : ['type' => 'danger',  'pesan' => 'Data mobil tidak ditemukan.'];
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Gagal menghapus: ' . $e->getMessage()];
    }
}

header('Location: list.php');
exit;