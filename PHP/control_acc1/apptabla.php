
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
    <li><a href="app/app.php">Comandas</a></li>
    <li><a class="active" href="app/apptabla.php">Eliminar</a></li>
    <li><a href="app/cocina.php">Cocina</a></li>
</ul>

<div style="padding:20px;margin-top:4rem;">

<?php
  include("conexion.php");
  $date = date('Y-m-d', time());

  $registros = mysqli_query($conexion, "select * from alumnos a
                                        inner join fechahora fh on fh.id_huella=a.id_huella where fh.fecha='$date'") or
    die("Problemas en el select:" . mysqli_error($conexion));
  
  $alumnos = mysqli_query($conexion, "select *
                                        from alumnos") or
    die("Problemas en el select:" . mysqli_error($conexion));
  ?>

    <form action="buscar.php" method="post">
      <input type="search" name="buscarid" placeholder="Buscar por ID..." required>
      <button type="submit" class="btn">
        <i class="bi bi-search"></i>
      </button>
    </form>
  <!--<datalist id="alumnos">
  <?php
    while ($alu = mysqli_fetch_array($alumnos)) {
        echo  "<option value=".$alu['dni'].">".$alu['nombre']." - ".$alu['apellido']." - ".$alu['division']." - ".$alu['id_huella']."</option>";
    }
  ?>
  </datalist><!-->
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
      <td><?php echo $reg['presente'] ?></td> 
      <td><?php if($reg['fecha'] == $date){echo $reg['fecha'];}?></td> 
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


