<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = [
            'type'    => 'success',
            'message' => 'Data pelanggan berhasil dihapus.'
        ];
    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type'    => 'danger',
            'message' => 'Gagal menghapus data pelanggan: ' . $e->getMessage()
        ];
    }
}

header('Location: list.php');
exit;