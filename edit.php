<?php
ob_start();

require 'navbar1.php';

$koneksi = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (!isset($_GET['id'], $_GET['role'])) {
    echo "<script>
        alert('Data user tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = (int) $_GET['id'];
$role = strtolower(trim($_GET['role']));

if (!in_array($role, ['admin', 'siswa', 'guru'], true)) {
    echo "<script>
        alert('Role user tidak valid');
        window.location.href='index.php';
    </script>";
    exit;
}

$data = [];

if ($role === 'admin') {
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT * FROM users WHERE id = ? AND role = 'admin'"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

} elseif ($role === 'siswa') {
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT users.*, siswa.*
         FROM users
         INNER JOIN siswa ON users.id = siswa.user_id
         WHERE users.id = ? AND users.role = 'siswa'"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

} elseif ($role === 'guru') {
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT users.*, guru.*
         FROM users
         INNER JOIN guru ON users.id = guru.user_id
         WHERE users.id = ? AND users.role = 'guru'"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
}

if (!$data) {
    echo "<script>
        alert('Data user tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit User - SIACAD SMK</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f8f9fc;
            font-family: Arial, sans-serif;
            color: #334155;
        }

        .form-container {
            max-width: 850px;
            margin: auto;
            padding: 30px 16px;
        }

        .form-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .form-header {
            padding: 22px 24px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            border-left: 4px solid #6366f1;
        }

        .form-header h2 {
            margin: 0;
            font-size: 23px;
            font-weight: 700;
            color: #1e293b;
        }

        .form-header p {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .form-content {
            padding: 24px;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #334155;
            padding-bottom: 10px;
            margin: 8px 0 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }

        .form-control {
            border-color: #dbe1e8;
            border-radius: 7px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .form-check {
            margin-bottom: 8px;
        }

        .form-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .form-actions .btn {
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 20px 10px;
            }

            .form-header {
                padding: 18px;
            }

            .form-header h2 {
                font-size: 20px;
            }

            .form-content {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<?php if ($role === 'admin'): ?>

<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2><i class="bi bi-person-gear"></i> Form Edit Admin</h2>
            <p>Perbarui informasi akun administrator.</p>
        </div>

        <div class="form-content">
            <form action="aksi_edit_user.php" method="POST">
                <h5 class="section-title">
                    <i class="bi bi-shield-lock"></i>
                    Data Kredensial Akun
                </h5>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        value="<?= e($data['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="pass" class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="pass"
                        id="pass"
                        class="form-control"
                        placeholder="Kosongkan jika tidak diubah"
                        autocomplete="new-password"
                    >
                </div>

                <input type="hidden" name="role" value="admin">
                <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">

                <div class="form-actions">
                    <button type="submit" name="edit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php elseif ($role === 'siswa'): ?>

<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2><i class="bi bi-person-vcard"></i> Form Edit Siswa</h2>
            <p>Perbarui data profil dan kredensial akun siswa.</p>
        </div>

        <div class="form-content">
            <form action="aksi_edit_user.php?aksi=editsiswa" method="POST">
                <h5 class="section-title">
                    <i class="bi bi-person"></i> Data Profil Siswa
                </h5>

                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input
                        type="text"
                        name="nis"
                        id="nis"
                        class="form-control"
                        value="<?= e($data['nis']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        id="nama_siswa"
                        class="form-control"
                        value="<?= e($data['nama']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input
                        type="text"
                        name="kelas"
                        id="kelas"
                        class="form-control"
                        value="<?= e($data['kelas']) ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Jenis Kelamin</label>

                    <div class="form-check">
                        <input
                            type="radio"
                            name="jenis_kelasmin"
                            id="siswa_l"
                            value="L"
                            class="form-check-input"
                            <?= ($data['jenis_kelasmin'] === 'L') ? 'checked' : '' ?>
                            required
                        >
                        <label class="form-check-label" for="siswa_l">
                            Laki-laki
                        </label>
                    </div>

                    <div class="form-check">
                        <input
                            type="radio"
                            name="jenis_kelasmin"
                            id="siswa_p"
                            value="P"
                            class="form-check-input"
                            <?= ($data['jenis_kelasmin'] === 'P') ? 'checked' : '' ?>
                            required
                        >
                        <label class="form-check-label" for="siswa_p">
                            Perempuan
                        </label>
                    </div>
                </div>

                <input type="hidden" name="id_siswa" value="<?= (int)$data['id'] ?>">
                <input type="hidden" name="id_user" value="<?= (int)$data['user_id'] ?>">
                <input type="hidden" name="role" value="siswa">

                <h5 class="section-title">
                    <i class="bi bi-shield-lock"></i> Data Kredensial Akun
                </h5>

                <div class="mb-3">
                    <label for="username_siswa" class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username_siswa"
                        class="form-control"
                        value="<?= e($data['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="pass_siswa" class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="pass"
                        id="pass_siswa"
                        class="form-control"
                        placeholder="Kosongkan jika tidak diubah"
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" name="edit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php elseif ($role === 'guru'): ?>

<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2><i class="bi bi-person-workspace"></i> Form Edit Guru</h2>
            <p>Perbarui data profil dan kredensial akun guru.</p>
        </div>

        <div class="form-content">
            <form action="aksi_edit_user.php?aksi=editguru" method="POST">
                <h5 class="section-title">
                    <i class="bi bi-person"></i> Data Profil Guru
                </h5>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input
                        type="text"
                        name="nip"
                        id="nip"
                        class="form-control"
                        value="<?= e($data['nip']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="nama_guru" class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        id="nama_guru"
                        class="form-control"
                        value="<?= e($data['nama']) ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Jenis Kelamin</label>

                    <div class="form-check">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            id="guru_l"
                            value="L"
                            class="form-check-input"
                            <?= ($data['jenis_kelamin'] === 'L') ? 'checked' : '' ?>
                            required
                        >
                        <label class="form-check-label" for="guru_l">
                            Laki-laki
                        </label>
                    </div>

                    <div class="form-check">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            id="guru_p"
                            value="P"
                            class="form-check-input"
                            <?= ($data['jenis_kelamin'] === 'P') ? 'checked' : '' ?>
                            required
                        >
                        <label class="form-check-label" for="guru_p">
                            Perempuan
                        </label>
                    </div>
                </div>

                <input type="hidden" name="id_guru" value="<?= (int)$data['id'] ?>">
                <input type="hidden" name="id_user" value="<?= (int)$data['user_id'] ?>">
                <input type="hidden" name="role" value="guru">

                <h5 class="section-title">
                    <i class="bi bi-shield-lock"></i> Data Kredensial Akun
                </h5>

                <div class="mb-3">
                    <label for="username_guru" class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username_guru"
                        class="form-control"
                        value="<?= e($data['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="pass_guru" class="form-label">Password Baru</label>
                    <input
                        type="password"
                        name="pass"
                        id="pass_guru"
                        class="form-control"
                        placeholder="Kosongkan jika tidak diubah"
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" name="edit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php endif; ?>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
</php>
