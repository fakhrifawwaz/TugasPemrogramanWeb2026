<?php
// Ambil URL koneksi database dari Railway
$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl) {
    // === KONEKSI RAILWAY ===
    $dbopts = parse_url($databaseUrl);
    
    $host = $dbopts["host"];
    $port = $dbopts["port"];
    $user = $dbopts["user"];
    $pass = $dbopts["pass"];
    $db   = ltrim($dbopts["path"], '/');

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi Railway gagal: " . $e->getMessage());
    }
} else {
    // === KONEKSI LOKAL (KOMPUTER ANDA) ===
    try {
        $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=sirenmo", "postgres", "12345678");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi Lokal gagal: " . $e->getMessage());
    }
}
?>