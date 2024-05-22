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
    mysqli_query($conexion, "update alumnos
                        set 
                        nombre='$_REQUEST[nombre]', 
                        apellido='$_REQUEST[apellido]',
                        dni='$_REQUEST[dni]',
                        id_huella='$_REQUEST[id_huella]',
                        division='$_REQUEST[division]'
                        where id_alumnos='$_REQUEST[id]'") or
      die("Problemas en el update:" . mysqli_error($conexion));
    echo "Se cambio el estado exitosamente.";
    } else {
    echo "ERROR: Algo falló";
  }

  echo "ID= ".$_REQUEST[id];

  mysqli_close($conexion);
  //header("Location: index.php");
  ?>
</body>

</html>