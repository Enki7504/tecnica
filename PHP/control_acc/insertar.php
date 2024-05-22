<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="modelo.css">
<html>

<head>
  <title>Ingresar datos del alumno</title>  
</head>

<body>
    <ul>
        <li><a href="index.php">Tabla</a></li>
        <li><a class="active" href="insertar.php">Insertar</a></li>
        <li><a href="listalumnos.php">Listado de alumnos</a></li>
    </ul>
    <div style="padding:20px;margin-top:30px;">
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">  
    Insertar datos:
      <form class="p-4" method="post" action="inspro.php">
          <label class="form-label">Nombre: </label>
          <input type="text" class="form-control" name="nombre" placeholder="Nombre">
          <label class="form-label">Apellido: </label>
          <input type="text" class="form-control" name="apellido" placeholder="Apellido">
          <label class="form-label">DNI: </label>
          <input type="number" class="form-control" name="dni" placeholder="DNI">
          <label class="form-label">ID Huella: </label>
          <input type="text" class="form-control" name="id_huella" placeholder="ID Huella">
          <label class="form-label">Division: </label>
          <input type="text" class="form-control" name="division" maxlength="2" placeholder="Division (ej: 4b)">
          <br>
          <input type="submit" class="btn btn-primary" value="Enviar">
      </form>
      </div>
  </div>
  </div>
  </div>
  </div>
  </div>
</body>

</html>