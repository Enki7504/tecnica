<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="modelo.css">

<?php 
foreach (glob("jquery.js") as $filename)
{
    echo "<script>";
    include $filename;
    echo "</script>";
}
?>
<script>// Filter table
$(document).ready(function(){
  $("#tableSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});</script>

<head>
<title>Tabla de alumnos</title>  
<head>
<body>

  <ul>
      <li><a href="index.php">Tabla</a></li>
      <li><a href="insertar.php">Insertar</a></li>
      <li><a class="active" href="listalumnos.php">Listado de alumnos</a></li>
  </ul>

  <?php
    include("conexion.php");

    $registros = mysqli_query($conexion, "SELECT * from alumnos") or
      die("Problemas en el select:" . mysqli_error($conexion));
    ?>
  <div class="container" style="margin-top:5rem;">
        <h3>Editar datos de los alumnos</h3>
    <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Buscar...">
    <table class="table table-bordered table-striped">
      <thead><tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>Division</th>
        <th>ID Huella</th>
        <th colspan="2">Opciones</th>
      </thead>
      <tbody id="myTable">
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
      </tbody>
    </table>
</div>

</body>
</html>