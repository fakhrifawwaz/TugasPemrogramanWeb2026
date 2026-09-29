/**
 * SIRENMO - Sistem Informasi Rental Mobil
 * Script Aplikasi Utama
 */

document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initNavToggle();
});

/**
 * Konfirmasi Hapus via Event 'submit'
 *
 * Mengantisipasi form penghapusan data mobil / pelanggan dengan class "form-hapus".
 * Jika pengguna menekan "Batal/Cancel", submit form akan dibatalkan (preventDefault).
 */
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        
        // Memastikan event submit berasal dari form dengan class "form-hapus"
        if (!form.classList.contains("form-hapus")) return;

        // Mengambil baris tabel (tr) induk untuk membaca nama/identitas data
        const row = form.closest("tr");
        
        // Mengambil teks dari kolom pertama (misal: No. Mobil / No. KTP / Nama)
        const identifier = row ? row.querySelector("td")?.textContent.trim() : "data ini";

        const yakin = confirm('Apakah Anda yakin ingin menghapus "' + identifier + '"?');

        // Jika pengguna menekan Cancel/Batal, cegah pengiriman form ke server
        if (!yakin) {
            e.preventDefault();
        }
    });
}

/**
 * Toggle Navigasi Responsif
 */
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const navMenu = document.querySelector("header nav");

    if (toggleBtn && navMenu) {
        toggleBtn.addEventListener("click", function () {
            navMenu.classList.toggle("active");
        });
    }
}