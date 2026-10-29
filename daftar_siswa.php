<?php
require 'navbar1.php';

$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");

// Ambil data siswa
$sql = "SELECT users.id, users.username, users.role, siswa.nama
        FROM users
        INNER JOIN siswa ON users.id = siswa.user_id
        ORDER BY users.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Role pengguna yang sedang login
$role_login = strtolower(trim($_SESSION['role'] ?? ''));
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Siswa - SIACAD</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f8f9fc;
            font-family: Arial, sans-serif;
            color: #334155;
        }

        .data-container {
            max-width: 1150px;
            margin: auto;
            padding: 30px 16px;
        }

        .data-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .data-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            border-left: 4px solid #6366f1;
            padding: 22px 24px;
        }

        .data-header h2 {
            margin: 0;
            font-size: 23px;
            font-weight: 700;
            color: #1e293b;
        }

        .data-header p {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .table-wrapper {
            padding: 20px;
        }

        .table {
            margin: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 13px;
            font-size: 14px;
            border-color: #edf0f4;
        }

        .badge-role {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            background: #eef2ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-action {
            border-radius: 6px;
            font-size: 12px;
            padding: 6px 10px;
            margin: 2px;
        }

        .empty-data {
            text-align: center;
            padding: 25px !important;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .data-container {
                padding: 20px 10px;
            }

            .data-header {
                padding: 18px;
            }

            .data-header h2 {
                font-size: 20px;
            }

            .table-wrapper {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

<div class="data-container">
    <div class="data-card">

        <div class="data-header">
            <h2>
                <i class="bi bi-people-fill"></i>
                Data Siswa
            </h2>

            <p>
                Daftar pengguna yang terdaftar sebagai siswa
            </p>
        </div>

        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; ?>

                        <?php while ($user = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $no++ ?></td>

                                <td>
                                    <?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                </td>

                                <td>
                                    <span class="badge-role">
                                        <?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if ($role_login === 'admin'): ?>

                                        <a
                                            href="edit.php?id=<?= (int) $user['id'] ?>&amp;role=<?= urlencode($user['role']) ?>"
                                            class="btn btn-warning btn-sm btn-action"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>

                                        <a
                                            href="delete.php?id=<?= (int) $user['id'] ?>"
                                            class="btn btn-danger btn-sm btn-action"
                                            onclick="return confirm('Yakin ingin menghapus siswa ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </a>

                                    <?php else: ?>

                                        <span class="text-secondary small">
                                            <i class="bi bi-lock-fill"></i>
                                            Hanya admin
                                        </span>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-data">
                                <i class="bi bi-inbox"></i>
                                Belum ada data siswa.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>