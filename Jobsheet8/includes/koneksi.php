<?php
$host = "localhost";
$port = "5432";
$db   = "sirenmo";
$user = "postgres";
$pass = "12345678"; // Sesuaikan dengan password PostgreSQL milikmu

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}