<?php
print_r($_POST);
if (!isset($_POST['codigo'])) {
    header('Location: index.php?mensaje=error');
}

include 'modelo/conexion.php';
$codigo = $_POST['codigo'];
$nombre = $_POST['txtNombre'];
$apellido = $_POST['txtApellido'];
$idhuella = $_POST['txtHuella'];
$dni = $_POST['txtDni'];
$division = $_POST['txtDivision'];

$sentencia = $bd->prepare("UPDATE personas SET nombre = ?, apellido = ?, huella = ?, dni = ?, division = ? where codigo = ?;");
$resultado = $sentencia->execute([$nombre, $apellido, $idhuella, $dni, $division, $codigo]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=editado');
} else {
    header('Location: index.php?mensaje=error');
    exit();
}
