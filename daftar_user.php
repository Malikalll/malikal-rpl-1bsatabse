<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
if (
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
) {
    header("Location: login.php");
    exit;
}

// Hanya admin yang boleh membuka halaman ini
$role_login = strtolower(trim($_SESSION['role'] ?? ''));

if ($role_login !== 'admin') {
    http_response_code(403);
    exit("Akses ditolak. Halaman ini hanya untuk admin.");
}

// Koneksi database
$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal.");
}

mysqli_set_charset($koneksi, "utf8mb4");

// Ambil data user
$sql = "SELECT users.id, users.username, users.role,
        COALESCE(siswa.nama, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . htmlspecialchars(
        mysqli_error($koneksi),
        ENT_QUOTES,
        'UTF-8'
    ));
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data User - SIACAD</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f8f9fc;
            color: #374151;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .data-container {
            width: 100%;
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 16px;
        }

        .data-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .data-header {
            padding: 22px 24px;
            border-bottom: 1px solid #e5e7eb;
            border-left: 4px solid #4f46e5;
        }

        .data-header h2 {
            margin: 0;
            color: #374151;
            font-size: 22px;
            font-weight: 700;
        }

        .data-header p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .table-wrapper {
            padding: 20px;
        }

        .table {
            margin: 0;
            vertical-align: middle;
        }

        .table thead th {
            padding: 13px;
            background: #f8f9fc;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 13px;
            color: #374151;
            border-color: #eef0f4;
        }

        .username {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .role-admin {
            background: #ede9fe;
            color: #6d28d9;
        }

        .role-guru {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .role-siswa {
            background: #dcfce7;
            color: #15803d;
        }

        .role-default {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-action {
            display: inline-block;
            padding: 7px 10px;
            margin: 2px;
            border: 0;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-edit {
            background: #eef2ff;
            color: #4f46e5;
        }

        .btn-edit:hover {
            background: #e0e7ff;
            color: #3730a3;
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-delete:hover {
            background: #fecaca;
            color: #991b1b;
        }

        .empty-data {
            padding: 25px !important;
            color: #6b7280 !important;
            text-align: center;
        }

        @media (max-width: 768px) {
            .data-container {
                margin: 18px auto;
                padding: 0 10px;
            }

            .data-header {
                padding: 17px;
            }

            .data-header h2 {
                font-size: 20px;
            }

            .table-wrapper {
                padding: 10px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px;
                font-size: 12px;
            }

            .btn-action {
                display: block;
                margin: 3px 0;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <?php require 'navbar1.php'; ?>

    <main class="data-container">
        <section class="data-card">

            <header class="data-header">
                <h2>
                    <i class="bi bi-people-fill"></i>
                    Data User
                </h2>

                <p>
                    Kelola akun pengguna sistem SIACAD
                </p>
            </header>

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
                            <?php
                            $no = 1;
                            $ada_data = false;

                            while ($user = mysqli_fetch_assoc($query)):
                                $ada_data = true;

                                $roleUser = strtolower(
                                    $user['role'] ?? ''
                                );

                                $roleClass = 'role-default';

                                if ($roleUser === 'admin') {
                                    $roleClass = 'role-admin';
                                } elseif ($roleUser === 'guru') {
                                    $roleClass = 'role-guru';
                                } elseif ($roleUser === 'siswa') {
                                    $roleClass = 'role-siswa';
                                }
                            ?>

                            <tr>
                                <td><?= $no++ ?></td>

                                <td class="username">
                                    <?= htmlspecialchars(
                                        $user['username'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $user['nama'] ?? '-',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <span class="role-badge <?= $roleClass ?>">
                                        <?= htmlspecialchars(
                                            $roleUser,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="edit.php?id=<?= (int)$user['id'] ?>&role=<?= urlencode($roleUser) ?>"
                                        class="btn-action btn-edit">

                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    <a
                                        href="delete.php?id=<?= (int)$user['id'] ?>"
                                        class="btn-action btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">

                                        <i class="bi bi-trash3"></i>
                                        Hapus
                                    </a>
                                </td>
                            </tr>

                            <?php endwhile; ?>

                            <?php if (!$ada_data): ?>
                                <tr>
                                    <td colspan="5" class="empty-data">
                                        Belum ada data user.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </main>

    <?php require 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
