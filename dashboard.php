<?php
session_start();

// Periksa status login
if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Data session
$role = strtolower($_SESSION['role'] ?? '');
$username = $_SESSION['username'] ?? '';
$user_id = (int) ($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0);
$nama_lengkap = $username;

// Koneksi database hanya untuk mengambil nama
$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil nama siswa atau guru
if (in_array($role, ['siswa', 'guru'], true)) {
    $tabel = $role === 'siswa' ? 'siswa' : 'guru';

    $sql = "SELECT nama FROM $tabel WHERE user_id = $user_id LIMIT 1";
    $hasil = mysqli_query($koneksi, $sql);

    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $data = mysqli_fetch_assoc($hasil);

        if (!empty($data['nama'])) {
            $nama_lengkap = $data['nama'];
        }
    }
}

mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet">
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SIACAD SMK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fc;
            color: #374151;
        }

        .dashboard-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .welcome-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #6366f1;
            border-radius: 10px;
            padding: 28px;
        }

        .welcome-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .role-badge {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .section-title {
            font-size: 19px;
            font-weight: 700;
            margin: 28px 0 15px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px;
            min-width: 0;
        }

        .card-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            border-radius: 8px;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .info-card h5 {
            color: #6b7280;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .info-card p {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            overflow-wrap: anywhere;
        }

        @media (max-width: 768px) {
            .dashboard-container { padding: 20px 14px; }
            .dashboard-grid { grid-template-columns: 1fr; gap: 12px; }
            .welcome-card { padding: 22px 18px; }
            .welcome-title { font-size: 22px; }
            .section-title { font-size: 17px; margin-top: 24px; }
            .info-card { padding: 18px; }
        }
    </style>
</head>
<body>

<?php require 'navbar1.php'; ?>
  
<main class="dashboard-container">
    <section class="welcome-card">
        <h1 class="welcome-title">
            Selamat datang,
            <?= htmlspecialchars($nama_lengkap, ENT_QUOTES, 'UTF-8'); ?>!
        </h1>

        <p class="welcome-subtitle">
            Selamat datang di
            <strong>Sistem Informasi Akademik SMK</strong>.
            Kelola informasi akademik dengan mudah melalui SIACAD.
        </p>

        <span class="role-badge">
            Role: <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
        </span>
    </section>

    <h2 class="section-title">Informasi Akun</h2>

    <section class="dashboard-grid">
        <article class="info-card">
            <div class="card-icon">👤</div>
            <h5>Nama Lengkap</h5>
            <p><?= htmlspecialchars($nama_lengkap, ENT_QUOTES, 'UTF-8'); ?></p>
        </article>

        <article class="info-card">
            <div class="card-icon">🔐</div>
            <h5>Username</h5>
            <p><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>
        </article>

        <article class="info-card">
            <div class="card-icon">🎓</div>
            <h5>Status Pengguna</h5>
            <p><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></p>
        </article>
    </section>

</main>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
