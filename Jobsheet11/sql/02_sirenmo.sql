CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL
);

-- Tambahkan user bawaan untuk login (Username: admin, Password: admin123)
INSERT INTO users (username, password, nama) 
VALUES ('admin', 'admin123', 'Fakhri')
ON CONFLICT (username) DO NOTHING;