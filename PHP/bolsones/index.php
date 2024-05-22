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
<link rel="icon" type="image/x-icon" href="favicon.ico">
<title>Tabla de alumnos</title>  
<head>
<body>

  <ul>
      <li><a class="active" href="index.php">Tabla</a></li>
      <li><a href="insertar.php">Insertar</a></li>
      <li><a href="entregados.php">Bolsones entregados</a></li>
  </ul>

  <?php
    include("conexion.php");

    $registros = mysqli_query($conexion, "select *
                                          from personas") or
      die("Problemas en el select:" . mysqli_error($conexion));
    ?>
  <div class="container" style="margin-top:5rem;">
  
  <?php if (empty($_GET['data'])){}else{?>
    <div class="divcerrar">
      <?php
        switch ($_GET['data']) {
          case "retirado":
            if ($_GET['ret'] == 1){$estado = "<i class='bi bi-check-circle-fill' style='color:green;'></i>";}else{$estado = "<i class='bi bi-x-square-fill' style='color:red;'></i>";}
            echo "Se cambio el estado a ".$estado;
            break;
          case "reiniciado":
              echo "Se reinició el contador exitosamente";
              break;
          case "eliminado":
              echo "Se eliminó el alumno exitosamente";
              break;
          case "insertado":
              echo "Se ingresaron los datos del alumno exitosamente";
              break;
          case "editado":
              echo "Se editaron los datos del alumno exitosamente";
              break;
        }
      ?>
      
      <button type="button" class="close" onclick="this.parentNode.remove(); return false;"><i class="bi bi-x-lg" style="font-size: 1.5rem;"></i></button>
    </div>
    <?php }?>
    <form action="buscar.php" method="post">
      <input type="search" name="buscarid" placeholder="Buscar por ID..." required>
      <button type="submit" class="btn">
        <i class="bi bi-search"></i>
      </button>
    </form>
    <input class="form-control mb-4" id="tableSearch" type="text"
      placeholder="Buscar...">

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>DNI</th>
          <th>Padre/Madre/Tutor</th>
          <th>Division</th>
          <th colspan="2" >Retirado</th>
          <th colspan="2" >Opciones</th>
        </tr>
      </thead>
      <tbody id="myTable">
      <?php
    while ($reg = mysqli_fetch_array($registros)) {
      ?>
      <tr>          
        <td><?php echo $reg['id_personas'] ?></td>
        <td><?php echo $reg['nombre'] ?></td> 
        <td><?php echo $reg['apellido'] ?></td> 
        <td><?php echo $reg['dni'] ?></td> 
        <td><?php echo $reg['padremadretutor'] ?></td> 
        <td><?php echo $reg['division'] ?></td> 
        <td><?php if ($reg['retirado'] == 1){echo "<i class='bi bi-check-circle-fill' style='color:green;'></i>";}else{echo "<i class='bi bi-x-square-fill' style='color:red;'></i>";} ?></td>
        <td><a href="retirado.php?id=<?php echo $reg['id_personas']; ?>&proxest=<?php if ($reg['retirado'] == 1){echo "0";}else{echo "1";} ?>"><i class="bi bi-square-half"></i></a></td> 
        <td><a href="edit.php?id=<?php echo $reg['id_personas']; ?>&nombre=<?php echo $reg['nombre']?>&apellido=<?php echo $reg['apellido']?>&dni=<?php echo $reg['dni']?>&padremadretutor=<?php echo $reg['padremadretutor']?>&division=<?php echo $reg['division']?>"><i class="bi bi-pencil-square"></i></a></td>
        <td><a onclick="return confirm('Estas seguro de eliminar?');" href="eliminar.php?id=<?php echo $reg['id_personas']; ?>"><i class="bi bi-trash"></i></a></td>
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