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

if (isset($_POST['kirim'])) {

    $id         = $_POST['id'] ?? '';
    $kode_mapel = trim($_POST['kode_mapel'] ?? '');
    $nama_mapel = trim($_POST['nama_mapel'] ?? '');
    $guru_id    = $_POST['guru_id'] ?? '';

    // Validasi input
    if (
        !is_numeric($id) ||
        $kode_mapel === '' ||
        $nama_mapel === '' ||
        !is_numeric($guru_id)
    ) {
        echo "<script>
                alert('Data mata pelajaran tidak lengkap atau tidak valid!');
                window.location.href='tabel_mapel2.php';
              </script>";
        exit;
    }

    $id      = (int) $id;
    $guru_id = (int) $guru_id;

    // Update data mata pelajaran
    $sql = mysqli_prepare(
        $koneksi,
        "UPDATE mapel
         SET kode_mapel = ?,
             nama_mapel = ?,
             guru_id = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $sql,
        "ssii",
        $kode_mapel,
        $nama_mapel,
        $guru_id,
        $id
    );

    if (mysqli_stmt_execute($sql)) {

        echo "<script>
                alert('Mata pelajaran berhasil diperbarui!');
                window.location.href='tabel_mapel2.php';
              </script>";

    } else {

        echo "<script>
                alert('Gagal memperbarui mata pelajaran!');
                window.location.href='tabel_mapel2.php';
              </script>";
    }

    mysqli_stmt_close($sql);

} else {

    header("Location: tabel_mapel2.php");
    exit;
}

mysqli_close($koneksi);

?>
