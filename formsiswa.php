<?php require 'navbar.php'?>
  <body>

   <div class="container">     

      <div class="card">
      <div class="card-body">
        <h1>Form Tambah Siswa 2</h1><br>
        
        <form action="aksi_user.php" method="POST">
          
          <div class="mb-3">
            
            <h6>-------------------------------------------------------</h6>
            <h1>Data Profil Siswa 2</h1>
            
  <label for="nis" class="form-label">NIS :</label>
  <input type="text" class="form-control" id="nis" name="nis" placeholder="Nomor Induk Siswa | Contoh: 123456">
          </div>
        
<div class="mb-3">
  <label for="nama" class="form-label">Nama :</label>
  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap Siswa | Contoh: Ujang Kedu">
      </div>
        
<div class="mb-3">
<label for="kelas" class="form-label">Kelas :</label>
  <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Kelas | Contoh: XI-RPL-1">
</div>
        
<div class="mb-3">
  <h5>Jenis Kelamin :</h5>
  <div class="form-check">
  <input class="form-check-input" type="radio" name="jenis_kelasmin" id="L" value="L">
  <label class="form-check-label" for="L">
   Laki Laki
  </label>
</div>
  
<div class="form-check">
  <input class="form-check-input" type="radio" name="jenis_kelasmin" id="P" value="P" checked>
  <label class="form-check-label" for="P">
    Perempuan
  </label>
</div>
  
</div>
     
<div class="mb-3">
  <h6>-------------------------------------------------------</h6>
  <h1>Data Kredensial Akun (Tabel Users)</h1>
  
  <label for="username" class="form-label">Username :</label>
  <input type="text" class="form-control" id="username" name="username" placeholder="Username Akun | Contoh: ujang123">
    </div>

<div class="mb-3">
  <label for="pass" class="form-label">Password :</label>
  <input type="password" class="form-control" id="pass" name="pass" placeholder="Password Akun | Contoh: password123">
    </div>

<div class="mb-3">
 <input type="hidden" name="role" value="siswa">
</div>
        
<div class="mb-3">
<button type="submit" name="kirim" class="btn btn-primary btn-sm">Submit</button>
<a href="formsiswa.php" class="btn btn-secondary btn-sm">Kembali</a>
</div>
    </form>
    </div>
   </div>
<br>
     <?php if(isset($_POST['kirim'])):?>
<h1>Output dari FORM</h1>
<?php

$nis       = $_POST['nis'];
$nama      = $_POST['nama'];
$kelas     = $_POST['kelas'];
$jenis     = $_POST['jenis_kelasmin'];
$username  = $_POST['username'];
$pass      = $_POST['pass'];

echo "NIS           :".$nis."<br>";
echo "Nama          :".$nama."<br>";
echo "Kelas         :".$kelas."<br>";
echo "Jenis Kelamin :".$jenis_kelasmin."<br><br><br>";

?>
  <?php endif ?>
<?php require 'footer.php'?>