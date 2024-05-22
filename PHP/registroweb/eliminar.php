<?php
if (!isset($_GET['codigo'])) {
    header('Location: index.php?mensaje=error');
    exit();
}

include 'modelo/conexion.php';
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("DELETE FROM personas where codigo = ?;");
$resultado = $sentencia->execute([$codigo]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=eliminado');
} else {
    header('Location: index.php?mensaje=error');
}
