<?php
include("conexion.php");
ob_start();
 $registros =   mysqli_query($conexion, "UPDATE personas
 SET
 nombre='a', 
 apellido='b',
 dni='1',
 padremadretutor='c',
 division='d'
 where id_personas=1");

 echo $registros;
?>