<?php

require_once "koneksi.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Cek apakah data mapel ada
    $query = mysqli_query(
        $koneksi,
        "SELECT id FROM mapel WHERE id = '$id'"
    );

    $data = mysqli_fetch_assoc($query);

    if (!$data) {

        echo "<script>
                alert('Mapel tidak ditemukan');
                window.location.href='tabel_mapel2.php';
              </script>";
        exit;
    }

    // Hapus data mapel
    $sql = "DELETE FROM mapel WHERE id = '$id'";

    if (mysqli_query($koneksi, $sql)) {

        echo "<script>
                alert('Mapel berhasil dihapus');
                window.location.href='tabel_mapel2.php';
              </script>";

    } else {

        echo "<script>
                alert('Gagal menghapus mapel: " . mysqli_error($koneksi) . "');
                window.location.href='tabel_mapel2.php';
              </script>";
    }

} else {

    echo "<script>
            alert('ID mapel tidak ditemukan');
            window.location.href='tabel_mapel2.php';
          </script>";
    exit;
}

?>