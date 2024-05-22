<?php
header("Refresh:5");
?>
<!DOCTYPE html>
<html>
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
    padding: 1rem 1.1rem;
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

.active:hover {
    background-color: #04AA6D;
    color: #333;
    text-decoration: none;
}

.enviar {
    margin: 10px 0px 10px 0px;
    padding: 10px 30% 1 0px 30%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.divcerrar{
  padding: 1rem 1rem;
  color: #0f5132;
  background-color: #d1e7dd;
  border-color: #badbcc;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}

.cerrar{
  float:right;
}

@media screen and (max-width: 900px){
  body{
    width:100%;
    font-size:2rem;
    margin:0px;
    padding:0;
  }

  ul{
  	width:100%;
    margin:0px;
  }

  li{
    width:100%;
    margin:0px;
  }

  .container{
    width:100%;
    font-size:2rem;
    margin:0px;
    padding:1rem;
    padding-top:9rem;
  }
}

</style>

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
      <li><a href="entregados.php">Bolsones entregados</a></li>
  </ul>

  <?php
    include("conexion.php");
  $date = date('Y-m-d', time());

    $registros = mysqli_query($conexion, "select * from alumnos a
                                          inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$date'") or
      die("Problemas en el select:" . mysqli_error($conexion));
    ?>
  <div class="container" style="margin-top:5rem;">
  
  <?php if (empty($_GET['data'])){}else{?>
    <div class="divcerrar">
      <?php
        switch ($_GET['data']) {
          case "retirado":
            if ($_GET[ret] == 1){$estado = "<i class='bi bi-check-circle-fill' style='color:green;'></i>";}else{$estado = "<i class='bi bi-x-square-fill' style='color:red;'></i>";}
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
    <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Buscar...">
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
          <td><?php echo $reg['presente'] ?></td> 
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