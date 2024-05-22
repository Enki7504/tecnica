
<!DOCTYPE html>
<html>
<head>
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

</head>
<body>

<ul>
    <li><a class="active" href="index.php">Tabla</a></li>
    <li><a href="insertar.php">Insertar</a></li>
    <li><a href="entregados.php">Listado de alumnos</a></li>
</ul>

<div style="padding:20px;margin-top:4rem;">

<?php
  include("conexion.php");
  $fecha = new DateTime($_POST['fecha']);
  $fecha = $fecha->format('Y-m-d');

  $registros = mysqli_query($conexion, "SELECT * from alumnos a
                                        inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$fecha'") or
    die("Problemas en el select:" . mysqli_error($conexion));
  ?>

  <h1>Buscaste a los presentes en la fecha <?php echo $fecha?></h1>

  <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Buscar...">
    <table class="table table-bordered">
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
      <td><?php if($reg['presente'] == 1){echo "<i class='bi bi-check-circle-fill' style='color:green;' title='Se encuentra dentro del establecimiento'></i>";}else{echo "<i class='bi bi-stop-circle-fill' style='color:#D60000;' title='Ya se fué del establecimiento'></i>";}?></td> 
      <td><?php echo $fecha;?></td> 
      <td><?php echo $reg['hora_llegada'] ?></td> 
      <td><?php echo $reg['hora_salida'] ?></td> 
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