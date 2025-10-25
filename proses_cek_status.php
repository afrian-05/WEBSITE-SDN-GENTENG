<?php
// 1. Sertakan file koneksi database
include("koneksi.php"); 

$status_result = "";

if (isset($_GET['nomor']) && !empty($_GET['nomor'])) {
    
    // Ambil input dari user dan amankan
    $nomor_pendaftaran_input = mysqli_real_escape_string($koneksi, trim($_GET['nomor']));
    
    // 2. LOGIKA EKSTRAKSI ID (Diperbaiki)
    // Mencari karakter '-' terakhir untuk memisahkan ID.
    $pos_strip = strrpos($nomor_pendaftaran_input, '-');
    
    // Pastikan formatnya benar dan ID adalah numerik
    if ($pos_strip !== false) {
        $id_pendaftar = substr($nomor_pendaftaran_input, $pos_strip + 1);
    } else {
        // Jika format salah, anggap ID tidak valid
        $id_pendaftar = 0; 
    }

    // Pastikan ID adalah angka dan lebih besar dari 0 sebelum query
    if (!is_numeric($id_pendaftar) || $id_pendaftar <= 0) {
        $status_result = "<p style='color: red; margin-top: 20px;'>Nomor Pendaftaran tidak valid atau format salah. (Contoh: PPDB-2025-1)</p>";
    } else {
        
        // 3. Query Database
        $query = "SELECT nama_lengkap, status_verifikasi FROM pendaftar_online WHERE id_pendaftar = '$id_pendaftar'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $nama = htmlspecialchars($data['nama_lengkap']);
            $status = htmlspecialchars($data['status_verifikasi']);
            
            // Logika pewarnaan status
            $color = 'orange'; // Menunggu
            if ($status == 'Diterima') {
                $color = 'green';
            } elseif ($status == 'Ditolak') {
                $color = 'red';
            }
            
            // 4. Tampilkan Hasil (Output HTML)
            $status_result = "
                <div style='border: 2px solid $color; padding: 20px; margin-top: 20px; border-radius: 8px;'>
                    <h3>Hasil Pengecekan Status</h3>
                    <p>Nama Calon Siswa: <b>$nama</b></p>
                    <p>Nomor Pendaftaran: <b>$nomor_pendaftaran_input</b></p>
                    <p style='font-size: 1.5em; color: $color; font-weight: bold;'>
                        STATUS: $status
                    </p>
                    <p>Silakan tunggu informasi selanjutnya dari pihak sekolah.</p>
                </div>
            ";
            
        } else {
            $status_result = "<p style='color: red; margin-top: 20px;'>Nomor Pendaftaran tidak ditemukan. Mohon cek kembali.</p>";
        }
    }
    
    mysqli_close($koneksi);
} else {
    // Jika diakses tanpa nomor, arahkan kembali ke halaman pendaftaran
    header("Location: pendaftaran.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Hasil Cek Status PPDB</title>
</head>
<body>
    <div style="max-width: 600px; margin: 50px auto; padding: 20px;">
        <a href="pendaftaran.php" style="color: #007bff; text-decoration: none;">← Kembali ke Halaman Pendaftaran</a>
        <?php echo $status_result; ?>
    </div>
</body>
</html>