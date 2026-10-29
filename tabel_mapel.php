<?php require 'navbar1.php'; ?>

<?php
$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

/* Role user yang sedang login */
$role_login = strtolower($_SESSION['role'] ?? '');

/*
    mapel.guru_id = guru.id
    Jadi kita JOIN untuk mengambil nama guru
*/
$sql = "SELECT 
            mapel.id,
            mapel.kode_mapel,
            mapel.nama_mapel,
            mapel.guru_id,
            guru.nama AS nama_guru
        FROM mapel
        LEFT JOIN guru ON mapel.guru_id = guru.id
        ORDER BY mapel.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Mapel</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(99, 102, 241, 0.15),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(124, 58, 237, 0.12),
                    transparent 35%
                ),
                #f5f7fb;
        }

        .data-container {
            max-width: 1250px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .data-card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.08);
        }

        /* HEADER */

        .data-header {
            padding: 25px 30px;

            background: linear-gradient(
                135deg,
                #4f46e5,
                #6366f1,
                #7c3aed
            );

            color: white;
        }

        .data-header h2 {
            margin: 0;
            font-size: 25px;
            font-weight: 800;
        }

        .data-header p {
            margin: 6px 0 0;
            opacity: 0.85;
            font-size: 14px;
        }

        /* TABLE */

        .table-wrapper {
            padding: 25px;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;

            font-size: 13px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 0.4px;

            border-bottom: 2px solid #e2e8f0;

            padding: 15px;
        }

        .table tbody td {
            padding: 15px;

            color: #334155;
            font-size: 14px;

            border-color: #eef2f7;
        }

        .table tbody tr {
            transition: 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8faff;
        }

        /* KODE MAPEL */

        .kode-mapel {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 8px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 12px;
            font-weight: 700;
        }

        /* NAMA MAPEL */

        .nama-mapel {
            font-weight: 600;
            color: #1e293b;
        }

        /* GURU */

        .nama-guru {
            color: #475569;
            font-weight: 500;
        }

        .guru-empty {
            color: #94a3b8;
            font-style: italic;
        }

        /* BUTTON */

        .btn-action {
            border: none;

            border-radius: 9px;

            padding: 7px 12px;

            font-size: 13px;
            font-weight: 600;

            transition: 0.2s ease;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-edit:hover {
            background: #fde68a;
            color: #78350f;

            transform: translateY(-1px);
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-delete:hover {
            background: #fecaca;
            color: #991b1b;

            transform: translateY(-1px);
        }

        /* NON ADMIN */

        .admin-only {
            color: #94a3b8;

            font-size: 12px;
            font-style: italic;
        }

        /* MOBILE */

        @media (max-width: 768px) {

            .data-container {
                margin: 25px auto;
                padding: 0 12px;
            }

            .data-header {
                padding: 20px;
            }

            .data-header h2 {
                font-size: 21px;
            }

            .table-wrapper {
                padding: 15px;
            }

            .table thead th,
            .table tbody td {
                padding: 11px 10px;
                font-size: 12px;
            }

            .btn-action {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }

        }

    </style>

</head>

<body>

<div class="data-container">

    <div class="data-card">

        <!-- HEADER -->

        <div class="data-header">

            <h2>
                <i class="bi bi-book-fill me-2"></i>
                Data Mata Pelajaran
            </h2>

            <p>
                Kelola data mata pelajaran dan guru pengampu
            </p>

        </div>


        <!-- TABLE -->

        <div class="table-wrapper">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Kode Mapel</th>

                            <th>Nama Mapel</th>

                            <th>Guru Pengampu</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php
                        $no = 1;

                        while ($mapel = mysqli_fetch_assoc($query)):
                        ?>

                        <tr>

                            <!-- NO -->

                            <td>
                                <?= $no++ ?>
                            </td>


                            <!-- KODE MAPEL -->

                            <td>

                                <span class="kode-mapel">

                                    <?= htmlspecialchars(
                                        $mapel['kode_mapel']
                                    ) ?>

                                </span>

                            </td>


                            <!-- NAMA MAPEL -->

                            <td>

                                <span class="nama-mapel">

                                    <?= htmlspecialchars(
                                        $mapel['nama_mapel']
                                    ) ?>

                                </span>

                            </td>


                            <!-- GURU -->

                            <td>

                                <?php if (!empty($mapel['nama_guru'])): ?>

                                    <span class="nama-guru">

                                        <i class="bi bi-person-fill me-1"></i>

                                        <?= htmlspecialchars(
                                            $mapel['nama_guru']
                                        ) ?>

                                    </span>

                                <?php else: ?>

                                    <span class="guru-empty">

                                        Belum ada guru

                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <?php if ($role_login === 'admin'): ?>

                                    <a
                                        href="edit_mapel.php?id=<?= (int)$mapel['id'] ?>"
                                        class="btn btn-action btn-edit"
                                    >

                                        <i class="bi bi-pencil-square me-1"></i>

                                        Edit

                                    </a>


                                    <a
                                        href="hapus_mapel.php?id=<?= (int)$mapel['id'] ?>"
                                        class="btn btn-action btn-delete"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus data mapel ini?')"
                                    >

                                        <i class="bi bi-trash3 me-1"></i>

                                        Hapus

                                    </a>

                                <?php else: ?>

                                    <span class="admin-only">

                                        <i class="bi bi-lock-fill me-1"></i>

                                        Hanya admin

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php require 'footer.php'; ?>

</body>

</html>