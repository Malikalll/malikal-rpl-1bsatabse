<?php require 'navbar1.php'; ?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tambah Admin - SIACAD</title>

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
            max-width: 750px;
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
            margin: 0 0 20px;
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

        .form-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .btn {
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

<div class="form-container">
    <div class="form-card">

        <div class="form-header">
            <h2>
                <i class="bi bi-person-gear"></i>
                Form Tambah Admin
            </h2>

            <p>
                Buat akun administrator baru untuk sistem SIACAD
            </p>
        </div>

        <div class="form-content">

            <form action="aksi_user.php" method="POST">

                <input type="hidden" name="form_type" value="admin">
                <input type="hidden" name="role" value="admin">

                <h5 class="section-title">
                    <i class="bi bi-shield-lock"></i>
                    Data Kredensial Akun
                </h5>

                <div class="mb-3">
                    <label for="username" class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        placeholder="Masukkan username admin"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="pass" class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        class="form-control"
                        id="pass"
                        name="pass"
                        placeholder="Masukkan password admin"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button
                        type="submit"
                        name="kirim"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-save"></i>
                        Simpan Admin
                    </button>

                    <a
                        href="daftar_user.php"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>