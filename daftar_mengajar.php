<?php
ob_start();

require 'koneksi.php';
require_once 'navbar1.php';

$sql = "SELECT
            mengajar.id,
            siswa.kelas,
            guru.nama AS nama_guru,
            mapel.nama_mapel,
            mapel.kode_mapel
        FROM mengajar
        JOIN siswa ON mengajar.siswa_id = siswa.id
        JOIN mapel ON mengajar.mapel_id = mapel.id
        JOIN guru ON mapel.guru_id = guru.id
        ORDER BY mengajar.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Gagal mengambil data mengajar: " . mysqli_error($koneksi));
}

function amanMengajar($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Mengajar - SIACAD</title>

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
            color: #334155;
            font-family: Arial, sans-serif;
        }

        .mengajar-page {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 16px;
        }

        .mengajar-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .mengajar-header {
            padding: 24px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        .mengajar-title {
            color: #4f46e5;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .mengajar-subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 0;
        }

        .mengajar-body {
            padding: 24px;
        }

        .table {
            margin-bottom: 0;
            white-space: nowrap;
        }

        .table thead th {
            background: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            padding: 13px 12px;
            font-size: 14px;
            color: #475569;
        }

        .table tbody tr:hover td {
            background: #f8faff;
        }

        .btn-edit {
            color: #4f46e5;
            border-color: #c7d2fe;
            border-radius: 7px;
        }

        .btn-edit:hover {
            background: #4f46e5;
            color: #fff;
        }

        .btn-hapus {
            border-radius: 7px;
        }

        .empty-data {
            padding: 35px 15px !important;
            color: #64748b !important;
        }

        @media (max-width: 576px) {
            .mengajar-page {
                margin: 20px auto;
                padding: 0 10px;
            }

            .mengajar-header,
            .mengajar-body {
                padding: 17px;
            }

            .mengajar-title {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<main class="mengajar-page">

    <div class="mengajar-card">

        <div class="mengajar-header">
            <h1 class="mengajar-title">
                <i class="bi bi-journal-bookmark"></i>
                Data Mengajar
            </h1>

            <p class="mengajar-subtitle">
                Daftar mata pelajaran yang diajarkan pada setiap kelas.
            </p>
        </div>

        <div class="mengajar-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead>
                        <tr>
                            <th style="width: 65px;">No</th>
                            <th>Nama Guru</th>
                            <th>Kelas</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Kode Mata Pelajaran</th>
                            <th style="min-width: 145px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (mysqli_num_rows($query) > 0) : ?>

                        <?php $no = 1; ?>

                        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <?= amanMengajar($row['nama_guru']); ?>
                                </td>

                                <td>
                                    <?= amanMengajar($row['kelas']); ?>
                                </td>

                                <td>
                                    <?= amanMengajar($row['nama_mapel']); ?>
                                </td>

                                <td>
                                    <?= amanMengajar($row['kode_mapel']); ?>
                                </td>

                                <td>
                                    <a
                                        href="form_edit_mengajar.php?id=<?= (int) $row['id']; ?>"
                                        class="btn btn-sm btn-outline-primary btn-edit"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="proses_mengajar.php"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data mengajar ini?');"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $row['id']; ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="aksi"
                                            value="hapus"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger btn-hapus"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    <?php else : ?>

                        <tr>
                            <td colspan="6" class="text-center empty-data">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data mengajar.
                            </td>
                        </tr>

                    <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</main>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_free_result($query);
mysqli_close($koneksi);

ob_end_flush();
?>
