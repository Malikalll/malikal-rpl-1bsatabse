<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
) {
    header("Location: login.php");
    exit;
}

$role = strtolower(trim($_SESSION['role'] ?? ''));
$username = $_SESSION['username'] ?? '';

if (!in_array($role, ['admin', 'guru', 'siswa'], true)) {
    http_response_code(403);
    exit('Role tidak valid.');
}
?>

<style>
.siacad-navbar {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    position: relative;
    z-index: 1000;
    font-family: Arial, sans-serif;
}

.siacad-navbar .navbar-brand {
    color: #4f46e5;
    font-size: 21px;
    font-weight: 700;
    letter-spacing: .5px;
}

.siacad-navbar .navbar-brand:hover {
    color: #3730a3;
}

.siacad-navbar .navbar-toggler {
    border: 1px solid #d1d5db;
    box-shadow: none;
}

.siacad-navbar .nav-link {
    color: #4b5563;
    font-size: 14px;
    padding: 10px 12px !important;
    border-radius: 6px;
}

.siacad-navbar .nav-link:hover,
.siacad-navbar .nav-link:focus {
    color: #4f46e5;
    background: #eef2ff;
}

.siacad-navbar .dropdown-menu {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 5px;
    box-shadow: 0 4px 12px rgba(0,0,0,.05);
}

.siacad-navbar .dropdown-item {
    padding: 9px 11px;
    border-radius: 5px;
    font-size: 14px;
}

.siacad-navbar .dropdown-item:hover {
    background: #eef2ff;
    color: #4f46e5;
}

.siacad-navbar .dropdown-header {
    color: #6b7280;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.siacad-navbar .user-info {
    color: #4b5563;
    font-size: 13px;
    padding: 8px 10px;
    background: #f8f9fc;
    border-radius: 7px;
}

.siacad-navbar .user-info strong {
    color: #4f46e5;
}

.siacad-navbar .role-text {
    color: #6b7280;
    text-transform: capitalize;
}

.siacad-navbar .logout-link {
    color: #dc2626 !important;
}

.siacad-navbar .logout-link:hover {
    background: #fef2f2;
}

@media (max-width: 991.98px) {
    .siacad-navbar .navbar-collapse {
        padding: 10px 0;
    }

    .siacad-navbar .navbar-nav {
        gap: 3px;
    }

    .siacad-navbar .dropdown-menu {
        box-shadow: none;
        border: none;
        background: #f8f9fc;
        margin-left: 12px;
    }

    .siacad-navbar .user-info {
        margin-top: 10px;
        white-space: normal;
    }
}
</style>

<nav class="navbar navbar-expand-lg siacad-navbar">
    <div class="container">

        <a class="navbar-brand" href="dashboard.php">
            SIACAD
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#siacadMenu"
            aria-controls="siacadMenu"
            aria-expanded="false"
            aria-label="Buka menu">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="siacadMenu">

            <ul class="navbar-nav me-auto">

                <!-- SEMUA ROLE -->
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        Dashboard
                    </a>
                </li>

                <!-- MENU ADMIN -->
                <?php if ($role === 'admin'): ?>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                            role="button"
                            aria-expanded="false">
                            Manajemen Data
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <h6 class="dropdown-header">
                                    Lihat Data
                                </h6>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_user.php">
                                    Data User
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_siswa.php">
                                    Data Siswa
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_guru.php">
                                    Data Guru
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="tabel_mapel2.php">
                                    Mata Pelajaran
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_mengajar.php">
                                    Data Mengajar
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <h6 class="dropdown-header">
                                    Tambah Data
                                </h6>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="tambah1.php">
                                    + Tambah User
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="formsiswa.php">
                                    + Tambah Siswa
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="tambah_guru.php">
                                    + Tambah Guru
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="tambah_mapel.php">
                                    + Tambah Mata Pelajaran
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="tambah_mengajar.php">
                                    + Tambah Mengajar
                                </a>
                            </li>

                        </ul>
                    </li>

                <!-- MENU GURU -->
                <?php elseif ($role === 'guru'): ?>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                            role="button"
                            aria-expanded="false">
                            Akademik
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item"
                                   href="tabel_mapel2.php">
                                    Mata Pelajaran
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_siswa.php">
                                    Data Siswa
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="daftar_nilai.php">
                                    Kelola Nilai
                                </a>
                            </li>

                        </ul>
                    </li>

                <!-- MENU SISWA -->
                <?php elseif ($role === 'siswa'): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="daftar_nilai.php">
                            Lihat Nilai
                        </a>
                    </li>

                <?php endif; ?>

                <!-- SEMUA ROLE -->
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">
                        Profil
                    </a>
                </li>

            </ul>

            <!-- INFORMASI USER DAN LOGOUT -->
            <div class="d-flex flex-column flex-lg-row
                        align-items-stretch align-items-lg-center gap-2">

                <div class="user-info">
                    <strong>
                        <?= htmlspecialchars(
                            $username,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>

                    <span class="role-text">
                        (<?= htmlspecialchars(
                            $role,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>)
                    </span>
                </div>

                <a
                    href="logout.php"
                    class="nav-link logout-link"
                    onclick="return confirm('Yakin ingin logout?')">
                    Logout
                </a>

            </div>

        </div>
    </div>
</nav>
