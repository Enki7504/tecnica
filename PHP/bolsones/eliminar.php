<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php    
  
  include("conexion.php");
  ob_start();

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
  header("Location: index.php?data=eliminado");
  ?>
</body>

</html>