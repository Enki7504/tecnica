<?php include 'template/header.php' ?>

<?php
if (!isset($_GET['codigo'])) {
    header('Location: index.php?mensaje=error');
    exit();
}

include_once 'modelo/conexion.php';
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("select * from personas where codigo = ?;");
$sentencia->execute([$codigo]);
$persona = $sentencia->fetch(PDO::FETCH_OBJ);
//print_r($persona);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Editar datos:
                </div>
                <form class="p-4" method="POST" action="editarProceso.php">
                    <div class="mb-3">
                        <label class="form-label">Nombre: </label>
                        <input type="text" class="form-control" name="txtNombre" required value="<?php echo $persona->nombre; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido: </label>
                        <input type="text" class="form-control" name="txtApellido" autofocus required value="<?php echo $persona->apellido; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID huella: </label>
                        <input type="text" class="form-control" name="txtHuella" autofocus required value="<?php echo $persona->huella; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dni: </label>
                        <input type="number" class="form-control" name="txtDni" autofocus required value="<?php echo $persona->dni; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Division: </label>
                        <input type="text" class="form-control" name="txtDivision" autofocus required value="<?php echo $persona->division; ?>">
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="codigo" value="<?php echo $persona->codigo; ?>">
                        <input type="submit" class="btn btn-primary" value="Editar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php' ?>