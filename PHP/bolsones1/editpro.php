  <?php
   
  echo "---";
  include("conexion.php");
  ob_start();
  $insertar="UPDATE personas SET nombre='$_REQUEST[nombre]', apellido='$_REQUEST[apellido]', dni='$_REQUEST[dni]', padremadretutor='$_REQUEST[padremadretutor]', division='$_REQUEST[division]'
                        where id_personas";					
  echo $insertar;
  $registros =   mysql_query($insertar);
						
  echo $registros;
  mysqli_close($conexion);
  //header("Location: apptabla.php?data=editado");
  ?>