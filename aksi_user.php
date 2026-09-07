<?php

require_once 'koneksi.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$jenis_kelasmin = $_POST['jenis_kelasmin'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

// Insert ke tabel users
$sql_users = "INSERT INTO users (username, password, role, created_at)
              VALUES ('$username', '$password', '$role', NOW())";

$query_users = mysqli_query($koneksi, $sql_users);

if ($query_users) {

    // Ambil ID user yang baru dibuat
    $id_terakhir = mysqli_insert_id($koneksi);

    // Insert ke tabel siswa
    // ID siswa tidak perlu dimasukkan karena AUTO_INCREMENT
    $sql_siswa = "INSERT INTO siswa (nis, nama, kelas, jenis_kelasmin, user_id)
                  VALUES ('$nis', '$nama', '$kelas', '$jenis_kelasmin', '$id_terakhir')";

    $query_siswa = mysqli_query($koneksi, $sql_siswa);

    if ($query_siswa) {

        echo "<script>
                alert('Data berhasil disimpan!');
                window.location.href='formm.php';
              </script>";

    } else {

        echo "Gagal menyimpan data ke tabel siswa: " . mysqli_error($koneksi);

    }

} else {

    echo "Gagal menyimpan data ke tabel users: " . mysqli_error($koneksi);

}

?>