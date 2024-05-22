<?php

    include("conexion.php");

  $registros = mysqli_query($conexion, "update personas
                                        set retirado=0
                                        where retirado=1") or
    die("Problemas en el select:" . mysqli_error($conexion));

  mysqli_close($conexion);
  header("Location: index.php?data=reiniciado");
  ?>