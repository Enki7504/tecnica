<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php    
  ob_start();
  include("conexion.php");

  $registros = mysqli_query($conexion, "select *
                                        from alumnos") or
    die("Problemas en el select:" . mysqli_error($conexion));

  if ($reg = mysqli_fetch_array($registros)) {
    mysqli_query($conexion, "delete from alumnos where id_alumnos='$_GET[id]'") or
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