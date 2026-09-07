<?php
$username = "root";
$password = "root";
$hostname = "127.0.0.1";
$data = "db_siacad_smk";

$koneksi = mysqli_connect("127.0.0.1","root","root","db_siacad_smk");

if ($koneksi) {
    echo "koneksi berhasil";
}
else{
    echo "koneksi gagal";
}
?>