<?php
  //Se conecta con la base de datos, a través del archivo conexion.php
  include("conexion.php");
  
  //Toma la fecha y hora actual de Buenos Aires, Argentina
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $date = date('Y-m-d', time());
  $hour = date('H:i:s', time());
  //Crea la variable que almacena el id_huella que manda la arduino por metodo GET
  $id_get = $_GET['id_huella'];
  $existe = 0;


  //Selecciona todos los registros dentro de la tabla "fechahora" donde la fecha sea la actual y el id_huella sea el que mando la arduino
  $registros = mysqli_query($conexion, "SELECT * from fechahora 
                                        where fecha='$date' AND id_huella='$id_get'") or
    die("Problemas en el select1:" . mysqli_error($conexion));

  //Selecciona todos los registros dentro de la tabla "fechahora" donde la fecha sea la actual, el id_huella sea el que mando la arduino y la hora de salida (hora_salida) este vacia
  $inssal = mysqli_query($conexion, "SELECT * from fechahora 
                                     where id_huella='$id_get' AND (fecha='$date' AND hora_salida='0')") or
  die("Problemas en el select2:" . mysqli_error($conexion));
    
    echo $date." HORA ".$hour." ";
    //Consulta si ya se registro el alumno en la fecha actual
    while($consulta = mysqli_fetch_array($registros)){
        $existe++;  
    }
    if($existe==0){       
        echo "No hay registros en la fecha actual, se crea una nueva fila ";
        //No hay registros en la fecha actual, por lo tanto no habia entrado a la escuela, se tiene que insertar la hora de ENTRADA
        $registros = mysqli_query($conexion, "INSERT into fechahora(id_huella,presente,fecha,hora_llegada) 
                                        values ('$id_get',1,'$date','$hour')") or
        die("Problemas en el insert:" . mysqli_error($conexion));
    }
    else{        
        //ya habia entrado a la escuela
        echo "El alumno ya habia entrado a la escuela ";
        $existe=0;
        //Consulta si el alumno ya se fue y volvio a entrar o si solo entro y no se fue
        while($consulta = mysqli_fetch_array($inssal)){
            $existe++;  
        }
        if($existe==0){        
            //El alumno entro y salio en la fecha actual, asi que se inserta la hora de entrada en otra fila
            echo "Ya habia salido antes, pero volvio a entrar, se crea otra fila";
            $registros = mysqli_query($conexion, "INSERT into fechahora(id_huella,presente,fecha,hora_llegada) 
                                        values ('$id_get',1,'$date','$hour')") or
            die("Problemas en el insert:" . mysqli_error($conexion));
            
        }else{
            //El alumno entró pero no salió, asi que se actualiza la hora de salida
            echo "Entro pero no habia salido, se actualiza la hora de salida";
            $registros = mysqli_query($conexion, "UPDATE fechahora
                                                set hora_salida='$hour',
                                                presente=0
                                                where id_huella='$id_get' AND (fecha='$date' AND hora_salida=0)") or
            die("Problemas en el insert:" . mysqli_error($conexion));
        }
    }
    mysqli_close($conexion);
  
    ?>