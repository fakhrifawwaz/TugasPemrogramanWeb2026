<?php
$dbUrl = getenv('DATABASE_URL');

if ($dbUrl) {
    // KONEKSI DI RAILWAY
    $dbopts = parse_url($dbUrl);
    
    $host = $dbopts["host"];
    $port = $dbopts["port"];
    $user = $dbopts["user"];
    $pass = $dbopts["pass"];
    $db   = ltrim($dbopts["path"], '/');
} else {
    // KONEKSI DI LOKAL (KOMPUTER ANDA)
    $host = "localhost";
    $port = "5432";
    $db   = "sirenmo";
    $user = "postgres";
    $pass = "12345678";
}

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>