<?php

require_once "Conexion.php";

$con = conexion();

$email = $_POST['EMAIL'];
$pass = $_POST['PASS'];

$sql = "INSERT INTO USER (EMAIL,PASS)  VALUES ('$email','$pass')";

// EL echo NOS RETORNA UN 0 O UN 1 DEPENDIENDO SI EJECUTA O NO EL COMANDO
echo $result = mysqli_query($con,$sql);

 ?>
