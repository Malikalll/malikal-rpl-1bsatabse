<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - SIACAD SMK</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fc;
            color: #374151;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            padding: 18px;
        }

        .login-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 32px;
            border-top: 4px solid #6366f1;
        }

        .login-title {
            text-align: center;
            font-size: 27px;
            font-weight: 700;
            color: #374151;
            margin: 0 0 8px;
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 14px;
            color: #374151;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 7px;
        }

        .form-control:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px 16px;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-primary {
            background: #4f46e5;
            color: #fff;
        }

        .btn-primary:hover {
            background: #4338ca;
        }

        .btn-register {
            background: #eef2ff;
            color: #4338ca;
            border-color: #c7d2fe;
        }

        .btn-register:hover {
            background: #e0e7ff;
        }

        .btn-secondary {
            background: #fff;
            color: #4b5563;
            border-color: #d1d5db;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
        }

        .login-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 14px;
            }

            .login-card {
                padding: 25px 20px;
            }

            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">

        <h1 class="login-title">SIACAD SMK</h1>

        <p class="login-subtitle">
            Sistem Informasi Akademik Sekolah<br>
            Silakan masuk ke akun Anda.
        </p>

        <form action="aksi_login.php" method="POST">

            <div class="form-group">
                <label for="username" class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="pass" class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    class="form-control"
                    id="pass"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="button-group">

                <button
                    type="submit"
                    name="login"
                    class="btn btn-primary"
                >
                    Login
                </button>

                <a
                    href="register_siswa.php"
                    class="btn btn-register"
                >
                    Register Siswa
                </a>

                <a
                    href="login.php"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </form>
      
    </div>
</div>

</body>
</html>