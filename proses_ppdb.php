<?php
// 1. Sertakan file koneksi database
include("koneksi.php");

// 2. Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Ambil data teks dari formulir
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $asal_sekolah = mysqli_real_escape_string($koneksi, $_POST['asal_sekolah']);
    $nilai_rata2  = mysqli_real_escape_string($koneksi, $_POST['nilai_rata2']);
    $nama_ayah    = mysqli_real_escape_string($koneksi, $_POST['nama_ayah']);
    $nama_ibu     = mysqli_real_escape_string($koneksi, $_POST['nama_ibu']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp        = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $tgl_daftar   = date("Y-m-d H:i:s");
    $status       = "Menunggu Verifikasi";

    // 4. Proses Upload File
    $dir_upload = "uploads/"; // Buat folder 'uploads' di root proyek Anda
    
    // Pastikan folder 'uploads' ada dan dapat ditulis
    if (!is_dir($dir_upload)) {
        mkdir($dir_upload, 0777, true);
    }

    $nama_file_kk = '';
    $nama_file_akta = '';

    // Upload Kartu Keluarga
    if (isset($_FILES['upload_kk']) && $_FILES['upload_kk']['error'] == 0) {
        $ext_kk = pathinfo($_FILES['upload_kk']['name'], PATHINFO_EXTENSION);
        $nama_file_kk = "KK_" . time() . "." . $ext_kk;
        move_uploaded_file($_FILES['upload_kk']['tmp_name'], $dir_upload . $nama_file_kk);
    }
    
    // Upload Akta Kelahiran
    if (isset($_FILES['upload_akta']) && $_FILES['upload_akta']['error'] == 0) {
        $ext_akta = pathinfo($_FILES['upload_akta']['name'], PATHINFO_EXTENSION);
        $nama_file_akta = "Akta_" . time() . "." . $ext_akta;
        move_uploaded_file($_FILES['upload_akta']['tmp_name'], $dir_upload . $nama_file_akta);
    }

    // 5. Masukkan data ke Database
    $query = "INSERT INTO pendaftar_online (
        tgl_daftar, nama_lengkap, asal_sekolah, nilai_rata2, nama_ayah, nama_ibu, 
        alamat, no_hp, file_kk, file_akta, status_verifikasi
    ) VALUES (
        '$tgl_daftar', '$nama_lengkap', '$asal_sekolah', '$nilai_rata2', '$nama_ayah', '$nama_ibu', 
        '$alamat', '$no_hp', '$nama_file_kk', '$nama_file_akta', '$status'
    )";

    if (mysqli_query($koneksi, $query)) {
        // Pendaftaran berhasil
        $id_baru = mysqli_insert_id($koneksi); // Ambil ID pendaftar yang baru dibuat
        $no_pendaftaran = "PPDB-" . date("Y") . "-" . $id_baru;

        // 6. Notifikasi Sukses
        echo "
        <!DOCTYPE html>
        <html><body>
        <div style='text-align: center; margin-top: 50px;'>
            <h2>✅ Pendaftaran Berhasil!</h2>
            <p>Terima kasih, $nama_lengkap. Data Anda telah kami terima.</p>
            <h3>Nomor Pendaftaran Anda: $no_pendaftaran</h3>
            <p>Silakan catat nomor ini. Kami akan menghubungi Anda melalui WhatsApp/HP ($no_hp) untuk verifikasi lebih lanjut.</p>
            <a href='pendaftaran.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Kembali ke Beranda</a>
        </div>
        </body></html>
        ";
        
        // CATATAN: Fitur kirim email/WA otomatis akan memerlukan library tambahan 
        // dan konfigurasi server yang lebih kompleks. Untuk tahap awal, notifikasi di layar ini sudah cukup.

    } else {
        // Pendaftaran gagal
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    // 7. Tutup koneksi
    mysqli_close($koneksi);
} else {
    // Jika diakses tanpa submit form
    header("Location: formulir_ppdb.php");
    exit();
}
?>