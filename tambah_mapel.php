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

// Mengambil data guru untuk pilihan select
$sql_guru = "SELECT id, nama FROM guru ORDER BY nama ASC";
$query_guru = mysqli_query($koneksi, $sql_guru);

if (!$query_guru) {
    die("Query guru gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Pelajaran - SIACAD</title>

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
        }

        .container-mapel {
            width: 100%;
            max-width: 650px;
            margin: 30px auto;
            padding: 0 15px;
            box-sizing: border-box;
        }

        .mapel-card {
            width: 100%;
            box-sizing: border-box;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-left: 5px solid #6f42c1;
            border-radius: 10px;
            padding: 25px;
        }

        .mapel-title {
            color: #343a40;
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 8px;
        }

        .mapel-description {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.5;
            margin: 0 0 25px;
        }

        .mapel-card .form-label {
            display: block;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 8px;
        }

        .mapel-card .form-control,
        .mapel-card .form-select {
            display: block;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 7px;
            padding: 10px 12px;
            font-size: 16px;
            background-color: #fff;
        }

        .mapel-card .form-control:focus,
        .mapel-card .form-select:focus {
            border-color: #9b80d4;
            outline: none;
            box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.12);
        }

        .mapel-card .mb-3 {
            margin-bottom: 18px;
        }

        .mapel-card .mb-4 {
            margin-bottom: 24px;
        }

        .mapel-card .mapel-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .mapel-card .btn {
            display: inline-block;
            box-sizing: border-box;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }

        .mapel-card .btn-simpan {
            background: #6f42c1;
            color: white;
            border: 1px solid #6f42c1;
        }

        .mapel-card .btn-simpan:hover {
            background: #59359c;
        }

        .mapel-card .btn-kembali {
            background: #6c757d;
            color: white;
            border: 1px solid #6c757d;
        }

        .mapel-card .btn-kembali:hover {
            background: #565e64;
        }

        @media (max-width: 576px) {
            .container-mapel {
                margin-top: 20px;
                padding: 0 12px;
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

<div class="container-mapel">
    <div class="mapel-card">

        <h1 class="mapel-title">Tambah Mata Pelajaran</h1>

        <p class="mapel-description">
            Masukkan kode, nama mata pelajaran, dan guru pengampu.
        </p>

        <form action="aksi_mapel.php" method="POST">

            <!-- KODE MAPEL -->
            <div class="mb-3">
                <label for="kode_mapel" class="form-label">
                    Kode Mata Pelajaran
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="kode_mapel"
                    name="kode_mapel"
                    placeholder="Contoh: MTK01"
                    required
                >
            </div>

            <!-- NAMA MAPEL -->
            <div class="mb-3">
                <label for="nama_mapel" class="form-label">
                    Nama Mata Pelajaran
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="nama_mapel"
                    name="nama_mapel"
                    placeholder="Contoh: Matematika"
                    required
                >
            </div>

            <!-- GURU PENGAMPU -->
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

                    <?php while ($guru = mysqli_fetch_assoc($query_guru)): ?>
                        <option value="<?= (int) $guru['id'] ?>">
                            <?= htmlspecialchars(
                                $guru['nama'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </option>
                    <?php endwhile; ?>

                </select>
            </div>

            <!-- TOMBOL -->
            <div class="mapel-actions">

                <button
                    type="submit"
                    name="kirim"
                    class="btn btn-simpan"
                >
                    Simpan Mapel
                </button>

                <a
                    href="tabel_mapel.php"
                    class="btn btn-kembali"
                >
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