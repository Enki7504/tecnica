<?php
include ('connection.php');
//$sql_insert = "INSERT INTO data (temperature, humidity, heat_index) VALUES ('".$_GET["temperature"]."', '".$_GET["humidity"]."', '".$_GET["heat_index"]."')";
//$sql_insert = "INSERT INTO data (`temperature`) VALUES ('".$_GET["temperature"]."')";
mysqli_query($con, "insert into data(temperature) values ('$_GET[huella]')")
    or die("Problemas en el select" . mysqli_error($conexion));

    mysqli_close($con);

    echo "Listo";
    

/*echo $sql_insert;
if(mysqli_query($con,$sql_insert))
{
echo "<br>";
echo "<br>";
echo "<br>";
echo "Done";
mysqli_close($con);
}
else
{
echo "error is ".mysqli_error($con );
}
*/
?>