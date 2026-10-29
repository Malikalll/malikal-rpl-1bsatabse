<?php
session_start();

// Koneksi database
$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Pastikan form dikirim dengan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

// Ambil username dan password
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?error=empty");
    exit;
}

// Cari pengguna berdasarkan username
$sql = "SELECT
            users.*,
            COALESCE(siswa.nama, guru.nama) AS nama,
            siswa.kelas
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        WHERE users.username = ?
        LIMIT 1";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Query gagal: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Periksa password
$password_valid = false;

if ($user) {
    $password_db = $user['password'];

    // Mendukung password hash dan password teks biasa
    if (password_verify($password, $password_db)) {
        $password_valid = true;
    } elseif (hash_equals((string) $password_db, (string) $password)) {
        $password_valid = true;
    }
}

if ($user && $password_valid) {

    session_regenerate_id(true);

    $_SESSION['id'] = $user['id'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = strtolower($user['role']);
    $_SESSION['nama'] = $user['nama'] ?? $user['username'];
    $_SESSION['kelas'] = $user['kelas'] ?? null;
    $_SESSION['login'] = true;

    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);

    header("Location: dashboard.php");
    exit;

} else {
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);

    header("Location: login.php?error=1");
    exit;
}
