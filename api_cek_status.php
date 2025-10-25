<?php
// SET HEADER AGAR BROWSER TAHU INI ADALAH JSON
header('Content-Type: application/json');
include("koneksi.php"); 

$response = ['success' => false, 'message' => ''];

if (isset($_GET['nomor']) && !empty($_GET['nomor'])) {
    
    $nomor_pendaftaran_input = mysqli_real_escape_string($koneksi, trim($_GET['nomor']));
    
    // Logika Ekstraksi ID
    $pos_strip = strrpos($nomor_pendaftaran_input, '-');
    $id_pendaftar = ($pos_strip !== false) ? substr($nomor_pendaftaran_input, $pos_strip + 1) : 0;
    
    if (!is_numeric($id_pendaftar) || $id_pendaftar <= 0) {
        $response['message'] = "Nomor Pendaftaran tidak valid.";
    } else {
        
        $query = "SELECT nama_lengkap, status_verifikasi FROM pendaftar_online WHERE id_pendaftar = '$id_pendaftar'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $response['success'] = true;
            $response['nama'] = htmlspecialchars($data['nama_lengkap']);
            $response['status'] = htmlspecialchars($data['status_verifikasi']);
            $response['nomor'] = $nomor_pendaftaran_input;
            
        } else {
            $response['message'] = "Nomor Pendaftaran tidak ditemukan.";
        }
    }
    
    mysqli_close($koneksi);
} else {
    $response['message'] = "Input nomor pendaftaran kosong.";
}

// KIRIM HASIL DALAM FORMAT JSON
echo json_encode($response);
?>