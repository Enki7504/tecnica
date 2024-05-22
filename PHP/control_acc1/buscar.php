
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<style>
    
body {
    margin:0;
    font-family: Arial;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
    text-decoration: none;  
    color: #fff;
}

.active {
    background-color: #04AA6D;
    color: #fff;
    text-decoration: none;
}

.enviar {
    margin: 10px 0px 10px 0px;
    padding: 10px 30% 10px 30%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

</head>
<body>

<ul>
    <li><a class="active" href="index.php">Tabla</a></li>
    <li><a href="insertar.php">Insertar</a></li>
    <li><a href="entregados.php">Bolsones entregados</a></li>
</ul>

<div style="padding:20px;margin-top:4rem;">

<?php
  include("conexion.php");
  $date = date('Y-m-d', time());

  $registros = mysqli_query($conexion, "SELECT * from alumnos a
                                        inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$date' AND a.id_alumnos='$_REQUEST[buscarid]'") or
    die("Problemas en el select:" . mysqli_error($conexion));
  
  $alumnos = mysqli_query($conexion, "SELECT *
                                        from alumnos") or
    die("Problemas en el select:" . mysqli_error($conexion));
  ?>

  <input list="alumnos" name="buscar" class="datal"/>
  <datalist id="alumnos">
  <?php
    while ($alu = mysqli_fetch_array($alumnos)) {
        echo  "<option value=".$alu['dni'].">".$alu['nombre']." - ".$alu['apellido']." - ".$alu['division']." - ".$alu['id_huella']."</option>";
    }
  ?>
  </datalist>
    <table class="table table-bordered">
        <thead><tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Division</th>
            <th>ID Huella</th>
            <th colspan="2" >Opciones</th>
        </thead>
    <tbody>
  <?php
  while ($reg = mysqli_fetch_array($registros)) {
    ?>
     <tr>          
      <td><?php echo $reg['id_alumnos'] ?></td>
      <td><?php echo $reg['nombre'] ?></td> 
      <td><?php echo $reg['apellido'] ?></td> 
      <td><?php echo $reg['dni'] ?></td> 
      <td><?php echo $reg['division'] ?></td> 
      <td><?php echo $reg['id_huella'] ?></td>
      <td><a href="edit.php?id=<?php echo $reg['id_alumnos']; ?>&nombre=<?php echo $reg['nombre']?>&apellido=<?php echo $reg['apellido']?>&dni=<?php echo $reg['dni']?>&id_huella=<?php echo $reg['id_huella']?>&division=<?php echo $reg['division']?>"><i class="bi bi-pencil-square"></i></a></td>
      <td><a onclick="return confirm('Estas seguro de eliminar?');" href="eliminar.php?id=<?php echo $reg['id_alumnos']; ?>"><i class="bi bi-trash"></i></a></td>
     </tr>     
    <?php
  }
  mysqli_close($conexion);
  ?>
  </table>
</div>
</div>

</body>
</html>