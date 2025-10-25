document.addEventListener("DOMContentLoaded", function () {
  // =========================================================
  // 1. CEK STATUS PPDB (AJAX) - Fungsionalitas Utama
  // =========================================================
  const formCekStatus = document.getElementById("formCekStatus");

  if (formCekStatus) {
    const hasilDiv = document.getElementById("hasil-status");
    const cekButton = document.getElementById("btnCekStatus");
    const nomorInput = document.getElementById("nomor_daftar");

    formCekStatus.addEventListener("submit", function (event) {
      event.preventDefault(); // Mencegah form submit normal (pindah halaman)

      const inputNomor = nomorInput.value.trim();

      if (inputNomor === "") {
        hasilDiv.innerHTML =
          '<p style="color: red; margin-top: 10px;">Mohon masukkan nomor pendaftaran.</p>';
        return;
      }

      hasilDiv.innerHTML =
        '<p style="color: #007bff; margin-top: 10px;">Sedang memproses...</p>';
      cekButton.disabled = true;

      // AJAX FETCH REQUEST
      // Asumsi api_cek_status.php berada di folder yang sama dengan file pendaftaran.php
      fetch(`api_cek_status.php?nomor=${encodeURIComponent(inputNomor)}`)
        .then((response) => {
          if (!response.ok) {
            // Throw error untuk kegagalan HTTP (misal 404/500)
            throw new Error(`Gagal memuat API: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          cekButton.disabled = false;

          if (data.success) {
            let color;
            let pesanKhusus =
              "Silakan tunggu informasi selanjutnya dari pihak sekolah.";

            if (data.status === "Diterima") {
              color = "green";
              pesanKhusus =
                "Selamat! Anda dinyatakan **Diterima**. Silakan lakukan proses daftar ulang.";
            } else if (data.status === "Ditolak") {
              color = "red";
              pesanKhusus = "Mohon maaf, Anda dinyatakan **Ditolak**.";
            } else {
              color = "orange";
            }

            hasilDiv.innerHTML = `
                            <div style="border: 2px solid ${color}; padding: 20px; margin-top: 20px; border-radius: 8px;">
                                <h3>Hasil Pengecekan Status</h3>
                                <p>Nama Calon Siswa: <b>${data.nama}</b></p>
                                <p>Nomor Pendaftaran: <b>${data.nomor}</b></p>
                                <p style="font-size: 1.5em; color: ${color}; font-weight: bold;">
                                    STATUS: ${data.status}
                                </p>
                                <p>${pesanKhusus}</p>
                            </div>
                        `;
          } else {
            // Jika data.success adalah false (Nomor tidak ditemukan/Invalid)
            hasilDiv.innerHTML = `<p style="color: red; margin-top: 20px;">${data.message}</p>`;
          }
        })
        .catch((error) => {
          cekButton.disabled = false;
          console.error("Error fetching status:", error);
          hasilDiv.innerHTML =
            '<p style="color: red; margin-top: 20px;">Terjadi kesalahan saat menghubungi server atau format API salah.</p>';
        });
    });
  }

  // =========================================================
  // 2. SCROLL TO TOP (Diadaptasi dari kode lama Anda)
  // =========================================================
  const toTop = document.createElement("button");
  toTop.innerText = "⬆";
  toTop.id = "toTopBtn";
  document.body.appendChild(toTop);

  toTop.style.position = "fixed";
  toTop.style.bottom = "20px";
  toTop.style.right = "20px";
  toTop.style.backgroundColor = "#004aad";
  toTop.style.color = "white";
  toTop.style.border = "none";
  toTop.style.borderRadius = "50%";
  toTop.style.width = "40px";
  toTop.style.height = "40px";
  toTop.style.cursor = "pointer";
  toTop.style.display = "none";
  toTop.style.zIndex = "9999";

  window.onscroll = function () {
    if (
      document.body.scrollTop > 200 ||
      document.documentElement.scrollTop > 200
    ) {
      toTop.style.display = "block";
    } else {
      toTop.style.display = "none";
    }
  };

  toTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // =========================================================
  // 3. VALIDASI FORM KONTAK (Diadaptasi dari kode lama Anda)
  // =========================================================
  // Asumsi form kontak Anda memiliki ID unik, misalnya id="formKontak"
  const formKontak = document.querySelector("#formKontak");

  if (formKontak) {
    formKontak.addEventListener("submit", (e) => {
      e.preventDefault(); // Mencegah submit normal (penting untuk AJAX/JS)

      // Perlu disesuaikan dengan ID input field Anda yang sebenarnya
      const name = document.querySelector("#nama").value.trim();
      const email = document.querySelector("#email").value.trim();
      const pesan = document.querySelector("#pesan").value.trim();

      if (name === "" || email === "" || pesan === "") {
        alert("Mohon lengkapi semua kolom sebelum mengirim!");
        return;
      }

      if (!email.includes("@")) {
        alert("Alamat email tidak valid!");
        return;
      }

      alert(
        "Pesan berhasil dikirim! Terima kasih telah menghubungi SD Negeri Genteng."
      );
      formKontak.reset();
    });
  }

  // =========================================================
  // 4. ANIMASI & MENU NAVIGASI (Diadaptasi dari kode lama Anda)
  // =========================================================

  // Animasi muncul saat scroll
  const sections = document.querySelectorAll("section");
  window.addEventListener("scroll", () => {
    sections.forEach((sec) => {
      const position = sec.getBoundingClientRect().top;
      if (position < window.innerHeight - 100) {
        sec.classList.add("visible");
      }
    });
  });

  // Navigasi Burger/Toggle (Perlu disesuaikan ID-nya)
  const burgerBtn = document.getElementById("burgerBtn"); // Perlu diganti dengan ID/Class tombol burger Anda
  const navbarMenu = document.getElementById("navbarMenu"); // Perlu diganti dengan ID/Class menu navigasi Anda

  if (burgerBtn && navbarMenu) {
    burgerBtn.addEventListener("click", () => {
      navbarMenu.classList.toggle("active");
    });
  }

  // Interval slide (Perlu disesuaikan dengan fungsi nextSlide Anda)
  // Jika Anda ingin ini berjalan, pastikan fungsi nextSlide() didefinisikan
  // setInterval(nextSlide, 3000);
});
