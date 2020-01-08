<?php
session_start();
// $_SESSION["ID_USER"] = 0;
require_once "Conexion.php";

$con = conexion();

  $email = $_POST['EMAIL'];
  $pass = $_POST['PASS'];



$sql = "SELECT * FROM USER WHERE EMAIL ='$email' AND PASS='$pass'";

  $result = mysqli_query($con,$sql);

  while($user = mysqli_fetch_row($result)){

    if ($email == $user[1] && $pass == $user[2]) {
      echo 1;
      $_SESSION["ID_USER"] = $user[0];
      $_SESSION["Email"] = $user[1];
    }
  }

?>
