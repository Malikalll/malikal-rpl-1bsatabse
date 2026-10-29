<?php

require_once 'koneksi.php';

// Pastikan data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: daftar_user.php");
    exit;
}

// Ambil dan validasi data umum
$role = $_POST['role'] ?? '';
$username = trim($_POST['username'] ?? '');
$pass = $_POST['pass'] ?? '';

if ($username === '' || $pass === '') {
    die("Username dan password wajib diisi.");
}

if (!in_array($role, ['siswa', 'guru', 'admin'], true)) {
    die("Role tidak dikenali.");
}

// Hash password
$password = password_hash($pass, PASSWORD_DEFAULT);

// Gunakan transaksi agar data akun dan profil konsisten
mysqli_begin_transaction($koneksi);

try {

    // Cek username agar tidak digunakan dua kali
    $cek = mysqli_prepare(
        $koneksi,
        "SELECT id FROM users WHERE username = ? LIMIT 1"
    );

    mysqli_stmt_bind_param($cek, "s", $username);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        throw new Exception("Username sudah digunakan.");
    }

    mysqli_stmt_close($cek);

    // Tambahkan akun ke tabel users
    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO users (username, password, role, created_at)
         VALUES (?, ?, ?, NOW())"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $username,
        $password,
        $role
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($koneksi));
    }

    $user_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);


    // =========================
    // TAMBAH SISWA
    // =========================
    if ($role === 'siswa') {

        $nis = trim($_POST['nis'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $jenis_kelasmin = $_POST['jenis_kelasmin'] ?? '';

        if (
            $nis === '' ||
            $nama === '' ||
            $kelas === '' ||
            !in_array($jenis_kelasmin, ['L', 'P'], true)
        ) {
            throw new Exception("Data siswa belum lengkap atau tidak valid.");
        }

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO siswa
             (nis, nama, kelas, jenis_kelasmin, user_id)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $nis,
            $nama,
            $kelas,
            $jenis_kelasmin,
            $user_id
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_close($stmt);

        $pesan = "Data siswa berhasil ditambahkan!";
        $tujuan = "daftar_siswa.php";
    }


    // =========================
    // TAMBAH GURU
    // =========================
    elseif ($role === 'guru') {

        $nip = trim($_POST['nip'] ?? '');
        $nama = trim($_POST['nama_guru'] ?? '');
        $jenis_kelamin = $_POST['jenis_kelamin_guru'] ?? '';

        if (
            $nip === '' ||
            $nama === '' ||
            !in_array($jenis_kelamin, ['L', 'P'], true)
        ) {
            throw new Exception("Data guru belum lengkap atau tidak valid.");
        }

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO guru
             (nip, nama, jenis_kelamin, user_id)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $nip,
            $nama,
            $jenis_kelamin,
            $user_id
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_close($stmt);

        $pesan = "Data guru berhasil ditambahkan!";
        $tujuan = "daftar_guru.php";
    }


    // =========================
    // TAMBAH ADMIN
    // =========================
    elseif ($role === 'admin') {

        $pesan = "Admin berhasil ditambahkan!";
        $tujuan = "daftar_user.php";
    }


    // Simpan semua perubahan
    mysqli_commit($koneksi);

    echo "<script>
        alert(" . json_encode($pesan) . ");
        window.location.href = " . json_encode($tujuan) . ";
    </script>";
    exit;

} catch (Throwable $e) {

    // Batalkan akun dan profil jika terjadi kegagalan
    mysqli_rollback($koneksi);

    echo "Gagal menambahkan data: "
         . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

?>