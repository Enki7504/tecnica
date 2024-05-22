<?php
$conexion = mysqli_connect("localhost", "root", "", "hola") or
die("Problemas con la conexión");

mysqli_query($conexion, "insert into hola(valor) values 
                   ('$_GET[valor]')")
or die("Problemas en el select" . mysqli_error($conexion));
/*
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("hola",$conexion);
mysql_query("INSERT INTO `hola`(`valor`) VALUES ('" . $_GET['valor'] . "')", $conexion);
*/
?>