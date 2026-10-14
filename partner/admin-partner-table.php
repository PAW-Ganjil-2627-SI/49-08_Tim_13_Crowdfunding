<?php
include '../koneksi.php';

$search = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, trim($_GET['q'])) : '';

if (!empty($search)) {
    $query_str = "SELECT * FROM partners WHERE nama_lembaga LIKE '%$search%' OR alamat LIKE '%$search%' ORDER BY id DESC";
} else {
    $query_str = "SELECT * FROM partners ORDER BY id DESC";
}

$query = mysqli_query($koneksi, $query_str);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Lembaga Penyalur - Admin</title>
    <link rel="stylesheet" href="../assests/css/style.css">
    
    <style>
        * { box-sizing: border-box; }
        .admin-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .table-tools {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }
        .search-input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
            font-size: 0.9em;
        }
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        table th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        .btn-action {
            padding: 6px 12px;
            font-size: 0.85em;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 3px;
            color: white;
            display: inline-block;
        }
        .btn-success { background-color: #28a745; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; }
        .btn-primary { background-color: #007bff; }
        .pic-info { font-size: 0.85em; color: #666; display: block; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="../index.html" class="brand">Admin Panel</a>
            <ul class="nav-links">
                <li><a href="admin-partner-table.php">Kelola Mitra</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <div class="admin-container">
            
            <div class="header-action">
                <div>
                    <h1>Manajemen Lembaga Penyalur</h1>
                    <p style="color: #666; margin: 5px 0 0 0;">Daftar seluruh yayasan dan mitra yang terdaftar dalam sistem.</p>
                </div>
                <a href="admin-partner-create.php" class="btn-action btn-primary" style="padding: 10px 16px; font-size: 0.95em;">+ Tambah Mitra Baru</a>
            </div>

            <form method="GET" action="admin-partner-table.php" class="table-tools">
                <input type="text" name="q" class="search-input" placeholder="Cari nama lembaga atau alamat..." value="<?= htmlspecialchars($search); ?>">
            </form>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Lembaga</th>
                            <th>Alamat Kantor</th>
                            <th>PIC Lapangan</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($row['nama_lembaga']); ?></strong></td>
                                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                                    <td>
                                        <?= htmlspecialchars($row['nama_pic']); ?>
                                        <span class="pic-info"><?= htmlspecialchars($row['telepon_pic']); ?></span>
                                    </td>
                                    <td>
                                        <a href="public-partner-detail.php?id=<?= $row['id']; ?>" class="btn-action btn-success">Detail</a>
                                        <a href="admin-partner-edit.php?id=<?= $row['id']; ?>" class="btn-action btn-warning">Edit</a>
                                        <a href="admin-partner-delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="btn-action btn-danger">Hapus</a>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else { 
                        ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #888;">Tidak ada data lembaga penyalur.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>