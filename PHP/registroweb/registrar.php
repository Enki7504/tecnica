<?php
//print_r($_POST);
if (empty($_POST["txtHuella"])) {
    header('Location: index.php?mensaje=falta');
    exit();
}

include_once 'modelo/conexion.php';
$nombre = $_POST["txtNombre"];
$apellido = $_POST["txtApellido"];
$idhuella = $_POST["txtHuella"];
$dni = $_POST["txtDni"];
$division = $_POST["txtDivision"];

$sentencia = $bd->prepare("INSERT INTO personas(nombre,apellido,huella,dni,division) VALUES (?,?,?,?,?);");
$resultado = $sentencia->execute([$nombre, $apellido, $idhuella, $dni, $division]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=registrado');
} else {
    header('Location: index.php?mensaje=error');
    exit();
}
