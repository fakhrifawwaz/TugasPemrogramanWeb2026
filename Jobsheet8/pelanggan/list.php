<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fakhri Rent Car | Daftar Pelanggan</title>
    <link rel="stylesheet" href="../assets/css/style.css ">
</head>
    <body>
        <header>
            <div class="brand-group">
                <h1>FAKHRI RENT CAR</h1>
                <p class="subtitle">SIRENMO — Sistem Informasi Rental Mobil</p>
            </div>
            <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
            <nav>
                <ul>
                    <li><a href="../index.html">Beranda</a></li>
                    <li><a href="../mobil/list.html">Daftar Mobil</a></li>
                    <li><a href="../mobil/tambah.html">Tambah Mobil</a></li>
                    <li><a href="list.html" class="aktif">Daftar Pelanggan</a></li>
                    <li><a href="tambah.html">Tambah Pelanggan</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section>
                <h2>Daftar Pelanggan</h2>
                <div class="search-box">
                    <input type="text" id="search-input" placeholder="Cari data...">
                </div>

                <!-- Indikator Loading -->
                <p id="loading-indicator" style="display:none;">Memuat data...</p>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris diisi dinamis oleh assets/js/pelanggan.js -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2026 Fakhri Rent Car &mdash; Pemrograman Web </p>
        </footer>
            <script src="../assets/js/app.js"></script>
            <script src="../assets/js/pelanggan.js"></script>
    </body>
</html>