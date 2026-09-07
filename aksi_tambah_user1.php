<?php

require_once 'koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

// Insert ke tabel users
$sql_users = "INSERT INTO users (username, password, role, created_at)
              VALUES ('$username', '$password', '$role', NOW())";

$query_users = mysqli_query($koneksi, $sql_users);

if ($query_users) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location.href='form_tabel.php';
              </script>";

} else {

    echo "Gagal menyimpan data ke tabel users: " . mysqli_error($koneksi);

}

?>