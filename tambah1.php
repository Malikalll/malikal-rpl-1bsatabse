<?php require 'navbar.php'?>
  <body>

   <div class="container">     

      <div class="card">
      <div class="card-body">
        <h1>Form Tambah User(Admin)</h1><br>
        
        <form action="aksi_user.php" method="POST">
          
<div class="mb-3">
  <h1>Data Kredensial Akun (Tabel Users)</h1>
  
  <label for="username" class="form-label">Username :</label>
  <input type="text" class="form-control" id="username" name="username" placeholder="Username Akun | Contoh: ujang123">
    </div>

<div class="mb-3">
  <label for="pass" class="form-label">Password :</label>
  <input type="password" class="form-control" id="pass" name="pass" placeholder="Password Akun | Contoh: password123">
    </div>

<div class="mb-3">
 <input type="hidden" name="role" value="admin">
</div>
        
<div class="mb-3">
<button type="submit" name="kirim" class="btn btn-primary btn-sm">Submit</button>
<a href="formsiswa.php" class="btn btn-secondary btn-sm">Kembali</a>
</div>
    </form>
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