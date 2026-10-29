<?php
ob_start();

require 'koneksi.php';
require_once 'navbar1.php';

$query_kelas = mysqli_query(
    $koneksi,
    "SELECT DISTINCT kelas
     FROM siswa
     WHERE kelas IS NOT NULL AND kelas <> ''
     ORDER BY kelas ASC"
);

$query_guru = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM guru ORDER BY nama ASC"
);

$query_mapel = mysqli_query(
    $koneksi,
    "SELECT id, kode_mapel, nama_mapel, guru_id
     FROM mapel
     ORDER BY nama_mapel ASC"
);

if (!$query_kelas || !$query_guru || !$query_mapel) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}

$daftar_mapel = [];

while ($m = mysqli_fetch_assoc($query_mapel)) {
    $daftar_mapel[] = $m;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Mengajar - SIACAD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f8f9fc;
            color: #334155;
            font-family: Arial, sans-serif;
        }

        .mengajar-page {
            max-width: 850px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .mengajar-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,.04);
        }

        .mengajar-header {
            padding: 24px;
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

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-select {
            padding: 11px 12px;
            border-radius: 8px;
        }

        .form-select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
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

        .form-text {
            color: #64748b;
        }

        @media (max-width: 576px) {
            .mengajar-page {
                margin: 20px auto;
                padding: 0 10px;
            }

            .mengajar-header,
            .mengajar-body {
                padding: 18px;
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
                <i class="bi bi-journal-plus"></i>
                Form Tambah Mengajar
            </h1>

            <p class="mengajar-subtitle">
                Pilih kelas, guru pengampu, dan mata pelajaran.
            </p>
        </div>

        <div class="mengajar-body">

            <form action="aksi_tambah_mengajar.php" method="POST">

                <div class="mb-3">
                    <label for="kelas" class="form-label">Pilih Kelas</label>

                    <select name="kelas" id="kelas" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>

                        <?php while ($k = mysqli_fetch_assoc($query_kelas)) : ?>
                            <option value="<?= htmlspecialchars($k['kelas'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($k['kelas'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="guru_id" class="form-label">Pilih Guru</label>

                    <select name="guru_id" id="guru_id" class="form-select" required>
                        <option value="">-- Pilih Guru --</option>

                        <?php while ($g = mysqli_fetch_assoc($query_guru)) : ?>
                            <option value="<?= (int) $g['id']; ?>">
                                <?= htmlspecialchars($g['nama'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="mapel_id" class="form-label">Pilih Mata Pelajaran</label>

                    <select name="mapel_id" id="mapel_id" class="form-select" required disabled>
                        <option value="">-- Pilih Guru Terlebih Dahulu --</option>
                    </select>

                    <div class="form-text">
                        Mata pelajaran mengikuti guru yang dipilih.
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" name="simpan" class="btn btn-simpan">
                        <i class="bi bi-save"></i>
                        Simpan Data
                    </button>

                    <a href="daftar_mengajar.php" class="btn btn-outline-secondary btn-kembali">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>

<?php require 'footer.php'; ?>

<script>
const semuaMapel = <?= json_encode(
    $daftar_mapel,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
); ?>;

const guruSelect = document.getElementById('guru_id');
const mapelSelect = document.getElementById('mapel_id');

guruSelect.addEventListener('change', function () {
    const guruId = this.value;

    mapelSelect.innerHTML = '';

    if (!guruId) {
        mapelSelect.add(new Option('-- Pilih Guru Terlebih Dahulu --', ''));
        mapelSelect.disabled = true;
        return;
    }

    const daftar = semuaMapel.filter(function (m) {
        return String(m.guru_id) === String(guruId);
    });

    if (daftar.length === 0) {
        mapelSelect.add(new Option('-- Guru Belum Memiliki Mapel --', ''));
        mapelSelect.disabled = true;
        return;
    }

    mapelSelect.add(new Option('-- Pilih Mata Pelajaran --', ''));

    daftar.forEach(function (m) {
        mapelSelect.add(new Option(
            m.kode_mapel + ' - ' + m.nama_mapel,
            m.id
        ));
    });

    mapelSelect.disabled = false;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
mysqli_close($koneksi);
ob_end_flush();
?>
