<?php
session_start();
require __DIR__ . '/../includes/auth.php'; 
require __DIR__ . '/../includes/csrf.php'; 
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM mobil WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = [
            'type'    => 'success',
            'message' => 'Data mobil berhasil dihapus.'
        ];
    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type'    => 'danger',
            'message' => 'Gagal menghapus data mobil: ' . $e->getMessage()
        ];
    }
}

header('Location: list.php');
exit;