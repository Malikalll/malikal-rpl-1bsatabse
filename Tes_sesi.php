
<?php
session_start();
$_SESSION['tes'] = true;
header("Location: login.php");
exit;
