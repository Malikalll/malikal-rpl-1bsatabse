<?php
require_once "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT role FROM users WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
            alert('User tidak ditemukan');
            window.location.href='daftar_user.php';
          </script>";
    exit;
}

$role = $data['role'];

if ($role == "siswa") {

    $sql = "DELETE users, siswa
            FROM users
            LEFT JOIN siswa ON siswa.user_id = users.id
            WHERE users.id = '$id'";

}
elseif ($role == "guru") {

    $sql = "DELETE users, guru
            FROM users
            LEFT JOIN guru ON guru.user_id = users.id
            WHERE users.id = '$id'";

}
elseif ($role == "admin") {

    $sql = "DELETE FROM users
            WHERE id = '$id'";

}
else {
    echo "<script>
            alert('Role user tidak dikenali');
            window.location.href='daftar_user.php';
          </script>";
    exit;
}

if (mysqli_query($koneksi, $sql)) {

    echo "<script>
            alert('User berhasil dihapus');
            window.location.href='daftar_user.php';
          </script>";

} else {

    echo "<script>
            alert('Gagal menghapus user: " . mysqli_error($koneksi) . "');
            window.location.href='daftar_user.php';
          </script>";
}
?>