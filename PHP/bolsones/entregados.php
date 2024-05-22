
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="modelo.css">
<style>
.enviar {
    margin: 10px 0px 10px 0px;
    padding: 10px 30% 10px 30%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.button {        
    text-decoration: none;
    background-color: #1c87c9;
    border: none;
    color: white;
    padding: 20px 34px;
    text-align: center;
    display: inline-block;
    font-size: 20px;
    margin: 4px 2px;
    cursor: pointer;
}

.button:hover {        
    text-decoration: none;
    background-color: #1c87c9;
    border: none;
    color: white;
    padding: 20px 34px;
    text-align: center;
    display: inline-block;
    font-size: 20px;
    margin: 4px 2px;
    cursor: pointer;
}

</style>

</head>
<body>

<ul>
    <li><a href="index.php">Tabla</a></li>
    <li><a href="insertar.php">Insertar</a></li>
    <li><a class="active" href="entregados.php">Bolsones entregados</a></li>
</ul>

<div style="padding:3rem;margin-top:30px;">


<?php

    include("conexion.php");

  $registros = mysqli_query($conexion, "select *
                                        from personas where retirado=1") or
    die("Problemas en el select:" . mysqli_error($conexion));
  ?>
  <?php
  $cont = 0;
  while ($reg = mysqli_fetch_array($registros)) {
    $cont++;
  }
    ?>
    Se entregaron <b><?php echo $cont; ?></b> bolsones
    <br>
    <hr>
    Para reinciar el contador: <a class="button" onclick="return confirm('Estas seguro de reinciar el contador?');" href="reiniciarcont.php">Reiniciar</a>
    <?php
    
  mysqli_close($conexion);
  ?>
</div>

</body>
</html>
