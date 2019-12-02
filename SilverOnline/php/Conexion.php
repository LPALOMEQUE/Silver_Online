<?php

function conexion(){

  $conexion = mysqli_connect("127.0.0.1","root","","silver_online");

  return $conexion;

}

 if(conexion())
 {
  echo "Conectado...";
 }else{
   echo "No conectado!!";
 }
?>
