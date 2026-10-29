<?php require 'navbar.php' ?>

<body>

<div class="container">

    <div class="card">
        <div class="card-body">

            <h1>Form Tambah User 3</h1><br>

            <form action="aksi_user.php" method="POST">

                <div class="mb-3">
                    <h3>Data Kredensial Akun (Tabel Users)</h3>

                    <label for="username" class="form-label">Username :</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="username" 
                        name="username" 
                        placeholder="Username Akun | Contoh: ujang123"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="pass" class="form-label">Password :</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="pass" 
                        name="pass" 
                        placeholder="Password Akun | Contoh: password123"
                        required
                    >
                </div>


              
                <div class="mb-3">
                    <h5>Role :</h5>

                    <div class="form-check">
                        <input 
                            class="form-check-input"
                            type="radio"
                            name="role"
                            id="siswa"
                            value="siswa"
                            onclick="pilihRole()"
                        >

                        <label class="form-check-label" for="siswa">
                            Siswa
                        </label>
                    </div>


                    <div class="form-check">
                        <input 
                            class="form-check-input"
                            type="radio"
                            name="role"
                            id="guru"
                            value="guru"
                            onclick="pilihRole()"
                        >

                        <label class="form-check-label" for="guru">
                            Guru
                        </label>
                    </div>


                    <div class="form-check">
                        <input 
                            class="form-check-input"
                            type="radio"
                            name="role"
                            id="admin"
                            value="admin"
                            checked
                            onclick="pilihRole()"
                        >

                        <label class="form-check-label" for="admin">
                            Admin
                        </label>
                    </div>

                </div>

                <div id="formSiswa" style="display: none;">

                    <hr>

                    <h3>Data Siswa</h3><br>

                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS :</label>

                        <input 
                            type="text" 
                            class="form-control" 
                            id="nis" 
                            name="nis"
                            placeholder="Contoh: 12345678"
                        >
                    </div>


                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">
                            Nama Siswa :
                        </label>

                        <input 
                            type="text" 
                            class="form-control" 
                            id="nama_siswa" 
                            name="nama_siswa"
                            placeholder="Nama lengkap siswa"
                        >
                    </div>


                    <div class="mb-3">
                        <label for="kelas" class="form-label">
                            Kelas :
                        </label>

                        <input 
                            type="text" 
                            class="form-control" 
                            id="kelas" 
                            name="kelas"
                            placeholder="Contoh: XI RPL 1"
                        >
                    </div>


                    <div class="mb-3">
                        <label for="jenis_kelasmin" class="form-label">
                            Jenis Kelamin :
                        </label>

                        <select 
                            class="form-control" 
                            id="jenis_kelasmin"
                            name="jenis_kelasmin"
                        >

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option value="L">
                                Laki-laki
                            </option>

                            <option value="P">
                                Perempuan
                            </option>

                        </select>
                    </div>

                </div>

                <div id="formGuru" style="display: none;">

                    <hr>

                    <h3>Data Guru</h3><br>

                    <div class="mb-3">
                        <label for="nip" class="form-label">
                            NIP :
                        </label>

                        <input 
                            type="text" 
                            class="form-control" 
                            id="nip" 
                            name="nip"
                            placeholder="Contoh: 198001012005011001"
                        >
                    </div>


                    <div class="mb-3">
                        <label for="nama_guru" class="form-label">
                            Nama Guru :
                        </label>

                        <input 
                            type="text" 
                            class="form-control" 
                            id="nama_guru" 
                            name="nama_guru"
                            placeholder="Nama lengkap guru"
                        >
                    </div>


                    <div class="mb-3">
                        <label for="jenis_kelamin_guru" class="form-label">
                            Jenis Kelamin :
                        </label>

                        <select 
                            class="form-control" 
                            id="jenis_kelamin_guru"
                            name="jenis_kelamin_guru"
                        >

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option value="L">
                                Laki-laki
                            </option>

                            <option value="P">
                                Perempuan
                            </option>

                        </select>
                    </div>

                </div>


                <div class="mb-3">

                    <button 
                        type="submit" 
                        name="kirim" 
                        class="btn btn-primary btn-sm"
                    >
                        Submit
                    </button>

                    <a 
                        href="formsiswa.php" 
                        class="btn btn-secondary btn-sm"
                    >
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>


<script>

function pilihRole() {

    var role = document.querySelector('input[name="role"]:checked');

    var formSiswa = document.getElementById("formSiswa");
    var formGuru = document.getElementById("formGuru");


    formSiswa.style.display = "none";
    formGuru.style.display = "none";


    if (role.value == "siswa") {

        formSiswa.style.display = "block";

    }


    else if (role.value == "guru") {

        formGuru.style.display = "block";

    }


    else if (role.value == "admin") {


    }

}

</script>


<?php require 'footer.php' ?>