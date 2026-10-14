<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_lembaga = mysqli_real_escape_string($koneksi, $_POST['nama_lembaga']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $deskripsi    = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $nama_pic     = mysqli_real_escape_string($koneksi, $_POST['nama_pic']);
    $telepon_pic  = mysqli_real_escape_string($koneksi, $_POST['telepon_pic']);
    
    $logo_name = NULL;

    if (isset($_FILES['logo_lembaga']) && $_FILES['logo_lembaga']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['logo_lembaga']['tmp_name'];
        $fileName    = $_FILES['logo_lembaga']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
        $uploadFileDir = '../assests/images/';
        
        if (move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)) {
            $logo_name = $newFileName;
        }
    }

    $query = "INSERT INTO partners (nama_lembaga, logo, alamat, deskripsi, nama_pic, telepon_pic) 
              VALUES ('$nama_lembaga', " . ($logo_name ? "'$logo_name'" : "NULL") . ", '$alamat', '$deskripsi', '$nama_pic', '$telepon_pic')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin-partner-table.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: admin-partner-table.php");
    exit;
}
?>