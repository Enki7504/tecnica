<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php    
  ob_start();
  
  $conexion = mysqli_connect("localhost", "root", "", "bolsones") or
    die("Problemas con la conexión");

  $registros = mysqli_query($conexion, "select *
                                        from personas") or
    die("Problemas en el select:" . mysqli_error($conexion));

  if ($reg = mysqli_fetch_array($registros)) {
    mysqli_query($conexion, "delete from personas where id_personas='$_GET[id]'") or
      die("Problemas en el select:" . mysqli_error($conexion));
    echo "Se efectuó el borrado del pedido.";
  } else {
    echo "ERROR: Algo falló";
  }
  mysqli_close($conexion);
  header("Location: apptabla.php");
  ?>
</body>

</html>