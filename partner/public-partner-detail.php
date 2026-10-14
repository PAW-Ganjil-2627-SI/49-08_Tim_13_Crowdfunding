<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query  = "SELECT * FROM partners WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: public-partner-list.php");
    exit;
}

$logo = !empty($data['logo']) ? "../assests/images/" . $data['logo'] : "../assests/images/hero-home.jpg";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mitra - <?= htmlspecialchars($data['nama_lembaga']); ?></title>
    <link rel="stylesheet" href="../assests/css/style.css">
    <style>
        * { box-sizing: border-box; }
        .detail-card {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .detail-header {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .detail-header img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        .detail-info { margin-bottom: 15px; }
        .detail-info h4 { margin: 0 0 5px 0; color: #444; }
        .detail-info p { margin: 0; color: #666; line-height: 1.5; }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="../index.html" class="brand">MR. BUAS</a>
            <ul class="nav-links">
                <li><a href="public-partner-list.php">Lembaga Penyalur</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <div class="detail-card">
            <div class="detail-header">
                <img src="<?= $logo; ?>" alt="<?= htmlspecialchars($data['nama_lembaga']); ?>">
                <div>
                    <h2><?= htmlspecialchars($data['nama_lembaga']); ?></h2>
                    <p style="color: #777;">Terdaftar sejak: <?= date('d M Y', strtotime($data['created_at'])); ?></p>
                </div>
            </div>

            <div class="detail-info">
                <h4>Alamat Kantor</h4>
                <p><?= htmlspecialchars($data['alamat']); ?></p>
            </div>

            <div class="detail-info">
                <h4>Penanggung Jawab (PIC Lapangan)</h4>
                <p><?= htmlspecialchars($data['nama_pic']); ?> (<?= htmlspecialchars($data['telepon_pic']); ?>)</p>
            </div>

            <div class="detail-info">
                <h4>Profil / Deskripsi Lembaga</h4>
                <p><?= nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
            </div>

            <a href="public-partner-list.php" class="btn-back">&laquo; Kembali ke Daftar Mitra</a>
        </div>
    </main>

</body>
</html>