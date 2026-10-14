<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM partners WHERE id = '$id'";
    mysqli_query($koneksi, $query);
}

header("Location: admin-partner-table.php");
exit;
?>