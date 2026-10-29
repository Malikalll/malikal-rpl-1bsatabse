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

if (!isset($_POST['edit'])) {
    die("Akses tidak valid.");
}

$role = $_POST['role'] ?? '';
$username = $_POST['username'] ?? '';
$pass = $_POST['pass'] ?? '';

if ($role == 'admin') {

    $id = $_POST['id'] ?? '';

    if ($id == '') {
        die("ID admin tidak ditemukan.");
    }

    if ($pass != '') {

        $password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET username='$username',
                    password='$password'
                WHERE id='$id'
                AND role='admin'";

    } else {

        $sql = "UPDATE users
                SET username='$username'
                WHERE id='$id'
                AND role='admin'";
    }

    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        die("Gagal update admin: " . mysqli_error($koneksi));
    }

} elseif ($role == 'siswa') {

    $id_user = $_POST['id_user'] ?? '';
    $id_siswa = $_POST['id_siswa'] ?? '';

    $nis = $_POST['nis'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $jk = $_POST['jenis_kelasmin'] ?? '';

    if ($id_user == '' || $id_siswa == '') {
        die("ID siswa atau ID user tidak ditemukan.");
    }

    if ($pass != '') {

        $password = password_hash($pass, PASSWORD_DEFAULT);

        $sql_user = "UPDATE users
                     SET username='$username',
                         password='$password'
                     WHERE id='$id_user'
                     AND role='siswa'";

    } else {

        $sql_user = "UPDATE users
                     SET username='$username'
                     WHERE id='$id_user'
                     AND role='siswa'";
    }

    $hasil_user = mysqli_query($koneksi, $sql_user);

    if (!$hasil_user) {
        die("Gagal update akun siswa: " . mysqli_error($koneksi));
    }

    $sql_siswa = "UPDATE siswa
                  SET nis='$nis',
                      nama='$nama',
                      kelas='$kelas',
                      jenis_kelasmin='$jk'
                  WHERE id='$id_siswa'
                  AND user_id='$id_user'";

    $hasil_siswa = mysqli_query($koneksi, $sql_siswa);

    if (!$hasil_siswa) {
        die("Gagal update data siswa: " . mysqli_error($koneksi));
    }

} elseif ($role == 'guru') {

    $id_user = $_POST['id_user'] ?? '';
    $id_guru = $_POST['id_guru'] ?? '';

    $nip = $_POST['nip'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $jenisk = $_POST['jenis_kelamin'] ?? '';

    if ($id_user == '' || $id_guru == '') {
        die("ID guru atau ID user tidak ditemukan.");
    }

    if ($pass != '') {

        $password = password_hash($pass, PASSWORD_DEFAULT);

        $sql_user = "UPDATE users
                     SET username='$username',
                         password='$password'
                     WHERE id='$id_user'
                     AND role='guru'";

    } else {

        $sql_user = "UPDATE users
                     SET username='$username'
                     WHERE id='$id_user'
                     AND role='guru'";
    }

    $hasil_user = mysqli_query($koneksi, $sql_user);

    if (!$hasil_user) {
        die("Gagal update akun guru: " . mysqli_error($koneksi));
    }

    $sql_guru = "UPDATE guru
                 SET nip='$nip',
                     nama='$nama',
                     jenis_kelamin='$jenisk'
                 WHERE id='$id_guru'
                 AND user_id='$id_user'";

    $hasil_guru = mysqli_query($koneksi, $sql_guru);

    if (!$hasil_guru) {
        die("Gagal update data guru: " . mysqli_error($koneksi));
    }

} else {

    die("Role user tidak valid.");
}

echo "<script>
        alert('Data Berhasil diubah');
        window.location.href='daftar_user.php';
      </script>";

?>