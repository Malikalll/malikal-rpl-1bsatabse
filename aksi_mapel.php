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

    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $guru_id    = $_POST['guru_id'];

    $sql = "INSERT INTO mapel
            (kode_mapel, nama_mapel, guru_id)
            VALUES
            ('$kode_mapel', '$nama_mapel', '$guru_id')";

    $query = mysqli_query($koneksi, $sql);

    if ($query) {

        header("Location: tabel_mapel2.php");
        exit;

    } else {

        die("Gagal menambahkan mapel: " . mysqli_error($koneksi));

    }
}
?>