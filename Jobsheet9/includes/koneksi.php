<?php
// Ambil konfigurasi dari Railway Environment Variables
$host = getenv('PGHOST') ?: getenv('POSTGRES_HOST');
$port = getenv('PGPORT') ?: '5432';
$db   = getenv('PGDATABASE') ?: getenv('POSTGRES_DB');
$user = getenv('PGUSER') ?: getenv('POSTGRES_USER');
$pass = getenv('PGPASSWORD') ?: getenv('POSTGRES_PASSWORD');

// Cek apakah berjalan di Railway
if ($host && $db && $user) {
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi Railway gagal: " . $e->getMessage());
    }
} else {
    // Jalur Koneksi Lokal (Komputer Anda)
    try {
        $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=sirenmo", "postgres", "12345678");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi Lokal gagal: " . $e->getMessage());
    }
}
?>