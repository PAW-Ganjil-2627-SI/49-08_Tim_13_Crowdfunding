<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id           = (int)$_POST['id'];
    $nama_lembaga = mysqli_real_escape_string($koneksi, $_POST['nama_lembaga']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $deskripsi    = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $nama_pic     = mysqli_real_escape_string($koneksi, $_POST['nama_pic']);
    $telepon_pic  = mysqli_real_escape_string($koneksi, $_POST['telepon_pic']);

    $update_logo_sql = "";

    if (isset($_FILES['logo_lembaga']) && $_FILES['logo_lembaga']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['logo_lembaga']['tmp_name'];
        $fileName      = $_FILES['logo_lembaga']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $newFileName   = time() . '_' . uniqid() . '.' . $fileExtension;
        $uploadFileDir = '../assests/images/';
        
        if (move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)) {
            $update_logo_sql = ", logo = '$newFileName'";
        }
    }

    $query = "UPDATE partners SET 
                nama_lembaga = '$nama_lembaga',
                alamat = '$alamat',
                deskripsi = '$deskripsi',
                nama_pic = '$nama_pic',
                telepon_pic = '$telepon_pic'
                $update_logo_sql
              WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin-partner-table.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: admin-partner-table.php");
    exit;
}
?>