<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php    
  
  include("conexion.php");
  ob_start();

  $registros =   mysqli_query($conexion, "UPDATE personas
                        SET
                        nombre='$_REQUEST[nombre]', 
                        apellido='$_REQUEST[apellido]',
                        dni='$_REQUEST[dni]',
                        padremadretutor='$_REQUEST[padremadretutor]',
                        division='$_REQUEST[division]'
                        where id_personas=$_REQUEST[idr]")
                        or die("Problemas en el update:" . mysqli_error($conexion));
  mysqli_close($conexion);
  header("Location: index.php?data=editado");
  ?>
</body>

</html>