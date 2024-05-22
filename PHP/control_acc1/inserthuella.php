<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<style>
    
body {
    margin:0;
    font-family: Arial;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
    text-decoration: none;  
    color: #fff;
}

.active {
    background-color: #04AA6D;
    color: #fff;
    text-decoration: none;
}

.enviar {
    margin: 10px 0px 10px 0px;
    padding: 10px 30% 10px 30%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

</head>
<body>

<div style="padding:20px;margin-top:30px;">

<?php
  include("conexion.php");
  
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $date = date('Y-m-d', time());
  $hour = date('H:i:s', time());
  $id_get = $_GET['id_huella'];

  echo $id_get."<br>";
  $existe = 0;

  $registros = mysqli_query($conexion, "SELECT * from fechahora 
                                        where fecha='$date' AND id_huella='$id_get'") or
    die("Problemas en el select1:" . mysqli_error($conexion));

  $inssal = mysqli_query($conexion, "SELECT * from fechahora 
                                    where id_huella='$id_get' AND (fecha='$date' AND hora_salida='0')") or
    die("Problemas en el select2:" . mysqli_error($conexion));
    
    echo $date." HORA ".$hour." ";

    while($consulta = mysqli_fetch_array($registros)){
        $existe++;  
    }
    if($existe==0){        
        echo "1er NO EXISTE";
        //No hay registros en la fecha actual, se tiene que insertar la hora de entrada
        $registros = mysqli_query($conexion, "INSERT into fechahora(id_huella,presente,fecha,hora_llegada) 
                                        values ('$id_get',1,'$date','$hour')") or
        die("Problemas en el 1er insert:" . mysqli_error($conexion));
    }
    else{        
        //ya habia entrado a la escuela
        echo "1er Existe";
        $existe=0;
        while($consulta = mysqli_fetch_array($inssal)){
            $existe++;  
        }
        //DEBERIA INSERTAR UNA NUEVA FILA, PERO SIGUE DICIENDO "1er EXISTE 2do EXISTE" CUANDO TIENE QUE DECIR "1er EXISTE"
        if($existe==0){        
            //El alumno entro y salio en la fecha actual, asi que se inserta la hora de entrada en otra fila
            echo "2do NO EXISTE";
            $registros = mysqli_query($conexion, "INSERT into fechahora(id_huella,presente,fecha,hora_llegada) 
                                        values ('$id_get',1,'$date','$hour')") or
            die("Problemas en el 2do insert:" . mysqli_error($conexion));
            
        }else{
            //El alumno entro pero no salio, asi que se actualiza la fecha de salida
            echo "2do Existe";
            $registros = mysqli_query($conexion, "UPDATE fechahora
                                                set hora_salida='$hour',
                                                presente=0
                                                where id_huella='$id_get' AND (fecha='$date' AND hora_salida=0)") or
            die("Problemas en el 3er insert:" . mysqli_error($conexion));
        }
    }
    
    /*mysqli_query($conexion, "insert into alumnos() values 
                         ('$_REQUEST[nombre]','$_REQUEST[mail]',$_REQUEST[codigocurso])")
      or die("Problemas en el select" . mysqli_error($conexion));
    */
    mysqli_close($conexion);
  
    ?>
  </table>
</div>
</div>

</body>
</html>