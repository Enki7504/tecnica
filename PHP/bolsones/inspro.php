<?php

  include("conexion.php");

  $registros = mysqli_query($conexion, "insert into personas(nombre,apellido,dni,padremadretutor,division) values 
                                        ('$_REQUEST[nombre]','$_REQUEST[apellido]','$_REQUEST[dni]','$_REQUEST[padremadretutor]','$_REQUEST[division]')") or
    die("Problemas en el select:" . mysqli_error($conexion));

    
  mysqli_close($conexion);
  header("Location: index.php?data=insertado");
  ?>

  