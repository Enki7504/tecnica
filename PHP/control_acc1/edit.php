<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="modelo.css">
<html>

<head>
  <title>Problema</title>
</head>

<body>
  <ul>
      <li><a href="index.php">Tabla</a></li>
      <li><a href="insertar.php">Insertar</a></li>
      <li><a href="entregados.php">Bolsones entregados</a></li>
  </ul>
  <?php    
  ob_start();
  include("conexion.php");

  $registros = mysqli_query($conexion, "select *
                                        from alumnos") or
    die("Problemas en el select:" . mysqli_error($conexion));
    ?>
  <div style="padding:20px;margin-top:30px;">
  <div class="container mt-5">
  <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
  Editar datos:
    <form class="p-4" method="post" action="editpro.php">
        <label class="form-label">Nombre: </label>
        <input type="text" class="form-control" name="nombre" value="<?php echo $_GET['nombre']; ?>" placeholder="<?php echo $_GET['nombre']; ?>">
        <label class="form-label">Apellido: </label>
        <input type="text" class="form-control" name="apellido" value="<?php echo $_GET['apellido']; ?>">
        <label class="form-label">DNI: </label>
        <input type="number" class="form-control" name="dni" value="<?php echo $_GET['dni']; ?>">
        <label class="form-label">Padre/Madre/Tutor: </label>
        <input type="text" class="form-control" name="id_huella" value="<?php echo $_GET['id_huella']; ?>">
        <label class="form-label">Division: </label>
        <input type="text" class="form-control" name="division" value="<?php echo $_GET['division']; ?>">
        <input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
        <input type="submit" class="btn btn-primary" value="Editar">
    </form>    
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <?php
  mysqli_close($conexion);
  ?>
</body>

</html>