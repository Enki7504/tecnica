<?php
header("Refresh:15");
?>
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
      <li><a class="active" href="index.php">Tabla</a></li>
      <li><a href="insertar.php">Insertar</a></li>
      <li><a href="listalumnos.php">Listado de alumnos</a></li>
  </ul>

  <?php
    include("conexion.php");
  $date = date('Y-m-d', time());

    $registros = mysqli_query($conexion, "SELECT * from alumnos a
                                          inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$date' AND fh.presente='1'") or
      die("Problemas en el select:" . mysqli_error($conexion));

    $presentes = mysqli_query($conexion, "SELECT * from alumnos a
                                          inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$date' AND fh.presente='1'") or
      die("Problemas en el select:" . mysqli_error($conexion));

    ?>
  <div class="container" style="margin-top:5rem;">
  
  <?php if (empty($_GET['data'])){}else{?>
    <div class="divcerrar">
      <?php
        switch ($_GET['data']) {
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
    <h3>Estos son los alumnos que estan dentro de la escuela</h3>
    <div>
    <form action="buscarfecha.php" method="post" style="display: inline; float: right;">
      <input type="date" name="fecha">
      <button type="submit" class="btn">
        <i class="bi bi-search"></i>
      </button>
    </form>
    </div>
    <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Buscar...">
    <?php
      $cantidad = 0;
      while ($reg = mysqli_fetch_array($presentes)) {
        $cantidad++;
      }?>
    Cantidad de alumnos dentro de la escuela: <?php echo $cantidad;?>

    <table class="table table-bordered table-striped">
      <thead><tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>Division</th>
        <th>ID Huella</th>
        <th>Presente</th>
        <th>Fecha</th>
        <th colspan="2" >Hora de llegada/Salida</th>
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
          <td><?php if($reg['presente'] == 1){echo "<i class='bi bi-check-circle-fill' style='color:green;'></i>";} ?></td> 
          <td><?php if($reg['fecha'] == $date){echo $reg['fecha'];}?></td> 
          <td><?php echo $reg['hora_llegada'] ?></td> 
          <td><?php echo $reg['hora_salida'] ?></td> 
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