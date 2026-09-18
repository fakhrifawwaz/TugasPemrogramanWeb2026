// Mengambil & menampilkan Daftar Mobil secara asinkron dari data/mobil.json
async function muatDaftarMobil() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi delay jaringan agar loading indicator sempat terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/mobil.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarMobil = await res.json();

        daftarMobil.forEach(function (mobil) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + mobil.no_mobil + "</td>" +
                "<td>" + mobil.merek + "</td>" +
                "<td>" + mobil.tipe + "</td>" +
                "<td>" + mobil.tahun + "</td>" +
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
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarMobil);