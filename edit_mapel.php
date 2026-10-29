<?php
ob_start();

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

// Periksa ID mata pelajaran
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
            alert('ID mata pelajaran tidak valid!');
            window.location.href = 'tabel_mapel2mapel.php';
          </script>";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data mata pelajaran
$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM mapel WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>
            alert('Data mata pelajaran tidak ditemukan!');
            window.location.href = 'tabel_mapel2.php';
          </script>";
    exit;
}

// Ambil daftar guru untuk dropdown
$query_guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM guru ORDER BY nama ASC"
);

if (!$query_guru) {
    die("Gagal mengambil data guru: " . mysqli_error($koneksi));
}

// Fungsi untuk mengamankan teks HTML
function aman($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Mata Pelajaran - SIACAD</title>

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

        .mapel-page {
            max-width: 760px;
            margin: 35px auto;
            padding: 0 15px;
        }

        .mapel-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .mapel-title {
            color: #4f46e5;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .mapel-subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .btn-simpan {
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
        }

        .btn-simpan:hover {
            background: #4338ca;
            color: #fff;
        }

        .btn-kembali {
            border-radius: 8px;
            padding: 10px 18px;
        }

        @media (max-width: 576px) {
            .mapel-page {
                margin: 20px auto;
            }

            .mapel-card {
                padding: 18px;
            }

            .mapel-title {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<div class="mapel-page">
    <div class="mapel-card">

        <h1 class="mapel-title">
            <i class="bi bi-pencil-square"></i>
            Edit Mata Pelajaran
        </h1>

        <p class="mapel-subtitle">
            Ubah informasi mata pelajaran pada formulir berikut.
        </p>

        <form action="aksi_edit_mapel.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= aman($data['id']); ?>"
            >

            <div class="mb-3">
                <label for="kode_mapel" class="form-label">
                    Kode Mata Pelajaran
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="kode_mapel"
                    name="kode_mapel"
                    value="<?= aman($data['kode_mapel']); ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="nama_mapel" class="form-label">
                    Nama Mata Pelajaran
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="nama_mapel"
                    name="nama_mapel"
                    value="<?= aman($data['nama_mapel']); ?>"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="guru_id" class="form-label">
                    Guru Pengampu
                </label>

                <select
                    class="form-select"
                    id="guru_id"
                    name="guru_id"
                    required
                >
                    <option value="">-- Pilih Guru --</option>

                    <?php while ($guru = mysqli_fetch_assoc($query_guru)) : ?>
                        <option
                            value="<?= aman($guru['id']); ?>"
                            <?= ((string) $data['guru_id'] === (string) $guru['id']) ? 'selected' : ''; ?>
                        >
                            <?= aman($guru['nama']); ?>
                        </option>
                    <?php endwhile; ?>

                </select>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" name="kirim" class="btn btn-simpan">
                    <i class="bi bi-save"></i>
                    Simpan Perubahan
                </button>

                <a href="tabel_mapel2.php" class="btn btn-outline-secondary btn-kembali">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_close($koneksi);
ob_end_flush();
?>
