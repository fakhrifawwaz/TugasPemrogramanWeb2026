-- Jobsheet 8: Skema awal database SIRENMO (PostgreSQL)
-- Jalankan setelah membuat database di terminal/pgAdmin:
--   createdb sirenmo
--   psql -d sirenmo -f sql/01_sirenmo.sql

CREATE TABLE IF NOT EXISTS mobil (
    id SERIAL PRIMARY KEY,
    no_mobil VARCHAR(20) NOT NULL UNIQUE,
    merek VARCHAR(100) NOT NULL,
    tipe VARCHAR(100) NOT NULL,
    tahun INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS pelanggan (
    id SERIAL PRIMARY KEY,
    no_ktp VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(255) NOT NULL,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);