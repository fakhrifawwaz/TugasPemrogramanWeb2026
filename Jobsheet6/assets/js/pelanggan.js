// Mengambil & menampilkan Daftar Pelanggan secara asinkron dari data/pelanggan.json
async function muatDaftarPelanggan() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi delay jaringan agar loading indicator sempat terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/pelanggan.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarPelanggan = await res.json();

        daftarPelanggan.forEach(function (pelanggan) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + pelanggan.nama + "</td>" +
                "<td>" + pelanggan.alamat + "</td>" +
                "<td>" + pelanggan.no_telp + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });

        // Pasang ulang event listener hapus untuk elemen yang baru dibuat secara dinamis
        if (typeof initHapusConfirm === "function") {
            initHapusConfirm();
        }
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"4\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarPelanggan);