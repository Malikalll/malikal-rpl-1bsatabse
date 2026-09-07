<?php require 'navbar.php'; ?>

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

$sql = "SELECT users.*,
        COALESCE(siswa.nama, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Users</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>

<body>

<div class="container mt-5">

    <div class="card shadow-sm">

        <div class="card-body">

            <h2 class="mb-4 text-center">
                Data Users
            </h2>

            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered border-secondary">

                    <thead class="table-primary">

                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Username</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Password</th>
                            <th scope="col">Role</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        while($user = mysqli_fetch_assoc($query)):
                        ?>

                            <tr>
                                <td>
                                  <?= $no++ ?>
                                </td>
                                  
                                <td>
                                  <?php echo $user['username']?>
                                </td>

                                <td>
                                  <?php echo $user['nama']?>
                                </td>

                               <td>
                                 <?php echo $user['password']?>
                               </td>

                                <td>
                                  <?php echo $user['role']?>
                                </td>

                                <td>
                                  <?php echo $user['created_at']?>
                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <!-- Edit -->
                                        <a
                                            href="edit.php?id=<?= $user['id']; ?>&page=siswafor.php"
                                            class="btn btn-sm btn-primary"
                                            title="Edit"
                                            aria-label="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete -->
                                        <a
                                            href="delete.php?id=<?= $user['id']; ?>&page=siswafor.php"
                                            class="btn btn-sm btn-danger"
                                            title="Hapus"
                                            aria-label="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php require 'footer.php'; ?>

</body>
</html>