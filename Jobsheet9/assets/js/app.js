/**
 * SIRENMO - Sistem Informasi Rental Mobil
 * Script Aplikasi Utama
 */

document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initUpdateConfirm(); // Inisialisasi konfirmasi update
    initNavToggle();
});

/**
 * Konfirmasi Hapus via Event 'submit'
 */
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const identifier = row ? row.querySelector("td")?.textContent.trim() : "data ini";

        const yakin = confirm('Apakah Anda yakin ingin menghapus "' + identifier + '"?');

        if (!yakin) {
            e.preventDefault();
        }
    });
}

/**
 * Konfirmasi Ekstra Sebelum Update (Edit Data)
 */
function initUpdateConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        
        // Memeriksa apakah form yang di-submit adalah form edit (mempunyai class / id form-edit)
        if (!form.classList.contains("form-edit") && form.id !== "form-edit") return;

        const yakin = confirm("Apakah Anda yakin ingin menyimpan perubahan data ini?");

        // Jika pengguna menekan Batal / Cancel, cegah pengiriman form
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
            navMenu.classList.toggle("nav-open");
        });
    }
}