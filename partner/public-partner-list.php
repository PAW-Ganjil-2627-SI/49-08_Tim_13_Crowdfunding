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
    <title>Daftar Lembaga Penyalur - Publik</title>
    <link rel="stylesheet" href="../assests/css/style.css">
    
    <style>
        * { box-sizing: border-box; }
        .partner-search { margin: 20px 0 30px; max-width: 500px; }
        .partner-search input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }
        .partner-card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        .partner-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .partner-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        }
        .partner-logo-wrapper {
            width: 100%;
            height: 150px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eee;
        }
        .partner-logo-wrapper img {
            max-height: 90px;
            max-width: 80%;
            object-fit: contain;
        }
        .partner-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .partner-card-body h3 { margin-top: 0; margin-bottom: 10px; color: #222; }
        .partner-info { font-size: 0.9em; color: #555; margin-bottom: 6px; }
        .partner-desc {
            font-size: 0.88em;
            color: #666;
            margin: 10px 0 20px 0;
            line-height: 1.4;
            flex-grow: 1;
        }
        .btn-detail {
            display: block;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            color: white;
            background: #007bff;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.2s ease;
        }
        .btn-detail:hover { background: #0056b3; }
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

    <main class="container" style="padding: 40px 20px;">
        <h1>Daftar Lembaga Penyalur (Mitra)</h1>
        <p style="color: #666;">Berikut adalah daftar yayasan dan lembaga penyalur yang bekerja sama dengan kami.</p>

        <form method="GET" action="public-partner-list.php" class="partner-search">
            <input type="text" name="q" placeholder="Cari nama lembaga atau lokasi..." value="<?= htmlspecialchars($search); ?>">
        </form>

        <div class="partner-card-container">
            <?php
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $logo = !empty($row['logo']) ? "../assests/images/" . $row['logo'] : "../assests/images/hero-home.jpg";
            ?>
                    <div class="partner-card">
                        <div class="partner-logo-wrapper">
                            <img src="<?= $logo; ?>" alt="<?= htmlspecialchars($row['nama_lembaga']); ?>">
                        </div>
                        <div class="partner-card-body">
                            <h3><?= htmlspecialchars($row['nama_lembaga']); ?></h3>
                            <p class="partner-info"><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                            <p class="partner-info"><strong>PIC Lapangan:</strong> <?= htmlspecialchars($row['nama_pic']); ?></p>
                            <p class="partner-desc"><?= htmlspecialchars($row['deskripsi']); ?></p>
                            <a href="public-partner-detail.php?id=<?= $row['id']; ?>" class="btn-detail">Lihat Detail</a>
                        </div>
                    </div>
            <?php 
                }
            } else { 
            ?>
                <p style="color: #777;">Belum ada mitra/lembaga penyalur yang ditemukan.</p>
            <?php } ?>
        </div>
    </main>

</body>
</html>