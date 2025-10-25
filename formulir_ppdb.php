<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran Siswa Baru Online</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h1>Formulir Pendaftaran Siswa Baru</h1>
        <p>Isi data diri calon siswa dan orang tua dengan lengkap dan benar.</p>
        
        <form action="proses_ppdb.php" method="POST" enctype="multipart/form-data">
            
            <fieldset>
                <legend>Data Calon Siswa</legend>
                <label for="nama_lengkap">Nama Lengkap:*</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                
                <label for="asal_sekolah">Asal Sekolah:*</label>
                <input type="text" id="asal_sekolah" name="asal_sekolah" required>

                <label for="nilai_rata2">Nilai Rata-Rata Raport Terakhir:*</label>
                <input type="number" step="0.01" id="nilai_rata2" name="nilai_rata2" required>
            </fieldset>

            <fieldset>
                <legend>Data Orang Tua/Wali</legend>
                <label for="nama_ayah">Nama Lengkap Ayah:*</label>
                <input type="text" id="nama_ayah" name="nama_ayah" required>
                
                <label for="nama_ibu">Nama Lengkap Ibu:*</label>
                <input type="text" id="nama_ibu" name="nama_ibu" required>
                
                <label for="alamat">Alamat Lengkap:*</label>
                <textarea id="alamat" name="alamat" required></textarea>
                
                <label for="no_hp">Nomor HP/WA yang dapat dihubungi:*</label>
                <input type="tel" id="no_hp" name="no_hp" required>
            </fieldset>

            <fieldset>
                <legend>Upload Dokumen Pendukung</legend>
                <p class="keterangan">Silakan unggah dokumen dalam format PDF atau JPG (ukuran maksimal 2MB per file).</p>
                
                <label for="upload_kk">Scan Kartu Keluarga (KK):</label>
                <input type="file" id="upload_kk" name="upload_kk" accept=".pdf, .jpg, .jpeg">
                
                <label for="upload_akta">Scan Akta Kelahiran:</label>
                <input type="file" id="upload_akta" name="upload_akta" accept=".pdf, .jpg, .jpeg">

                <label for="upload_ktp">scan kartu tanda penduduk(ktp):</label>
                <input type="file" id="upload_ktp" name="upload_ktp" accept=".pdf, .jgp, jpeg">

                <label for="upload_ijazah">Scan Ijazah Terakhir:</label>
                <input type="file" id="upload_ijazah" name="upload_ijazah" accept=".pdf, .jpg, .jpeg">
            </fieldset>

            <div style="text-align: center; margin-top: 30px;">
                <input type="submit" value="Kirim Pendaftaran" style="padding: 15px 30px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1em;">
            </div>

        </form>
        <button onclick="window.location.href='pendaftaran.html'" style="margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Kembali ke Beranda</button>
    </div>
</body>
</html>