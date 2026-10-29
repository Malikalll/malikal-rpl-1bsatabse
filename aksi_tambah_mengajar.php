<?php

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['simpan'])) {
    header("Location: tambah_mengajar.php");
    exit;
}

$kelas = trim($_POST['kelas'] ?? '');
$guru_id = filter_input(INPUT_POST, 'guru_id', FILTER_VALIDATE_INT);
$mapel_id = filter_input(INPUT_POST, 'mapel_id', FILTER_VALIDATE_INT);

if ($kelas === '' || !$guru_id || !$mapel_id) {
    echo "<script>
        alert('Semua pilihan wajib diisi!');
        window.location.href='tambah_mengajar.php';
    </script>";
    exit;
}

// Pastikan kelas memiliki siswa, ambil satu siswa untuk mengisi siswa_id
$stmt_siswa = mysqli_prepare(
    $koneksi,
    "SELECT id FROM siswa WHERE kelas = ? ORDER BY id ASC LIMIT 1"
);

mysqli_stmt_bind_param($stmt_siswa, "s", $kelas);
mysqli_stmt_execute($stmt_siswa);

$result_siswa = mysqli_stmt_get_result($stmt_siswa);
$siswa = mysqli_fetch_assoc($result_siswa);

mysqli_stmt_close($stmt_siswa);

if (!$siswa) {
    echo "<script>
        alert('Tidak ada siswa di kelas yang dipilih!');
        window.location.href='tambah_mengajar.php';
    </script>";
    exit;
}

$siswa_id = (int) $siswa['id'];

// Pastikan mapel milik guru yang dipilih
$stmt_mapel = mysqli_prepare(
    $koneksi,
    "SELECT id FROM mapel WHERE id = ? AND guru_id = ?"
);

mysqli_stmt_bind_param($stmt_mapel, "ii", $mapel_id, $guru_id);
mysqli_stmt_execute($stmt_mapel);

$result_mapel = mysqli_stmt_get_result($stmt_mapel);
$mapel = mysqli_fetch_assoc($result_mapel);

mysqli_stmt_close($stmt_mapel);

if (!$mapel) {
    echo "<script>
        alert('Mata pelajaran tidak sesuai dengan guru!');
        window.location.href='tambah_mengajar.php';
    </script>";
    exit;
}

// Cegah data duplikat
$stmt_cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM mengajar
     WHERE mapel_id = ? AND siswa_id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt_cek, "ii", $mapel_id, $siswa_id);
mysqli_stmt_execute($stmt_cek);

$result_cek = mysqli_stmt_get_result($stmt_cek);
$duplikat = mysqli_fetch_assoc($result_cek);

mysqli_stmt_close($stmt_cek);

if ($duplikat) {
    echo "<script>
        alert('Data mengajar tersebut sudah ada!');
        window.location.href='daftar_mengajar.php';
    </script>";
    exit;
}

// Simpan tepat satu baris
$stmt_insert = mysqli_prepare(
    $koneksi,
    "INSERT INTO mengajar (mapel_id, siswa_id)
     VALUES (?, ?)"
);

mysqli_stmt_bind_param($stmt_insert, "ii", $mapel_id, $siswa_id);

if (mysqli_stmt_execute($stmt_insert)) {
    mysqli_stmt_close($stmt_insert);
    mysqli_close($koneksi);

    echo "<script>
        alert('Data mengajar berhasil ditambahkan!');
        window.location.href='daftar_mengajar.php';
    </script>";
    exit;
}

mysqli_stmt_close($stmt_insert);
mysqli_close($koneksi);

echo "<script>
    alert('Gagal menambahkan data mengajar!');
    window.location.href='tambah_mengajar.php';
</script>";

exit;
?>
