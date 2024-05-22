
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="modelo.css">

<title>Buscar alumnos</title>  
</head>
<body>

<ul>
    <li><a class="active" href="index.php">Tabla</a></li>
    <li><a href="insertar.php">Insertar</a></li>
    <li><a href="entregados.php">Bolsones entregados</a></li>
</ul>

<div style="padding:20px;margin-top:30px;">
<?php

    include("conexion.php");

  $registros = mysqli_query($conexion, "select *
                                        from personas where id_personas='$_REQUEST[buscarid]'") or
    die("Problemas en el select:" . mysqli_error($conexion));
  ?>
  <h1>Buscaste la ID: #<?php echo $_REQUEST['buscarid'];?></h1>
    <table class="table table-bordered">
        <thead><tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Padre/Madre/Tutor</th>
            <th>Division</th>
            <th colspan="2" >Retirado</th>
            <th colspan="2" >Opciones</th>
        </thead>
    <tbody>
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
      <td><a href="edit.php?id=<?php echo $reg['id_personas']; ?>&nombre=<?php echo $reg['nombre']?>&apellido=<?php echo $reg['apellido']?>&dni=<?php echo $reg['dni']?>&padremadretutor=<?php echo $reg['padre/madre/tutor']?>&division=<?php echo $reg['division']?>"><i class="bi bi-pencil-square"></i></a></td>
      <td><a onclick="return confirm('Estas seguro de eliminar?');" href="eliminar.php?id=<?php echo $reg['id_personas']; ?>"><i class="bi bi-trash"></i></a></td>
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
